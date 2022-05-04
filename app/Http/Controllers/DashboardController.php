<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
