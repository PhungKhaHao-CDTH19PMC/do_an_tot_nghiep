<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contract;

class DashboardController extends Controller
{
    public function __construct() {
        $this->module = 'dashboard';
        $this->breadcrumb = [
            'object'    => 'Thống kê',
            'page'      => ''
        ];
    }
    public function index()
    {   
        $module= $this->module;
        $this->breadcrumb['page'] = 'Danh sách';
        $breadcrumb= $this->breadcrumb;
        return view('dashboard', compact('breadcrumb','module'));
    }


    public function customFilterAjax($filter, $columns)
    {
        if (!empty($columns)) {
            foreach ($columns as $column) {
                if ($column["search"]["value"] != null) {
                    $filter[$column["name"]] = $column["search"]["value"];
                }
            }
        }
        return $filter;
    }


    public function loadAjax(Request $request)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowperpage      = $request->get("length"); // Rows display per page
        $columnIndex_arr = $request->get('order');
        $columnName_arr  = $request->get('columns');
        $order_arr       = $request->get('order');
        $search_arr      = $request->get('search');
        $columnIndex     = $columnIndex_arr[0]['column']; // Column index
        $columnName      = $columnName_arr[$columnIndex]['name']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue     = trim($search_arr['value']); // Search value

        $filter['code'] =  $searchValue;
        $filter = $this->customFilterAjax($filter, $columnName_arr);

        // Total records
        $totalRecords  = Contract::count();
        $totalRecordswithFilter = Contract::select(['contracts.*','users.fullname'])
        ->leftjoin('users', 'users.id', '=', 'contracts.user_id')
        ->with(['user'])
        ->queryData($filter)->distinct()->count();
        $contracts = Contract::select(['contracts.*','users.fullname'])
        ->leftjoin('users', 'users.id', '=', 'contracts.user_id')
        ->with(['user'])
        ->queryData($filter)
        ->orderBy($columnName, $columnSortOrder)->skip($start)->take($rowperpage)->get();
        $response = [
            "draw"                 => intval($draw),
            "iTotalRecords"        => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData"               => $contracts,
            "filter"               => $filter,
        ];
        
        echo json_encode($response);
        exit;
    }
}
