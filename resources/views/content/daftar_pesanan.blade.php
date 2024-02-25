<style type="text/css">
            #printDiv {display: none;}
            @media print {
                div {display: none;}
                #printDiv {display: block;}
            }
        </style>
     
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container-xxl" id="kt_content_container">
    <div class="card">
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body py-4">
                <div class="mt-10 mb-10 d-flex text-right">
                    <div class="form-group scheduled me-2" >
                        <div class="input-group mb-4">
                            <input type="text" class="form-control date" name="tgl_awal" id="tgl_awal" placeholder="Tanggal Awal">
                            <span class="input-group-text" style="width:40px">
                                <i class="fas fa-calendar-alt fs-4"></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-group scheduled me-2" >
                        <div class="input-group mb-4">
                            <input type="text" class="form-control date" name="tgl_akhir" id="tgl_akhir" placeholder="Tanggal Akhir">
                            <span class="input-group-text" style="width:40px">
                                <i class="fas fa-calendar-alt fs-4"></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-group scheduled me-2" >
                        <div class="input-group mb-4">
                            <a href="javascript:;" class="btn btn-light fw-bold flex-shrink-0" onClick="searchData()">Cari</a>
                        </div>
                    </div>
                    <div class="form-group scheduled" >
                        <div class="input-group mb-4">
                            <a href="javascript:;" class="btn btn-light fw-bold flex-shrink-0" onClick="cetak()">Cetak</a>
                        </div>
                    </div>
                </div>
                <div id="table_data">
                    <table id="data-table" class="table align-middle table-row-dashed fs-6 gy-5">
                        <thead>
                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                            <th>No</th>
                            <th>Kode Pemesanan</th>
                            <th>Produk</th>
                            <th>Pemesan</th>
                            <th>Total Harga</th>
                            <th>Tanggal</th>
                            <th>Status Pembayaran</th>
                            <th>Ket. Pesanan</th>
                            <th>Desain</th>
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
<div id='printDiv'>
    
</div>

@push('custom-scripts')
<script>
    // $("#DivIdToPrint").printThis();
    setInterval(function() { 
        autoPrint()
    }, 10000);
    
    function autoPrint() {
        
        $.ajax({
            type: "GET",
            url: "{{ route('autoPrint') }}",
            success: function (res) {
                if (res.data instanceof Array) {
                    $(res.data).each(function(){
                        if(localStorage.getItem(this.kode_pemesanan) === null){
                            let html = `
                            <table class="table align-middle table-row-dashed">
                                <tr>
                                    <td>Kode Pemesanan</td>
                                    <td>${this.kode_pemesanan}</td>
                                </tr>
                                <tr>
                                    <td>Pemesan</td>
                                    <td>${this.user.name}</td>
                                </tr>
                                <tr>
                                    <td>Produk</td>
                                    <td>${this.produk.nama_produk}</td>
                                </tr>
                                <tr>
                                    <td>Total Harga</td>
                                    <td>${this.total_harga}</td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>${this.status}</td>
                                </tr>
                            </table>
                            `;
                            $("#printDiv").html(html);
                            $("#printDiv").printThis();
                        }
                        localStorage.setItem(this.kode_pemesanan, this.kode_pemesanan);
                    })
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
        ajax: "{{ route('daftar-pesanan') }}",
        columns: [
            {
                data: 'DT_RowIndex', 
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false},
            {
                data: 'kode_pemesanan'
            },
            {
                data: 'produk.nama_produk'
            },
            {
                data: 'user.name'
            },
            {
                data: 'total_harga', className: "dt-body-right", render: function (data, type, row) {
                    return formatRupiah(String(data), '');
                }
            },
            {
                data: 'tanggal'
            },
            {
                data: 'status'
            },
            {
                data: 'ket'
            },
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



    function searchData(){
        var tgl_awal    = $('#tgl_awal').val();
        var tgl_akhir   = $('#tgl_akhir').val();
        table.ajax.url( "{{ route('daftar-pesanan') }}" + "?tgl_awal=" + tgl_awal + "&tgl_akhir=" + tgl_akhir + "&search_btn=true").load();
    }
    function downloadFile(response) {
  var blob = new Blob([response], {type: 'application/pdf'})
  var url = URL.createObjectURL(blob);
  location.assign(url);
} 
    function cetak(){
        var tgl_awal    = $('#tgl_awal').val();
        var tgl_akhir   = $('#tgl_akhir').val();
        // location.href = "{{ route('laporan.daftarPesanan', ['tgl_awal'=>"+tgl_awal+", 'tgl_akhir'=>"+tgl_akhir+"]) }}";
        $.ajax({
            type: "POST",
            url: "{{route('laporan.daftarPesanan')}}" + '?tgl_awal=' + tgl_awal + '&tgl_akhir=' + tgl_akhir,
            xhrFields: {
                responseType: 'blob'
            },
            success: function(response){
                var blob = new Blob([response]);
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = "daftar-pesanan.pdf";
                link.click();
            },
            error: function(blob){
                console.log(blob);
            }
        });
    }
</script>
@endpush