<?php

namespace App\Http\Controllers\Distributor\order;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Subscriber;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    function index()
    {
        $packages = Package::all();
        return view('admin.distributors.orders.orders' , compact('packages'));
    }

    function getdata()
    {
        $users = Subscription::query()->where('user_id', Auth::user()->id)->where('status', Subscription::WAITING)->orderBy('created_at', 'desc');

        return DataTables::of($users)
            ->addIndexColumn()

            ->addColumn('name', function ($qur) {
                return $qur->subscriber->name;
            })->addColumn('package', function ($qur) {
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
            ->addColumn('status_number', function ($qur) {
                if ($qur->subscriber->status_mobile == Subscription::NEW) {
                    return '<div class="badge rounded-pill alert-success"> جديد </div>';
                }elseif($qur->subscriber->status_mobile == Subscription::OLD){
                    return '<div class="badge rounded-pill alert-dark"> قديم </div>';
                }
            })
            ->addColumn('actions', function ($qur) {
                $data_attr = '';
                $data_attr .= 'data-id="' . $qur->id  . '" ';
                $data_attr .= 'data-user_id="' . $qur->subscriber->id  . '" ';
                $data_attr .= 'data-name="' . $qur->subscriber->name . '"';
                $data_attr .= 'data-id_number="' . $qur->subscriber->id_number . '"';
                $data_attr .= 'data-serial_number="' . $qur->subscriber->serial_number . '"';
                $data_attr .= 'data-start="' . $qur->start . '"';
                $data_attr .= 'data-end="' . $qur->end . '"';
                $data_attr .= 'data-mobile="' . $qur->subscriber->mobile . '"';
                $data_attr .= 'data-status_mobile="' . $qur->status_mobile . '"';
                $data_attr .= 'data-time="' . $qur->time . '"';
                $data_attr .= 'data-package="' . $qur->package_id . '"';

                $string = '';
                $string .= '
                   <div class="d-flex align-items-center gap-3 fs-6">

      <div  class="text-warning edit_btn" data-bs-toggle="modal" data-bs-target="#edit-modal" ' . $data_attr . '><i class="bi bi-pencil-fill"></i></div>
      <div class="text-danger delete_btn" data-id="' . $qur->id . '" data-url="/distributor/orders/delete">
      <i class="bi bi-trash-fill"></i>
      </div>
    </div>
      </div>';


                return $string;


            })
            ->rawColumns(['name', 'status', 'mobile' , 'package', 'actions' , 'status_number' , 'serial_number'])
            ->make(true);
    }

    function update(Request $request)
    {

        
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|unique:Users,mobile,'.$request->user_id,
            'id_number' => 'required|numeric|regex:/^[0-9]+$/|unique:subscribers,id_number,'.$request->user_id,
            'serial_number' => 'required|unique:subscribers,serial_number,'.$request->user_id,
            'start' => 'required' ,
            'time' => 'required' ,
            'package' => 'required' ,
        ]);


        //$subscriper = Subscriber::query()->where('id', $request->id)->first();
        $subscription = Subscription::query()->where('id' , $request->id)->first();
        $subscriber = Subscriber::query()->where('id' , $subscription->subscriber->id)->first();
        $subscriber->update([
            'name' => $request->name,
            'id_number' => $request->id_number,
            'serial_number' => $request->serial_number,
            'mobile' => $request->mobile,
        ]);

        $subscription->update([
               'start'=>$request->start ,
               'time' => $request->time ,
               'package_id' => $request->package
        ]);





        return response()->json([
            'success' => __('تم التعديل بنجاح')
        ], 201);
    }


    function delete(Request $request)
    {
        $sub = Subscription::find($request->id);
        $sub->delete();

        return response()->json(["success" => "تم الحذف بنجاح"], 201);
    }

    function canceled()
    {
        return view('admin.distributors.orders.canceled');
    }

    function getdata_canceled()
    {
        $users = Subscription::query()->where('user_id', Auth::user()->id)->where('status', Subscription::CANCELED)->orderBy('created_at', 'desc');

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('name', function ($qur) {
                return $qur->subscriber->name;
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
            ->addColumn('mobile', function ($qur) {
                return $qur->subscriber->mobile;
            })
            ->addColumn('id_number', function ($qur) {
                return $qur->subscriber->id_number;
            })
            ->addColumn('serial_number', function ($qur) {
                return $qur->subscriber->serial_number;
            })
            ->addColumn('status', function ($qur) {
                if ($qur->status == Subscription::CANCELED) {
                    return '<div class="badge rounded-pill alert-danger">الطلب ملغي </div>';
                }
            })
            ->addColumn('status_number', function ($qur) {
                if ($qur->subscriber->status_mobile == Subscription::NEW) {
                    return '<div class="badge rounded-pill alert-success"> جديد </div>';
                }elseif($qur->subscriber->status_mobile == Subscription::OLD){
                    return '<div class="badge rounded-pill alert-dark"> قديم </div>';
                }
            })
            ->addColumn('actions', function ($qur) {
                return '<div class="text-danger delete_btn" data-id="' . $qur->id . '" data-url="/distributor/orders/delete">
                <i class="bi bi-trash-fill"></i>
                </div>';
            })
            ->rawColumns(['name', 'package' ,  'status_number' ,  'status', 'mobile', 'actions'])
            ->make(true);
    }




    function renewal()
    {
        return view('admin.distributors.orders.renewal');
    }

    function getdatarenewal()
    {
        $users = Subscription::query()->where('user_id', Auth::user()->id)->where('status', Subscription::RENEWAL)->orderBy('created_at', 'desc');

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('name', function ($qur) {
                return $qur->subscriber->name;
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
            ->addColumn('mobile', function ($qur) {
                return $qur->subscriber->mobile;
            })
            ->addColumn('id_number', function ($qur) {
                return $qur->subscriber->id_number;
            })
            ->addColumn('serial_number', function ($qur) {
                return $qur->subscriber->serial_number;
            })
            ->addColumn('status', function ($qur) {
                if ($qur->status == Subscription::RENEWAL) {
                    return '<div class="badge rounded-pill alert-info">الطلب مرسل للتجديد </div>';
                }
            })
            ->addColumn('status_number', function ($qur) {
                if ($qur->subscriber->status_mobile == Subscription::NEW) {
                    return '<div class="badge rounded-pill alert-success"> جديد </div>';
                }elseif($qur->subscriber->status_mobile == Subscription::OLD){
                    return '<div class="badge rounded-pill alert-dark"> قديم </div>';
                }
            })
            ->addColumn('actions', function ($qur) {
                $data_attr = '';
                $data_attr .= 'data-id="' . $qur->id  . '" ';
                $data_attr .= 'data-name="' . $qur->subscriber->name . '"';
                $data_attr .= 'data-id_number="' . $qur->subscriber->id_number . '"';
                $data_attr .= 'data-serial_number="' . $qur->subscriber->serial_number . '"';
                $data_attr .= 'data-start="' . $qur->start . '"';
                $data_attr .= 'data-end="' . $qur->end . '"';
                $data_attr .= 'data-mobile="' . $qur->subscriber->mobile . '"';
                $data_attr .= 'data-status_mobile="' . $qur->status_mobile . '"';

                $string = '';
                $string .= '
                   <div class="d-flex align-items-center gap-3 fs-6">

      <div  class="text-warning edit_btn" data-bs-toggle="modal" data-bs-target="#edit-modal" ' . $data_attr . '><i class="bi bi-pencil-fill"></i></div>
      <div class="text-danger delete_btn" data-id="' . $qur->id . '" data-url="/distributor/orders/delete">
      <i class="bi bi-trash-fill"></i>
      </div>
    </div>
      </div>';


                return $string;
            })
            ->rawColumns(['name' , 'package', 'status_number' ,  'status', 'mobile', 'actions'])
            ->make(true);
    }
}
