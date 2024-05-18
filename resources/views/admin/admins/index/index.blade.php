@extends('admin.master')

@section('title' , 'Admin | Home')

@section('css')

    @stop
@php
    use App\Models\Subscription ;
@endphp
@section('content')
    @if(Auth::user()->status == 1)
        <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-4">
            <div class="col">
              <div class="card overflow-hidden radius-10">
                  <div class="card-body p-2">
                   <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                    <div class="w-50 p-3 bg-light-primary">
                      <p>الطلبات المعلقة    </p>
                      <h4 class="text-primary">{{ $wait }}</h4>
                    </div>
                    <div class="w-50 bg-primary p-3">
                      <a href="{{ route('admin.order.index') }}"> <p class="mb-3 text-white"> معاينة التفاصيل<i class="bi bi-arrow-up"></i></p></a>
                       <div id="chart1"></div>
                    </div>
                  </div>
                </div>
              </div>
             </div>
             <div class="col">
              <div class="card overflow-hidden radius-10">
                  <div class="card-body p-2">
                   <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                    <div class="w-50 p-3 bg-light-primary">
                      <p>الطلبات الملغية</p>
                      <h4 class="text-primary">{{ $cancel }}</h4>
                    </div>
                    <div class="w-50 bg-primary p-3">
                        <a href="{{ route('admin.order.canceled') }}"> <p class="mb-3 text-white"> معاينة التفاصيل<i class="bi bi-arrow-up"></i></p></a>               <div id="chart2"></div>
                    </div>
                  </div>
                </div>
              </div>
             </div>
             <div class="col">
              <div class="card overflow-hidden radius-10">
                  <div class="card-body p-2">
                   <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                    <div class="w-50 p-3 bg-light-primary">
                      <p>المرسلة للتجديد</p>
                      <h4 class="text-primary">{{  $re }}</h4>
                    </div>
                    <div class="w-50 bg-primary p-3">
                        <a href="{{ route('admin.order.renewal') }}"> <p class="mb-3 text-white"> معاينة التفاصيل<i class="bi bi-arrow-up"></i></p></a>               <div id="chart3"></div>
                    </div>
                  </div>
                </div>
              </div>
             </div>
             <div class="col">
              <div class="card overflow-hidden radius-10">
                  <div class="card-body p-2">
                   <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                    <div class="w-50 p-3 bg-light-primary">
                      <p>الاشتراكات الجارية</p>
                      <h4 class="text-primary">{{ $accept }}</h4>
                    </div>
                    <div class="w-50 bg-primary p-3">
                        <a href="{{ route('admin.subscription.accepted') }}"> <p class="mb-3 text-white"> معاينة التفاصيل<i class="bi bi-arrow-up"></i></p></a>               <div id="chart4"></div>
                    </div>
                  </div>
                </div>
              </div>
             </div>
          </div><!--end row-->

          <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-4">
            <div class="col">
              <div class="card overflow-hidden radius-10">
                  <div class="card-body p-2">
                   <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                    <div class="w-50 p-3 bg-light-primary">
                      <p> الاشتراكات المنتهية    </p>
                      <h4 class="text-primary">{{ $ex }}</h4>
                    </div>
                    <div class="w-50 bg-primary p-3">
                       <a href="{{ route('admin.subscription.expired') }}"><p class="mb-3 text-white"> معاينة التفاصيل<i class="bi bi-arrow-up"></i></p></a>
                       <div id="chart1"></div>
                    </div>
                  </div>
                </div>
              </div>
             </div>
             <div class="col">
              <div class="card overflow-hidden radius-10">
                  <div class="card-body p-2">
                   <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                    <div class="w-50 p-3 bg-light-primary">
                      <p> الموزعين</p>
                      <h4 class="text-primary">{{ $admins }}</h4>
                    </div>
                    <div class="w-50 bg-primary p-3">
                        <a href="{{ route('admin.admin.index') }}"><p class="mb-3 text-white"> معاينة التفاصيل<i class="bi bi-arrow-up"></i></p></a>
                       <div id="chart2"></div>
                    </div>
                  </div>
                </div>
              </div>
             </div>
             <div class="col">
              <div class="card overflow-hidden radius-10">
                  <div class="card-body p-2">
                   <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                    <div class="w-50 p-3 bg-light-primary">
                      <p>المشتركين</p>
                      <h4 class="text-primary">{{  $users }}</h4>
                    </div>
                    <div class="w-50 bg-primary p-3">
                        <a href="{{ route('admin.user.index') }}"><p class="mb-3 text-white"> معاينة التفاصيل<i class="bi bi-arrow-up"></i></p></a>
                           <div id="chart3"></div>
                    </div>
                  </div>
                </div>
              </div>
             </div>
             <div class="col">
              <div class="card overflow-hidden radius-10">
                  <div class="card-body p-2">
                   <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                    <div class="w-50 p-3 bg-light-primary">
                      <p>الحزم</p>
                      <h4 class="text-primary">{{ $packages }}</h4>
                    </div>
                    <div class="w-50 bg-primary p-3">
                        <a href="{{ route('admin.package.index') }}"><p class="mb-3 text-white"> معاينة التفاصيل<i class="bi bi-arrow-up"></i></p></a>               <div id="chart4"></div>
                    </div>
                  </div>
                </div>
              </div>
             </div>
          </div><!--end row-->


          <div class="row">
            <div class="col-12 col-lg-12 ">
              <div class="card radius-10 w-100">
                <div class="card-header bg-transparent">
                  <div class="row g-3 align-items-center">
                    <div class="col">
                      <h5 class="mb-0">المشتركين الذين سينفذ اشتراكهم قريبا  </h5>
                    </div>

                   </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>@lang('name_dist')</th>
                                    <th>@lang('name')</th>
                                    <th>@lang('mobile')</th>
                                    <th>@lang('status_number')</th>
                                    <th>@lang('id_number')</th>
                                    <th>@lang('serial_number')</th>
                                    <th>@lang('package')</th>
                                    <th>@lang('start')</th>
                                    <th>@lang('end')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users_ended_soon as $u)
                                   <tr>
                                    <th scope="row">{{ $loop->index }}</th>
                                    <td>{{ $u->user->email }}</td>
                                    <td>{{ $u->subscriber->name }}</td>
                                    <td>{{ $u->subscriber->mobile }}</td>
                                    <td>{{ $u->subscriber->status_mobile = 6 ? 'قديم ' : 'جديد' }}</td>
                                    <td>{{ $u->subscriber->id_number }}</td>
                                    <td>{{ $u->subscriber->serial_number }}</td>
                                    <td>{{ $u->package->name }}</td>
                                    <td>{{ $u->start }}</td>
                                    <td>{{ $u->end }}</td>
                                  </tr>
                                @empty
                                <tr>
                                    <td class="text-center" colspan="10">                                     لا يوجد مستخدمين
                                    </td>

                                </tr>
                                @endforelse

                              </tbody>
                        </table>
                    </div>
                </div>
              </div>
            </div>
        </div>








          @endif

    @if(Auth::user()->status == 2)
        <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-4">
            <div class="col">
              <div class="card overflow-hidden radius-10">
                  <div class="card-body p-2">
                   <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                    <div class="w-50 p-3 bg-light-primary">
                      <p>الطلبات المعلقة    </p>
                      <h4 class="text-primary">{{ $wait }}</h4>
                    </div>
                    <div class="w-50 bg-primary p-3">
                        <a href="{{ route('dist.subscription.expired') }}"><p class="mb-3 text-white"> معاينة التفاصيل<i class="bi bi-arrow-up"></i></p></a>
                       <div id="chart1"></div>
                    </div>
                  </div>
                </div>
              </div>
             </div>
             <div class="col">
              <div class="card overflow-hidden radius-10">
                  <div class="card-body p-2">
                   <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                    <div class="w-50 p-3 bg-light-primary">
                      <p>الطلبات الملغية</p>
                      <h4 class="text-primary">{{ $cancel }}</h4>
                    </div>
                    <div class="w-50 bg-primary p-3">
                        <a href="{{ route('dist.order.canceled') }}"><p class="mb-3 text-white"> معاينة التفاصيل<i class="bi bi-arrow-up"></i></p></a>
                       <div id="chart2"></div>
                    </div>
                  </div>
                </div>
              </div>
             </div>
             <div class="col">
              <div class="card overflow-hidden radius-10">
                  <div class="card-body p-2">
                   <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                    <div class="w-50 p-3 bg-light-primary">
                      <p>المرسلة للتجديد</p>
                      <h4 class="text-primary">{{  $re }}</h4>
                    </div>
                    <div class="w-50 bg-primary p-3">
                        <a href="{{ route('dist.order.renewal') }}"><p class="mb-3 text-white"> معاينة التفاصيل<i class="bi bi-arrow-up"></i></p></a>
                       <div id="chart3"></div>
                    </div>
                  </div>
                </div>
              </div>
             </div>
             <div class="col">
              <div class="card overflow-hidden radius-10">
                  <div class="card-body p-2">
                   <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                    <div class="w-50 p-3 bg-light-primary">
                      <p>الاشتراكات الجارية</p>
                      <h4 class="text-primary">{{ $accept }}</h4>
                    </div>
                    <div class="w-50 bg-primary p-3">
                        <a href="{{ route('dist.subscription.accepted') }}"><p class="mb-3 text-white"> معاينة التفاصيل<i class="bi bi-arrow-up"></i></p></a>
                       <div id="chart4"></div>
                    </div>
                  </div>
                </div>
              </div>
             </div>
          </div><!--end row-->

          <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-4">
            <div class="col">
                <div class="card overflow-hidden radius-10">
                    <div class="card-body p-2">
                     <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                      <div class="w-50 p-3 bg-light-primary">
                        <p> الاشتراكات المنتهية    </p>
                        <h4 class="text-primary">{{ $ex }}</h4>
                      </div>
                      <div class="w-50 bg-primary p-3">
                         <a href="{{ route('dist.subscription.expired') }}"><p class="mb-3 text-white"> معاينة التفاصيل<i class="bi bi-arrow-up"></i></p></a>
                         <div id="chart1"></div>
                      </div>
                    </div>
                  </div>
                </div>
               </div>

               <div class="col">
                <div class="card overflow-hidden radius-10">
                    <div class="card-body p-2">
                     <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                      <div class="w-50 p-3 bg-light-primary">
                        <p>المشتركين</p>
                        <h4 class="text-primary">{{  $users }}</h4>
                      </div>
                      <div class="w-50 bg-primary p-3">
                          <a href="{{ route('dist.user.index') }}"><p class="mb-3 text-white"> معاينة التفاصيل<i class="bi bi-arrow-up"></i></p></a>
                             <div id="chart3"></div>
                      </div>
                    </div>
                  </div>
                </div>
               </div>
               <div class="col">
                <div class="card overflow-hidden radius-10">
                    <div class="card-body p-2">
                     <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                      <div class="w-50 p-3 bg-light-primary">
                        <p>  المشتركين الفعالين    </p>
                        <h4 class="text-primary">{{ $user_acc }}</h4>
                      </div>
                      <div class="w-50 bg-primary p-3">
                         <a href="{{ route('dist.subscription.accepted') }}"><p class="mb-3 text-white"> معاينة التفاصيل<i class="bi bi-arrow-up"></i></p></a>
                         <div id="chart1"></div>
                      </div>
                    </div>
                  </div>
                </div>
               </div>

               <div class="col">
                <div class="card overflow-hidden radius-10">
                    <div class="card-body p-2">
                     <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                      <div class="w-50 p-3 bg-light-primary">
                        <p>المشتركين المعطلين </p>
                        <h4 class="text-primary">{{  $user_ex }}</h4>
                      </div>
                      <div class="w-50 bg-primary p-3">
                          <a href="{{ route('dist.order.index') }}"><p class="mb-3 text-white"> معاينة التفاصيل<i class="bi bi-arrow-up"></i></p></a>
                             <div id="chart3"></div>
                      </div>
                    </div>
                  </div>
                </div>
               </div>
            </div>


            <div class="row">
                <div class="col-12 col-lg-12 ">
                  <div class="card radius-10 w-100">
                    <div class="card-header bg-transparent">
                      <div class="row g-3 align-items-center">
                        <div class="col">
                          <h5 class="mb-0">اضافة مشترك جديد</h5>
                        </div>

                       </div>
                    </div>
                    <div class="card-body">
                        <form class="form_add" id="form_add" enctype="multipart/form-data"
                        action="{{ route('dist.user.store') }}" method="POST">
                        @csrf
                        <div class="mb-2 form-group">
                            <label class="form-label">@lang('name')</label>
                            <input placeholder="@lang('name')" name="name" class="form-control" type="text">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-2 form-group">
                            <label class="form-label">@lang('حالة رقم الجدوال')</label>
                            <select name="status_mobile" class="form-control">
                                <option disabled selected>حالة رقم الجوال</option>
                                <option value="6">قديم</option>
                                <option value="7">جديد</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-2 form-group">
                            <label class="form-label">@lang('mobile')</label>
                            <input id="mobile" placeholder="@lang('mobile')" name="mobile" class="form-control" type="text">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-2 form-group">
                            <label class="form-label">@lang('الرقم التسلسلي للشريحة')</label>
                            <input id="serial_number" placeholder="@lang('الرقم التسلسلي للشريحة')" name="serial_number" class="form-control"
                                type="text">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-2 form-group">
                            <label class="form-label">@lang('رقم الهوية')</label>
                            <input placeholder="@lang('رقم الهوية')" name="id_number" class="form-control" type="text">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-2 form-group">
                            <label class="form-label">@lang(' العنوان')</label>
                            <input placeholder="@lang(' العنوان')" name="address" class="form-control" type="text">
                            <div class="invalid-feedback"></div>
                        </div>



                        <div class="mb-2 form-group">
                            <label class="form-label">@lang('بداية الاشتراك')</label>
                            <input placeholder="@lang('بداية الاشتراك')" name="start" class="form-control" type="date">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-2 form-group">
                            <label class="form-label">@lang('مدة الاشتراك')</label>
                            <select name="time" class="form-control">
                                <option disabled selected> مدة الاشتراك</option>
                                <option value="1">شهر</option>
                                <option value="2">شهرين</option>
                                <option value="3">ثلاث شهور</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-2 form-group">
                            <label class="form-label">@lang(' نوع الحزمة المرادة')</label>
                            <select name="package" class="form-control" type="date">
                                <option disabled selected>اختر نوع الحزمة </option>
                                @foreach ($packages as $package)
                                    <option value="{{ $package->id }}"> {{ $package->name }}</option>
                                @endforeach

                            </select>
                            <div class="invalid-feedback"></div>
                        </div>



                            <button type="submit" class="btn btn-info mt-3 col-12">اضافة</button>
                    </form>
                    </div>
                  </div>
                </div>
            </div>



            <div class="row">
                <div class="col-12 col-lg-12 ">
                  <div class="card radius-10 w-100">
                    <div class="card-header bg-transparent">
                      <div class="row g-3 align-items-center">
                        <div class="col">
                          <h5 class="mb-0">المشتركين الذين سينفذ اشتراكهم قريبا  </h5>
                        </div>

                       </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('name')</th>
                                        <th>@lang('mobile')</th>
                                        <th>@lang('status_number')</th>
                                        <th>@lang('id_number')</th>
                                        <th>@lang('serial_number')</th>
                                        <th>@lang('package')</th>
                                        <th>@lang('start')</th>
                                        <th>@lang('end')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users_ended_soon as $u)
                                       <tr>
                                        <th scope="row">{{ $loop->index }}</th>
                                        <td>{{ $u->subscriber->name }}</td>
                                        <td>{{ $u->subscriber->mobile }}</td>
                                        <td>{{ $u->subscriber->status_mobile = 6 ? 'قديم ' : 'جديد' }}</td>
                                        <td>{{ $u->subscriber->id_number }}</td>
                                        <td>{{ $u->subscriber->serial_number }}</td>
                                        <td>{{ $u->package->name }}</td>
                                        <td>{{ $u->start }}</td>
                                        <td>{{ $u->end }}</td>
                                      </tr>
                                    @empty
                                    <tr>
                                        <td class="text-center" colspan="9">                                     لا يوجد مستخدمين
                                        </td>

                                    </tr>
                                    @endforelse

                                  </tbody>
                            </table>
                        </div>
                    </div>
                  </div>
                </div>
            </div>

          @endif



@stop
@section('js')

<script>
     $(document).ready(function() {
            // اكتشاف تغيير في قيمة حقل "حالة رقم الجوال"
            $('select[name="status_mobile"]').change(function() {
                // إذا كانت القيمة قديم، عرض حقول "رقم الجوال" و"الرقم التسلسلي للشريحة"
                if ($(this).val() == '6') {
                    $('input[id="mobile"]').closest('.form-group').show();
                    $('input[id="serial_number"]').closest('.form-group').show();
                } else {
                    // إخفاء الحقول إذا كانت القيمة غير قديمة
                    $('input[id="mobile"]').closest('.form-group').hide();
                    $('input[id="serial_number"]').closest('.form-group').hide();
                }
            });

            // الخفاء الأولي لحقول "رقم الجوال" و"الرقم التسلسلي للشريحة"
            $('input[id="mobile"]').closest('.form-group').hide();
            $('input[id="serial_number"]').closest('.form-group').hide();
        });
</script>

@stop






