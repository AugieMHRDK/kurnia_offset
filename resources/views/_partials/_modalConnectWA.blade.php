
<!-- Modal-->
<div class="modal fade" id="modal-qr" data-bs-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Connect to Whatsapp</h5>
            </div>
            <div class="modal-body pb-10" id="qr-content">
                <div class="row">
                    <div class="col-md-6 text-center">
						<div class="notice rounded border-gray-600 border-2 border border-dashed h-lg-100 p-6 notice-border" style="min-height:350px">
							<!--begin::Wrapper-->
							<div class="text-center py-3">
								<!--begin::Content-->
				        		<img src="" alt="QR Code" class="d-none qrcode" id="qrcode" style="max-width:100%">
								<!--end::Content-->
							</div>
							<div class="mt-20 pt-10 connecting d-none">
								<span class="label label-inline label-lg label-light label-pill mr-2">
									<span class="position-relative"></span>
									<span id="tc0">Connecting</span>
								</span>
								<a href="#" class="btn btn-icon pulse text-center">
									<span class="bullet bullet-dot bg-secondary h-10px w-10px position-absolute translate-middle top-50 start-50 animation-blink"></span>
									<span class="pulse-ring border-5"></span>
								</a>
							</div>
							<div class="mt-20 pt-10 authenticating d-none">
								<span class="badge badge-light-warning mr-2">
									<span>Authenticating</span>
								</span>
								<a href="#" class="btn btn-icon pulse pulse-warning text-center">
									<span class="bullet bullet-dot bg-warning h-10px w-10px position-absolute translate-middle top-50 start-50 animation-blink"></span>
									<span class="pulse-ring border-5"></span>
								</a>
							</div>
							<div class="mt-20 pt-10 connected d-none">
								<span class="btn btn-light-primary active">Connected</span>
							</div>
							<!--end::Wrapper-->
						</div>
                    </div>
                    <div class="col-md-6">
						<div class="d-flex flex-column logs" id="logs">
						</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                
                <div>Jangan tutup halaman ini sebelum status <span class="badge badge-primary">Connected</span></div>
                <button type="button" class="btn btn-light-danger font-weight-bold" data-bs-dismiss="modal">Close</button>
                   
            </div>
        </div>
    </div>
</div>