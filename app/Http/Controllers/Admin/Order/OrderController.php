<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\SMS;
use App\Models\Subscriber;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    function index()
    {
        return view('admin.admins.orders.orders');
    }

    function getdata()
    {
        $users = Subscription::query()
            ->where('status', Subscription::WAITING)
            ->orderBy('created_at', 'desc');

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('name_dis', function ($qur) {
                return $qur->user->email;
            })
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
            ->addColumn('name', function ($qur) {
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
            ->addColumn('id_number', function ($qur) {
                return $qur->subscriber->id_number;
            })
            ->addColumn('status', function ($qur) {
                if ($qur->status == Subscription::WAITING) {
                    return '<div class="badge rounded-pill alert-info">الطلب معلق </div>';
                }
            })
            ->addColumn('actions', function ($qur) {
                if(!is_numeric($qur->subscriber->serial_number) && !is_numeric($qur->subscriber->mobile)){
                    return '<form method="post" id="form_status" action="' . route('admin.order.update') . '">
                    <input type="hidden" name="id" id="id_subscriber" value="' . $qur->subscriber->id .  '">
                    <input type="hidden" name="status_mobile" id="status_mobile" value="' . $qur->subscriber->status_mobile .  '">
                    <input type="hidden" name="_token"  value="' . csrf_token() .  '">
                    <div class="mb-2 form-group">
                    <select name="status" class="form-control-sm select_status" >
                     <option disabled selected>تعديل حالة الطلب</option>
                     <option value="2" data-bs-toggle="modal" data-bs-target="#edit-modal" >تاكيد الطلب</option>
                     <option value="3">إلغاء الطلب</option>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                </form>';
            }else{
             return '<form method="post" id="form_status" action="' . route('admin.order.update') . '">
             <input type="hidden" name="id" id="id" value="' . $qur->id .  '">
             <input type="hidden" name="_token"  value="' . csrf_token() .  '">
             <input type="hidden" name="status_mobile" id="status_mobile" value="' . $qur->subscriber->status_mobile .  '">
             <div class="mb-2 form-group">
             <select name="status" class="form-control-sm select_status" >
              <option disabled selected>تعديل حالة الطلب</option>
              <option value="2" data-bs-toggle="modal" data-bs-target="#edit-modal">تاكيد الطلب</option>
              <option value="3">إلغاء الطلب</option>
             </select>
             <div class="invalid-feedback"></div>
         </div>
         </form>';
            }
            })
            ->rawColumns(['name', 'mobile' , 'serial_number' ,  'package', 'status', 'mobile', 'actions'])
            ->make(true);
    }

    function update(Request $request)
    {

        $order = Subscription::query()->findOrFail($request->id);
        $admin = User::find($order->user->id);

        if ($order->status == Subscription::ACCEPTED && $request->status == Subscription::WAITING || $request->status == Subscription::CANCELED ) {
            $admin->update([
                'portfolio' => $admin->portfolio - $order->price
            ]);
        }

        if ($request->status == Subscription::ACCEPTED) {
            $order->update([
                'status' => Subscription::ACCEPTED,
            ]);
            $admin->update([
                'portfolio' => $admin->portfolio .+ $order->price
            ]);
        } elseif ($request->status == Subscription::CANCELED) {
            $order->update([
                'status' => Subscription::CANCELED
            ]);
        } elseif ($request->status == Subscription::WAITING) {
            $order->update([
                'status' => Subscription::WAITING
            ]);
        } else {
            return  response()->json([
                'danger' => 'الادخال خاطئ'
            ], 201);
        }

        return  response()->json([
            'success' => 'تم تعديل الحالة بنجاح'
        ], 201);
    }

    function canceled()
    {
        return view('admin.admins.orders.canceled');
    }

    function getdatacanceled()
    {
        $users = Subscription::query()->where('status', Subscription::CANCELED)->orderBy('created_at', 'desc');

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('name_dis', function ($qur) {
                return $qur->user->email;
            })
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
            ->addColumn('name', function ($qur) {
                return $qur->subscriber->name;
            })

            ->addColumn('id_number', function ($qur) {
                return $qur->subscriber->id_number;
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
            ->addColumn('status', function ($qur) {
                if ($qur->status == Subscription::CANCELED) {
                    return '<div class="badge rounded-pill alert-danger">الطلب ملغي </div>';
                }
            })
            ->addColumn('actions', function ($qur) {
                if(!is_numeric($qur->subscriber->serial_number) && !is_numeric($qur->subscriber->mobile)){
                    return '<button  type="submit" data-bs-toggle="modal" data-bs-target="#edit-modal" data-id="'.  $qur->subscriber->id .'" class="btn btn-outline-success btn-sm btn-update-numbers">اضافة بيانات الشريحة </button>';
            }else{
             return '<form method="post" id="form_status" action="' . route('admin.order.update') . '">
             <input type="hidden" name="id" id="id" value="' . $qur->id .  '">
             <input type="hidden" name="_token"  value="' . csrf_token() .  '">
             <div class="mb-2 form-group">
             <select name="status" class="form-control-sm select_status" >
              <option disabled selected>تعديل حالة الطلب</option>
              <option value="2">تاكيد الطلب</option>
              <option value="3">إلغاء الطلب</option>
             </select>
             <div class="invalid-feedback"></div>
         </div>
         </form>';
            }
            })
            ->rawColumns(['name' , 'mobile' , 'serial_number' , 'package', 'status', 'mobile', 'actions'])
            ->make(true);
    }

    function renewal()
    {
        return view('admin.admins.orders.renewal');
    }

    function getdatarenewal()
    {
        $users = Subscription::query()
            ->where('status', Subscription::RENEWAL)
            ->orderBy('created_at', 'desc');

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('name_dis', function ($qur) {
                return $qur->user->email;
            })
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
            ->addColumn('name', function ($qur) {
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
            ->addColumn('id_number', function ($qur) {
                return $qur->subscriber->id_number;
            })

            ->addColumn('status', function ($qur) {
                if ($qur->status == Subscription::RENEWAL) {
                    return '<div class="badge rounded-pill alert-info">الطلب مرسل للتجديد </div>';
                }
            })
            ->addColumn('actions', function ($qur) {
                if(!is_numeric($qur->subscriber->serial_number) && !is_numeric($qur->subscriber->mobile)){
                       return '<button  type="submit" data-bs-toggle="modal" data-bs-target="#edit-modal" data-id="'. $qur->subscriber->id .'" class="btn btn-outline-success btn-sm btn-update-numbers">اضافة بيانات الشريحة </button>';
               }else{
                return '<form method="post" id="form_status" action="' . route('admin.order.update') . '">
                <input type="hidden" name="id" id="id" value="' . $qur->id .  '">
                <input type="hidden" name="_token"  value="' . csrf_token() .  '">
                <div class="mb-2 form-group">
                <select name="status" class="form-control-sm select_status" >
                 <option disabled selected>تعديل حالة الطلب</option>
                 <option value="2">تاكيد الطلب</option>
                 <option value="3">إلغاء الطلب</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            </form>';
               }

            })
            ->rawColumns(['name', 'mobile' , 'serial_number', 'package', 'status', 'mobile', 'actions'])
            ->make(true);
    }


    function update_numbers(Request $request) {
        $request->validate([
          'mobile' => 'required' ,
          'serial_number' => 'required'
        ]);

        $user = Subscriber::findOrFail($request->id);

            $user->update([
             'mobile' => $request->mobile ,
             'serial_number' => $request->serial_number ,
              'status_mobile' => '8' ,
            ]);

            return response()->json([
                "success" => "success"
            ], 201);
    }

}
