<?php

namespace App\Http\Controllers\Admin\Package;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PackageController extends Controller
{
    function index() {
      return view('admin.packages.index');
    }

    function getdata()
    {
        $users = Package::query()->orderBy('created_at', 'desc');

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn(
                'actions',
                function ($qur) {
                    $data_attr = '';
                    $data_attr .= 'data-id="' . $qur->id  . '" ';
                    $data_attr .= 'data-name="' . $qur->name . '"';
                    $data_attr .= 'data-price="' . $qur->price . '"';

                    $string = '';
                    $string .= '
                   <div class="d-flex align-items-center gap-3 fs-6">
                          <div class="dropdown">


    </div>

      <div  class="text-warning edit_btn" data-bs-toggle="modal" data-bs-target="#edit-modal" ' . $data_attr . '><i class="bi bi-pencil-fill"></i></div>



     <div class="text-danger delete_btn" data-id="' . $qur->id . '" data-url="/admin/packages/delete">
        <i class="bi bi-trash-fill"></i>
      </div>
    </div>
      </div>';
                    return $string;
                }
            )
            ->rawColumns(['actions' ])
            ->make(true);
    }

    function store(Request $request)
    {


        $request->validate([
            'name' => 'required',
            'price' => 'required',

        ]);

            $package = Package::create([
                'name' => $request->name,
                'price' => $request->price,
            ]);

            return response()->json([
                "success" => "تم اضافة الحزمة بنجاح "
            ], 201);

    }


    function update(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required',
        ]);


        $package = Package::query()->where('id', $request->id)->first();

        $package->update([
            'name' => $request->name,
            'price' => $request->price,

        ]);

        return response()->json([
            'success' => __('تم التعديل بنجاح')
        ], 201);
    }

    function delete(Request $request)
    {

        $package = Package::query()->findOrFail($request->id);
        $package->delete();

        return response()->json(["success" => "تم الحذف بنجاح"], 201);
    }

}
