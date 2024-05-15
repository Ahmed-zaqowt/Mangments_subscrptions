<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    function index() {
       return view('admin.admins.users.index');
    }

    function getdata(Request $request) {
        $users = Subscriber::query()->orderBy('created_at', 'desc');

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('name_dis' , function($qur){
               return $qur->user->email ;
               })
            ->addColumn('mobile' , function($qur){
                if(!is_numeric($qur->mobile)){
                     return '<div class="badge rounded-pill alert-warning">'.Subscriber::SMSM .'</div>';
                }

                return $qur->mobile ;
               })
               ->addColumn('serial_number' , function($qur){
                   if(!is_numeric($qur->serial_number)){
                        return '<div class="badge rounded-pill alert-warning">'.Subscriber::SMSS.'</div>';
                   }
                   return $qur->serial_number ;
                  })
                  ->addColumn('status_mobile' , function($qur){
                    if($qur->status_mobile == Subscription::OLD){
                         return '<div class="badge rounded-pill alert-secondary">قديم</div>';
                    }else{
                        return '<div class="badge rounded-pill alert-warning">جديد</div>';

                    }

                   })
              ->rawColumns(['name' , 'status' , 'mobile' , 'serial_number' , 'status_mobile'])
            ->make(true);
    }
}
