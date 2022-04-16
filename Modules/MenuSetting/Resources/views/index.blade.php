@extends('layouts.app')
@section('title', 'Pengaturan Menu')

@section('content')
<!-- Container fluid  -->
<!-- ============================================================== -->
<!-- <div class="container-fluid"> -->
<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->
<!-- basic table -->
@if (session('message'))

@endif
<?php
$count = count($menusettings) + 1;
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header w-100">
                @if (session('message'))

                <strong id="msgId" hidden>{{ session('message') }}</strong>


                @endif
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="h3">Pengaturan Menu</h3>
                    </div>
                    <div class="col-md-6">
                        
                    </div>
                </div>
            </div>
            <div class="card-body">
                {{-- <div class="addData"> --}}
                <a href="javascript:void(0)" class="btn btn-success btnAdd">
                    <i data-feather="plus" width="16" height="16" class="me-2"></i>
                    Tambah Pengaturan Menu
                </a>
                {{-- </div> --}}

                <div class="table-responsive">
                    <table id="table-data" class="table table-stripped card-table table-vcenter text-nowrap table-data">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">Menu</th>
                                <th width="20%">Parent</th>
                                <th width="20%">URL</th>
                                <th width="5%">Eksternal</th>
                                <th width="5%">Level</th>
                                <th width="5%">Status</th>
                                <th width="5%">Posisi</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (sizeof($menusettings) == 0)
                            <tr>
                                <td colspan="6" align="center">Data kosong</td>
                            </tr>
                            @else
                            @foreach ($menusettings as $menu_setting)

                            <tr>
                                <td width="5%">{{ $loop->iteration }}</td>
                                <td width="20%">{{ $menu_setting->menu_setting_name }}</td>
                                <td width="20%">
                                    @foreach ($menusettings as $menusetting)
                                    @if($menusetting->menu_setting_id == $menu_setting->menu_parent_setting_id)
                                    {{ $menusetting->menu_setting_name }}
                                    @endif
                                    @endforeach
                                </td>
                                <td width="20%">{{ $menu_setting->menu_setting_url }}</td>
                                <td width="5%">
                                    @if($menu_setting->menu_setting_link_eksternal == 1)
                                        Aktif
                                    @elseif($menu_setting->menu_setting_link_eksternal == 0)
                                        Non Aktif
                                    @endif
                                </td>
                                <td width="5%">{{ $menu_setting->menu_setting_level }}</td>
                                <td width="5%">{{ $menu_setting->menu_setting_status }}</td>
                                <td width="5%">{{ $menu_setting->menu_setting_position }}</td>
                                <td width="15%">
                                    @if($menu_setting->menu_setting_id > 0)
                                    <a href="javascript:void(0)" class="btn btn-icon btnEdit btn-outline-warning"
                                        data-id="{{ $menu_setting->menu_setting_id }}" data-toggle="tooltip"
                                        data-placement="top" title="Ubah">
                                        <i data-feather="edit" width="16" height="16"></i>
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-icon btn-outline-danger btnDelete"
                                        data-url="{{ url('menu-setting/delete/'. $menu_setting->menu_setting_id) }}"
                                        data-toggle="tooltip" data-placement="top" title="Hapus">
                                        <i data-feather="trash-2" width="16" height="16"></i>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End PAge Content -->
<!-- ============================================================== -->
<!-- </div> -->
<!-- ============================================================== -->
<!-- End Container fluid  -->

