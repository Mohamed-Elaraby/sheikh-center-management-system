<?php

namespace App\DataTables;


use App\Models\Check;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CheckDatatable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('checkStatus', function ($query){
                return view('admin.datatableHtmlBuilderRender.check.checkStatusChange', compact('query'));
            })
            ->addColumn('action', function ($query){
                return view('admin.datatableHtmlBuilderRender.check.action', compact('query'));
            })
            ->editColumn('car_type', function ($query){
                return $query->carType->name ?? '';
            })
            ->editColumn('branch', function ($query){
                return $query->branch->name ?? '';
            })
            ->editColumn('check_number', function ($query){
                return "<a href='".route('admin.check.receipt', $query->id)."'>".$query -> check_number."</a>";
            })
            ->filterColumn('car_type', function($query, $keyword) {
                $query->whereHas('carType', function ($q) use ($keyword){
                    $q->where('name', 'LIKE', "%{$keyword}%");
                });
            })
            ->rawColumns(['checkStatus', 'action', 'check_number'])
            ->addRowAttr('class', function ($query){

                if (auth()->user()->hasRole(['owner', 'general_manager'])) {
                    if ($query->management_notes != NULL) {
                        return 'management_notes_select_color'; // add class management_notes to set row background color if management_notes not empty
                    }
                }
            });

    }



    protected function searchFilter($model, $request,array $selectQueryColumns, string $column_name_whereBetween, array $where_query, array $extra_ifConditions = null)
    {
        // Search Parameters
        $start_date = $this -> request() -> get('start_date');
        $end_date = $this -> request() -> get('end_date');

        // Date Range Used With Search => Array
        $date_range = [$start_date.' 00:00:00', $end_date.' 23:59:59'];


        $allCheck = Auth::user()->hasRole(['owner', 'general_manager'])?
            $model->newQuery() ->select($selectQueryColumns):
            $model->newQuery() ->where($where_query) -> select($selectQueryColumns);
        if (!empty($start_date) && !empty($end_date))
        {
            $allCheck = Auth::user()->hasRole(['owner', 'general_manager'])?
                $model->newQuery()-> whereBetween($column_name_whereBetween, $date_range) ->select($selectQueryColumns):
                $model->newQuery()-> whereBetween($column_name_whereBetween, $date_range) ->where($where_query) -> select($selectQueryColumns);
        }


        if (count($extra_ifConditions) > 0)
        {
            foreach ($extra_ifConditions as $key => $value)
            {
                if ($value) { // Get all check with [ check status id ] from request url
                    $allCheck = Auth::user()->hasRole(['owner', 'general_manager'])?
                        $model->newQuery()->where($key, $value)->select($selectQueryColumns):
                        $model->newQuery()->where($key, $value)->where($where_query)->select($selectQueryColumns);
                    if($key == 'client_id')
                    {
                        $allCheck = $model->newQuery()->where($key, $value)->select($selectQueryColumns);
                    }
                    if (!empty($start_date) && !empty($end_date))
                    {
                        $allCheck = Auth::user()->hasRole(['owner', 'general_manager'])?
                            $model->newQuery()-> whereBetween($column_name_whereBetween, $date_range) ->where($key, $value)->select($selectQueryColumns):
                            $model->newQuery()-> whereBetween($column_name_whereBetween, $date_range) ->where($key, $value)->where($where_query)->select($selectQueryColumns);
                    }
                }
            }
        }
        if ($request -> check_status_id && $request -> branch_id)
        {
            $allCheck = Auth::user()->hasRole(['owner', 'general_manager'])?
                $model->newQuery()->where([['check_status_id', $request -> check_status_id], ['branch_id', $request -> branch_id]])->select($selectQueryColumns):
                $model->newQuery()->where([['check_status_id', $request -> check_status_id], ['branch_id', $request -> branch_id]])->where($where_query)->select($selectQueryColumns);
            if (!empty($start_date) && !empty($end_date))
            {
                $allCheck = Auth::user()->hasRole(['owner', 'general_manager'])?
                    $model->newQuery()-> whereBetween($column_name_whereBetween, $date_range) ->where([['check_status_id', $request -> check_status_id], ['branch_id', $request -> branch_id]])->select($selectQueryColumns):
                    $model->newQuery()-> whereBetween($column_name_whereBetween, $date_range) ->where([['check_status_id', $request -> check_status_id], ['branch_id', $request -> branch_id]])->where($where_query)->select($selectQueryColumns);
            }
        }
        if ($request->car_exists == true) {
            $allCheck = Auth::user()->hasRole(['owner', 'general_manager']) ?
                $model->newQuery()->whereHas('checkStatus', function ($checkStatus) {
                    $checkStatus->where('name', '!=', 'تم تسليم السيارة الى العميل');
                })->where('branch_id', $request->branch_id)->select($selectQueryColumns) :
                $model->newQuery()->where('branch_id', $request->branch_id)->where($where_query)->select($selectQueryColumns);

            if (!empty($start_date) && !empty($end_date)) {
                $allCheck = Auth::user()->hasRole(['owner', 'general_manager']) ?
                    $model->newQuery()->whereHas('checkStatus', function ($checkStatus) {
                        $checkStatus->where('name', '!=', 'تم تسليم السيارة الى العميل');
                    })->whereBetween($column_name_whereBetween, $date_range)->where('branch_id', $request->branch_id)->select($selectQueryColumns) :
                    $model->newQuery()->whereBetween($column_name_whereBetween, $date_range)->where('branch_id', $request->branch_id)->where($where_query)->select($selectQueryColumns);
            }
        }
        return $allCheck;
    }

    /**
     * Get query source of dataTable.
     *
     * @param Check $model
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Check $model, Request $request)
    {
        $selectQueryColumns = ['id', 'check_number', 'car_type_id', 'car_color', 'plate_number', 'management_notes', 'check_status_id','branch_id', 'updated_at'];
        $result = $this -> searchFilter($model, $request, $selectQueryColumns, 'updated_at', [['branch_id','=',Auth::user()->branch_id]] , ['check_status_id' => $request -> check_status_id, 'branch_id' => $request -> branch_id, 'client_id' => $request -> client_id, 'car_exists' => $request -> car_exists]);
        return $result;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('checkdatatable-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
//                    ->addAction([])
                    ->parameters(array_merge($this->getBuilderParameters(),[]))
                    ->dom('Blfrtip')
                    ->scrollX(false)
                    ->scrollY(true)
                    ->searching(true)
                    ->responsive(true)
                    ->autoWidth(true)
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
                    ->orderBy(7)
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
            Column::make('check_number')    -> title( __('trans.check number') ),
            Column::make('car_type')        -> title( __('trans.car type') ),
            Column::make('car_color')       -> title( __('trans.car color') ),
            Column::make('plate_number')    -> title( __('trans.plate number') ),
            Column::make('branch')          -> title( __('trans.branch name') ),
            Column::make('checkStatus')     -> title( __('trans.status') ),
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
        return 'Check_' . date('YmdHis');
    }

}
