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
                    @foreach ($produk as $p)
                        <!--begin::Col-->
                        <div class="col-6">
                            <!--begin::Card-->
                            <div class="card card-stretch">
                                <!--begin::Link-->
                                <a href="{{url('pemesanan')}}/{{$p->id}}" class="btn btn-flex btn-text-gray-800 btn-icon-gray-400 btn-active-color-primary bg-body flex-column justfiy-content-start align-items-middle text-start w-100 p-10">
                                    <!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm007.svg-->
                                    <span class="mb-10">
                                        @if(isset($p->attachments))
                                        <img src="{{ url($p->attachments->url) }}" alt="" class="w-100">
                                        @endif
                                    </span>
                                    <!--end::Svg Icon-->
                                    <span class="fs-4 fw-bolder">{{ $p->nama_produk }}</span>
                               
                                </a>
                                <!--end::Link-->
                            </div>
                            <!--end::Card-->
                        </div>
                        <!--end::Col-->
                    @endforeach
					
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
								<h3 class="card-title fw-bolder text-dark">Pesanan Anda</h3>
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
											<th>Action</th>
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
<!-- Modal-->
<div class="modal fade" id="modal-detail" data-bs-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pemesanan</h5>
            </div>
            <div class="modal-body pb-10">
                <label class="fs-6 fw-bold form-label">Kode Pemesanan</label>
                <div class="input-group mb-5">
                    <input type="text" name="kode_pemesanan" id="kode_pemesanan" class="form-control" readonly>
                </div>
                <label class="fs-6 fw-bold form-label">Produk</label>
                <div class="input-group mb-5">
                    <input type="text" name="nama_produk" id="nama_produk" class="form-control" readonly>
                </div>
                <label class="fs-6 fw-bold form-label">Jumlah</label>
                <div class="input-group mb-5">
                    <input type="text" name="jumlah" id="jumlah" class="form-control" readonly>
                </div>
                <label class="fs-6 fw-bold form-label">Total Harga</label>
                <div class="input-group mb-5">
                    <input type="text" name="total_harga" id="total_harga" class="form-control" readonly>
                </div>
                <label class="fs-6 fw-bold form-label">Status</label>
                <div class="input-group mb-5">
                    <input type="text" name="status" id="status" class="form-control" readonly>
                </div>
                <label class="fs-6 fw-bold form-label">Catatan</label>
                <div class="input-group mb-5">
                    <input type="text" name="catatan" id="catatan" class="form-control" readonly>
                </div>
                <label class="fs-6 fw-bold form-label">Tanggal Pesan</label>
                <div class="input-group mb-5">
                    <input type="text" name="timestamp" id="timestamp" class="form-control" readonly>
                </div>
            </div>
            <div class="modal-footer d-flex text-right">
                <button type="button" class="btn btn-light-danger me-5" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
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
                    data: 'action'
                }
            ],
			drawCallback: function (settings) {
			$('[data-toggle="tooltip"]').tooltip();
			}
        });
        
	    // var socket = io("{{ config('app.url_ws', 'localhost:8000') }}", { transports : ['websocket'] });

        
        // socket.on('ready', function(data) {
        //     $(`.qrcode-client-${data.id}`).addClass('d-none');
        //     $(`.connecting-client-${data.id}`).addClass('d-none');
        //     $(`.authenticating-client-${data.id}`).addClass('d-none');
        //     $(`.connected-client-${data.id}`).removeClass('d-none');
        //     $(`.notice-border-client-${data.id}`).removeClass('border-gray-600').addClass('border-primary');
        //     table.draw();
        // });
        
        // initialize btn edit
        $('body').on('click', '.detailData', function () {
            var id = $(this).data('id');
            $.get("{{url('detail-pemesanan')}}" + '/' + id, function (data) {
                console.log(data)
                $('#modal-detail').modal('show');
                $('#nama_produk').val(data.produk.nama_produk);
                $.each(data, function(key,val) {    
                    $('#'+key).val(val);    
                }); 
                // $.each(data, function (i) {
                //     $.each(data[i], function (key, val) {
                //         console.log(key)
                //         // $('#'+key).val(val);
                //     });
                // });

            })
        });

    })
	
</script>
@endpush