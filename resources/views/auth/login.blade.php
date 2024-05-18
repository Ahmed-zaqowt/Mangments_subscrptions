<!doctype html>
<html lang="en" class="light-theme" dir="rtl">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
  <!-- Bootstrap CSS -->
  <link href="{{ asset('admin_assets_rtl/css/bootstrap.min.css') }}" rel="stylesheet" />
  <link href="{{  asset('admin_assets_rtl/css/bootstrap-extended.css') }}" rel="stylesheet" />
  <link href="{{ asset('admin_assets_rtl/css/style.css') }}" rel="stylesheet" />
  <link href="{{ asset('admin_assets_rtl/css/icons.css') }}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

  <!-- loader-->
	<link href="{{ asset('admin_assets_rtl/css/pace.min.css') }}" rel="stylesheet" />

  <title>IFutuerTelecom | Login</title>
</head>

<body>

  <!--start wrapper-->
  <div class="wrapper">

       <!--start content-->
       <main class="authentication-content">
        <div class="container-fluid">
          <div class="authentication-card">
            <div class="card shadow rounded-0 overflow-hidden">
              <div class="row g-0">
                <div class="col-lg-6 bg-login d-flex align-items-center justify-content-center">
                  <img src="{{ asset('admin_assets_rtl/images/error/login-img.jpg') }}" class="img-fluid" alt="">
                </div>
                <div class="col-lg-6">
                  <div class="card-body p-4 p-sm-5">
                    <h5 class="card-title">تسجيل الدخول</h5>
                    <p class="card-text mb-5">قم بتسجيل الدخول للسماح لك !</p>
                    <form method="POST" action="{{ route('login') }}" class="form-body">
                     @csrf
                      <div class="login-separater text-center mb-4"> <span>سجل الدخول باستخدام اسم المستخدم</span>
                        <hr>
                      </div>
                      @if ($errors->any())
                <ul>
                    @foreach ($errors->all() as $e)
                       <li class="text-danger">{{ $e }}</li>
                    @endforeach
                </ul>
             @endif
                        <div class="row g-3">
                          <div class="col-12">
                            <label for="email" class="form-label">ادخل اسم المستخدم</label>
                            <div class="ms-auto position-relative">
                              <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="fadeIn animated bx bx-user"></i></div>
                              <input type="text" name="email" class="form-control radius-30 ps-5" id="inputEmailAddress" placeholder="اسم المستخدم">
                            </div>
                          </div>
                          <div class="col-12">
                            <label for="inputChoosePassword" class="form-label">ادخل كلمة المرور</label>
                            <div class="ms-auto position-relative">
                              <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-lock-fill"></i></div>
                              <input type="password" name="password" class="form-control radius-30 ps-5" id="inputChoosePassword" placeholder="كلمة المرور">
                            </div>
                          </div>


                          <div class="col-12">
                            <div class="d-grid">
                              <button type="submit" class="btn btn-primary radius-30">تسجيل الدخول</button>
                            </div>
                          </div>

                        </div>
                    </form>
                 </div>
                </div>
              </div>
            </div>
          </div>
        </div>
       </main>

       <!--end page main-->

  </div>
  <!--end wrapper-->


  <!--plugins-->
  <script src="{{ asset('admin_assets_rtl/js/jquery.min.js') }}"></script>
  <script src="{{ asset('admin_assets_rtl/js/pace.min.js') }}"></script>


</body>

</html>











