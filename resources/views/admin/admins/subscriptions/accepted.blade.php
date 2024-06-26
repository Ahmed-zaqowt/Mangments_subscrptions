@extends('admin.master')

@section('title' , 'Admin | Home')

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
                    <form class="form_add" id="form_add" enctype="multipart/form-data" action="{{ route('admin.admin.store')  }}"  method="POST">
                        @csrf
                        <div class="mb-2 form-group">
                            <label class="form-label">@lang("name")</label>
                            <input  placeholder="@lang('name')"  name="name" class="form-control" type="text">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-2 form-group">
                            <label class="form-label">@lang("user_name") <small>(@lang('must_be_unique'))</small></label>
                            <input  placeholder="@lang('user_name')"  name="username" class="form-control" type="text">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-2 form-group">
                            <label class="form-label">@lang("mobile")</label>
                            <input  placeholder="@lang('mobile')"  name="mobile" class="form-control" type="text">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-2 form-group">
                            <label class="form-label">@lang("password")</label>
                            <input  placeholder="@lang('password')"  name="password" class="form-control" type="text">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang("close")</button>
                            <button type="submit" class="btn btn-info">@lang("save")</button>
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
                    <form class="form_edit" id="form_edit" enctype="multipart/form-data" action="{{ route('admin.admin.update')  }}"  method="POST">
                        @csrf
                        <input type="hidden" name="id" id="id"  class="form-control">
                        <div class="mb-2 form-group">
                            <label class="form-label">@lang("name")</label>
                            <input id="edit_name" placeholder="@lang('name')"  name="name" class="form-control" type="text">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-2 form-group">
                            <label class="form-label">@lang("user_name")</label>
                            <input id="edit_username" placeholder="@lang('user_name')"  name="username" class="form-control" type="text">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-2 form-group">
                            <label class="form-label">@lang("mobile")</label>
                            <input id="edit_mobile" placeholder="@lang('mobile')"  name="mobile" class="form-control" type="text">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-2 form-group">
                            <label class="form-label">@lang("password")</label>
                            <input  placeholder="@lang('password')"  name="password" class="form-control" type="text">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang("close")</button>
                            <button type="submit" class="btn btn-info">@lang("save")</button>
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
                            <h5 class="mb-0">@lang(' الاشتراكات الجارية')</h5>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>@lang('name_dis')</th>
                                    <th>@lang('name')</th>
                                    <th>@lang('mobile')</th>
                                    <th>@lang('status')</th>
                                    <th>@lang('package')</th>
                                    <th>@lang('times')</th>
                                    <th>@lang('start_sub')</th>
                                    <th>@lang('end_sub')</th>
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
                    url: "{{ route('admin.subscription.getdataaccepted') }}",
                },

                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "name_dis",
                        name: "name_dis",
                        orderable: true,
                        searchable: true
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
                        data: "status",
                        name: "status",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "package",
                        name: "package",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "time",
                        name: "time",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "start",
                        name: "start",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "end",
                        name: "end",
                        orderable: true,
                        searchable: true
                    },

                    {
                        data: "actions",
                        name: "actions",
                        orderable: true,
                        searchable: true
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
                    $('#edit_username').val(button.data('username'))
                    $('#edit_mobile').val(button.data('mobile'))
                    //$('#image_preview').src(button.data('image'))
                    var imageURL = button.data('image');

                    // اعثر على عنصر الصورة باستخدام الهوية وقم بتعيين الرابط
                    var imagePreview = document.getElementById('image_preview');
                    imagePreview.src = imageURL;
                });
            });

            $(document).ready(function() {
            $(document).on('change', '.select_status', function(event) {
                if(confirm("هل تريد فعلا تعديل حالة الطلب ؟؟ ")){
                    var form =  document.getElementById("form_status");
              var data = new FormData(form) ;
              let url = $(form).attr('action');
              var method = $(form).attr('method');
                $.ajax({
                    type: method,
                    cache: false,
                    contentType: false,
                    processData: false,
                    url: url ,
                    data: data,

                    beforeSend: function() {},
                    success: function(result) {
                        toastr.success(result.success);
                        table.draw()
                    },
                    error: function(data) {
                        if (data.status === 422) {
                            var response = data.responseJSON;
                            $.each(response.errors, function(key, value) {
                                var str = (key.split("."));
                                if (str[1] === '0') {
                                    key = str[0] + '[]';
                                }
                                $('[name="' + key + '"], [name="' + key + '[]"]').addClass(
                                    'is-invalid');
                                $('[name="' + key + '"], [name="' + key + '[]"]').closest(
                                    '.form-group').find('.invalid-feedback').html(value[0]);
                            });
                        } else {
                            console.log('ahmed');
                        }
                    }
                });
                }else{
                    document.getElementById("form_status").reset();
                }

            });
        });

    </script>

@stop






