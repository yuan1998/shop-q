<?php

namespace App\Admin\Exporters;

use Dcat\Admin\Grid\Exporters\AbstractExporter;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

abstract class BaseExporter extends AbstractExporter implements FromCollection, WithHeadings
{
    use Exportable;

    protected $columns;

    public function collection(): \Illuminate\Support\Collection
    {
        return collect($this->buildData());
    }

    /**
     * {@inheritdoc}
     */
    public function export()
    {
        // 很有可能的是上面的方法没有查询到数据，用laravel-admin的相关的方法不行，因为model好像被变更了。=_=
        $this->download($this->exportFilename())->prepare(request())->send();
        exit;
    }

    public function headings(): array
    {
        return $this->columns;
    }

    /**
     * 导出文件的文件名
     *
     * @return string
     */
    public function exportFilename(): string
    {
        return $this->getFilename() .'.xlsx';
    }
}
