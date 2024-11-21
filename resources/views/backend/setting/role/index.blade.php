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
                                            <div class="col-sm-6 text-end">
                                                <button class="btn btn-success btn-sm btn-round has-ripple"
                                                    data-bs-toggle="modal" data-bs-target="#modal-report"><i
                                                        class="feather icon-plus"></i> Add
                                                    Data</button>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="simpletable" class="table table-bordered table-striped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Name</th>
                                                        <th width="50%">Guard Name</th>
                                                        {{-- <th>Options</th> --}}
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

    <div class="modal fade" id="modal-report" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="floating-label" for="Name">Name</label>
                                    <input type="text" class="form-control" id="Name" placeholder="">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="floating-label" for="Name">Guard Name</label>
                                    <input type="text" class="form-control" id="Name" placeholder="">
                                </div>
                            </div>

                            <div class="col-sm-12 mt-3">
                                <button class="btn btn-primary">Submit</button>
                                <button class="btn btn-danger">Clear</button>
                            </div>
                        </div>
                    </form>
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
                ajax: '{{ route('roles.index') }}', // Pastikan URL ini benar
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'guard_name'
                    },
                    // { data: 'options', orderable: false, searchable: false },
                ]
            });
        });
    </script>
@endpush
