@extends('admin.master')

@section('title', 'Admin | Home')

@section('css')

@stop

@section('content')



    <div class="row">
        <div class="col-12 col-lg-12 col-xl-12 d-flex">
            <div class="card radius-10 w-100">
                <div class="card-header bg-transparent">
                    <div class="row g-3 align-items-center">
                        <div class="col">
                            <h5 class="mb-0">المشتركين</h5>
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
                                    <th>@lang('status')</th>
                                    <th>@lang('mobile')</th>
                                    <th>@lang('id_number')</th>
                                    <th>@lang('serial_number')</th>
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
                url: "{{ route('admin.user.getdata') }}",
            },

            columns: [{
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
                    data: "status_mobile",
                    name: "status_mobile",
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


            ]
        });

    </script>

@stop
