<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container-xxl" id="kt_content_container">
    <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6" data-select2-id="select2-data-124-g3f4">
                <!--begin::Card title-->
                <div class="card-title">
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">

                    <!--begin::Filter-->
                    <button type="button" class="btn btn-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                    <i class="fa fa-file-export"></i>
                    <!--end::Svg Icon-->Export</button>
                    <!--begin::Menu 1-->
                    <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true" style="">
                        <!--begin::Header-->
                        <div class="px-7 py-5">
                            <div class="fs-5 text-dark fw-bolder">Export</div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Separator-->
                        <div class="separator border-gray-200"></div>
                        <!--end::Separator-->
                        <!--begin::Content-->
                        <div class="px-7 py-5" data-kt-user-table-filter="form">
                            <button type="button" class="btn btn-light-primary mb-3 w-100" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" onClick="exportExcel()">
                                Excel
                            </button>
                            <button type="button" class="btn btn-light-primary mb-3 w-100" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" onClick="exportPDF()">
                                PDF
                            </button>
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Menu 1-->
                    <!--end::Filter-->
                    </div>
                    
                    <!--end::Toolbar-->
                    
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body py-4">
                    <table id="report-table" class="table align-middle table-row-dashed fs-6 gy-5">
                        <thead>
                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th>No</th>
                                <th>Broadcast Name</th>
                                <th>Type</th>
                                <th>Success</th>
                                <th>Failed</th>
                                <th>Total</th>
                                <th>Broadcast at</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-bold">
                        </tbody>
                    </table>
                <h2 class="text-gray-400 text-center mt-8 no-contact d-none ">Belum ada contact tersimpan</h2>
                <div class="flex-grow-1 bgi-no-repeat bgi-size-contain bgi-position-x-center card-rounded-bottom h-200px mh-200px my-5 my-lg-12 no-contact d-none" style="background-image:url('assets/media/illustrations/sigma-1/18.png')"></div>
            <!--end::Card body-->
            </div>
        </div>
    </div>
</div>

<!-- Modal-->
<div class="modal fade" id="modal-report" data-bs-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Message</h5>
            </div>
            <div class="modal-body pb-10" id="qr-content">
                
                    <table id="detail-table" class="table align-middle table-row-dashed fs-6 gy-5">
                        <thead>
                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th>No</th>
                                <th>Sender</th>
                                <th>To</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-bold">
                        </tbody>
                    </table>
            </div>
            <div class="modal-footer text-right">
                <button type="button" class="btn btn-light-danger font-weight-bold" data-bs-dismiss="modal">Close</button>
                   
            </div>
        </div>
    </div>
</div>
@push('custom-scripts')
<script>
    var table;
    $('document').ready(function () {
        // table serverside
        table = $('#report-table').DataTable({
            processing: false,
            serverSide: true,
            ordering: false,
            dom:
                "<'row'" +
                "<'col-sm-6 d-flex align-items-center justify-content-start'f>" +
                ">" +
                "<'table-responsive'tr>" +

                "<'row'" +
                "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'l>" +
                "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                ">",
            buttons: [
                'excel', 'pdf'
            ],
            ajax: "{{ route('report.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'schedule',
                    name: 'schedule'
                },
                {
                    data: 'success',
                    name: 'success'
                },
                {
                    data: 'failed',
                    name: 'failed'
                },
                {
                    data: 'total',
                    name: 'total'
                },
                {
                    data: 'broadcast_at',
                    name: 'broadcast_at'
                },
                {
                    data: 'detail',
                    name: 'detail'
                },
            ],
			drawCallback: function (settings) {
			    $('[data-toggle="tooltip"]').tooltip();
			}
        });
        
        // initialize btn delete
        $('body').on('click', '.detailReport', function () {
            var id = $(this).data("id");
                $('#modal-report').modal('show');
                $("#detail-table").dataTable().fnDestroy()
                $('#detail-table').DataTable({
                    processing: false,
                    serverSide: true,
                    ordering: false,
                    dom:
                        "<'row'" +
                        "<'col-sm-6 d-flex align-items-center justify-content-start'f>" +
                        ">" +
                        "<'table-responsive'tr>" +

                        "<'row'" +
                        "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'l>" +
                        "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                        ">",
                    buttons: [
                        'excel', 'pdf'
                    ],
                    ajax: "{{ route('report.getDetailMessage') }}" + "/?id="+id,
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                        {
                            data: 'sender',
                            name: 'sender'
                        },
                        {
                            data: 'number',
                            name: 'number'
                        },
                        {
                            data: 'stat',
                            name: 'stat'
                        },
                    ],
                    drawCallback: function (settings) {
                        $('[data-toggle="tooltip"]').tooltip();
                    }
                });
        });


    });

    function searchData(){
        var status      = $('#status').val();
        var number      = $('#number').val();
        table.ajax.url( "{{ route('report.index') }}" + "?status=" + status + "&number=" + number).load();
    }

</script>
@endpush
