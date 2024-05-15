<?php

namespace App\Http\Controllers\Distributor\subscription;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\SMS;
use App\Models\Subscriber;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Yajra\DataTables\Facades\DataTables;

class SubscriptionController extends Controller
{
    function index() {


        return view('admin.distributors.subscriptions.index');
    }

    function getdata() {
        $users = Subscription::query()
        ->where('user_id' , Auth::user()
        ->id)
        ->Where('status' , Subscription::ACCEPTED)
        ->orWhere('status' , Subscription::EXPIRED)
        ;
        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('package', function ($qur) {
                return '<div class="badge rounded-pill alert-info"> '. $qur->package->name .' </div>';

             })
             ->addColumn('time', function ($qur) {
                 if($qur->time == 1 ){
                     return 'شهر';
                 }elseif($qur->time == 2){
                     return 'شهرين';

                 }elseif($qur->time == 3){
                     return 'ثلاثة أشهر';

                 }
              })
            ->addColumn('name' , function ($qur) {
                 return $qur->subscriber->name ;
            })
            ->addColumn('mobile' , function($qur){
                if(!is_numeric($qur->subscriber->mobile)){
                     return '<div class="badge rounded-pill alert-warning">'.Subscriber::SMSM .'</div>';
                }

                return $qur->subscriber->mobile ;
               })
               ->addColumn('serial_number' , function($qur){
                   if(!is_numeric($qur->subscriber->serial_number)){
                        return '<div class="badge rounded-pill alert-warning">'.Subscriber::SMSS.'</div>';
                   }
                   return $qur->subscriber->serial_number ;

                  })
              ->addColumn('status' , function ($qur) {
                   if($qur->status == Subscription::WAITING){
                    return '<div class="badge rounded-pill alert-info">الاشتراك معلق </div>'  ;
                   }elseif($qur->status == Subscription::ACCEPTED){
                    return '<div class="badge rounded-pill alert-success">الاشتراك جاري</div>'  ;
                 }elseif($qur->status == Subscription::CANCELED){
                    return '<div class="badge rounded-pill alert-danger">الاشتراك ملغي </div>'  ;
                  }elseif($qur->status == Subscription::EXPIRED){
                    return '<div class="badge rounded-pill alert-warning">الاشتراك منتهي </div>'  ;
                   }
              })
              ->addColumn('actions', function ($qur) {
                if($qur->status == Subscription::ACCEPTED){
                    return '<span class="text-danger">  ليس هناك اجراءات للاشتراك</span>';
                }else{
                    return '<button  type="submit" data-bs-toggle="modal" data-bs-target="#edit-modal" data-id="'. $qur->id .'" class="btn btn-outline-success btn-sm btn-renewal">تجديد الاشتراك المنتهي</button>';
                }

            })
              ->rawColumns(['name' , 'status' , 'package' , 'mobile' , 'actions' , 'serial_number'])
              ->make(true);
    }


    function accepted() {
       return view('admin.distributors.subscriptions.accepted');
    }

    function getdataaccepted() {
        $users = Subscription::query()->where('user_id' , Auth::user()
        ->id)->where('status' , Subscription::ACCEPTED )->orderBy('created_at', 'desc');
        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('package', function ($qur) {
                return '<div class="badge rounded-pill alert-success"> '. $qur->package->name .' </div>';

             })
             ->addColumn('time', function ($qur) {
                 if($qur->time == 1 ){
                     return 'شهر';
                 }elseif($qur->time == 2){
                     return 'شهرين';

                 }elseif($qur->time == 3){
                     return 'ثلاثة أشهر';

                 }
              })
            ->addColumn('name' , function ($qur) {
              return $qur->subscriber->name;
            })
            ->addColumn('mobile' , function($qur){
                if(!is_numeric($qur->subscriber->mobile)){
                     return '<div class="badge rounded-pill alert-warning">'.Subscriber::SMSM .'</div>';
                }

                return $qur->subscriber->mobile ;
               })
               ->addColumn('serial_number' , function($qur){
                   if(!is_numeric($qur->subscriber->serial_number)){
                        return '<div class="badge rounded-pill alert-warning">'.Subscriber::SMSS.'</div>';
                   }
                   return $qur->subscriber->serial_number ;

                  })
              ->addColumn('status' , function ($qur) {
                if($qur->status == Subscription::WAITING){
                    return '<div class="badge rounded-pill alert-info">الاشتراك معلق </div>'  ;
                   }elseif($qur->status == Subscription::ACCEPTED){
                    return '<div class="badge rounded-pill alert-success">الاشتراك جاري</div>'  ;
                 }elseif($qur->status == Subscription::CANCELED){
                    return '<div class="badge rounded-pill alert-danger">الاشتراك ملغي </div>'  ;
                  }elseif($qur->status == Subscription::EXPIRED){
                    return '<div class="badge rounded-pill alert-warning">الاشتراك منتهي </div>'  ;
                   }
              })->addColumn('actions', function ($qur) {
                return '<span class="text-danger">  ليس هناك اجراءات للاشتراك</span>';

            })
              ->rawColumns(['name' , 'status' , 'package' ,'serial_number' ,  'mobile' ,  'actions'])
            ->make(true);
    }

