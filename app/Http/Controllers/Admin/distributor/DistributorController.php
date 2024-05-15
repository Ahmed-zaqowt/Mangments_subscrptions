<?php

namespace App\Http\Controllers\Admin\distributor;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Setting;
use App\Models\SMS;
use App\Models\Subscriber;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Vonage\SMS\SentSMS;
use Yajra\DataTables\Facades\DataTables;

class DistributorController extends Controller
{
    function index()
    {
        $packages = Package::orderBy('created_at' , 'desc')->get();
        return view('admin.distributors.index' , compact('packages'));
    }


    function getdata()
    {
        $users = Subscriber::query()->where('user_id' , Auth::user()->id)->orderBy('created_at', 'desc');
        return DataTables::of($users)
            ->addIndexColumn()
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
            ->addColumn(
                'actions',
                function ($qur) {
                    $user = Subscription::query()->where('subscriber_id', $qur->id)->orderBy('created_at', 'desc')->first();
                    $data_attr = '';
                    $data_attr .= 'data-id="' . $qur->id  . '" ';
                    $data_attr .= 'data-name="' . $qur->name . '"';
                    $data_attr .= 'data-id_number="' . $qur->id_number . '"';
                    $data_attr .= 'data-mobile="' . $qur->mobile . '"';
                    $data_attr .= 'data-status-mobile="' . $qur->status_mobile . '"';
                    $data_attr .= 'data-serial_number="' . $qur->serial_number . '"';

                    $string = '';
                    $string .= '
                   <div class="d-flex align-items-center gap-3 fs-6">
                          <div class="dropdown">
      <div class="text-primary dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-eye-fill"></i>
      </div>
      <ul class="dropdown-menu" tabindex="-88888" aria-labelledby="dropdownMenuButton">

        <li> <a href="' . route('dist.user.subsciptions', $qur->id) . '"><div class="dropdown-item followers_btn" data-id="' . $qur->id . '" data-type="followers">' . __('رؤية سجل الاشتراكات') . '</a></div></li>
      </ul>
    </div>

      <div  class="text-warning edit_btn" data-bs-toggle="modal" data-bs-target="#edit-modal" ' . $data_attr . '><i class="bi bi-pencil-fill"></i></div>



     <div class="text-danger delete_btn" data-id="' . $qur->id . '" data-url="/distributor/users/delete">
        <i class="bi bi-trash-fill"></i>
      </div>
    </div>
      </div>';
                    return $string;
                }
            )
            ->rawColumns(['actions' , 'mobile' , 'serial_number',  'status_number' ])
            ->make(true);
    }

    function store(Request $request)
    {
       $subscribers = Subscriber::all();
         if($request->status_mobile == Subscription::OLD){
             $request->validate([
                'mobile' => 'required|string:255|unique:subscribers,mobile',
                'serial_number' => 'required|string:255|unique:subscribers,serial_number',
             ]);
             $mobile = $request->mobile;
            $serial_number = $request->serial_number;

        }else{
            $mobile = 'required'.$subscribers->count().random_int(1, 1000000);
            $serial_number = 'required'.$subscribers->count().random_int(1, 1000000);
        }

        $request->validate([
            'name' => 'required',
            'id_number' => 'required|string:255|unique:subscribers,id_number',
            'start' => 'required',
            'time' => 'required',
            'status_mobile' => 'required' ,
            'package' => 'required',
            'address' => 'required'
        ]);

        $package = Package::findOrFail($request->package)->first();
        $price = $request->time * $package->price ;
        $startDate = Carbon::parse($request->start);
        $endDate = $startDate->addMonths($request->time);

            $subscriber = Subscriber::create([
                'name' => $request->name,
                'mobile' => $mobile,
                'id_number' => $request->id_number,
                'address' => $request->address,
                'serial_number' => $serial_number,
                'user_id' => Auth::user()->id,
                'status_mobile' => $request->status_mobile ,
            ]);

            $sub = Subscription::create([
                'user_id' => Auth::user()->id,
                'subscriber_id' => $subscriber->id,
                'status' => Subscription::WAITING,
                'start' => $request->start,
                'end' => $endDate ,
                'time' => $request->time,
                'package_id' => $request->package,
                'price' => $price
            ]);

            $basic = new \Vonage\Client\Credentials\Basic('ac403f49', '2HbnsHlqYznqPIdg');
            $client = new \Vonage\Client($basic);

            $response = $client->sms()->send(
                new \Vonage\SMS\Message\SMS(env('MOBILE_ADMIN'), 'VEGA' ,'تمت اضافة اشتراك جديد' , 'unicode')
            );

            $message = $response->current();


            return response()->json([
                "success" => "تم ارسال الطلب بنجاح "
            ], 201);

    }


    function update(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255|unique:subscribers,serial_number,' . $request->id,
            'id_number' => 'required|string|max:255|unique:subscribers,id_number,' . $request->id,
            'mobile' => 'required|unique:subscribers,mobile,' . $request->id,
        ]);


        $subscriper = Subscriber::query()->where('id', $request->id)->first();

        $subscriper->update([
            'name' => $request->name,
            'id_number' => $request->id_number,
            'serial_number' => $request->serial_number,
            'mobile' => $request->mobile,

        ]);

        return response()->json([
            'success' => __('تم التعديل بنجاح')
        ], 201);
    }

    function delete(Request $request)
    {

        $user = Subscriber::query()->findOrFail($request->id);
        $user->delete();

        return response()->json(["success" => "Deleted Successful"], 201);
    }

    function subsciptions($id)
    {
        $sub = Subscriber::where('id', $id)->first();
        return view('admin.distributors.subscription', compact('sub'));
    }

    function getdatasub(Request $request)
    {

        $users = Subscription::query()->where('subscriber_id', $request->id)->orderBy('created_at', 'desc');

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('status', function ($qur) {
                if ($qur->status == Subscription::WAITING) {
                    return '<div class="badge rounded-pill alert-info">الاشتراك معلق </div>';
                } elseif ($qur->status == Subscription::ACCEPTED) {
                    return '<div class="badge rounded-pill alert-success">الاشتراك جاري</div>';
                } elseif ($qur->status == Subscription::CANCELED) {
                    return '<div class="badge rounded-pill alert-danger">الاشتراك ملغي </div>';
                } elseif ($qur->status == Subscription::EXPIRED) {
                    return '<div class="badge rounded-pill alert-warning">الاشتراك منتهي </div>';
                }
            })
            ->rawColumns(['status', 'price', 'payment'])
            ->make(true);
    }

    function add_sub(Request $request)
    {

        Subscription::create([
            'user_id' => Auth::user()->id,
            'subscriber_id' => $request->subscriber_id,
            'status' => Subscription::WAITING,
            'payment' => Subscription::NOPAID,
            'start' => $request->start,
            'end' => $request->end,
        ]);

        return redirect()->back()->with(['msg' => 'تمت الاضافة بنجاح']);
    }
}
