@extends('layouts.app')
@section('title', 'My Profile')

@section('breadcrumb')
    <ol class="breadcrumb breadcrumb-links breadcrumb-dark mt-4">
        <li class="breadcrumb-item"><a
                href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">
            Profile
        </li>
    </ol>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-xl-4 order-xl-2">
            <div class="card card-profile">
                <img src="{{ asset('/assets/img/theme/img-1-1000x600.jpg') }}" alt="Image placeholder"
                    class="card-img-top">
                <div class="row justify-content-center">
                    <div class="col-lg-3 order-lg-2">
                        <div class="card-profile-image">
                            <form action="{{ route('profile.change-ava') }}" id="form-upload" enctype="multipart/form-data"
                                method="post">
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="oldImage" id="oldImage" value="{{ Auth::user()->avatar }}">
                                <input type="file" class="d-none" name="image" id="uploadImage"><img
                                    style="cursor: pointer;"
                                    src="{{ asset('/uploads/images/profiles/' . Auth::user()->avatar) }}"
                                    class="rounded-circle" id="avaImage">
                            </form>

                        </div>
                    </div>
                </div>
                <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                </div>
                <div class="card-body pt-0 mt-xl-5">
                    <div class="text-center">
                        <h5 class="h3">
                            {{ Auth::user()->name }}
                        </h5>
                        <div class="h5 mt-2">
                            <i
                                class="ni business_briefcase-24 mr-2"></i>{{ \Illuminate\Support\Str::title(Auth::user()->role) }}
                            </i>
                        </div>
                    </div>
                    <!-- Divider -->
                    <hr class="my-3">
                </div>
            </div>
        </div>
        <div class="col-xl-8 order-xl-1">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Edit profile </h3>
                        </div>
                        <div class="col-4 text-right">
                            <button onclick="$('#form-update-prof').submit()" title="Save Changes"
                                class="btn btn-outline-primary btn-primary"><span class="fas fa-save"></span></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="form-update-prof" action="{{ route('profile.change-info') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <h6 class="heading-small text-muted mb-4">User information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-name">Nama</label>
                                        <input type="text" id="input-name"
                                            class="form-control @error('name')
                                        is-invalid
                                        @enderror"
                                            placeholder="Nama" name="name"
                                            value="{{ Auth::user()->name }}">

                                        @error('name')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">Email address @if (Auth::user()->email_verified_at == null)
                                                <span class="text-danger" style="cursor: pointer"
                                                    onclick="verifEmail()">*email not
                                                    verified</span>
                                            @else
                                                <span class="text-primary">*email verified</span>
                                            @endif</label>
                                        <input type="email" id="input-email"
                                            class="form-control @error('email')
                                            is-invalid
                                        @enderror"
                                            placeholder="Email@example" value="{{ Auth::user()->email }}" name="email">
                                        @error('email')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4" />
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Edit password</h3>
                        </div>
                        <div class="col-4 text-right">
                            <button onclick="alertChangePassword()" title="Save Changes"
                                class="btn btn-outline-primary btn-primary"><span class="fas fa-save"></span></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="form-update-password" action="{{ route('profile.change-password') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <h6 class="heading-small text-muted mb-4">User password</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="old_password">Old password</label>
                                        <div class="input-group input-group-merge input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                            </div>
                                            <input class="form-control" name="old_password" placeholder="Password" type="password"
                                                value="{{ old('old_password') }}" id="old_password" data-toggle="password">
                                            <div class="input-group-prepend">
                                                <button type="button" onclick="seePassword(this)" class="input-group-text"
                                                   id="seePass1"><i class="fas fa-eye"></i></button>
                                            </div>
                                        </div>
                                        @error('old_password')
                                            <div class="invalid-feedback d-block">*{{ $message }} <i
                                                    class="fas fa-arrow-up"></i></div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="new_password">New password</label>
                                        <div class="input-group input-group-merge input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                            </div>
                                            <input class="form-control" name="new_password" placeholder="Password" type="password"
                                                value="{{ old('new_password') }}" id="new_password" data-toggle="password">
                                            <div class="input-group-prepend">
                                                <button type="button" onclick="seePassword(this)" class="input-group-text"
                                                id="seePass2"><i class="fas fa-eye"></i></button>
                                            </div>
                                        </div>
                                        @error('new_password')
                                            <div class="invalid-feedback d-block">*{{ $message }} <i
                                                    class="fas fa-arrow-up"></i></div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="confirm_new_password">Confirm New password</label>
                                        <div class="input-group input-group-merge input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                            </div>
                                            <input class="form-control" name="confirm_new_password" placeholder="Password" type="password"
                                                value="{{ old('confirm_new_password') }}" id="confirm_new_password" data-toggle="password">
                                            <div class="input-group-prepend">
                                                <button type="button" onclick="seePassword(this)" class="input-group-text"
                                                id="seePass3"><i class="fas fa-eye"></i></button>
                                            </div>
                                        </div>
                                        @error('confirm_new_password')
                                            <div class="invalid-feedback d-block">*{{ $message }} <i
                                                    class="fas fa-arrow-up"></i></div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4" />
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('c_js')
    @include('_partials.cjs.ajaxPromise')
    <script>
        $('#avaImage').on('click', function() {
            event.preventDefault();

            $('input[name="image"]').click()
        })

        function bacaGambar(input) {
            try {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#avaImage').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);

                    // timeout 2 detik
                    setTimeout(function() {
                        Swal.fire({
                            title: 'Lanjutkan pasang foto profile?',
                            text: "Jadikan gambar sebagai foto profile",
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya!',
                            cancelButtonText: 'Batalkan'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#form-upload').submit()
                            } else {
                                $('#avaImage').attr('src', '/uploads/images/profiles/' + $('input[name="oldImage"]').val());
                            }
                        })
                    }, 2000);
                }
            } catch (error) {

                Snackbar.show({
                    text: 'Error ' + error,
                    duration: 4000,
                });
                window.location.reload()
            }
        }

        $('input[name="image"]').change(function() {
            bacaGambar(this);
        });

        function verifEmail() {
            try {
                Swal.fire({
                    title: 'Verifikasi Email',
                    text: "Anda akan mem-verifikasi email sebagai email terdaftar",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya!',
                    cancelButtonText: 'Batalkan'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const response = HitData("{{ route('verification.send') }}", null, "POST").then((res) =>{
                            Snackbar.show({
                                text: res.message,
                                duration: 4000,
                            });
                        }).catch((err)=>{
                            Snackbar.show({
                                text: err.message,
                                duration: 4000,
                            });
                        })
                    }
                })
            } catch (error) {
                Snackbar.show({
                    text: 'Error ' + error
                })
            }
        }

        function alertChangePassword() {
            Swal.fire({
                title: 'Ganti Password',
                text: "Anda akan mengganti password",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya!',
                cancelButtonText: 'Batalkan'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form-update-password').submit()
                }
            })
        }
    </script>
@endsection