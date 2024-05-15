@extends('admin.master')

@section('title' , 'Admin | Home')

@section('css')

    @stop

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

          </div><!--end row-->

    @endif



@stop







