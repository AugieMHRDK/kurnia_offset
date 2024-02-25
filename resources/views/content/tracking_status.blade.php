<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Container-->
    <div class="container-xxl d-flex" id="kt_content_container">
        <div class="mb-5 mb-xl-6 col-xl-5 p-4">
            <div class="card">
            <!--begin::Header-->
            <div class="card-header align-items-center border-0 mt-4">
                <h3 class="card-title align-items-start flex-column">
                    <span class="fw-bold mb-2 text-dark">Detail Pesanan</span>
                </h3>
            </div>
            <!--end::Header-->

            <!--begin::Body-->
            <div class="card-body pt-5">
                <table class="table table-bordered">
                    <tr>
                        <td>Kode Pemesanan</td>
                        <td>{{ $detail->kode_pemesanan }}</td>
                    </tr>
                    <tr>
                        <td>Produk</td>
                        <td>{{ $detail->produk->nama_produk }}</td>
                    </tr>
                    <tr>
                        <td>Bahan</td>
                        <td>{{ $detail->bahan->bahan }}</td>
                    </tr>
                    <tr>
                        <td>Jumlah</td>
                        <td>{{ $detail->jumlah }}</td>
                    </tr>
                    <tr>
                        <td>Catatan</td>
                        <td>{{ $detail->catatan }}</td>
                    </tr>
                    <tr>
                        <td>Desain</td>
                        <td><a href="{{ url($detail->desain) }}" target="_blank">Lihat Desain</a></td>
                    </tr>
                </table>
            </div>
            </div>
        </div>
        <div class="mb-5 mb-xl-6 col-xl-7 p-4">
            <div class="card">
            <!--begin::Header-->
            <div class="card-header align-items-center border-0 mt-4">
                <h3 class="card-title align-items-start flex-column">
                    <span class="fw-bold mb-2 text-dark">Tracking Status</span>
                </h3>
            </div>
            <!--end::Header-->

            <!--begin::Body-->
            <div class="card-body pt-5">
                <!--begin::Timeline-->
                <div class="timeline-label p-0">
                    @foreach ($track as $t)
                        
                    <!--begin::Item-->
                    <div class="timeline-item ">
                        <!--begin::Label-->
                        <div class="timeline-label text-gray-400 fs-7 w-90px">{{ $t->tanggal }}</div>
                        <!--end::Label-->

                        <!--begin::Badge-->
                        <div class="timeline-badge">
                            <i class="fa fa-genderless text-warning fs-1"></i>
                        </div>
                        <!--end::Badge-->

                        <!--begin::Text-->
                        <div class="fw-mormal timeline-content ps-3 text-gray-800">
                            <span class=" text-muted fs-7">{{ $t->jam }}</span> {{ $t->status }} 
                        </div>
                        <!--end::Text-->
                    </div>
                    <!--end::Item-->

                    @endforeach



                </div>
                <!--end::Timeline-->
            </div>
            </div>
            <!--end: Card Body-->
        </div>
    </div>
</div>