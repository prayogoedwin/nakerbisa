@extends('backend.template.backend')

@section('content')
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Layout container -->
            <div class="layout-page">
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="container">
                            <h2 class="text-center mb-4">Register {{ $dt['role_name'] }} </h2>
                            {{-- <form id="registrationForm"> --}}
                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
                            <input type="hidden" name="kode_role" id="kode_role" value="{{ $dt['role'] }}">
                            <!-- Step 1 -->
                            <div class="step" id="step1">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email"
                                        value="{{ old('email', $prefill['email'] ?? '') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="whatsapp" class="form-label">WhatsApp</label>
                                    <input type="text" class="form-control" id="whatsapp"
                                        value="{{ old('whatsapp', $prefill['whatsapp'] ?? '') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" required>
                                    <input type="checkbox" id="show-password"><small>Lihat Kata Sandi</small>
                                </div>
                                <button type="button" id="btnStep1" class="btn btn-primary w-100 mt-3"
                                    onclick="nextStepBaru1()">Next</button>
                            </div>

                            <input type="hidden" id="email_registered" name="email_registered">

                            <!-- Step 3 -->
                            <div id="step3-container">
                                @if ($dt['role'] == 'tenaga-kerja')
                                    @include('backend.ak1.step3_pencarikerja')
                                @endif
                            </div>
                            {{-- </form> --}}
                        </div>
                    </div>
                    <!-- / Content -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>
        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $("#show-password").change(function() {
                $(this).prop("checked") ? $("#password").prop("type", "text") : $("#password").prop("type",
                    "password");
            });
        });
    </script>

    <script>
        let currentStep = 1;

        function showStep(step) {
            document.querySelectorAll('.step').forEach((element, index) => {
                element.classList.add('d-none');
                if (index === step - 1) {
                    element.classList.remove('d-none');
                }
            });

            document.querySelectorAll('.step-indicator .circle').forEach((circle, index) => {
                circle.classList.remove('active');
                if (index < step) {
                    circle.classList.add('active');
                }
            });
        }

        function nextStep() {
            if (currentStep < 2) {
                currentStep++;
                showStep(currentStep);
            }
        }

        function previousStep() {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        }

        // document.getElementById('registrationForm').addEventListener('submit', function(event) {
        //     event.preventDefault();
        //     alert('Registration Successful!');
        // });

        // Initialize to show only the first step
        showStep(currentStep);

        function nextStepBaru1() {
            var imel = $('#email').val();
            var wa = $('#whatsapp').val();
            var pass = $('#password').val()
            var _token = $('#_token').val();
            var kd_role = $('#kode_role').val();

            if (!imel || !wa || !pass) {
                // Swal.fire({
                //     title: "<i>Title</i>",
                //     html: "Testno  sporocilo za objekt: <b>test</b>",
                //     confirmButtonText: "V <u>redu</u>",
                // });
                Swal.fire({
                    // title: 'Pastikan semua kolom terisi',
                    text: 'Pastikan semua kolom terisi',
                    icon: 'info'
                });
                return;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('cek-awal-akun-ak1') }}",
                type: "POST",
                data: {
                    _token: _token,
                    email: imel,
                    wa: wa,
                    password: pass,
                    role: kd_role
                },
                // dataType: "html",
                success: function(response) {
                    console.log(`STEP 1 RES : ${response}`)
                    var sts = response.status
                    var msg = response.message
                    var dt = response.data

                    if (sts == 0) {
                        Swal.fire({
                            title: 'Ooppss',
                            text: msg,
                            icon: 'warning'
                        });
                    } else {
                        Swal.fire({
                            title: 'Berhasil',
                            text: msg,
                            icon: 'success'
                        });

                        // Step OTP sudah dihapus, jadi lanjut ke step form data.
                        currentStep = 2;
                        showStep(currentStep);

                        $('#email_registered').val(dt.email)
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.fire({
                        title: 'Error!',
                        text: thrownError,
                        icon: 'error',
                    });
                }
            });
        }

        // Step OTP dihapus untuk alur back/daftar


        $('#kabkota_id').on('change', function() {
            // console.log(this.value);
            var kd = this.value

            // Panggil API untuk mendapatkan kecamatan berdasarkan kabkota_id
            $.ajax({
                url: "{{ route('get-kecamatan-bykabkota', ':id') }}".replace(':id', kd), // Panggil API
                type: 'GET',
                success: function(response) {
                    // Kosongkan dropdown kecamatan sebelumnya
                    $('#kecamatan_id').empty();

                    $('#desa_id').empty();
                    $('#desa_id').append('<option selected disabled>Pilih Desa/Kelurahan</option>');

                    // Tambahkan opsi default
                    $('#kecamatan_id').append('<option selected disabled>Pilih Kecamatan</option>');

                    // Loop data kecamatan dan tambahkan ke dropdown
                    $.each(response, function(index, kecamatan) {
                        $('#kecamatan_id').append('<option value="' + kecamatan.id + '">' +
                            kecamatan.name + '</option>');
                    });
                },
                error: function(xhr) {
                    console.error(xhr);
                }
            });
        });


        $('#kecamatan_id').on('change', function() {
            // console.log(this.value);
            var kd = this.value

            // Panggil API untuk mendapatkan kecamatan berdasarkan kabkota_id
            $.ajax({
                url: "{{ route('get-desa-bykecamatan', ':id') }}".replace(':id', kd), // Panggil API
                type: 'GET',
                success: function(response) {
                    // Kosongkan dropdown kecamatan sebelumnya
                    $('#desa_id').empty();

                    // Tambahkan opsi default
                    $('#desa_id').append('<option selected disabled>Pilih Desa/Kelurahan</option>');

                    // Loop data kecamatan dan tambahkan ke dropdown
                    $.each(response, function(index, kecamatan) {
                        $('#desa_id').append('<option value="' + kecamatan.id + '">' +
                            kecamatan.name + '</option>');
                    });
                },
                error: function(xhr) {
                    console.error(xhr);
                }
            });
        });


        $('#pendidikan_id').on('change', function() {
            // console.log(this.value);
            var kd = this.value

            // Panggil API untuk mendapatkan kecamatan berdasarkan kabkota_id
            $.ajax({
                url: "{{ route('get-jurusan-bypendidikan', ':id') }}".replace(':id', kd), // Panggil API
                type: 'GET',
                success: function(response) {
                    // Kosongkan dropdown kecamatan sebelumnya
                    $('#jurusan_id').empty();

                    // Tambahkan opsi default
                    $('#jurusan_id').append('<option selected disabled>Pilih Jurusan</option>');

                    // Loop data kecamatan dan tambahkan ke dropdown
                    $.each(response, function(index, jurusan) {
                        $('#jurusan_id').append('<option value="' + jurusan.id + '">' +
                            jurusan.nama + '</option>');
                    });
                },
                error: function(xhr) {
                    console.error(xhr);
                }
            });
        });
    </script>

    <script>
        $('#provinsi_id').on('change', function() {
            // console.log(this.value);
            var kd = this.value

            // Panggil API untuk mendapatkan kecamatan berdasarkan kabkota_id
            $.ajax({
                url: "{{ route('get-kabkota-byprov', ':id') }}".replace(':id', kd), // Panggil API
                type: 'GET',
                success: function(response) {
                    // Kosongkan dropdown kecamatan sebelumnya
                    $('#kabkota_id').empty();

                    // Tambahkan opsi default
                    $('#kabkota_id').append('<option selected disabled>Pilih Kabupaten/Kota</option>');

                    // Loop data kecamatan dan tambahkan ke dropdown
                    $.each(response, function(index, kabkota) {
                        $('#kabkota_id').append('<option value="' + kabkota.id + '">' +
                            kabkota.name + '</option>');
                    });
                },
                error: function(xhr) {
                    console.error(xhr);
                }
            });
        });
    </script>

    <script>
        function togglePekerjaanFields(status) {
            const pekerjaanFields = document.getElementById('pekerjaan-fields');
            pekerjaanFields.style.display = (status === '1') ? 'block' : 'none';
        }
    </script>
@endpush
