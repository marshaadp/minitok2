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
    </style>
    <link rel="icon" href="{{ asset('resources/img/minitok.jpeg') }}">
</head>

<body>
    <div class="wrapper d-flex align-items-stretch">
        @include('template.sidebar')
        <div id="content" style=" margin: 0 auto;  box-sizing: border-box; ">
            <div class="container-fluid" style=" width: 105.5%">
                @include('template.navbar')

                <div class="mb-3">
                    <div class="card mt-3" style="">
                        <div class="col justify-content-start">
                            <form class="mt-3" method="POST"
                                action="{{ URL('/upload_file_tmp') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <label class="ml-2">Masukan file stock SCMT untuk diupload:</label>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-sm-12 col-md-4 mb-3">
                                        <input class="form-control" type="file" name="file_tmp" style="height: 45px;"
                                            required>
                                    </div>

                                    <div class="col-sm-6 col-md-8">
                                        <button type="submit" class="btn btn-primary">Upload</button>
                                        <a href="{{ URL('/download_template_sementara') }}"
                                            class="btn btn-secondary mt-1">Download Template</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
