@extends('layouts.app')

@section('title', 'Data villarian')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-links breadcrumb-dark">
    <li class="breadcrumb-item">
        <a href="{{route('home')}}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Data villarian</li>
</ol>
@endsection

@section('action_btn')
    <a href="{{ route('villas.create') }}" class="btn sm-d-block btn-default"><i class="fas fa-plus"></i> Tambah
        data</a>
@endsection

@section('content')

    <div class="row">
        
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h4>Data villa</h4>
                    <div class="table-responsive mt-2">
                        <table class="table table-striped table-bordered table-hover text-center" id="table-data">
                            <thead>
                                <tr>
                                    <th>Nama villa</th>
                                    <th>Alamat </th>
                                    <th>Deskripsi</th>
                                    <th>Foto</th>
                                    <th>Harga sewa</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="list"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('c_js')
    @include('_partials.cjs.ajaxPromise')
    <script>
        var ajaxUrl = "{{ route('datatable.villa') }}";
        // get parameter from url
        var url_string = window.location.href;
        var url = new URL(url_string);
        var id = url.searchParams.get("id");
        if(id != null) {
            ajaxUrl = "{{ route('datatable.villa') }}?id=" + id;
        }
        var tableVilla = $('#table-data').DataTable({
            processing: true,
            serverSide: true,
            responsive: false,
            ajax: ajaxUrl,
            columns: [{
                    data: 'nama_villa'
                },
                {
                    data: 'alamat'
                },
                {
                    data: 'deskripsi'
                },
                {
                    data: 'foto',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'harga_sewa'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari Data",
                lengthMenu: "Menampilkan _MENU_ data",
                zeroRecords: "Data tidak ditemukan",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                infoFiltered: "(disaring dari _MAX_ data)",
                paginate: {
                    previous: '<i class="fa fa-angle-left"></i>',
                    next: "<i class='fa fa-angle-right'></i>",
                }
            },
            dom: 'lBfrtip',
            buttons: [{
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'A5',
                    title: 'Data Villa',
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    className: 'btn btn-sm btn-danger',
                    customize: function(doc) {
                        //find paths of all images, already in base64 format
                        var img = $('.foto-villa').map(function() {
                            return this.src;
                        }).get();
                        //add images to doc
                        for (var i = 0, c = 1; i < img.length; i++, c++) {
                            doc.content[1].table.body[c][3] = {
                                image: img[i],
                                width: 100
                            }
                        }
                    },
                    exportOptions:{
                        columns: [0,1,2,3,4],
                    }
                },
                // excel export 
                {
                    extend: "excelHtml5",
                    title: "Data Villa",
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    className: 'btn btn-sm btn-success',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4],
                        stripHtml: false,
                        modifier: {
                            page: 'current'
                        },
                        sheetName: 'Data Villa',
                        sheetHeader: true,
                        sheetFooter: false,
                        exportData: {
                            decodeEntities: true,
                        },
                    },
                },
                // reload button
                {
                    text: '<i class="fas fa-sync-alt"></i> Reload',
                    className: 'btn btn-sm btn-secondary',
                    action: function(e, dt, node, config) {
                        dt.ajax.reload()
                    }
                },
            ],
        });

        function deleteData(id) {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                var url = "{{ route('villas.destroy', ':id') }}".replace(':id', id);
                if (result.value) {
                    const response = HitData(url, null, 'DELETE').then((res)=>{
                        Swal.fire(
                            'Terhapus!',
                            res.message,
                            'success'
                        ).then(function() {
                            tableVilla.ajax.reload();
                        });
                    }).catch((err) => {
                        Swal.fire(
                            'Gagal!',
                            'Data gagal dihapus.',
                            'error'
                        );
                    })
                }
            });
        }
    </script>
@endsection