        
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

                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">

                        <!--begin::Filter-->
                        <button type="button" class="btn btn-primary" onClick="addData()">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                        <i class="fa fa-plus"></i>
                        <!--end::Svg Icon-->Tambah Data</button>
                        <!--end::Filter-->
                    </div>
                    <!--end::Toolbar-->
                    
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body py-4">
                <div id="table_data" >
                    <table id="data-table" class="table align-middle table-row-dashed fs-6 gy-5">
                        <thead>
                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Role</th>
                            <th class="text-center w-100px dt-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-bold">
                        </tbody>
                    </table>
                </div>
                <h2 class="text-gray-400 text-center mt-8 no-data d-none ">Belum ada data produk</h2>
                <div class="flex-grow-1 bgi-no-repeat bgi-size-contain bgi-position-x-center card-rounded-datatom h-200px mh-200px my-5 my-lg-12 no-data d-none" style="background-image:url('assets/media/illustrations/sigma-1/18.png')"></div>
            <!--end::Card body-->
            </div>
        </div>
    </div>
</div>

<!-- Modal-->
<div class="modal fade" id="modal-entri" data-bs-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Data Pengguna</h5>
            </div>
            <div class="modal-body pb-10">
                <form id="formData" name="formData">
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="uid" id="uid">
                    <label class="fs-6 fw-bold form-label">Nama</label>
                    <div class="input-group mb-5">
                        <input type="text" name="name" id="name" class="form-control" placeholder="Nama">
                    </div>

                    <label class="fs-6 fw-bold form-label">Nomor WA</label>
                    <div class="input-group mb-5">
                        <input type="text" name="number" id="number" class="form-control" placeholder="Nomor WA">
                    </div>

                    <label class="fs-6 fw-bold form-label">Email</label>
                    <div class="input-group mb-5">
                        <input type="text" name="email" id="email" class="form-control" placeholder="Email">
                    </div>

                    <label class="fs-6 fw-bold form-label">Password</label>
                    <div class="input-group mb-5">
                        <input type="text" name="password" id="password" class="form-control" placeholder="Password">
                    </div>

                    <label class="fs-6 fw-bold form-label">Hak Akses</label>
                    <div class="input-group mb-5">
                        <select class="form-control select2" id="level" name="level" >
                            <option >Hak Akses</option>
                            <option value="1">Admin</option>
                            <option value="2">User</option>
                        </select>
                    </div>
                </form>
                <!--end::Form-->
            </div>
            <div class="modal-footer d-flex text-right">
                <button type="button" class="btn btn-light-danger me-5" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onClick="saveData()" >Save Data</button>
                   
            </div>
        </div>
    </div>
</div>

@push('custom-scripts')
<script>
    
    function addData(){
        $('#formData').trigger("reset");
        $('#id').val('');
        $('#modal-entri').modal('show');
    }
    
    function saveData(){
        $.ajax({
            data: $('#formData').serialize(),
            headers: {
                'x-csrf-token': document.head.querySelector('meta[name="csrf-token"]').content
            },
            url: "{{ route('users.store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {

                if(data.status === true){
                    $('#formData').trigger("reset");
                    createNotif('success', 'Success', data.message, true, 3000);
                    $('#modal-entri').modal('hide');
                } else {
                    createNotif('error', 'Failed', data.message, true, 3000);
                }
                $('.no-data').addClass('d-none');
                $('#table_data').removeClass('d-none');
                table.ajax.reload();

            },
            error: function (data) {
                swal_error();
            }
        });
    }

    // table serverside
    var table = $('#data-table').DataTable({
        processing: false,
        serverSide: true,
        // dom: 'Bfrtip',
        // // buttons: [
        // //     'copy', 'excel', 'pdf'
        // // ],
        ajax: "{{ route('users.index') }}",
        columns: [
            {
                data: 'DT_RowIndex', 
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false},
            { data: 'name' },
            { data: 'email' },
            { data: 'number' },
            { data: 'role' },
            {
                data: 'action',
                name: 'action',
                className: 'text-center',
                orderable: false,
                searchable: false
            },
        ],
        drawCallback: function (settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
        
        // csrf token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    

    $(function(){
        
        
        // initialize btn edit
        $('body').on('click', '.editData', function () {
            var id = $(this).data('id');
            $.get("{{route('users.index')}}" + '/' + id + '/edit', function (data) {
                $('#saveBtn').val("edit-user");
                $('#modal-entri').modal('show');
                $('#id').val(data.id);
                $('#name').val(data.name);
                $('#email').val(data.email);
                $('#number').val(data.number);
                $('#level').val(data.level);
                
            })
        });

        // initialize btn delete
        $('body').on('click', '.deleteData', function () {
            var id = $(this).data("id");

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{route('users.store')}}" + '/' + id,
                        success: function (data) {
                            if(data.status === true){
                                createNotif('success', 'Success', data.message, true, 3000);
                                $('#modal-import-excel').modal('hide');
                            } else {
                                createNotif('error', 'Failed', data.message, true, 3000);
                            }
                            table.ajax.reload();
                        },
                        error: function (data) {
                            swal_error();
                        }
                    });
                }
            })
        });

    })
</script>
@endpush