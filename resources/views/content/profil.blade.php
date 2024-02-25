<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container-xxl" id="kt_content_container">
        <div class="card mb-5 mb-xl-10">
        <div class="card-body pt-9 pb-0">
        <div class="d-flex flex-wrap flex-sm-nowrap">
            <!--begin: Pic-->
            <div class="me-7 mb-4">
                <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                    <img src="{{asset('assets')}}/img/avatar1.png" alt="image">
                    <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px"></div>
                </div>
            </div>
            <!--end::Pic-->

            <!--begin::Info-->
            <div class="flex-grow-1">
                <!--begin::Title-->
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <!--begin::User-->
                    <div class="d-flex flex-column">
                        <!--begin::Name-->
                        <div class="d-flex align-items-center mb-2">
                            <a href="#" id="txt-name" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ auth()->user()->name }}</a>
                            <a href="#"><i class="ki-duotone ki-verify fs-1 text-primary"><span class="path1"></span><span class="path2"></span></i></a>
                        </div>
                        <!--end::Name-->

                        <!--begin::Info-->                        
                        <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                            <a href="#" id="txt-number" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                No WA : {{ auth()->user()->number }}
                            </a>
                            <a href="#" id="txt-email" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                Email : {{ auth()->user()->email }}
                            </a>
                            <a href="#" id="txt-email" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                Bergabung pada : {{ $tanggal }}
                            </a>
                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::User-->

                    <!--begin::Actions-->
                    <div class="d-flex my-4">
                        <a href="javascript:;" class="btn btn-sm btn-primary me-3 editData" data-id="{{ auth()->user()->id }}"  >Ubah Profil</a>

                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Title-->

                <!--begin::Stats-->
                <div class="d-flex flex-wrap flex-stack">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column flex-grow-1 pe-8">
                        <!--begin::Stats-->
                        <div class="d-flex flex-wrap">
                            <!--begin::Stat-->
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    <i class="ki-duotone ki-arrow-up fs-3 text-success me-2"><span class="path1"></span><span class="path2"></span></i> <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="4500" data-kt-countup-prefix="$" data-kt-initialized="1">{{ $count_p }}</div>
                                </div>
                                <!--end::Number-->

                                <!--begin::Label-->
                                <div class="fw-semibold fs-6 text-gray-400">Pesanan</div>
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->

                            <!--begin::Stat-->
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    <i class="ki-duotone ki-arrow-down fs-3 text-danger me-2"><span class="path1"></span><span class="path2"></span></i> <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="80" data-kt-initialized="1">{{ $sum_p }}</div>
                                </div>
                                <!--end::Number-->

                                <!--begin::Label-->
                                <div class="fw-semibold fs-6 text-gray-400">Total Harga</div>
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->

                        </div>
                        <!--end::Stats-->
                    </div>
                    <!--end::Wrapper-->

                </div>
                <!--end::Stats-->
            </div>
            <!--end::Info-->
        </div>
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
                    <input type="hidden" name="level" id="level">
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
                    <hr>
                    <label class="fs-6 fw-bold form-label">Ubah Password ?</label>
                    <br><br>
                    <label class="fs-6 fw-bold form-label">Password Lama</label>
                    <div class="input-group mb-5">
                        <input type="text" name="password_lama" id="password_lama" class="form-control" placeholder="Password Lama">
                    </div>

                    <label class="fs-6 fw-bold form-label">Password Baru</label>
                    <div class="input-group mb-5">
                        <input type="text" name="password" id="password" class="form-control" placeholder="Password Baru">
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
        if($("#password_lama").val() != ''){
            $.ajax({
                data: $('#formData').serialize(),
                headers: {
                    'x-csrf-token': document.head.querySelector('meta[name="csrf-token"]').content
                },
                url: "{{ route('cek_password') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    if(data.status === false){
                        createNotif('warning', 'Warning', "Password tidak sesuai", true, 3000);
                        return false;
                    }

                },
                error: function (data) {
                    swal_error();
                }
            });
        }

        $.ajax({
            data: $('#formData').serialize(),
            headers: {
                'x-csrf-token': document.head.querySelector('meta[name="csrf-token"]').content
            },
            url: "{{ route('users.store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $("#txt-name").html($("#name").val())
                $("#txt-number").html($("#number").val())
                $("#txt-email").html($("#email").val())
                if(data.status === true){
                    $('#formData').trigger("reset");
                    createNotif('success', 'Success', data.message, true, 3000);
                    $('#modal-entri').modal('hide');
                } else {
                    createNotif('error', 'Failed', data.message, true, 3000);
                }

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