<!doctype html>
<html lang="en">

<head>
    <title>Input Data</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @include('template.import_datatable')
    <style>
        select.form-control {
            display: inline;
            width: 200px;
            margin-left: 25px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: url(bg.jpeg);
        }

        form {
            box-shadow: 2px 6px 100px #ffffff;
        }
    </style>
    <link rel="icon" href="{{ asset('resources/img/minitok.jpeg') }}">
</head>

<body>


    <div class="wrapper d-flex align-items-stretch">
        @include('template.sidebar')
        <div id="content" style=" margin: 0 auto;  box-sizing: border-box;">
            <div class="container-fluid" style=" width: 105.5%">
                @include('template.navbar')
                <div class="card mb-3 mt-3">
                    @if ($message = Session::get('message'))
                        <div class="alert alert-success alert-dismissible fade show ml-3 mr-3 mb-3 mt-5" role="alert">
                            <strong>{!! $message !!}</strong>
                        </div>
                    @endif
                    <div class="card-body mb-2">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="requestOutbondTable"
                                style="font-size:10px; width: 100%;">
                                <thead>
                                    <tr class="text-center align-middle"
                                        style="color:black; background-color:gray; color:white;">
                                        <th rowspan="2" class="small-2-width"
                                            style="vertical-align: middle !important;">No</th>
                                        <th rowspan="2" style="vertical-align: middle !important;"
                                            class="small-2-width">Username</th>
                                        <th rowspan="2" style="vertical-align: middle !important;"
                                            class="small-2-width">Password</th>
                                        <th rowspan="2" style="vertical-align: middle !important;"
                                            class="small-2-width">Fullname</th>
                                        <th rowspan="2" style="vertical-align: middle !important;"
                                            class="small-2-width">Role</th>
                                        <th rowspan="2" style="vertical-align: middle !important;"
                                            class="small-2-width">Asal</th>
                                        <th rowspan="2" style="vertical-align: middle !important;"
                                            class="small-2-width">Jenis Akun</th>
                                        <th rowspan="2" style="vertical-align: middle !important;"
                                            class="small-2-width">Action</th>
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
    </div>
</body>

</html>