<!-- Modal Add -->
<div class="modal addModal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pengaturan Menu</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ url('menu-setting/store') }}" method="POST" id="addForm">
                @csrf
                <div class="modal-body">
                    <div class="form-body">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Nama Pengaturan Menu<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="menu_setting_name"
                                        id="menu_setting_name" placeholder="Masukan Nama Pengaturan Menu"
                                        value="{{ old('menu_setting_name') }}">
                                    @if ($errors->has('menu_setting_name'))
                                    <span class="text-danger">
                                        <label id="basic-error" class="validation-error-label" for="basic">Pengaturan
                                            Menu tidak
                                            boleh sama</label>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">URL Pengaturan Menu<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="menu_setting_url"
                                        id="menu_setting_url" placeholder="Masukan URL Pengaturan Menu"
                                        value="{{ old('menu_setting_url') }}">
                                        <small>Masukkan <strong>#</strong> Jika untuk menu utama, dan url jika bukan menu utama</small>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Menu Parent </label>
                                    <select class="form-control" name="menu_parent_setting_id"
                                        id="menu_parent_setting_id">
                                        <option value="">- Pilih Menu Parent -</option>
                                        @if(sizeof($menusettings) > 0)
                                        @foreach($menusettings as $menusetting)
                                        @if($menusetting->menu_setting_url == "#")
                                        <option value="{{ $menusetting->menu_setting_id }}">
                                            {{ $menusetting->menu_setting_name }}</option>
                                        @endif
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Level <span class="text-danger">*</span></label>
                                    <select class="form-control" name="menu_setting_level"
                                        id="menu_setting_level">
                                        <option value="">- Pilih Level -</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>

                                    <!-- <input type="text" class="form-control" name="menu_setting_level"
                                        id="menu_setting_level" placeholder="Masukan Level Pengaturan Menu">
                                    <small>Semakin kecil, semakin atas (0)</small> -->
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Pilih Link Eksternal </label>
                                    <select class="form-control" name="menu_setting_link_eksternal"
                                        id="menu_setting_link_eksternal">
                                        <option value="">- Pilih Link Eksternal -</option>
                                        <option value="1">Aktif</option>
                                        <option value="0">Non Aktif</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Pilih Status </label>
                                    <select class="form-control" name="menu_setting_status" id="menu_setting_status">
                                        <option value="">- Pilih Status -</option>
                                        <option value="1">Aktif</option>
                                        <option value="0">Non Aktif</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Posisi <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="menu_setting_position"
                                        id="menu_setting_position" value="{{$count}}" placeholder="Masukan posisi">
                                    <small>Semakin kecil, semakin atas (0)</small>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Add -->
@endsection

@section('script')
<script type="text/javascript">
    $('.btnAdd').click(function () {
        document.getElementById("addForm").reset();
        $('#menu_setting_name').val('');
        $('#menu_setting_url').val('');
        $('.addModal form').attr('action', "{{ url('menu-setting/store') }}");
        $('.addModal .modal-title').text('Tambah Pengaturan Menu');
        $('.addModal').modal('show');
    });

    // check error
    @if(count($errors))
    $('.addModal').modal('show');
    @endif

    $('.btnEdit').click(function () {

        var id = $(this).attr('data-id');
        var url = "{{ url('menu-setting/getdata') }}";

        $('.addModal form').attr('action', "{{ url('menu-setting/update') }}" + '/' + id);

        $.ajax({
            type: 'GET',
            url: url + '/' + id,
            dataType: 'JSON',
            success: function (data) {
                console.log(data);

                if (data.status == 1) {

                    $('#menu_setting_name').val(data.result.menu_setting_name);
                    $('#menu_setting_url').val(data.result.menu_setting_url);
                    $('#menu_parent_setting_id').val(data.result.menu_parent_setting_id);
                    $('#menu_setting_level').val(data.result.menu_setting_level);
                    $('#menu_setting_link_eksternal').val(data.result.menu_setting_link_eksternal);
                    $('#menu_setting_status').val(data.result.menu_setting_status);
                    $('#menu_setting_position').val(data.result.menu_setting_position);
                    $('.addModal .modal-title').text('Ubah Pengaturan Menu');
                    $('.addModal').modal('show');

                }

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert('Error : Gagal mengambil data');
            }
        });

    });

    $('.btnDelete').click(function () {
        $('.btnDelete').attr('disabled', true)
        var url = $(this).attr('data-url');
        Swal.fire({
            title: 'Apakah anda yakin ingin menghapus data?',
            text: "Kamu tidak akan bisa mengembalikan data ini setelah dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya. Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function (data) {
                        if (result.isConfirmed) {
                            Swal.fire(
                                'Terhapus!',
                                'Data Berhasil Dihapus.',
                                'success'
                            ).then(() => {
                                location.reload()
                            })
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        Swal.fire(
                            'Gagal!',
                            'Gagal menghapus data.',
                            'error'
                        );
                    }
                });
            }
        })
    });

    $("#addForm").validate({
        rules: {
            menu_setting_name: "required",
            menu_setting_url: "required",
            menu_setting_level: "required",
            menu_setting_link_eksternal: "required",
            menu_setting_status: "required",
            menu_setting_position: {
                required: true,
                number: true
            },
        },
        messages: {
            menu_setting_name: "Tipe tidak boleh kosong",
            menu_setting_url: "URL tidak boleh kosong",
            menu_setting_level: "Level tidak boleh kosong",
            menu_setting_link_eksternal: "Tautan Eksternal tidak boleh kosong",
            menu_setting_status: "Pilih status",
            menu_setting_position: "Posisi tidak boleh kosong",
        },
        errorElement: "em",
        errorClass: "invalid-feedback",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            $(element).parents('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        }
    });

    var notyf = new Notyf({
        duration: 5000,
        position: {
            x: 'right',
            y: 'top'
        }
    });
    var msg = $('#msgId').html()
    if (msg !== undefined) {
        notyf.success(msg)
    }

</script>
@endsection
