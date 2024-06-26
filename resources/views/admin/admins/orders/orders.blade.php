@extends('admin.master')

@section('title' , 'Admin | Home')

@section('css')

    @stop

@section('content')



<div class="modal fade" id="edit-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">اضافة بيانات الشريحة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form_edit" id="form_edit" enctype="multipart/form-data" action="{{ route('admin.order.update_numbers')  }}"  method="POST">
                    @csrf
                    <input type="hidden" name="id" id="id"  class="form-control">
                    <div class="mb-2 form-group">
                        <label class="form-label">رقم الجوال الجديد</label>
                        <input id="edit_mobile" placeholder="@lang('mobile')" name="mobile" class="form-control"
                            type="text">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-2 form-group">
                        <label class="form-label">الرقم التسلسلي الجديد</label>
                        <input id="edit_serial_number" placeholder="@lang('serial_number')" name="serial_number"
                            class="form-control" type="text">
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
                            <h5 class="mb-0">@lang(' الطلبات المعلقة')</h5>
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
                                <th>@lang('serial_number')</th>
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




            $(document).ready(function() {
            $(document).on('change', '.select_status', function(event) {
                if (confirm("هل تريد فعلا تعديل حالة الطلب ؟؟ ")) {
                    var form = document.getElementById("form_status");
                    var data = new FormData(form);
                    let url = $(form).attr('action');
                    var method = $(form).attr('method');
                    var input = document.getElementById("status_mobile");
                    var id = document.getElementById("id_subscriber");
                    if(input.value == 7){
                        $("#edit-modal").modal("show");
                        $("#id").val(id.value);
                        document.getElementById("form_status").reset();
                    }else{
                        console.log('ahmed');
                        $.ajax({
                        type: method,
                        cache: false,
                        contentType: false,
                        processData: false,
                        url: url,
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
                                    $('[name="' + key + '"], [name="' + key + '[]"]')
                                        .addClass(
                                            'is-invalid');
                                    $('[name="' + key + '"], [name="' + key + '[]"]')
                                        .closest(
                                            '.form-group').find('.invalid-feedback')
                                        .html(value[0]);
                                });
                            } else {
                                console.log('ahmed');
                            }
                        }
                    });
                    }
                } else {
                    document.getElementById("form_status").reset();
                }
            });
        });

            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                responsive: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json',
                },
                ajax: {
                    url: "{{ route('admin.order.getdata') }}",
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
                        data: "serial_number",
                        name: "serial_number",
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





    </script>

@stop






