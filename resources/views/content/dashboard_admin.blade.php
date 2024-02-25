@push('custom-styles')
<link href="{{asset('assets')}}/plugins/custom/leaflet/leaflet.bundle.css" rel="stylesheet" type="text/css" />
<link href="{{asset('assets')}}/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
@endpush

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<!--begin::Container-->
	<div class="container-xxl" id="kt_content_container">
		<!--begin::Row-->
		<div class="row g-5 g-xl-8">
			<!--begin::Col-->
			<div class="col-xl-4">
				<!--begin::Misc Widget 1-->
				<div class="row mb-5 mb-xl-8 g-5 g-xl-8">
					<!--begin::Col-->
					<div class="col-6">
						<!--begin::Card-->
						<div class="card card-stretch">
							<!--begin::Link-->
							<a href="{{ url('produk') }}" class="btn btn-flex btn-text-gray-800 btn-icon-gray-400 btn-active-color-primary bg-body flex-column justfiy-content-start align-items-middle text-start w-100 p-10">
								<!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm007.svg-->
								<span class="mb-10">
									<i class="fa fa-cubes" style="font-size:26pt"></i>
								</span>
								<!--end::Svg Icon-->
								<span class="fs-4 fw-bolder">Produk</span>
							</a>
							<!--end::Link-->
						</div>
						<!--end::Card-->
					</div>
					<!--end::Col-->
					<!--begin::Col-->
					<div class="col-6">
						<!--begin::Card-->
						<div class="card card-stretch">
							<!--begin::Link-->
							<a href="{{ url('users') }}" class="btn btn-flex btn-text-gray-800 btn-icon-gray-400 btn-active-color-primary bg-body flex-column justfiy-content-start align-items-middle text-start w-100 p-10">
								<span class="mb-10">
									<i class="fa fa-users" style="font-size:26pt"></i>
								</span>
								<span class="fs-4 fw-bolder">Pengguna</span>
							</a>
							<!--end::Link-->
						</div>
						<!--end::Card-->
					</div>
					<!--end::Col-->
					<!--begin::Col-->
					<div class="col-6">
						<!--begin::Card-->
						<div class="card card-stretch">
							<!--begin::Link-->
							<a href="{{ url('tracking') }}" class="btn btn-flex btn-text-gray-800 btn-icon-gray-400 btn-active-color-primary bg-body flex-column justfiy-content-start align-items-middle text-middle w-100 p-10">
								<span class="mb-10">
									<i class="fa fa-pen" style="font-size:26pt"></i>
								</span>
								<span class="fs-4 fw-clipboard">Update Status Pesanan</span>
							</a>
							<!--end::Link-->
						</div>
						<!--end::Card-->
					</div>
					<!--end::Col-->
					<!--begin::Col-->
					<div class="col-6">
						<!--begin::Card-->
						<div class="card card-stretch">
							<!--begin::Link-->
							<a href="{{ url('daftar-pesanan') }}" class="btn btn-flex btn-text-gray-800 btn-icon-gray-400 btn-active-color-primary bg-body flex-column justfiy-content-start align-items-middle text-middle w-100 p-10">
								<span class="mb-10">
									<i class="fa fa-clipboard" style="font-size:26pt"></i>
								</span>
								<span class="fs-4 fw-bolder">Pesanan</span>
							</a>
							<!--end::Link-->
						</div>
						<!--end::Card-->
					</div>
					<!--end::Col-->
				</div>
				<!--end::Misc Widget 1-->
			</div>
			<!--end::Col-->

			<!--begin::Col-->
			<div class="col-xl-8 ps-xl-12">
				<!--begin::Row-->
				<div class="row g-5 g-xl-8">
					<!--begin::Col-->
					<div class="col-xl-12">
						<!--begin::List Widget 3-->
						<div class="card mb-xl-8">
							<!--begin::Header-->
							<div class="card-header border-0">
								<h3 class="card-title fw-bolder text-dark">Pesanan Terbaru</h3>
							</div>
							<!--end::Header-->
							<!--begin::Body-->
							<div class="card-body pt-2">
								<!--begin::Datatable-->
									<table id="broadcast-table" class="table align-middle table-row-dashed fs-6 gy-5">
										<thead>
										<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
											<th>Kode Pemesanan</th>
											<th>Barang</th>
											<th>Total Harga</th>
											<th>Status Pembayaran</th>
											<th>Tanggal</th>
										</tr>
										</thead>
										<tbody class="text-gray-600 fw-bold">
										</tbody>
									</table>
								<!--end::Datatable-->
							</div>
							<!--end::Body-->
						</div>
						<!--end:List Widget 3-->
					</div>
					<!--end::Col-->
				</div>
				<!--end::Row-->
			</div>
			<!--end::Col-->
		</div>
		<!--end::Row-->
	</div>
	<!--end::Container-->
</div>

@push('custom-scripts')
<script>
	
    $('document').ready(function () {
        // table serverside
        var tableBroadcast = $('#broadcast-table').DataTable({
            processing: false,
            serverSide: true,
            ordering: false,
            dom: 't',
            // // buttons: [
            // //     'copy', 'excel', 'pdf'
            // // ],
            ajax: "{{ route('home') }}",
            columns: [
                {
                    data: 'kode_pemesanan'
                },
                {
                    data: 'produk.nama_produk'
                },
                {
                    data: 'total_harga', className: "dt-body-right", render: function (data, type, row) {
                        return formatRupiah(String(data), '');
                    }
                },
                {
                    data: 'status'
                },
                {
                    data: 'timestamp_f'
                }
            ],
			drawCallback: function (settings) {
			$('[data-toggle="tooltip"]').tooltip();
			}
        });
        
	    // var socket = io("{{ config('app.url_ws', 'localhost:8000') }}", { transports : ['websocket'] });

            
        
        // success alert
        function swal_success() {
            Swal.fire({
                position: 'centered',
                icon: 'success',
                title: 'It\'s All Done',
                showConfirmButton: false,
                timer: 1000
            })
        }
        // error alert
        function swal_error() {
            Swal.fire({
                position: 'centered',
                icon: 'error',
                title: 'Something goes wrong !',
                showConfirmButton: true,
            })
        }
            
    })
        
	
</script>
@endpush