    function expired() {
        $packages = Package::all();
        return view('admin.distributors.subscriptions.expired' , compact('packages'));
     }

     function getdataexpired() {
         $users = Subscription::query()->where('user_id' , Auth::user()
         ->id)->where('status' , Subscription::EXPIRED )->orderBy('created_at', 'desc');
         return DataTables::of($users)
             ->addIndexColumn()
             ->addColumn('package', function ($qur) {
                return '<div class="badge rounded-pill alert-success"> '. $qur->package->name .' </div>';

             })
             ->addColumn('time', function ($qur) {
                 if($qur->time == 1 ){
                     return 'شهر';
                 }elseif($qur->time == 2){
                     return 'شهرين';

                 }elseif($qur->time == 3){
                     return 'ثلاثة أشهر';
                 }
              })
             ->addColumn('name' , function ($qur) {
               return $qur->subscriber->name;
             })
             ->addColumn('mobile' , function($qur){
                if(!is_numeric($qur->subscriber->mobile)){
                     return '<div class="badge rounded-pill alert-warning">'.Subscriber::SMSM .'</div>';
                }

                return $qur->subscriber->mobile ;
               })
               ->addColumn('serial_number' , function($qur){
                   if(!is_numeric($qur->subscriber->serial_number)){
                        return '<div class="badge rounded-pill alert-warning">'.Subscriber::SMSS.'</div>';
                   }
                   return $qur->subscriber->serial_number ;

                  })
               ->addColumn('status' , function ($qur) {
                if($qur->status == Subscription::WAITING){
                    return '<div class="badge rounded-pill alert-info">الاشتراك معلق </div>'  ;
                   }elseif($qur->status == Subscription::ACCEPTED){
                    return '<div class="badge rounded-pill alert-success">الاشتراك جاري</div>'  ;
                 }elseif($qur->status == Subscription::CANCELED){
                    return '<div class="badge rounded-pill alert-danger">الاشتراك ملغي </div>'  ;
                  }elseif($qur->status == Subscription::EXPIRED){
                    return '<div class="badge rounded-pill alert-warning">الاشتراك منتهي </div>'  ;
                   }
               })
               ->addColumn('actions', function ($qur) {
                if($qur->status == Subscription::ACCEPTED){
                    return '<span class="text-danger">  ليس هناك اجراءات للاشتراك</span>';
                }else{
                    return '<button  type="submit" data-bs-toggle="modal" data-bs-target="#edit-modal" data-id="'. $qur->id .'" class="btn btn-outline-success btn-sm btn-renewal">تجديد الاشتراك المنتهي</button>';
                }

            })
               ->rawColumns(['name' , 'package' , 'status' , 'mobile' , 'serial_number' , 'actions'])
             ->make(true);
     }



     function renewal(Request $request) {
        $request->validate([
            'start' => 'required' ,
            'time' => 'required' ,
            'package' => 'required' ,
        ]);

        $subscription = Subscription::query()->findOrFail($request->id);
        $subscription->update([
            'start' => $request->start ,
            'time' => $request->time ,
            'package_id' => $request->package ,
            'status' => Subscription::RENEWAL
        ]);

        return response()->json([
            'success' => __('تم تجديد الاشتراك بنجاح')
        ], 201);
   }







}
