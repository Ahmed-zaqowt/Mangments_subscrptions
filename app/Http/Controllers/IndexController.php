<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Subscriber;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    function index_super() {
        $tomorrow = Carbon::tomorrow();
       $user = Auth::user();
       if($user->status == User::SUPER){
        $users_ended_soon = Subscription::query()->where('end' , $tomorrow)->get();
        $user_acc = Subscription::where('user_id' , Auth::user()->id)->where('status' , Subscription::ACCEPTED)->count();
        $user_ex = Subscription::where('user_id' , Auth::user()->id)->where('status' , '<>' , Subscription::ACCEPTED)->count();
        $wait = Subscription::where('status' , Subscription::WAITING)->count();
        $cancel = Subscription::where('status' , Subscription::CANCELED)->count();
        $re = Subscription::where('status' , Subscription::RENEWAL)->count();
        $accept = Subscription::where('status' , Subscription::ACCEPTED)->count();
        $ex = Subscription::where('status' , Subscription::EXPIRED)->count();
        $admins = User::where('status' , User::ADMIN)->count();
        $packages = Package::count();
        $users = Subscriber::count();
        return view('admin.admins.index.index' , compact('wait' , 'cancel' , 're' , 'accept' , 'ex' , 'admins' , 'users' , 'packages' , 'users_ended_soon'));
       }else{
        $users_ended_soon = Subscription::query()->where('user_id' , Auth::user()->id)->where('end' , $tomorrow)->get();
        $user_acc = Subscription::where('user_id' , Auth::user()->id)->where('status' , Subscription::ACCEPTED)->count();
        $user_ex = Subscription::where('user_id' , Auth::user()->id)->where('status' , '<>' , Subscription::ACCEPTED)->count();
        $packages = Package::all();
        $wait = Subscription::where('user_id' , Auth::user()->id)->where('status' , Subscription::WAITING)->count();
        $cancel = Subscription::where('user_id' , Auth::user()->id)->where('status' , Subscription::CANCELED)->count();
        $re = Subscription::where('user_id' , Auth::user()->id)->where('status' , Subscription::RENEWAL)->count();
        $accept = Subscription::where('user_id' , Auth::user()->id)->where('status' , Subscription::ACCEPTED)->count();
        $ex = Subscription::where('user_id' , Auth::user()->id)->where('status' , Subscription::EXPIRED)->count();
        $users = Subscriber::where('user_id' , Auth::user()->id)->count();
        return view('admin.admins.index.index' , compact('wait' , 'cancel' , 're' , 'accept' , 'ex'  , 'users' , 'packages' , 'user_acc' , 'user_ex' , 'users_ended_soon'));
       }

    }


}
