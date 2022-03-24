@extends('layouts.app')
@section('title', 'Ubah data villa')

@section('breadcrumb')
    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('villas.index') }}">Data villarian</a>
        </li>
        <li class="breadcrumb-item active">Ubah Data villa</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-transparent border-0">
                    <h3 class="card-title mb-3">Ubah data</h3>

                    <form action="{{route('villas.update', $villa->uuid)}}" id="form-create-villa" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="deskripsi" id="deskripsi" value="{{$villa->deskripsi}}">
                        @csrf
                        @method('PUT')
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-nama_villa">Nama Villa</label>
                                        <input type="text" id="input-nama_villa"
                                            class="form-control @error('nama_villa') is-invalid @enderror"
                                            placeholder="Nama Villa" name="nama_villa" value="{{$villa->nama_villa}}">

                                        @error('nama_villa')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-alamat">Alamat Villa</label>
                                        <input type="text" id="input-alamat"
                                            class="form-control @error('alamat') is-invalid @enderror"
                                            placeholder="Alamat Villa" name="alamat" value="{{ $villa->alamat }}">

                                        @error('alamat')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-control-label">Deskripsi Villa</label>
                                <div id="editor">
                                    {!! $villa->deskripsi !!}
                                </div>

                                <div class="invalid-feedback d-block" id="count-deskripsi">
                                    <span id="count-deskripsi-text">100 karakter tersisa</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-foto">Foto Villa</label>
                                        <input type="file" id="input-foto"
                                            class="form-control @error('foto') is-invalid @enderror"
                                            placeholder="Foto Villa" name="foto" value="{{ old('foto') }}">

                                        <div class="invalid-feedback d-block">
                                            Jangan unggah foto jika tidak ingin mengganti foto.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-harga_sewa">Harga Sewa Villa</label>
                                        <input type="number" id="input-harga_sewa"
                                            class="form-control @error('harga_sewa') is-invalid @enderror"
                                            placeholder="Harga Sewa Villa" name="harga_sewa" value="{{ $villa->harga_sewa }}">

                                        @error('harga_sewa')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <button class="btn btn-success btn-sm" type="button" id="action-villa">Ubah</button>
                                    <a href="{{ route('villas.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('c_js')
    @include('_partials.cjs.ckeditor')
    @include('_partials.cjs.countTextEditor')
    <script>
        $(document).ready(function() {
            countTextDeskripsi();
            deskripsiEditor.on('keyup', function() {
                countTextDeskripsi();
            });
        });
    </script>
@endsection
