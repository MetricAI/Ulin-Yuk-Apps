<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 4 Admin &amp; Dashboard Template">
    <meta name="author" content="Bootlab">

    <title>
        @if(View::hasSection('title'))
        @yield('title') -
        @endif
        Web Utama
    </title>

    <link rel="canonical" href="https://appstack.bootlab.io/dashboard-default.html" />
    <link rel="shortcut icon" href="{{url('img/stt.png')}}">
    <link rel="stylesheet" href="{{ url('css/style-custom.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link class="stylesheet" href="{{url('css/light.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>

    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

    <style type="text/css">
        .parsley-errors-list li {
            list-style: none;
            color: red;
        }

        .handlelist{
            cursor: move;
            cursor: -webkit-grabbing;
        }

        .handleimage{
            cursor: move;
            cursor: -webkit-grabbing;
        }

        .ghost {
          opacity: 0.4;
        }

        div.polaroid {
          width: 80%;
          background-color: white;
          box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 3px 10px 0 rgba(0, 0, 0, 0.10);
          margin-bottom: 25px;
          text-align: center;
          padding: 10px 15px;
        }

    </style>

</head>

<body data-theme="light" data-layout="fluid" data-sidebar-position="left" data-sidebar-behavior="sticky">
    <div class="wrapper">
        <nav id="sidebar" class="sidebar">
            <div class="sidebar-content js-simplebar">
                <a class="sidebar-brand">
                    <img src="{{url('img/logo.png')}}" width="210" height="40">
                </a>
                {{-- sidebar --}}
                <ul class="sidebar-nav">
                    @include('components.menu')
                </ul>
            </div>
        </nav>
        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle">
                    <i class="hamburger align-self-center"></i>
                </a>

                <!-- <form class="d-none d-sm-inline-block">
                    <div class="input-group input-group-navbar">
                        <input type="text" class="form-control" placeholder="Cari…" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn" type="button">
                                <i class="align-middle" data-feather="search"></i>
                            </button>
                        </div>
                    </div>
                </form>
 -->
                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav navbar-align">
                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#"
                                data-toggle="dropdown">
                                <i class="align-middle" data-feather="settings"></i>
                            </a>

                            <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#"
                                data-toggle="dropdown">
                                @if(Auth::user()->user_image == NULL)
                                <img src="{{url('img/avatars/profile.jpg')}}"
                                    class="avatar img-fluid rounded-circle mr-1" alt="user_name" />
                                @else
                                <img src="{{asset('storage/uploads/images')}}/{{Auth::user()->user_image}}"
                                    class="avatar img-fluid rounded-circle mr-1" alt="user_name" />
                                @endif
                                <span class="text-dark">{{ Auth::user()->user_name }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="/profile"><i class="align-middle mr-1"
                                        data-feather="user">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                    </i> Profil
                                </a>
                                <!-- <a class="dropdown-item" href="/profile"><i class="align-middle mr-2 mb-1"
                                        data-feather="unlock">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-unlock">
                                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                            <path d="M7 11V7a5 5 0 0 1 9.9-1"></path>
                                        </svg>
                                    </i>Edit Data</a> -->
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item logout" data-url="/logout">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-log-out">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                        <polyline points="16 17 21 12 16 7"></polyline>
                                        <line x1="21" y1="12" x2="9" y2="12"></line>
                                    </svg>
                                    Keluar
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>



            {{-- main content --}}
            <main class="content">
                @yield('content')
            </main>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-12 text-center">
                            <p class="mb-0">
                                &copy; <?php echo date("Y"); ?> STTBandung <b>.</b> By Gesit Team</a>
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src={{ url('js/app.js') }}></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- include summernote css/\\js -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <!-- include parsley js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.8.0/parsley.min.js"
        integrity="sha512-wNs1j1Vo1t0stXW7Lz5QL6T7a/9ClH7/X10Q4jd3aIcRsFTTPh0gRkTxRk0jgXcloVwNIrvmkyStp99hMObegQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            $("#datetimepicker-dashboard").datetimepicker({
                inline: true,
                sideBySide: false,
                format: "L"
            });
        });

    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            $(".table-data").DataTable({
                pageLength: 10,
                lengthChange: false,
                bFilter: true,
                autoWidth: true
            });
        });

    </script>

    <script>
        // summernote
        $(document).ready(function () {
            $(".summernote").summernote({
                height: 200,
                toolbar: [
                    ['style', ['highlight', 'bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['codeview']]
                ],
            });

            $(".summernote-work").summernote({
                height: 200,
                toolbar: [
                    ['style', ['highlight', 'bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['codeview']]
                ],
            });
        });





        // choose file
        $('.custom-file-input').on('change', function () {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });

    </script>

    <script>
        $('.logout').click(function () {
            $('.logout').attr('disabled', true)
            var url = $(this).attr('data-url');
            Swal.fire({
                title: 'Apakah anda yakin ingin Logout ?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya. Logout'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'GET',
                        url: url,
                        success: function (data) {
                            if (result.isConfirmed) {
                                Swal.fire(
                                    'Berhasil!',
                                    'Berhasil Logout.',
                                    'success'
                                ).then(() => {
                                    location.reload()
                                })
                            }
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            Swal.fire(
                                'Gagal!',
                                'Gagal Logout.',
                                'error'
                            );
                        }
                    });
                }
            })
        });

    </script>

    {{-- notification show --}}
    <script>
        var notyfSuccess = new Notyf({
            duration: 5000,
            position: {
                x: 'right',
                y: 'top'
            }
        });
        var notyfError = new Notyf({
            duration: 0,
            dismissible: true,
            position: {
                x: 'right',
                y: 'top'
            }
        });
        var msgSuccess = $('#successMessage').html()
        if (msgSuccess !== undefined) {
            notyfSuccess.success(msgSuccess)
        }
        var msgError = $('#errorMessage').html()
        if (msgError !== undefined) {
            notyfError.error(msgError)
        }

    </script>

    @yield('script')

</body>

</html>
