@extends('layouts.auth')
@section('title', 'Login')

@section('content')
<div class="container d-flex flex-column">
    <div class="row h-100 p-3">
        <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
        <div class="d-table-cell align-middle">

            <div class="card">
                <div class="card-body">
                    <div class="m-sm-4">
                        <div class="text-center">
                            <img src="img/logosamping.png" width="50" height="60">
                            <br>
                            <p class="h4" style="line-height: 2em;"><strong>Admin Website Utama</strong></p>
                        </div>
                        <div class="text-center">
                            <img src="img/illustrations/Group.png" width="220" height="200" />
                        </div>
                        @if (session('error'))
                            <div class="alert alert-danger text-center p-2">
                                <small class="text-danger">{{ session('error') }}</small>
                            </div>
                        @endif
                        <form action="{{ url('do_login') }}" method="post" autocomplete="off">
                            @csrf
                            <div class="form-group">
                                <label>Kode Pengguna</label>
                                <input class="form-control form-control-lg" type="email" name="email" placeholder="Masukan Kode Pengguna" />
                            </div>
                            <div class="form-group">
                                <label>Kata Sandi</label>
                                <input class="form-control form-control-lg " type="password" name="password" placeholder="********" />
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-lg btn-primary form-control form-control-lg">Masuk</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        </div>
</div>
</div>
@endsection
