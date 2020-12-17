<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Message;
use App\Models\Report;
use App\Services\ReportsService;
use Illuminate\Support\Facades\View;


class ReportsController extends Controller
{
    public function __construct(){
        $messagescount = Message::where('seen',0)->count();
        View::share('messagescount',$messagescount);
        $newads = Ad::where('seen',0)->count();
        View::share('newads',$newads);
        $reports=Report::where('seen',0)->count();
        View::share('reports',$reports);
    }

	public function index(ReportsService $reportsService){
        $old_reports=$reportsService->getReports(1);
        $new_reports=$reportsService->getReports(0,true);
        return view('admin/reports/index',compact('new_reports','old_reports'));
    }
}
