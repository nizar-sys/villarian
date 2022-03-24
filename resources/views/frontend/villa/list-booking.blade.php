@extends('layouts.frontend')

@section('title', 'Daftar sewa')

@section('content')

    <div class="row">
        
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h4>Daftar sewa</h4>
                    <div class="table-responsive mt-2">
                        <table class="table table-striped table-bordered table-hover text-center" id="table-data">
                            <thead>
                                <tr>
                                    <th>Nama villa</th>
                                    <th>Nama pemesan </th>
                                    <th>No HP</th>
                                    <th>Tanggal CheckIn</th>
                                    <th>Tanggal CheckOut</th>
                                    <th>Status pembayaran</th>
                                    <th>Total Harga sewa</th>
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
        var tableVilla = $('#table-data').DataTable({
            processing: true,
            serverSide: true,
            responsive: false,
            ajax: "{{ route('booking.data') }}",
            columns: [
                {
                    data: 'nama_villa'
                },
                {
                    data: 'nama_pemesan'
                },
                {
                    data: 'no_hp'
                },
                {
                    data: 'tanggal_checkin'
                },
                {
                    data: 'tanggal_checkout'
                },
                {
                    data: 'status_pembayaran'
                },
                {
                    data: 'total_bayar'
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
        });

        async function bayar(bookingId) {
            var data = {
                bookingId,
            }
            const response = await HitData("{{route('booking.bayar')}}", data, 'PUT')
            return response
        }

        function bayarSewa(snaptoken, bookingId) {
            snap.pay(snaptoken, {
                onSuccess: function(result) {
                        /* You may add your own js here, this is just example */
                        // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                        console.log('Success')
                        console.log(result)
                        tableVilla.ajax.reload()
                    },
                // Optional
                onPending: function(result) {
                    console.log('pending')
                    console.log(result);
                    bayar(bookingId).then(res => {
                        Snackbar.show({
                            text: result.status_message,
                        })
                        tableVilla.ajax.reload()
                    });
                    tableVilla.ajax.reload()
                },
                // Optional
                onError: function(result) {
                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    console.log('Error: ')
                    console.log(result)
                    tableVilla.ajax.reload()
                }
            })
            
        }

        function deleteData(id) {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda akan membatalkan sewa villa",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                var url = "{{ route('booking.villa.batal', ':id') }}".replace(':id', id);
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
                        console.log(err)
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