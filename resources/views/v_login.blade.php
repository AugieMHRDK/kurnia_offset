<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head><base href="{{asset('assets')}}">
		<title>Kurnia Offsite</title>
		<meta charset="utf-8" />
    	<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="description" content="Whatsapp API Gateway for Bussiness" />
		<meta name="keywords" content="Whatsapp, API, Gateway, Broadcast WA" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<!-- <meta property="og:type" content="article" />
		<meta property="og:title" content="Metronic - Bootstrap 5 HTML, VueJS, React, Angular &amp; Laravel Admin Dashboard Theme" />
		<meta property="og:url" content="https://keenthemes.com/metronic" />
		<meta property="og:site_name" content="Keenthemes | Metronic" /> -->
		<link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
		<link rel="shortcut icon" href="{{asset('assets')}}/media/logos/favicon.ico" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="{{asset('assets')}}/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="{{asset('assets')}}/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="bg-body">
		<!--begin::Main-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Authentication - Sign-in -->
			<div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url({{asset('assets')}}/media/illustrations/sigma-1/14.png">
				<!--begin::Content-->
				<div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
					<!--begin::Logo-->
					<!--end::Logo-->
					<!--begin::Wrapper-->
					<div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
						<!--begin::Form-->
						<div class="text-center mb-5">
							<img alt="Logo" src="{{asset('assets')}}/media/logos/kurnia.png" class="h-70px mx-auto my-auto  text-center" />
						</div>
						<form method="POST" action="{{ route('login') }}">
							@csrf
							<div class="form-group text-center">
								@if ($errors->has('number'))
								<label for="" class="text-danger ">Nomor WA atau Password tidak sesuai</label>
								@endif
							</div>
							<!--begin::Heading-->
							<!--begin::Heading-->
							<!--begin::Input group-->
							<div class="fv-row mb-10">
								<!--begin::Label-->
								<label class="form-label fs-6 fw-bolder text-dark">Nomor WA</label>
								<!--end::Label-->
								<!--begin::Input-->
								<input class="form-control form-control-lg form-control-solid" type="text" placeholder="Nomor WA" name="number" id="number"/>
								<!--end::Input-->
							</div>
							<!--end::Input group-->
							<!--begin::Input group-->
							<div class="fv-row mb-10">
								<!--begin::Wrapper-->
								<div class="d-flex flex-stack mb-2">
									<!--begin::Label-->
									<label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
									<!--end::Label-->
									<!--begin::Link-->
									<!-- <a href="../../demo17/dist/authentication/layouts/basic/password-reset.html" class="link-primary fs-6 fw-bolder">Forgot Password ?</a> -->
									<!--end::Link-->
								</div>
								<!--end::Wrapper-->
								<!--begin::Input-->
								<input class="form-control form-control-lg form-control-solid" type="password" name="password" autocomplete="off" />
								<!--end::Input-->
							</div>
							<!--end::Input group-->
							<!--begin::Actions-->
							<div class="text-center">
								<!--begin::Submit button-->
								<button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
									<span class="indicator-label">Continue</span>
									<span class="indicator-progress">Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
								</button>
								<!--end::Google link-->
							</div>
								<div class="text-gray-400 fw-bold fs-4">Pengguna Baru?
								<a href="javascript:;" class="link-primary fw-bolder" onClick="addData()">Buat Akun</a></div>
							<!--end::Actions-->
						</form>
						<!--end::Form-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Content-->
				<!--begin::Footer-->
				<div class="d-flex flex-center flex-column-auto p-10">
					<!--begin::Links-->
					<!-- <div class="d-flex align-items-center fw-bold fs-6">
						<a href="https://keenthemes.com" class="text-muted text-hover-primary px-2">About</a>
						<a href="mailto:support@keenthemes.com" class="text-muted text-hover-primary px-2">Contact</a>
						<a href="https://1.envato.market/EA4JP" class="text-muted text-hover-primary px-2">Contact Us</a>
					</div> -->
					<!--end::Links-->
				</div>
				<!--end::Footer-->
			</div>
			<!--end::Authentication - Sign-in-->
		</div>
		<!--end::Root-->
		<!--end::Main-->
		<!--begin::Javascript-->
		<script>var hostUrl = "{{asset('assets')}}/";</script>
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="{{asset('assets')}}/plugins/global/plugins.bundle.js"></script>
		<script src="{{asset('assets')}}/js/scripts.bundle.js"></script>
		<script src="{{asset('assets')}}/js/custom.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Page Custom Javascript(used by this page)-->
		<script src="{{asset('assets')}}/js/custom/authentication/sign-in/general.js"></script>
		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->
<!-- Modal-->
<div class="modal fade" id="modal-entri" data-bs-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Registrasi</h5>
            </div>
            <div class="modal-body pb-10">
                <form id="formData" name="formData">
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="level" id="level" value="2">
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
<script>
    
    function addData(){
        $('#formData').trigger("reset");
        $('#id').val('');
        $('#modal-entri').modal('show');
    }
    
    function saveData(){
        if(
            $("#name").val() == "" || 
            $("#number").val() == "" || 
            $("#email").val() == "" || 
            $("#password").val() == ""
            ) {
                createNotif('warning', 'Peringatan', "Semua data wajib diisi", true, 3000);
                return false;
            }
        $.ajax({
            data: $('#formData').serialize(),
            headers: {
                'x-csrf-token': document.head.querySelector('meta[name="csrf-token"]').content
            },
            url: "{{ route('account.register') }}",
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
	</body>
	<!--end::Body-->
</html>