<?php

namespace App\Admin\Forms;

use App\Models\BlackList;
use Dcat\Admin\Contracts\LazyRenderable;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Widgets\Form;
use Dcat\EasyExcel\Excel;
use Illuminate\Support\Facades\Storage;

class ImportBlackListForm extends Form implements LazyRenderable
{

    use LazyWidget;

    /**
     * Build a form here.
     */
    public function form()
    {
        // 获取外部传递参数

        $this->file('file', '文件')->autoUpload()->required();
        $this->text('remark', '备注');
    }

    // 处理请求
    public function handle(array $input)
    {
        $file = $input['file'] ?? null;
        if (!$file) {
            return $this->response()->error('上传文件错误');
        }
        $f = Storage::disk('public')->path($file);

        $firstSheet = Excel::import($f)->first()->toArray();
        $firstSheet = collect($firstSheet)->filter(function ($row) {
            return data_get($row, '屏蔽类型') && data_get($row, '值');
        });

        if (!$firstSheet->count())
            return $this->response()->info('文件为空或者格式错误');

        $remark = data_get($input, 'remark', '文件上传');
        $firstSheet->each(function ($row) use ($remark) {
            $type = data_get($row, '屏蔽类型') === 'IP' ? BlackList::TYPE_IP : BlackList::TYPE_PHONE;

            BlackList::blockIp(data_get($row, '值'),
                data_get($row, '备注')??$remark,
                BlackList::ADD_TYPE_MANUAL,
                $type
            );
        });

        return $this->response()->success("上传成功,可能有些已经添加,将不会重复添加")->refresh();
    }

}
