<?php

namespace App\Http\Controllers\User;

use App\DTOs\Users\ReportDTO;
use App\Http\Controllers\Controller;
use App\Models\Link;
use App\RequestsWeb\User\ReportValidator;
use App\Services\ReportsService;
use App\Services\Users\UserService;
use Illuminate\Support\Facades\View;

//DB Connect

class ReportsController extends Controller
{
    public function __construct(){
        $links = Link::all();
        View::share('links',$links);
    }
    public function index(){
        return redirect('/');
    }

    public function show($slug,UserService $userService){
        $page=trans('strings.report');
        $user=$userService->get_user_by_slug($slug);
        return view('report',compact('page','slug','user'));
    }

    public function update($slug,ReportValidator $reportValidator,ReportsService $reportsService){
        $reportDto=ReportDTO::fromArray($reportValidator->request()->all());
        $reportsService->makeReport($reportDto,$slug);
        return back();
    }
}
