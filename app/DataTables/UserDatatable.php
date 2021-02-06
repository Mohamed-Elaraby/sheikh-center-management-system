<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;

class UserDatatable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->editColumn('profile_picture_path', function ($query){
                $profile_picture_path = $query -> image_name == 'default.png' ? 'storage' .DIRECTORY_SEPARATOR. 'default.png' : $query -> profile_picture_path;
                return '<img class="img-thumbnail" src="'.asset($profile_picture_path).'" alt="">';
            })
            ->editColumn('job_title_id', function ($query){
                return $query -> jobTitle -> name ?? '';
            })
            ->editColumn('role_id', function ($query){
                return $query -> role -> name ?? '';
            })
            ->editColumn('branch_id', function ($query){
                return $query -> branch -> name ?? '';
            })
            ->addColumn('action', function ($query){
                return view('admin.datatableHtmlBuilderRender.user.action', compact('query'));
            })
            ->rawColumns(['action', 'profile_picture_path']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        $users = Auth::user()->hasRole('owner')?
            $model->newQuery():
            $model->newQuery() -> whereRoleIs('admin')->orWhereRoleIs('user');
        if (request('branch_id')) {
            $users = Auth::user()->hasRole('owner')?
                $model->newQuery() -> where('branch_id', request('branch_id')):
                $model->newQuery() -> where('branch_id', request('branch_id')) -> whereRoleIs('admin')->orWhereRoleIs('user');
        }
        return $users;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('userdatatable-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->parameters(array_merge($this->getBuilderParameters(),[]))
                    ->dom('Blfrtip')
                    ->scrollX(true)
                    ->searching(true)
                    ->responsive(true)
                    ->autoWidth(false)
                    ->lengthMenu([[5,10,25,50,100,-1], [5,10,25,50,100,"الكل"]])
                    ->processing(true)
                    ->serverSide(true)
                    ->language(
                        [
                            "buttons" =>
                                [
                                    "create" => 'إنشاء',
                                    "export" => 'إستخراج',
                                    "print" => 'طباعة',
                                    "reset" => 'إعادة ضبط',
                                    "reload" => 'إعادة تحميل',
                                ]
                        ]
                    )
                    ->languageUrl('//cdn.datatables.net/plug-ins/1.10.22/i18n/Arabic.json')
                    ->orderBy(4, 'asc')
                    ->buttons(
                        Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')     -> title('#') ->searchable(false),
            Column::make('name')            -> title( __('trans.username') ),
            Column::make('email')            -> title( __('trans.email') ),
            Column::make('profile_picture_path')            -> title( __('trans.profile picture') ),
            Column::make('job_title_id')            -> title( __('trans.job title') ),
            Column::make('role_id')            -> title( __('trans.role') ),
            Column::make('branch_id')            -> title( __('trans.branch name') ),
            Column::make('updated_at')      -> title( __('trans.last update') )
                ->addClass('date_dir_setting'),
            Column::make('action')          -> title( __('trans.action') )
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'User_' . date('YmdHis');
    }
}
