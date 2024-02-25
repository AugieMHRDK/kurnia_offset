@push('custom-styles')
<link href="{{asset('assets')}}/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
@endpush

<link href="{{asset('assets')}}/css/whatsapp.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css" integrity="sha512-rRQtF4V2wtAvXsou4iUAs2kXHi3Lj9NE7xJR77DE7GHsxgY9RTWy93dzMXgDIG8ToiRTD45VsDNdTiUagOFeZA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Container-->
    <div class="container-xxl" id="kt_content_container">
        <!--begin::Form-->
        <form id="formBroadcast" class="form d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework" >
            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
            <!--begin::Aside column-->
            <div class="d-flex flex-column gap-3 gap-lg-3 w-100 w-lg-400px mb-3 me-lg-3">
                
                <!--begin::Template settings-->
                <div class="card card-flush py-4">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2>Data Pemesanan</h2>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <div class="card-body pt-0">
                        <div class="mb-10 fv-row fv-plugins-icon-container">
                            <label class="form-label">Nama Produk</label>
                            <div class="input-group input-group-solid">
                                <input type="text" class="form-control" value="{{$produk->nama_produk}}" readonly />
                            </div>
                        </div>

                        <div class="mb-10 fv-row fv-plugins-icon-container">
                            <label class="fs-6 fw-bold form-label">Bahan</label>
                            <select class="form-select mb-2 select2-hidden-accessible bahan_id" data-control="select2" data-hide-search="true" data-placeholder="Pilih Bahan" id="bahan_id" name="bahan_id"  data-select2-id="select2-data-bahan_id" tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                @foreach ($bahan as $val)
                                    <option value="{{$val->id}}">{{$val->text}}</option>
                                @endforeach
                            </select>
                        </div>
                    
                        <!--begin::Input group-->
                        <div class="mb-10 fv-row fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="form-label">Jumlah Barang</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Jumlah barang" id="jumlah" name="jumlah" />
                                <span class="input-group-text" id="basic-addon2">{{$produk->satuan}}</span>
                            </div>
                        </div>
                    
                        <!--begin::Input group-->
                        <div class="mb-10 fv-row fv-plugins-icon-container">
                            <label class="form-label">Harga Satuan</label>
                            <div class="input-group input-group-solid">
                                <span class="input-group-text" id="basic-addon1">Rp</span>
                                <input type="text" class="form-control" id="harga_satuan" name="harga_satuan" value="" readonly />
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!--end::Aside column-->
            <!--begin::Main column-->
            <div class="d-flex flex-column flex-row-fluid gap-3 gap-lg-3">
                <div class="d-flex flex-column gap-3">
                    <!--begin::General options-->
                    <div class="card card-flush py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Catatan</h2>
                            </div>
                            <div class="card-toolbar">
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Input group-->
                            <div class="fv-row fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class="form-label">Pesan</label><br>
                                <!--end::Label-->
                                <!--begin::Editor-->
                                <textarea class="form-control" name="catatan" id="catatan" rows="5" placeholder="Jelaskan permintaan Anda secara singkat"></textarea>
                                <!--end::Editor-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Card header-->
                    </div>
                    <!--end::General options-->
                    <!--begin::Media-->
                    <div class="card card-flush py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Desain Custom (opsional)</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Input group-->
                                <input type="file" class="form-control mb-3" id="file" name="file" style="width:100%" accept=".pdf,.cdr" onChange="loadFile(event)" />
                            <!--end::Input group-->
                            <!--begin::Description-->
                            <div class="text-muted fs-7"><label style="width:60px">Format :</label> .pdf atau .cdr</div>
                            <!--end::Description-->
                        </div>
                        <!--end::Card header-->
                    </div>
                    <!--end::Media-->
                    <!--begin::General options-->
                    <div class="card card-flush py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Keterangan</h2>
                            </div>
                            <div class="card-toolbar">
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Input group-->
                            <div class="fv-row fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label">Pengambilan Pesanan</label>
                                <select class="form-select mb-2 select2-hidden-accessible ket" data-control="select2" data-hide-search="true" data-placeholder="Pilih" id="ket" name="ket"  data-select2-id="select2-data-ket" tabindex="-1" aria-hidden="true">
                                        <option value=""></option>
                                        <option value="Diambil">Diambil</option>
                                        <option value="Dikirim">Dikirim</option>
                                </select>
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Card header-->
                    </div>
                    <!--end::General options-->
                </div>    

                <div class="d-flex justify-content-end mb-20">
                    <!--begin::Button-->
                    <a href="{{route('home')}}" id="kt_ecommerce_add_product_cancel" class="btn btn-light-danger me-5 btn-hover-scale">Cancel</a>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button id="btnPesan" class="btn btn-primary btn-hover-scale">
                        <span class="indicator-label">Buat Pesanan</span>
                        <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>


                    
                    <!--end::Button-->
                </div>
            </div>
            <!--end::Main column-->
        <div></div></form>
        <!--end::Form-->
    </div>
    <!--end::Container-->
</div>

@push('custom-scripts')
<script>
    var hs = @json($hs);
    console.log(hs)
    var cekImg = '';
    
    var loadFile = function(event) {
        let output = document.getElementById('wa-img');
        output.src = URL.createObjectURL(event.target.files[0]);
        let fileType = event.target.files[0]['type'];
        let validImageTypes = ['image/gif', 'image/jpeg', 'image/png', 'image/jpg'];
        if (validImageTypes.includes(fileType)) {
            cekImg = output.src;
            output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
            }
        } else {
            cekImg = '';
        }
    }
    
    $(function(){
        $('.bahan_id').select2();

        $('#bahan_id').on('select2:select', function (e) {
            var data = e.params.data;
            $('#harga_satuan').val(hs[data.id]);
        });

        // csrf token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#btnPesan').click(function (e) {
            e.preventDefault();
            if($("#jumlah").val() == "" || $("#jumlah").val() == 0){
                createNotif('warning', 'Perhatian', 'Jumlah barang masih kosong', true, 3000);
                return false;
            }
            
            let formBroadcast = document.getElementById('formBroadcast');
            let formData = new FormData(formBroadcast);
            $.ajax({
                data: formData,
                url: "{{ route('pemesanan.store') }}",
                type: "POST",
                enctype: 'multipart/form-data',
                cache:false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if(data.status === true){
                        createNotif('success', 'Success', data.message, true, 3000);
                        setTimeout(() => {
                            window.location = window.location.origin + "/pembayaran/" + data.id;
                        }, 2000);
                    } else {
                        createNotif('error', 'Failed', 'Error Sending Message!', true, 3000);
                    }
                },
                error: function (data) {
                    createNotif('error', 'Error', 'Something went wrong', true, 3000);
                }
            });

        });
    })
</script>
@endpush