<?php

namespace Dcat\Admin\GridSortable\Http\Controllers;

use Dcat\Admin\Form;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class GridSortableController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->title('Title')
            ->description('Description')
            ->body(Admin::view('dcat-admin.grid-sortable::index'));
    }

    public function sort(Request $request)
    {
        $status = true;
        $column = $request->get('_column');
        $message = trans('admin.save_succeeded');
        $repository = $request->get('_model');

        $sorts = $request->get('_sort');
        $sorts = collect($sorts)
            ->pluck('key')
            ->combine(
                collect($sorts)->pluck('sort')->sort()
            );

        try {
            $sorts->each(function ($v, $k) use ($repository, $column) {
                $form = new Form(new $repository);

                $form->text($column);

                $form->update($k, [$column => $v]);
            });

        } catch (\Exception $exception) {
            $status  = false;
            $message = $exception->getMessage();
        }

        return response()->json(compact('status', 'message'));
    }
}
