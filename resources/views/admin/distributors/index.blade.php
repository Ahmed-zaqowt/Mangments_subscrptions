@extends('admin.master')

@section('title', 'Admin | Home')

@section('css')

@stop

@section('content')

    <div class="modal fade" id="add-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('update') @lang('user')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">@lang('close')</button>
                            <button type="submit" class="btn btn-info">@lang('save')</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>


    <div class="modal fade" id="edit-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('update') @lang('user')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form_edit" id="form_edit" enctype="multipart/form-data"
                        action="{{ route('dist.user.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="id" class="form-control">
                        <div class="mb-2 form-group">
                            <label class="form-label">@lang('name')</label>
                            <input id="edit_name" placeholder="@lang('name')" name="name" class="form-control"
                                type="text">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-2 form-group">
                            <label class="form-label">رقم الهوية </label>
                            <input id="edit_id_number" placeholder="رقم الهوية" name="id_number" class="form-control"
                                type="text">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-2 form-group">
                            <label class="form-label">@lang('mobile')</label>
                            <input id="edit_mobile" placeholder="@lang('mobile')" name="mobile" class="form-control"
                                type="text">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-2 form-group">
                            <label class="form-label">@lang('serial_number')</label>
                            <input id="edit_serial_number" placeholder="@lang('serial_number')" name="serial_number"
                                class="form-control" type="text">
                            <div class="invalid-feedback"></div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">@lang('close')</button>
                            <button type="submit" class="btn btn-info">@lang('save')</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>






    <div class="row">
        <div class="col-12 col-lg-12 col-xl-12 d-flex">
            <div class="card radius-10 w-100">
                <div class="card-header bg-transparent">
                    <div class="row g-3 align-items-center">
                        <div class="col">
                            <h5 class="mb-0">المشتركين</h5>
                        </div>
                        <div class="col">
                            <div class="d-flex align-items-center justify-content-end gap-3 cursor-pointer">
                                <div class="dropdown">
                                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#"
                                        data-bs-toggle="dropdown" aria-expanded="false"><i
                                            class="fadeIn animated bx bx-plus-medical font-22 text-option"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li data-bs-toggle="modal" data-bs-target="#add-modal"><a
                                                class="dropdown-item">@lang('add')</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>@lang('name')</th>
                                    <th>@lang('mobile')</th>
                                    <th>@lang('id_number')</th>
                                    <th>@lang('serial_number')</th>
                                    <th>@lang('actions')</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
@section('js')
    <script>
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: false,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json',
            },
            ajax: {
                url: "{{ route('dist.user.getdata') }}",
            },

            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: "name",
                    name: "name",
                    orderable: true,
                    searchable: true
                },

                {
                    data: "mobile",
                    name: "mobile",
                    orderable: true,
                    searchable: true
                },

                {
                    data: "id_number",
                    name: "id_number",
                    orderable: true,
                    searchable: true
                },

                {
                    data: "serial_number",
                    name: "serial_number",
                    orderable: true,
                    searchable: true
                },

                {
                    data: "actions",
                    name: "actions",
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $(document).ready(function() {
            $(document).on('click', '.edit_btn', function(event) {
                $('input').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                event.preventDefault();
                var button = $(this)
                var id = button.data('id');
                $('#id').val(id);
                $('#edit_name').val(button.data('name'))
                $('#edit_id_number').val(button.data('id_number'))
                $('#edit_serial_number').val(button.data('serial_number'))
                $('#edit_mobile').val(button.data('mobile'))
                if (button.data('status-mobile') == '6') {
                    $('input[id="edit_mobile"]').closest('.form-group').show();
                    $('input[id="edit_serial_number"]').closest('.form-group').show();
                } else {
                    // إخفاء الحقول إذا كانت القيمة غير قديمة
                    $('input[id="edit_mobile"]').closest('.form-group').hide();
                    $('input[id="edit_serial_number"]').closest('.form-group').hide();
                }
            });
        });

        $(document).ready(function() {
            $(document).on('click', '.add_sub_btn', function(event) {
                $('input').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                event.preventDefault();
                var button = $(this)
                var user_id = button.data('user_id');
                var subscriber_id = button.data('subscriber_id');
                $('#user_id').val(user_id);
                $('#subscriber_id').val(subscriber_id);
            });
        });


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
