@extends('layouts.app')
@section('title', 'Log Statistik')

@section('content')
<!-- Container fluid  -->
<!-- ============================================================== -->
<!-- <div class="container-fluid"> -->
<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->
<!-- basic table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header w-100">
                @if (session('successMessage'))
                <strong id="successMessage" hidden>{{ session('successMessage') }}</strong>
                @elseif(session('errorMessage'))
                <strong id="errorMessage" hidden>{{ session('errorMessage') }}</strong>
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="h3">Log Statistik</h3>
                    </div>
                    <div class="col-md-6">
                        
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="addData mb-3">
                    <a href="javascript:void(0)" class="btn btn-success btnAdd">
                        <i data-feather="plus" width="16" height="16" class="me-2"></i>
                        Tambah Log Statistik
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped card-table table-hover text-nowrap log-table-data">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="10%">IP Address</th>
                                <th width="10%">Halaman</th>
                                <th width="10%">HIT URL</th>
                                <th width="10%">Tanggal</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
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
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Log Statistik</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ url('logstatistic/store') }}" method="POST" id="addForm">
                @csrf
                <div class="modal-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="ip_address">IP Address<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="ip_address" id="ip_address"
                                        placeholder="Masukan IP Address" value="{{ old('ip_address') }}">
                                    @if ($errors->has('ip_address'))
                                    <span class="text-danger">
                                        <label id="basic-error" class="validation-error-label" for="basic">IP Address
                                            tidak boleh sama</label>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="url_access">URL<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="url_access" id="url_access"
                                        placeholder="Masukan URL" value="{{ old('url_access') }}">
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="page_access">Halaman<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="page_access" id="page_access"
                                        placeholder="Masukan Halaman" value="{{ old('page_access') }}">
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="hits_url_access">HIT URL<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="hits_url_access" id="hits_url_access"
                                        placeholder="Masukan HIT URL" value="{{ old('hits_url_access') }}">
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="browser_access">Browser<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="browser_access" id="browser_access"
                                        placeholder="Masukan Browser" value="{{ old('browser_access') }}">
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="device_access">Perangkat<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="device_access" id="device_access"
                                        placeholder="Masukan Perangkat" value="{{ old('device_access') }}">
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="operating_system_access">Sistem Operasi<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="operating_system_access"
                                        id="operating_system_access" placeholder="Masukan Sistem Operasi"
                                        value="{{ old('operating_system_access') }}">
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" id="saveBtn" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Add -->

<!-- Modal Detail -->
<div class=" modal detailModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Log Statistik</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6 mb-3 row">
                                <label for="ip_address" class="col-md-5 col-form-label">IP Address</label>
                                <div class="col-md-7">
                                    <input type="text" readonly class="form-control-plaintext ip_address"
                                        value="{{ old('ip_address') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 row">
                                <label for="url_access" class="col-md-5 col-form-label">Akses URL</label>
                                <div class="col-md-6">
                                    <input type="text" readonly class="form-control-plaintext url_access"
                                        value="{{ old('url_access') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 row">
                                <label for="page_access" class="col-md-5 col-form-label">Akses Halaman</label>
                                <div class="col-md-6">
                                    <input type="text" readonly class="form-control-plaintext page_access"
                                        value="{{ old('page_access') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 row">
                                <label for="hits_url_access" class="col-md-5 col-form-label">Akses HIT URL</label>
                                <div class="col-md-6">
                                    <input type="text" readonly class="form-control-plaintext hits_url_access"
                                        value="{{ old('hits_url_access') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 row">
                                <label for="browser_access" class="col-md-5 col-form-label">Akses Browser</label>
                                <div class="col-md-6">
                                    <input type="text" readonly class="form-control-plaintext browser_access"
                                        value="{{ old('browser_access') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 row">
                                <label for="device_access" class="col-md-5 col-form-label">Akses Perangkat</label>
                                <div class="col-md-6">
                                    <input type="text" readonly class="form-control-plaintext device_access"
                                        value="{{ old('device_access') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 row">
                                <label for="operating_system_access" class="col-md-5 col-form-label">Akses Sistem
                                    Operasi</label>
                                <div class="col-md-6">
                                    <input type="text" readonly class="form-control-plaintext operating_system_access"
                                        value="{{ old('operating_system_access') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 row">
                                <label for="created_at" class="col-md-5 col-form-label">Akses Tanggal</label>
                                <div class="col-md-6">
                                    <input type="text" readonly class="form-control-plaintext created_at"
                                        value="{{ old('created_at') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Detail -->
@endsection

