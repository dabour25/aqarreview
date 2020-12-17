<?php

namespace App\Services;


use App\DTOs\Users\ReportDTO;
use App\Models\Report;
use App\Services\Users\UserService;
use Illuminate\Support\Facades\Auth;

class ReportsService{
    public function getReports(int $seen,bool $markRead=false){
        $reports=Report::with(['toUser','fromUser'])->where('seen',$seen)
            ->orderBy('id','DESC')->paginate(20);
        if($markRead){
            foreach ($reports as $report){
                $report->seen=1;
                $report->save();
            }
        }
        return $reports;
    }
    /**
     * @param ReportDTO $reportDTO
     * @param string $slug
     * @return bool
     */
    public function makeReport(ReportDTO $reportDTO,string $slug):bool{
        $userService=new UserService();
        $toUser=$userService->get_user_by_slug($slug);
        if(!$toUser){
            session()->push('m','danger');
            session()->push('m',trans('strings.report_user_fail'));
            return false;
        }
        $fromUser=Auth::user()->id;
        if($toUser->id==$fromUser){
            session()->push('m','danger');
            session()->push('m',trans('strings.report_same_user'));
            return false;
        }
        Report::create(['report'=>$reportDTO->report,'to_user'=>$toUser->id,'reporter'=>$fromUser]);
        session()->push('m','success');
        session()->push('m',trans('strings.report_success'));
        return true;
    }
}
