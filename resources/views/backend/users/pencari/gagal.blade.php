@extends('backend.template.backend')

@section('content')
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Layout container -->
            <div class="layout-page">
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row align-items-center m-l-0">
                                            <div class="col-sm-6">

                                            </div>
                                           
                                        </div>
                                        <div class="table-responsive">
                                            <table id="simpletable" class="table table-bordered table-striped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>

                                                        <th>Email</th>
                                                        <th>Whatsapp</th>
                                                        <th>Role</th>
        
                                                        <th>Options</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Content -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>
    </div>

  
               
            

          
@endsection


@push('js')
<script>
    $(document).ready(function() {
        $('#simpletable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('userpencari.gagal_daftar') }}',
            autoWidth: false, // Menonaktifkan auto-width
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'email'
                },
                
                {
                    data: 'whatsapp'
                },

                {
                    data: 'role_id'
                },

                
               

                {
                    data: 'options',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    });
</script>

 
<script>
    $(document).ready(function() {
        $('#registerForm').submit(function(e) {
            e.preventDefault(); // Prevent form from submitting normally

            // Clear previous error messages
            $('#errorMessages').html('').addClass('d-none');

            var formData = {
                name: $('#name').val(),
                email: $('#email').val(),
                whatsapp: $('#whatsapp').val(),

                _token: '{{ csrf_token() }}' // Add CSRF token for security
            };

            $.ajax({
                type: 'POST',
                url: '{{ route('admin.add') }}', // Ganti dengan rute yang sesuai
                data: formData,
                success: function(response) {
                    if (response.success) {
                        alert('User berhasil ditambahkan');
                        $('#modal-report').modal('hide');
                        location.reload(); // Refresh halaman
                    } else {
                        // If validation errors are found, display them in an alert
                        if (response.errors) {
                            let errorMessages = '';
                            $.each(response.errors, function(key, value) {
                                $.each(value, function(index, errorMessage) {
                                    errorMessages += errorMessage +
                                        '\n'; // Gabungkan pesan error
                                });
                            });
                            alert('Terjadi kesalahan:\n' + errorMessages);
                        } else {
                            alert('Gagal menambahkan user');
                        }
                    }
                },
                error: function(xhr, status, error) {
                    alert('Terjadi kesalahan: ' + error);
                }
            });
        });
    });
</script>

<script>
    function confirmDelete(id) {
        // Konfirmasi penghapusan
        var deleteUrl = "{{ route('userpencari.forcedelete', ':id') }}".replace(':id', id);
        if (confirm("Yakin hapus data?")) {
            // Kirim request ke server untuk menghapus data
            $.ajax({
                url: deleteUrl,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'), // Menyertakan CSRF token
                },
                success: function(response) {
                    // Jika berhasil, reload DataTable
                    alert(response.message); // Menampilkan pesan
                    $('#simpletable').DataTable().ajax.reload(); // Reload data tabel
                },
                error: function(xhr, status, error) {
                    // Tampilkan error jika ada masalah
                    alert('Error: ' + xhr.responseText);
                }
            });
        }
    }
</script>

@endpush
