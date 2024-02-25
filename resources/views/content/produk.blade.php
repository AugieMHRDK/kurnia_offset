        
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
                <div id="table_data" class="d-none">
                    <table id="data-table" class="table align-middle table-row-dashed fs-6 gy-5">
                        <thead>
                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Satuan</th>
                            <!-- <th>Harga</th> -->
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
                <h5 class="modal-title">Form Data Produk</h5>
            </div>
            <div class="modal-body pb-10">
                <form id="formData" name="formData">
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="uid" id="uid">
                    <label class="fs-6 fw-bold form-label">Nama Produk</label>
                    <div class="input-group mb-5">
                        <input type="text" name="nama_produk" id="nama_produk" class="form-control" placeholder="Nama Produk">
                    </div>

                    <label class="fs-6 fw-bold form-label">Satuan</label>
                    <div class="input-group mb-5">
                        <input type="text" name="satuan" id="satuan" class="form-control" placeholder="Satuan">
                    </div>
<!-- 
                    <label class="fs-6 fw-bold form-label">Harga Satuan</label>
                    <div class="input-group mb-5">
                        <input type="text" name="harga_satuan" id="harga_satuan" class="form-control" placeholder="Harga Satuan">
                    </div> -->

                    <!--begin::Input wrapper-->
                    <div class="w-100">
                        <label class="fs-6 fw-bold form-label">Jenis Bahan</label>
                        <!--begin::Title-->
                        <div class="d-flex">
                            <input type="text" id="bahan" class="form-control  me-3" placeholder="Jenis Bahan">
                            <input type="text" id="harga_satuan" class="form-control  me-3" placeholder="Harga Satuan">
                            <a href="javascript:;" class="btn btn-light fw-bold flex-shrink-0" onClick="addJenisBahan()">Tambah</a>
                        </div>
                        <!--end::Title-->
                    </div>
                    <div class="w-100" id="data-bahan">
                    </div>
                    <!--end::Input wrapper-->
                </form>
                <div class="row form-row mt-4" id="attach"></div><br>
                
                <label class="form-label" >File <span class="font-size-sm">( Format : .jpeg/ .png/ .jpg)</span></label>
                <!--begin::Form-->
                <form class="dropzone" id="kt_dropzonejs_example_1">
                    <!--begin::Input group-->
                    <div class="fv-row">
                        <!--begin::Dropzone-->
                        <div>
                            <input type="hidden" name="uuid" id="uuid">
                            <!--begin::Message-->
                            <div class="dz-message needsclick">
                                <!--begin::Icon-->
                                <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                <!--end::Icon-->

                                <!--begin::Info-->
                                <div class="ms-4">
                                    <h3 class="fs-5 fw-bolder text-gray-900 mb-1">Drop files here or click to upload.</h3>
                                    <span class="fs-7 fw-bold text-gray-400">Upload up to 10 files</span>
                                </div>
                                <!--end::Info-->
                            </div>
                        </div>
                        <!--end::Dropzone-->
                    </div>
                    <!--end::Input group-->
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
    Dropzone.autoDiscover = false;
    var uid = uuidv4();
	var countData = {{$count}};
    let inc = 1;

    if(countData > 0){
        $('.no-data').addClass('d-none');
        $('#table_data').removeClass('d-none');
    } else {
        $('.no-data').removeClass('d-none');
        $('#table_data').addClass('d-none');
    }

    function addJenisBahan(){
        if($('#bahan').val() == ''){
            return swal_warning('Data tidak boleh kosong!')
        }
        let html = `<div class="w-100 mt-2" id="bahan${inc}">
                        <div class="d-flex">
                            <input type="text" name="bahan[]" value="${$('#bahan').val()}" class="form-control  me-3" placeholder="Jenis Bahan">
                            <input type="text" name="harga_satuan[]" value="${$('#harga_satuan').val()}" class="form-control  me-3" placeholder="Harga Satuan">
                            <a href="javascript:;" class="btn btn-danger fw-bold flex-shrink-0" onClick="delJenisBahan('#bahan${inc}')">Hapus</a>
                        </div>
                    </div>`;
        $('#data-bahan').append(html);
        $('#bahan').val('');
        $('#harga_satuan').val('');
        inc++;
    }

    function delJenisBahan(id){
        $(id).remove();
    }
    
    function addData(){
        $('#data-bahan').empty();
        $("#attach").empty();
        $('#formData').trigger("reset");
        $('#id').val('');
        $('#uid').val(uid);
        $('#uuid').val(uid);
        $('#modal-entri').modal('show');
        Dropzone.forElement('#kt_dropzonejs_example_1').removeAllFiles(true);
    }
    
    function saveData(){
        $.ajax({
            data: $('#formData').serialize(),
            headers: {
                'x-csrf-token': document.head.querySelector('meta[name="csrf-token"]').content
            },
            url: "{{ route('produk.store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {

                $('#formData').trigger("reset");
                if(data.status === true){
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
        ajax: "{{ route('produk.index') }}",
        columns: [
            {
                data: 'DT_RowIndex', 
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false},
            {
                data: 'nama_produk',
                name: 'nama_produk'
            },
            {
                data: 'satuan',
                name: 'satuan'
            },
            // {
            //     data: 'harga_satuan', className: "dt-body-right", render: function (data, type, row) {
            //         return formatRupiah(String(data), '');
            //     }
            // },
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
        var myDropzone = new Dropzone("#kt_dropzonejs_example_1", {
            url: "{{route('produk.imageUpload')}}",
            headers: {
                'x-csrf-token': document.head.querySelector('meta[name="csrf-token"]').content
            },
            paramName: "file", // The name that will be used to transfer the file
            maxFiles: 10,
            maxFilesize: 10, // MB
            addRemoveLinks: true,
            init: function() {
                this.on('error', function(file, response) {
                    $(file.previewElement).find('.dz-error-message').text(response.message);
                });
            }
        });
        
        
        // initialize btn edit
        $('body').on('click', '.editData', function () {
            Dropzone.forElement('#kt_dropzonejs_example_1').removeAllFiles(true);
            $('#data-bahan').empty();
            var id = $(this).data('id');
            $.get("{{route('produk.index')}}" + '/' + id + '/edit', function (data) {
                $('#saveBtn').val("edit-user");
                $('#modal-entri').modal('show');
                $('#id').val(data.id);
                $('#uid').val(data.id_gambar);
                $('#uuid').val(data.id_gambar);
                $('#nama_produk').val(data.nama_produk);
                $('#satuan').val(data.satuan);
                // $('#harga_satuan').val(data.harga_satuan);
                
                $(data.bahan).each(function(){
                    let html = `<div class="w-100 mt-2" id="bahan${this.id}">
                                    <div class="d-flex">
                                        <input type="text" name="bahan[]" value="${this.bahan}" class="form-control  me-3" placeholder="Jenis Bahan">
                                        <input type="text" name="harga_satuan[]" value="${this.harga_satuan}" class="form-control  me-3" placeholder="Harga Satuan">
                                        <a href="javascript:;" class="btn btn-danger fw-bold flex-shrink-0" onClick="delJenisBahan('#bahan${this.id}')">Hapus</a>
                                    </div>
                                </div>`;
                    $('#data-bahan').append(html);
                })

                var n=1;
                var baseimage = "{{asset('files')}}";
                $("#attach").empty();
                $(data.attachments).each(function(){
                    
                    if(n%4==0){
                    var clr = "<div style='clear:datah'></div><br>";
                    } else {
                    var clr = "";
                    }
                    var opt = $('<div class="col-md-3 mb-20 text-right cattach" id="ida'+this.id+'">\
                            <a href="javascript:void(0)" data-id="'+this.id+'" class="btn btn-danger  btn-sm btn-mini deleteAttach"  style="margin-datatom:4px">Hapus</a>\
                            <img src="'+baseimage+'/'+this.filename+'" style="width:100%" /><br>\
                            </div>'+clr);
                    $("#attach").append(opt);
                    n++;
                })
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
                        url: "{{route('produk.store')}}" + '/' + id,
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

        // initialize btn delete attach
        $('body').on('click', '.deleteAttach', function () {
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
                        url: "{{route('produk.index')}}" + '/destroyAttach/' + id,
                        success: function (data) {
                            createNotif('success', 'Success', data.message, true, 3000);
                            table.draw();
                            $('#ida'+id).remove();
                        },
                        error: function (data) {
                            createNotif('error', 'Failed', data.message, true, 3000);
                        }
                    });
                }
            })
        });
        
    })
</script>
@endpush