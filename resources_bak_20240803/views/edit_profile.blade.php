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
        <div id="content" style=" margin: 0 auto;  box-sizing: border-box; ">
            <div class="container-fluid" style=" width: 105.5%">
                @include('template.navbar')
                <div class="container-fluid">
                    {{-- <header class="text-center">
                        <h1 class="display-6">Update Profile</h1>
                    </header> --}}
                    <section class="container my-2 p-2">
                        <form class="row g-3 p-3">
                            <div class="col-md-12">
                                <label for="validationDefault01" class="form-label">Fullname</label>
                                <input type="text" class="form-control" id="validationDefault01" value="Mark" required>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="inputEmail4" class="form-label">Username</label>
                                <input type="email" class="form-control" id="inputEmail4">
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="inputPassword4" class="form-label">Password</label>
                                <input type="password" class="form-control" id="inputPassword4">
                            </div>
                            <div class="col-md-12 mt-3">
                                <label for="inputAddress" class="form-label">Asal</label>
                                <select id="categoryFilter"
                                    class="col-12 col-md-3 me-2 custom-select custom-select-sm form-control">
                                    <option value="WH TR TREG1">DID</option>
                                    <option value="WH TR TREG2">Nokia</option>
                                    <option value="WH TR TREG3">Fiberhome</option>
                                    <option value="WH TR TREG4">ZTE</option>
                                    <option value="WH TR TREG5">Huawei</option>
                                    <option value="WH TR TREG1">TREG 1</option>
                                    <option value="WH TR TREG2">TREG 2</option>
                                    <option value="WH TR TREG3">TREG 3</option>
                                    <option value="WH TR TREG4">TREG 4</option>
                                    <option value="WH TR TREG5">TREG 5</option>
                                    <option value="WH TR TREG6">TREG 6</option>
                                    <option value="WH TR TREG7">TREG 7</option>
                                </select>
                            </div>
    
                            <div class="col-md-12 mt-5">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </section>
                </div>
               
            </div>
        </div>
    </div>
</body>

</html>
