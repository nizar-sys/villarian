@extends('layouts.frontend')
@section('title', 'Booking '.$villa->nama_villa)

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="row">
                    
                    <div class="col-md-6 col-sm-12">
                        <div class="card bg-default shadow">
                            <div class="card-header bg-transparent">
                                <h3 class="card-title mb-3">Daftar sewa villa</h3>
                                <div id="calendar"></div>
                              <!-- THE CALENDAR -->
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <div class="container">
                            <div class="row">
                                @if (is_null($userBooked))
                                <div class="col-12">
                                    <div class="card bg-default shadow">
                                        <div class="card-header bg-transparent border-0">
                                            <h3 class="card-title mb-3">Form sewa villa</h3>
        
                                            <form id="form-sewa" action="{{route('booking.villa.post', $villa->uuid)}}" method="POST">
                                                @csrf
                
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label class="form-control-label" for="input-nama_pemesan">Nama Pemesan</label>
                                                            <input type="text" id="input-nama_pemesan"
                                                                class="form-control @error('nama_pemesan') is-invalid @enderror"
                                                                placeholder="Nama Pemesan" name="nama_pemesan" value="{{ old('nama_pemesan') }}">
                        
                                                            @error('nama_pemesan')
                                                                <div class="invalid-feedback d-block">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label class="form-control-label" for="input-no_hp">No HP Pemesan</label>
                                                            <input type="text" id="input-no_hp"
                                                                class="form-control @error('no_hp') is-invalid @enderror"
                                                                placeholder="No HP Pemesan" name="no_hp" value="{{ old('no_hp') }}">
                        
                                                            @error('no_hp')
                                                                <div class="invalid-feedback d-block">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
        
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label class="form-control-label" for="input-tanggal_checkin">Tanggal checkin</label>
                                                            <input type="date" id="input-tanggal_checkin"
                                                                class="form-control @error('tanggal_checkin') is-invalid @enderror"
                                                                placeholder="Tanggal checkin" name="tanggal_checkin" value="{{ old('tanggal_checkin') }}">
                        
                                                            @error('tanggal_checkin')
                                                                <div class="invalid-feedback d-block">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label class="form-control-label" for="input-tanggal_checkout">Tanggal checkout</label>
                                                            <input type="date" id="input-tanggal_checkout"
                                                                class="form-control @error('tanggal_checkout') is-invalid @enderror"
                                                                placeholder="Tanggal checkout" name="tanggal_checkout" value="{{ old('tanggal_checkout') }}">
                        
                                                            @error('tanggal_checkout')
                                                                <div class="invalid-feedback d-block">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="form-control-label" for="input-jumlah_hari">Jumlah hari</label>
                                                    <input type="text" id="input-jumlah_hari"
                                                        class="form-control @error('jumlah_hari') is-invalid @enderror"
                                                        placeholder="Jumlah hari" value="0 hari" name="jumlah_hari" disabled>
                
                                                    @error('jumlah_hari')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label class="form-control-label" for="input-total_bayar">Total Harga sewa</label>
                                                    <input type="text" id="input-total_bayar"
                                                        class="form-control @error('total_bayar') is-invalid @enderror"
                                                        placeholder="Total Harga sewa" value="{{$villa->harga_sewa}}" name="total_bayar" readonly>
                
                                                    @error('total_bayar')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @else
                                    <h3>Anda telah menyewa villa <i>{{$villa->nama_villa}}</i>, silahkan klik "Bayar" atau "Batalkan"</h3>
                                @endif
                                
                            </div>
                            <div class="row mt-2">
                                <div class="col-6">
                                    <a href="{{route('villa.detail', $villa->uuid)}}" class="btn btn-secondary btn-sm">Kembali</a>

                                    @if (!is_null($userBooked))
                                        <a href="{{route('booking.list')}}" class="btn btn-primary btn-sm">Daftar sewa</a>
                                    @else
                                    <button type="button" onclick="$('#form-sewa').submit()" class="btn btn-success btn-sm">Sewa</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endSection

@section('c_js')
    @include('_partials.cjs.calendarBooking')
    <script>
        function hitungSelisihHari(tgl_awal, tgl_ahkir) {
            var hari = (new Date(tgl_ahkir).getTime() - new Date(tgl_awal).getTime()) / (1000 * 3600 * 24);
            return hari
        }

        $(document).ready(()=>{
            var inputTglAwal = $('#input-tanggal_checkin');
            var inputTglAkhir = $('#input-tanggal_checkout');
            var jmlHari = $('#input-jumlah_hari');
            var inputHargaSewa = $('#input-total_bayar');

            const hargaSewa = inputHargaSewa.val();

            inputTglAkhir.on('change', (e)=>{
                if(inputTglAwal.val() != ''){
                    var hari = hitungSelisihHari(inputTglAwal.val(), $(e.target).val())
                    jmlHari.val(`${hari} Hari.`)
                    inputHargaSewa.val(hari * hargaSewa)
                }
            })

            inputTglAwal.on('change', (e)=>{
                if(inputTglAkhir.val() != ''){
                    var hari = hitungSelisihHari(inputTglAkhir.val(), $(e.target).val())
                    jmlHari.val(`${hari} Hari.`)
                    inputHargaSewa.val(hari * hargaSewa)
                }
            })
        })

        function batalkanSewa(id)
        {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda akan membatalkan sewa!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, batalkan!'
            }).then((result) => {
                if (result.value) {
                    $('#form-batal-sewa-'+id).submit()
                }
            });
        }
    </script>
@endsection