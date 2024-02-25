        
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
                            <th>Kode Pemesanan</th>
                            <th>Pemesan</th>
                            <th>Produk</th>
                            <th>Catatan</th>
                            <th class="text-center w-100px dt-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-bold">
                        </tbody>
                    </table>
                </div>
                <h2 class="text-gray-400 text-center mt-8 no-data d-none ">Belum ada data</h2>
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
                <h5 class="modal-title">Form Update Status</h5>
            </div>
            <div class="modal-body pb-10">
                <form id="formData" name="formData">
                    <input type="hidden" name="id" id="id">
                    
                    <!--begin::Input wrapper-->
                    <div class="w-100" id="data-bahan">
                    </div>
                    <hr>
                    <div class="w-100">
                        <!--begin::Title-->
                            <!-- <input type="text" id="status" name="status" class="form-control  me-3" placeholder="Status Pesanan"> -->
                    <div class="input-group mb-5">
                        <select class="form-control select2" id="status" name="status" onChange="changeStatus(event)">
                            <option >Status Pesanan</option>
                            <option value="Proses cetak">Proses cetak</option>
                            <option value="Proses jilid">Proses jilid</option>
                            <option value="Proses finishing">Proses finishing</option>
                            <option value="Proses packing">Proses packing</option>
                            <option value="Selesai">Selesai</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                        <input type="text" id="status_txt" name="status_txt" class="form-control me-3" placeholder="Status Pesanan" style="display:none">
                    </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Input wrapper-->
                </form>
                
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

    function changeStatus(evt){
        if (evt.target.value === "Lainnya") {
            $('#status_txt').show();
        } else {
            $('#status_txt').hide();
        }
    }

	var countData = {{$count}};
    let inc = 1;

    if(countData > 0){
        $('.no-data').addClass('d-none');
        $('#table_data').removeClass('d-none');
    } else {
        $('.no-data').removeClass('d-none');
        $('#table_data').addClass('d-none');
    }
    
    function addData(){
        $("#attach").empty();
        $('#formData').trigger("reset");
        $('#id').val('');
        $('#uid').val(uid);
        $('#uuid').val(uid);
        $('#modal-entri').modal('show');
    }
    
    function saveData(){
        $.ajax({
            data: $('#formData').serialize(),
            headers: {
                'x-csrf-token': document.head.querySelector('meta[name="csrf-token"]').content
            },
            url: "{{ route('tracking.store') }}",
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
        dom: 'frtip',
        // buttons: [
        //     'copy', 'excel', 'pdf'
        // ],
        ajax: "{{ route('tracking.index') }}",
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
                data: 'user.name'
            },
            {
                data: 'produk.nama_produk'
            },
            {
                data: 'catatan'
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
    

    $(function(){
        
        // initialize btn edit
        $('body').on('click', '.editData', function () {
            $('#data-bahan').empty();
            var id = $(this).data('id');
            $.get("{{route('tracking.index')}}" + '/' + id + '/edit', function (data) {
                
                $('#saveBtn').val("edit-user");
                $('#modal-entri').modal('show');
                $('#id').val(id);
                console.log(data)
                $(data).each(function(){
                    let html = `<div class="w-100 mt-2" id="data${this.id}">
                                    <div class="d-flex w-100 ">
                                        <input type="text" name="bahan[]" value="${this.tanggal} ${this.jam} - ${this.status}" class="form-control form-control-flush me-3" readonly>
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