<?php

namespace App\DataTables;

use App\Models\SaleOrderReturn;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;

class SaleOrderReturnDatatable extends DataTable
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
            ->editColumn('branch_id', function ($query){
                return $query->branch->display_name ?? '';
            })
            ->editColumn('user_id', function ($query){
                return $query->user->name ?? '';
            })
            ->addColumn('related_products', function ($query){
                return "<a class='btn btn-warning' href='" . route('admin.saleOrderReturnProducts', $query -> id) . "'>". __('trans.related products') ."</a>";
            })
            ->addColumn('show_invoice', function ($query){
                return "<a class='btn btn-warning' href='" . route('admin.saleOrderReturns.show', $query -> id) . "'>". __('trans.show invoice') ."</a>";
            })
            ->addColumn('sale_invoice_number', function ($query){
                return "<a class='btn btn-success' href='" . route('admin.saleOrders.show', $query -> saleOrder -> id) . "'>". $query -> saleOrder -> invoice_number ."</a>";
            })
            ->rawColumns(['related_products', 'show_invoice', 'sale_invoice_number']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\SaleOrderReturn $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(SaleOrderReturn $model)
    {
        // Search Parameters
        $start_date = $this -> request() -> get('start_date');
        $end_date = $this -> request() -> get('end_date');
        $branch_id = $this -> request() -> get('branch_id');
        $sale_order_id = $this -> request() -> get('sale_order_id');
        // Date Range Used With Search => Array
        $date_range = [$start_date.' 00:00:00', $end_date.' 23:59:59'];

        $saleOrderReturns = $model->newQuery()
            ->where(function ($query)use ($start_date, $end_date, $date_range ){
                if ($start_date && $end_date)
                {
                    $query-> whereBetween('created_at' ,$date_range);
                }
            })
            ->where(function ($query)use ($sale_order_id){
                if ($sale_order_id)
                {
                    $query-> where('sale_order_id' ,$sale_order_id);
                }
            })
            ->where(function ($query)use ($branch_id){
                if ($branch_id)
                {
                    $query-> where('branch_id' ,$branch_id);
                }
            });

        return $saleOrderReturns;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('saleorderreturndatatable-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Blfrtip')
                    ->scrollX(true)
                    ->scrollY(false)
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
            Column::make('DT_RowIndex')                 -> title('#') ->searchable(false),
            Column::make('related_products')            -> title( __('trans.all products') ),
            Column::make('show_invoice')                -> title( __('trans.full invoice') ),
            Column::make('invoice_number')              -> title( __('trans.return invoice number') ),
            Column::make('sale_invoice_number')         -> title( __('trans.sale invoice number') ),
            Column::make('invoice_date')                -> title( __('trans.invoice date') ),
            Column::make('total_return_items')          -> title( __('trans.total return items') ),
            Column::make('branch_id')                   -> title( __('trans.branch') ),
//            Column::make('notes')                             -> title( __('trans.notes') ),
            Column::make('updated_at')                  -> title( __('trans.last update') )
                ->addClass('date_dir_setting'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'SaleOrderReturn_' . date('YmdHis');
    }
}