@section('script')
<script type="text/javascript">
    loadTable();

    function loadTable() {
        let url = "{{ url('logstatistic/getdatayajra') }}";
        let table = $('.log-table-data').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            language: {
                zeroRecords: "Data kosong"
            },
            ajax: url,
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'ip_address',
                    name: 'ip_address'
                },
                {
                    data: 'page_access',
                    name: 'page_access'
                },
                {
                    data: 'hits_url_access',
                    name: 'hits_url_access'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });
    }

    $('.btnAdd').click(function () {
        document.getElementById("addForm").reset();
        $('.addModal form').attr('action', "{{ url('logstatistic/store') }}");
        $('.addModal .modal-title').text('Tambah Data Log Statistik');
        $('.addModal').modal('show');
    });

    // check error
    @if(count($errors))
    $('.addModal').modal('show');
    @endif

    $('body').on('click', '.btnEdit', function () {
        var id = $(this).attr('data-id');
        var url = "{{ url('logstatistic/getdata') }}";
        $('.addModal form').attr('action', "{{ url('logstatistic/update') }}" + '/' + id);

        $.ajax({
            type: 'GET',
            url: url + '/' + id,
            dataType: 'JSON',
            success: function (data) {
                console.log(data);

                if (data.status == 1) {
                    $('#ip_address').val(data.result.ip_address);
                    $('#url_access').val(data.result.url_access);
                    $('#page_access').val(data.result.page_access);
                    $('#hits_url_access').val(data.result.hits_url_access);
                    $('#browser_access').val(data.result.browser_access);
                    $('#device_access').val(data.result.device_access);
                    $('#operating_system_access').val(data.result.operating_system_access);

                    $('.addModal .modal-title').text('Ubah Data Log Statistik');
                    $('.addModal').modal('show');
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                Swal.fire(
                    'Gagal!',
                    'Gagal mengambil data.',
                    'error'
                );
            }
        });
    });

    $('body').on('click', '.btnDelete', function () {
        $('.btnDelete').attr('disabled', true);
        let id = $(this).attr('data-id');
        let url = "{{ url('logstatistic/delete')}}";

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
                    type: 'get',
                    url: url + '/' + id,
                    success: function (data) {
                        if (data.status == 1) {
                            if (result.isConfirmed) {
                                loadTable();
                                Swal.fire(
                                    'Terhapus!',
                                    data.message,
                                    'success'
                                );
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Delete gagal!',
                                text: data.message,
                                showConfirmButton: false,
                                timer: 2000
                            })
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        Swal.fire(
                            'Gagal!',
                            data.message,
                            'error'
                        );
                    }
                });
            }
        })
    });

    $('body').on('click', '.btnDetail', function () {
        let id = $(this).attr('data-id');
        let url = "{{ url('logstatistic/show') }}";
        $.ajax({
            type: 'GET',
            url: url + '/' + id,
            dataType: 'JSON',
            success: function (data) {
                if (data.status == 1) {

                    $('.ip_address').val(': ' + data.result.ip_address);
                    $('.url_access').val(': ' + data.result.url_access);
                    $('.page_access').val(': ' + data.result.page_access);
                    $('.hits_url_access').val(': ' + data.result.hits_url_access);
                    $('.browser_access').val(': ' + data.result.browser_access);
                    $('.device_access').val(': ' + data.result.device_access);
                    $('.operating_system_access').val(': ' + data.result.operating_system_access);
                    $('.created_at').val(': ' + data.result.created_at);

                    $('.detailModal .modal-title').text('Detail Data Log Statistik');
                    $('.detailModal').modal('show');
                }

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                Swal.fire(
                    'Gagal!',
                    'Gagal mengambil data.',
                    'error'
                );
            }
        });
    });

    $("#addForm").validate({
        rules: {
            ip_address: "required",
        },
        messages: {
            ip_address: "IP Address tidak boleh kosong",
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
        },
        submitHandler: function (addForm) {
            let url = $('.addModal form').attr('action');
            $('#saveBtn').attr('disabled', true);
            $('#saveBtn').html('Menyimpan...');
            $.ajax({
                data: $('#addForm').serialize(),
                url: url,
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    if (data.status == 1) {
                        Swal.fire(
                            'Berhasil',
                            data.message,
                            'success'
                        );
                        $('.addModal').modal('hide');
                        $('#saveBtn').html('Simpan');
                        $('#saveBtn').attr('disabled', false);
                        loadTable();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: data.message,
                            showConfirmButton: false,
                            timer: 2000
                        }).then((
                            $('#saveBtn').html('Simpan'),
                            $('#saveBtn').attr('disabled', false)
                        ));
                    }
                },
                error: function (data) {
                    Swal.fire(
                        'Gagal!',
                        data.message,
                        'error'
                    ).then((
                        $('#saveBtn').html('Simpan'),
                        $('#saveBtn').attr('disabled', false)
                    ));
                }
            });
        }
    });

</script>
@endsection
