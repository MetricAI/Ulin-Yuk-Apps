@extends('layouts.app')
@section('title', 'Log Aktivitas')

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
                        <h3 class="h3">Log Aktivitas</h3>
                    </div>
                    <div class="col-md-6">
                        
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="addData mb-3">
                    <a href="javascript:void(0)" class="btn btn-success btnAdd">
                        <i data-feather="plus" width="16" height="16" class="me-2"></i>
                        Tambah Log Aktivitas
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped card-table table-hover text-nowrap log-table-data">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Log Deskripsi</th>
                                <th>Created at</th>
                                <th>Created by</th>
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
                <h5 class="modal-title">Tambah Log Aktivitas</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ url('logactivity/store') }}" method="POST" id="addForm">
                @csrf
                <div class="modal-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="log_description">Log Deskripsi
                                        Surat<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="log_description" id="log_description"
                                        placeholder="Masukan log deskripsi" value="{{ old('log_description') }}">
                                    @if ($errors->has('log_description'))
                                    <span class="text-danger">
                                        <label id="basic-error" class="validation-error-label" for="basic">Log deskripsi
                                            tidak boleh sama</label>
                                    </span>
                                    @endif
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
                <h5 class="modal-title">Detail Log Aktivitas</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6 mb-3 row">
                                <label for="log_description" class="col-md-5 col-form-label">Log Aktivitas</label>
                                <div class="col-md-7">
                                    <input type="text" readonly class="form-control-plaintext log_description"
                                        value="{{ old('log_description') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 row">
                                <label for="created_at" class="col-md-5 col-form-label">Created At</label>
                                <div class="col-md-6">
                                    <input type="text" readonly class="form-control-plaintext created_at"
                                        value="{{ old('created_at') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 row">
                                <label for="user_name" class="col-md-5 col-form-label">Created By</label>
                                <div class="col-md-6">
                                    <input type="text" readonly class="form-control-plaintext user_name"
                                        value="{{ old('user_name') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 row">
                                <label for="user_email" class="col-md-5 col-form-label">Created Email</label>
                                <div class="col-md-6">
                                    <input type="text" readonly class="form-control-plaintext user_email"
                                        value="{{ old('user_email') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 row">
                                <label for="group_name" class="col-md-5 col-form-label">Created Group</label>
                                <div class="col-md-6">
                                    <input type="text" readonly class="form-control-plaintext group_name"
                                        value="{{ old('group_name') }}">
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
        let url = "{{ url('logactivity/getdatayajra') }}";
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
                    data: 'log_description',
                    name: 'log_description'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'user_name',
                    name: 'user_name'
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
        $('.addModal form').attr('action', "{{ url('logactivity/store') }}");
        $('.addModal .modal-title').text('Tambah Data Log Aktivitas');
        $('.addModal').modal('show');
    });

    // check error
    @if(count($errors))
    $('.addModal').modal('show');
    @endif

    $('body').on('click', '.btnEdit', function () {
        var id = $(this).attr('data-id');
        var url = "{{ url('logactivity/getdata') }}";
        $('.addModal form').attr('action', "{{ url('logactivity/update') }}" + '/' + id);

        $.ajax({
            type: 'GET',
            url: url + '/' + id,
            dataType: 'JSON',
            success: function (data) {
                console.log(data);

                if (data.status == 1) {
                    $('#log_description').val(data.result.log_description);

                    $('.addModal .modal-title').text('Ubah Data Log Aktivitas');
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
        let url = "{{ url('logactivity/delete')}}";

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
        let url = "{{ url('logactivity/show') }}";
        $.ajax({
            type: 'GET',
            url: url + '/' + id,
            dataType: 'JSON',
            success: function (data) {
                if (data.status == 1) {

                    $('.log_description').val(': ' + data.result.log_description);
                    $('.created_at').val(': ' + data.result.created_at);
                    $('.user_name').val(': ' + data.result.user_name);
                    $('.user_email').val(': ' + data.result.user_email);
                    $('.group_name').val(': ' + data.result.group_name);

                    $('.detailModal .modal-title').text('Detail Data Log Aktivitas');
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
            log_description: "required",
        },
        messages: {
            log_description: "Log deskripsi tidak boleh kosong",
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
