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
                    <div class="card mt-3 mr-3">
                        <form class="mt-3" style="padding-left: 15px; padding-right: 15px; padding-bottom: 15px;"
                        method="POST"
                            action="{{ URL('/upload_file_penerima/replace') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label class="ml-2">Masukan file pengiriman untuk replace data di database
                                    pengiriman:</label>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-12 col-md-4 mb-3">
                                    <input class="form-control" type="file" style="height: 45px;"
                                        name="file_penerima" required>
                                </div>
                                <div class="col-sm-12 col-md-8">
                                    <div class="row">
                                        <div class="col-md-6 mb-1">
                                            <button type="submit" class="btn btn-primary mb-1"
                                                style="height:40px">Upload</button>
                                            <a href="{{ URL('download_template_penerima') }}"
                                                class="btn btn-secondary">Download
                                                Template</a>

                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-5 d-flex justify-content-end">
                                            <a href="{{ URL('export_penerima/All') }}" class="btn btn-secondary mr-3"
                                                style="height: 40px;">Export All Data Pengiriman</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
