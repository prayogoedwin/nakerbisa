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
                                                        <th>Nama</th>
                                                        <th>Email</th>
                                                        <th>No Telepon</th>
                                                        {{-- <th>Keterangan</th> --}}
                                                        <th>Tanggal Lamar</th>
                                                        <th>Status</th>
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

    <!-- Modal for showing details -->
    <div class="modal fade" id="detailModal" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Pelamar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status">
                            @foreach($progress_lamaran as $status)
                                <option value="{{ $status->id }}">{{ $status->name }}</option>  <!-- Assuming 'id' and 'name' are fields in progressLamaran -->
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" id="pelamarId"> <!-- Hidden input to store the pelamar ID -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateStatusBtn">Update</button>
                </div>
            </div>
        </div>
    </div>
    



@endsection


@push('js')
    <script>
          $(document).ready(function() {
            $('#simpletable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('lowongan.pelamar', $lowongan_id) }}', // Adjust $lowongan_id from the controller
                autoWidth: false,
                columns: [
                    { data: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'whatsapp', name: 'whatsapp' },
                    // { data: 'keterangan', name: 'keterangan' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'status', name: 'status' },
                    { data: 'options', orderable: false, searchable: false }
                ]
            });
        });
    </script>

    <script>
        function showDetailModal(id) {
            // Send AJAX request to get the pelamar's details
            $.ajax({
                url: '{{ url('dapur/lamaran-detail') }}/' + id,  // Correct URL syntax with id parameter
                method: 'GET',
                success: function(response) {
                    // Show the modal
                    $('#detailModal').modal('show');

                    // Set the modal fields with data
                    $('#status').val(response.data.progres_id).trigger('change'); // Assuming 'status' is part of the response
                    $('#pelamarId').val(response.data.id);
                }
            });
        }
        // Update status button click
        $('#updateStatusBtn').on('click', function() {
                var pelamarId = $('#pelamarId').val();  // Get the pelamar ID
                var statusId = $('#status').val();      // Get the selected status ID

                // Send the update request
                $.ajax({
                    url: '{{ route('lamaran.updateStatus') }}', // Create this route in your controller
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // Include CSRF token
                        id: pelamarId,
                        status_id: statusId
                    },
                    success: function(response) {
                        if (response.success) {
                            // Show success alert
                            alert('Status updated successfully!');
                            
                            // Close the modal
                            $('#detailModal').modal('hide');
                            $('#simpletable').DataTable().ajax.reload();  // This reloads the DataTable data
                            
                            // Optionally, reload the DataTable or perform other actions
                        } else {
                            alert('Failed to update status');
                        }
                    },
                    error: function() {
                        alert('An error occurred while updating the status');
                    }
                });
            });
    </script>

@endpush
