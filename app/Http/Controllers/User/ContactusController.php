<?php

namespace App\Http\Controllers\User;


use App\DTOs\Users\ContactUsDTO;
use App\Http\Controllers\Controller;
use App\Models\Link;
use App\Models\Message;
use App\RequestsWeb\User\ContactUsValidator;
use Illuminate\Support\Facades\View;

class ContactusController extends Controller
{
    public function __construct(){
        $links = Link::all();
        View::share('links',$links);
    }

    public function index(){
        $page=trans('strings.contact');
        return view('contact',compact('page'));
    }

    public function store(ContactUsValidator $contactUsValidator){
        $contactUsDTO=ContactUsDTO::fromArray($contactUsValidator->request()->all());
        $message=new Message();
        $message->name=$contactUsDTO->name;
        $message->email=$contactUsDTO->email;
        $message->subject=$contactUsDTO->subject;
        $message->message=$contactUsDTO->message;
        $message->save();
        session()->push('m','success');
        session()->push('m',trans('strings.Message_Sent_To_Admin_Successfully'));
        return back();
    }
}
