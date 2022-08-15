@extends('app')
@section('content')
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-2">
                <!--begin::Page Title-->
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Dashboard</h5>
                <!--end::Page Title-->
            </div>
            <!--end::Info-->
            <!--begin::Toolbar-->
            <div class="d-flex align-items-center">
            </div>
            <!--end::Toolbar-->
        </div>
    </div>
    <!--end::Subheader-->
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="row">
                <!--  Begin Page Content -->
                <div class="container-fluid">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"> Users List
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>first Name</th>
                                        <th>last Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Main Content -->
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        var dt = $('#dataTable').DataTable( {
            "processing": true,
            "responsive": true,
            "ordering": false,
            "serverSide": true,
            "ajax": "{{ url('/users_list')}}",
            "columns": [
                { "data": "first_name"},
                { "data": "last_name" },
                { "data": "email" },
                { "data": "status" },
                { "data": "action",searchable: true,orderable: false }
            ],
            "order": [[1, 'Asc']]
        } );

        $(function()
        {
            function timeChecker(){
                setInterval(function ()
                {
                    var storedTimeStamp = sessionStorage.getItem("lastTimeStamp");
                },3000);
            }
            $(document).mousemove(function ()
            {
                var timeStamp = new Date();
                sessionStorage.setItem("lastTimeStamp",timeStamp);
            });
            timeChecker();
        });

    </script>
@endsection
