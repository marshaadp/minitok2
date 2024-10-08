<!doctype html>
<html lang="en">

<head>
    <title>Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    @include('template.import_datatable')
    <link rel="icon" href="{{ asset('resources/img/minitok.jpeg') }}">
    <link href="{{ asset('resources/css/form.css') }}" rel="stylesheet">
    <!-- <script src="{{ asset('resources/js/validation.js') }}"></script> -->
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css?family=Noto+Sans+TC&display=swap');

        .popup_box,
        .popup_box2 {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 5px;
        }

        .popup_box,
        .popup_box2 {
            width: 450px;
            background: #f2f2f2;
            text-align: center;
            align-items: center;
            padding: 40px;
            border: 1px solid #b3b3b3;
            box-shadow: 0px 5px 10px rgba(0, 0, 0, .2);
            z-index: 9999;
            display: none;
        }

        .popup_box i,
        .popup_box2 i {
            font-size: 60px;
            color: #eb9447;
            border: 5px solid #eb9447;
            padding: 20px 40px;
            border-radius: 50%;
            margin: -10px 0 20px 0;
        }

        .popup_box h1,
        .popup_box2 h1 {
            font-size: 30px;
            color: #1b2631;
            margin-bottom: 5px;
        }

        .popup_box label,
        .popup_box2 label {
            font-size: 23px;
            color: #404040;
        }

        li {
            display: block
        }

        .table {
            font-size: 13px;
        }

        th {
            text-align: center;
        }

        .navbar-left {
            height: 100%;
            /* Full-height: remove this if you want "auto" height */
            width: 100px;
            /* Set the width of the sidebar */
            position: fixed;
            /* Fixed Sidebar (stay in place on scroll) */
            z-index: 1;
            /* Stay on top */
            top: 0;
            /* Stay at the top */
            left: 0;
            background-color: #111;
            /* Black */
            overflow-x: hidden;
            /* Disable horizontal scroll */
            padding-top: 20px;
        }

        .first-col {
            left: 0px;
            min-width: 100px;
            background-color: white !important;
        }

        .sticky-col {
            position: -webkit-sticky;
            position: sticky;
            background-color: white;
        }

        /* Header fixed to the top of the modal */
        .modal-header--sticky {
            /*display: flex;*/
            /*align-items: flex-start;*/
            justify-content: space-between;
            padding: 1rem 1rem;
            border-bottom: 1px solid #e3e6f0;
            border-top-left-radius: calc(0.3rem - 1px);
            border-top-right-radius: calc(0.3rem - 1px);
            position: sticky;
            top: 0;
            background-color: inherit;
            /* [1] */
            z-index: 1055;
            /* [2] */
        }

        /* Footer fixed to the bottom of the modal */
        .modal-footer--sticky {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            /*justify-content: flex-end;*/
            padding: 0.75rem;
            border-top: 1px solid #e3e6f0;
            border-bottom-right-radius: calc(0.3rem - 1px);
            border-bottom-left-radius: calc(0.3rem - 1px);
            position: sticky;
            bottom: 0;
            background-color: inherit;
            /* [1] */
            z-index: 1055;
            /* [2] */
        }

        .first-col-modal {
            min-width: 250px;
        }

        .colon-col {
            min-width: 20px;
            max-width: 20px;
        }

        .dataTables_filter {
            float: right;
            text-align: right;
        }
    </style>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.js"></script> -->
    <script>
        $(document).ready(function() {
            $('.click').click(function() {
                $('.popup_box').css("display", "block");
            });
            $('.btn1').click(function() {
                $('.popup_box').css("display", "none");
            });
            $('.btn2').click(function() {
                $('.popup_box2').css("display", "block");
                $('.popup_box').css("display", "none");
            });
            $('.btn3').click(function() {
                $('.popup_box2').css("display", "none");
            });
            $('.btn4').click(function() {
                $('.popup_box2').css("display", "none");
            });
        });
    </script>
</head>

<body>
    <div class="wrapper d-flex align-items-stretch">
        @include('template.sidebar')
        <div id="content" style=" margin: 0 auto;  box-sizing: border-box; ">
            <div class="container-fluid" style=" width: 105.5%">
                @include('template.navbar')

                @if (session('role') == 'Administrator')
                    <div class="card">
                        <form class="mt-3" style="padding-left: 15px; padding-right: 15px; padding-bottom: 15px;"
                            method="POST" action="{{ URL('/upload_file_penerima/ont') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label class="ml-4">Masukan file pengiriman untuk diupload:</label>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-12 col-md-4 mb-3">
                                    <input class="form-control" type="file" style="height: 45px;"
                                        name="file_penerima" required>
                                </div>
                                <div class="col-sm-12 col-md-8">
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <a href="#" class="btn btn-primary click">Upload</a>
                                            <div class="popup_box">
                                                <i class="fas fa-exclamation"></i>
                                                <label>anda yakin SN;MAC yang diupload TYPE XXXXX sejumlah XX ke WH
                                                    XXX ???</label>
                                                <div class="btns">
                                                    <a href="#" class="btn2 btn btn-primary">Yakin</a>
                                                    <a href="#" class="btn1 btn btn-secondary">Tidak Yakin</a>
                                                </div>
                                            </div>
                                            <div class="popup_box2">
                                                <i class="fas fa-exclamation"></i>
                                                <label>Semua SN;MAC yang diupload jadi acuan di SCMT, jadi jangan salah
                                                    upload.</label>
                                                <div class="btns">
                                                    <button type="submit" class="btn btn-primary"
                                                        style="height: 40px;">
                                                        Teruskan Upload
                                                    </button>
                                                    <a href="#" class="btn3 btn btn-secondary">Batalkan Upload</a>
                                                </div>
                                            </div>

                                            <a href="{{ URL('download_template_penerima') }}"
                                                class="btn btn-secondary">Download Template</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif

                <div class="card mb-3 mt-3">
                    @if ($message = Session::get('message'))
                        <div class="alert alert-success alert-dismissible fade show ml-3 mr-3 mb-3 mt-5" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif

                    <div class="card-body mb-2">
                        <div class="row mb-3">
                            
                            @if (session('role') == 'Administrator')
                            <div class="col-md-6 col-lg-5">
                                <a class="btn btn-secondary mb-2" href="{{ URL('/export_penerima/ONT') }}">Export</a>
                                <a class="btn btn-secondary mb-2"
                                    href="{{ URL('/download_all_serial_number') }}">Download All SN</a>
                            </div>

                            <div class="col-md-6 col-lg-7 col-xl-7">
                                <div class="d-flex justify-content-end align-items-center">
                                    <a class='btn btn-primary btn-sm mx-1' data-toggle="modal"
                                        data-target="#tambahModal">Tambah</a>
                                    <a class='btn btn-danger btn-sm mx-1' data-toggle="modal"
                                        data-target="#hapusModal">Delete All</a>
                                </div>
                            </div>
                            @endif

                            <div class="col-md-6 col-lg-5">
                                <select id="categoryFilter"
                                    class="col-12 col-md-3 me-2 custom-select custom-select-sm form-control">

                                    <option value="" disabled selected>TREG:</option>
                                    <option value="">All TREG</option>
                                    <option value="WH TR TREG1">TREG 1</option>
                                    <option value="WH TR TREG2">TREG 2</option>
                                    <option value="WH TR TREG3">TREG 3</option>
                                    <option value="WH TR TREG4">TREG 4</option>
                                    <option value="WH TR TREG5">TREG 5</option>
                                    <option value="WH TR TREG6">TREG 6</option>
                                    <option value="WH TR TREG7">TREG 7</option>
                                </select>
                                <select id="batch-filter"
                                    class="col-12 col-md-2 custom-select custom-select-sm form-control">
                                    <option value="" disabled selected>Batch:</option>
                                    <option value="">All Batch</option>
                                    <option value="BATCH 1">Batch 1</option>
                                    <option value="BATCH 2">Batch 2</option>
                                    <option value="BATCH 3">Batch 3</option>
                                    <option value="BATCH 4">Batch 4</option>
                                    <option value="BATCH 5">Batch 5</option>
                                    <option value="BATCH 6">Batch 6</option>
                                    <option value="BATCH 7">Batch 7</option>
                                    <option value="BATCH 8">Batch 8</option>
                                    <option value="BATCH 9">Batch 9</option>
                                    <option value="BATCH 10">Batch 10</option>
                                    <option value="BATCH 11">Batch 11</option>
                                    <option value="BATCH 12">Batch 12</option>
                                    <option value="BATCH 13">Batch 13</option>
                                    <option value="BATCH 14">Batch 14</option>
                                </select>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered w-100" id="dataTable-pengiriman">
                                <thead class="text-center">
                                    <tr>
                                        <th rowspan="2" class="align-middle">No</th>
                                        @if (session('role') == 'Administrator')
                                            <th rowspan="2" class="align-middle">Action</th>
                                        @endif
                                        <th rowspan="2" class="align-middle">Type</th>
                                        <th rowspan="2" class="align-middle">Qty</th>
                                        <th colspan="2">Pengirim</th>
                                        <th colspan="3">Penerima</th>
                                        <th rowspan="2" class="align-middle">Tanggal Pengiriman</th>
                                        <th rowspan="2" class="align-middle">Tanggal Sampai</th>
                                        <th rowspan="2" class="align-middle">Batch</th>
                                        <th rowspan="2" class="align-middle">Edit</th>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <th>PIC</th>
                                        <th>Alamat</th>
                                        <th style="width: 180px;">Warehouse</th>
                                        <th>PIC</th>
                                        <th hidden>regional</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Isi tabel disini -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="qr_modal" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <form action='{{ URL('tambah_penerima') }}' name='form' method='POST' accept-charset='UTF-8'
                enctype='multipart/form-data' id='form'>
                @csrf
                <div class="modal-content">
                    <div class="modal-body" id="isi_qr">
                        <div class="zf-templateWrapper"><!---------template Header Starts Here---------->
                            <ul class="zf-tempHeadBdr">
                                <li class="zf-tempHeadContBdr">
                                    <h2 class="zf-frmTitle"><em>Tambah Pengiriman</em></h2>
                                    <p class="zf-frmDesc"></p>
                                    <div class="zf-clearBoth"></div>
                                </li>
                            </ul><!---------template Header Ends Here---------->
                            <!---------template Container Starts Here---------->
                            <style>
                                table {
                                    border-collapse: collapse;
                                    width: 100%;
                                }

                                th,
                                td {
                                    padding: 8px;
                                    text-align: left;
                                }
                            </style>

                            <table>
                                <tr style=" border-bottom: 1px solid #ddd;">
                                    <th>
                                        <ul>
                                            <!---------Dropdown Starts Here---------->
                                            <li class="zf-tempFrmWrapper zf-small">
                                                <label style="color: black;">Type</label>
                                                <div class="zf-tempContDiv">
                                                    <select style=" border: 1px solid black;"
                                                        class=" zf-form-sBox col-12 col-md-7 me-2 custom-select custom-select-sm form-control"
                                                        name="type" checktype="c1" required>
                                                        <option selected="true" value="">-Pilih Type-
                                                        </option>
                                                        <option value="ONT_ZTE_F670L">ONT_ZTE_F670L</option>
                                                        <option value="ONT_NOKIA_G240WL">ONT_NOKIA_G240WL</option>
                                                        <option value="ONT_NOKIA_G-2425G-A">ONT_NOKIA_G-2425G-A
                                                        </option>
                                                        <option value="ONT_FIBERHOME_HG6145D2">
                                                            ONT_FIBERHOME_HG6145D2</option>
                                                        <option value="ONT_FIBERHOME_HG6145F">ONT_FIBERHOME_HG6145F
                                                        </option>
                                                        <option value="ONT_HUAWEI_HG8145V5">ONT_HUAWEI_HG8145V5
                                                        </option>
                                                        <option value="ONT_ZTE_F670 V2.0">ONT_ZTE_F670 V2.0
                                                        </option>
                                                        <option value="ONT_ZTE_F670">ONT_ZTE_F670</option>
                                                        <option value="ONT_FIBERHOME_HG6245N">ONT_FIBERHOME_HG6245N
                                                        </option>
                                                        <option value="ONT_HUAWEI HG8245W5-6T">ONT_HUAWEI
                                                            HG8245W5-6T</option>
                                                        <option value="ONT_HW_HG8245W5-6T">ONT_HW_HG8245W5-6T
                                                        </option>
                                                    </select>
                                                </div>
                                            </li>
                                        </ul>
                                    </th>
                                    <th>
                                        <li class="zf-tempFrmWrapper zf-small">
                                            <label style="color: black;">Jumlah</label>
                                            <div class="zf-tempContDiv">
                                                <span class="zf-addOne">
                                                    <input style=" border: 1px solid black;" type="number"
                                                        name="qty" value="" maxlength="18" placeholder=""
                                                        required />
                                                </span>
                                            </div>
                                        </li>
                                    </th>
                                </tr>
                                <tr>
                                    <td>

                                        <div class="zf-subContWrap zf-topAlign">
                                            <li class="zf-tempFrmWrapper zf-name zf-namemedium">
                                                <label style="color: black;">Pengirim: </label>
                                            </li>
                                        </div>
                                    </td>
                                    <td>
                                        <li class="zf-tempFrmWrapper zf-name zf-namemedium">
                                            <div class="zf-tempContDiv zf-twoType">
                                                <div class="zf-nameWrapper">
                                                    <span>
                                                        <label style="color: black;">PIC</label>
                                                    </span>
                                                    <input style=" border: 1px solid black;" type="text"
                                                        maxlength="255" fieldType=7 placeholder=""
                                                        name="pic_pengirim" required />
                                                </div>
                                            </div>
                                            <div class="zf-clearBoth"></div>
                                        </li>
                                    </td>
                                </tr>
                                <tr style=" border-bottom: 1px solid #ddd;">
                                    <td></td>
                                    <td>
                                        <li class="zf-tempFrmWrapper zf-name zf-namemedium">
                                            <div class="zf-tempContDiv zf-twoType">
                                                <div class="zf-nameWrapper">
                                                    <span>
                                                        <label style="color: black;">Alamat</label>
                                                        <textarea style=" border: 1px solid black;" checktype="c1" maxlength="65535" fieldType=7 name="alamat_pengirim"
                                                            placeholder="" required></textarea>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="zf-clearBoth"></div>
                                        </li>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="zf-subContWrap zf-topAlign">
                                            <li class="zf-tempFrmWrapper zf-name zf-namemedium">
                                                <label style="color: black;">Penerima: </label>
                                            </li>
                                        </div>
                                    </td>

                                    <td>
                                        <li class="zf-tempFrmWrapper zf-name zf-namemedium">
                                            <div class="zf-tempContDiv zf-twoType">
                                                <div class="zf-nameWrapper">
                                                    <span>
                                                        <label style="color: black;">PIC</label>
                                                        <input style=" border: 1px solid black;" type="text"
                                                            maxlength="255" name="pic_penerima" fieldType=7
                                                            placeholder="" required />
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="zf-clearBoth"></div>
                                        </li>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style=" padding-left: 20px;">
                                        <label style="color: black;">Warehouse</label> <br>
                                        <select style=" border: 1px solid black;"
                                            class="zf-form-sBox col-12 col-md-8 me-5 custom-select custom-select-sm form-control"
                                            name="warehouse_penerima" checktype="c1" required>
                                            <option selected="true" value="">-Pilih Warehouse-
                                            </option>
                                            @foreach ($data['warehouse'] as $wh)
                                                <option value="{{ $wh->lokasi_wh }}">{{ $wh->lokasi_wh }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr style=" border-bottom: 1px solid #ddd;">
                                    <td></td>
                                    <td>
                                        <li class="zf-tempFrmWrapper zf-name zf-namemedium">
                                            <div class="zf-tempContDiv zf-twoType">
                                                <div class="zf-nameWrapper">
                                                    <span>
                                                        <label style="color: black;">Alamat</label>
                                                        <textarea style=" border: 1px solid black;" checktype="c1" maxlength="65535" name="alamat_penerima" fieldType=7
                                                            placeholder="" required></textarea>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="zf-clearBoth"></div>
                                        </li>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="zf-subContWrap zf-topAlign">
                                            <li class="zf-tempFrmWrapper zf-name zf-namemedium"><label
                                                    class="zf-labelName">Waktu
                                                    Pengiriman</label>
                                                <div class="zf-tempContDiv zf-twoType">
                                                    <div class="zf-nameWrapper">
                                                        <span>
                                                            <input type="date" maxlength="255"
                                                                name="tanggal_pengiriman" fieldType=7
                                                                placeholder="" />
                                                            <label>Tanggal Kirim</label>
                                                        </span>
                                                    </div>
                                                </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="zf-subContWrap zf-topAlign">
                                            <li class="zf-tempFrmWrapper zf-name zf-namemedium">
                                                <label class="zf-labelName">Waktu Pengiriman</label>
                                                <div class="zf-tempContDiv zf-twoType">
                                                    <div class="zf-nameWrapper">
                                                        <span>
                                                            <input type="date" maxlength="255"
                                                                name="tanggal_sampai" fieldType=7 placeholder="" />
                                                            <label>Tanggal Sampai</label>
                                                        </span>
                                                    </div>
                                                </div>
                                            </li>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                        </div>
                    </div>
                    <div class="">
                        <div class="row mb-3 mt-3">
                            <div class="col-6">
                            </div>
                            <div class="col-6">
                                <div class="float-right mr-3">
                                    <button class="btn btn-secondary" type="button"
                                        data-dismiss="modal">Cancel</button>
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Hapus Modal-->
    <div class="modal fade" id="hapusModal" tabindex="-1" role="dialog" aria-labelledby="qr_modal" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header--sticky">
                    <div class="row">
                        <div class="col-4">
                        </div>
                        <div class="col-4">
                            <h5 class="modal-title w-100 text-center">Hapus Data</h5>
                        </div>
                        <div class="col-4">
                        </div>
                    </div>
                </div>
                <div class="modal-body">Apakah anda yakin ingin menghapus semua data Pengiriman?</div>
                <div class="modal-footer--sticky">
                    <button class="btn btn-secondary mr-1 ml-auto" type="button"
                        data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger mr-1" href="{{ URL('/delete_all_data_pengiriman') }}">Hapus</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Hapus Modal-->
    <div class="modal fade" id="hapusModalById" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header--sticky">
                    <div class="row">
                        <div class="col-4">
                        </div>
                        <div class="col-4">
                            <h5 class="modal-title w-100 text-center">Hapus Data</h5>
                        </div>
                        <div class="col-4">
                        </div>
                    </div>
                </div>
                <div class="modal-body" id="modal-hapus-body">Apakah anda yakin ingin menghapus data Pengiriman?</div>
                <div class="modal-footer--sticky">
                    <button class="btn btn-secondary mr-1 ml-auto" type="button"
                        data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger mr-1" id="hapusBtn">Hapus</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal-->
    <div class="modal fade" id="editModalById" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header--sticky">
                    <div class="row">
                        <div class="col-4">
                        </div>
                        <div class="col-4">
                            <h5 class="modal-title w-100 text-center">Edit Data</h5>
                        </div>
                        <div class="col-4">
                        </div>
                    </div>
                </div>
                <form name='form_edit' method='POST' accept-charset='UTF-8' enctype='multipart/form-data'
                    id='form_edit'>
                    @csrf
                    <div class="modal-body" id="modal-hapus-body">
                        <div class="row">
                            <div class="col-4">
                                <label>Tanggal Pengiriman</label>
                                <input type="date" class="form-control" name="edit_tanggal_pengiriman"
                                    id="edit_tanggal_pengiriman"
                                    @if (session('role') == 'User') placeholder="Diisi oleh DID" readonly @endif>
                            </div>
                            <div class="col-4">
                                <label>Tanggal Sampai</label>
                                <input type="date" class="form-control" name="edit_tanggal_sampai"
                                    id="edit_tanggal_sampai"
                                    @if (session('role') == 'User') placeholder="Diisi oleh DID" readonly @endif>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-5">
                                <label>Nomor IDO/GD</label>
                                <input type="text" class="form-control" name="edit_ido_gd" id="edit_ido_gd" style="height: 45px;"
                                    @if (session('role') != 'Administrator') placeholder="Diisi oleh Admin" readonly @endif
                                >
                            </div>
                            @if (session('role') == 'Administator' || session('role') == 'User')
                            <div class="col-5">
                                <label>Upload SN; MAC Hasil Barcode</label>
                                <input type="file" class="form-control" name="edit_sn_mac_barcode"
                                    id="edit_sn_mac_barcode" style="height: 45px;"
                                    accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                            </div>
                            <div class="col-2">
                                <label>Template SN</label>
                                <a class="btn btn-secondary" href="{{ URL('/download_template_sn/') }}"
                                    value="false">Template</a>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer--sticky">
                        <div class="col-3 ml-auto">
                            <div class="d-flex flex-row-reverse ml-4">
                                <button class="btn btn-primary" type="submit">Submit</button>
                                <button class="btn btn-secondary mr-1" type="button"
                                    data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- QR Modal -->
    <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog"
        aria-labelledby="qr_modal"aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form action='{{ URL('tambah_penerima') }}' name='form' method='POST' accept-charset='UTF-8'
                enctype='multipart/form-data' id='form'>
                @csrf
                <div class="modal-content" style="min-width: 1000px">
                    <div class="modal-body" id="isi_qr">
                        <div class="zf-templateWrapper"><!---------template Header Starts Here---------->
                            <ul class="zf-tempHeadBdr">
                                <li class="zf-tempHeadContBdr">
                                    <h2 class="zf-frmTitle"><em>Tambah Pengiriman</em></h2>
                                    <p class="zf-frmDesc"></p>
                                    <div class="zf-clearBoth"></div>
                                </li>
                            </ul><!---------template Header Ends Here---------->
                            <!---------template Container Starts Here---------->
                            <div class="zf-subContWrap zf-topAlign">
                                <div class="card">
                                    <div class="row">
                                        <div class="col-5 ms-5 mt-3">
                                            <ul>
                                                <!---------Dropdown Starts Here---------->
                                                <li class="zf-tempFrmWrapper zf-large">
                                                    <label class="zf-labelName">Type</label>
                                                    <div class="zf-tempContDiv">
                                                        <select class="zf-form-sBox" name="type" checktype="c1"
                                                            required>
                                                            <option selected="true" value="">-Pilih Type-
                                                            </option>
                                                            <option value="ONT_ZTE_F670L">ONT_ZTE_F670L</option>
                                                            <option value="ONT_NOKIA_G240WL">ONT_NOKIA_G240WL
                                                            </option>
                                                            <option value="ONT_NOKIA_G-2425G-A">ONT_NOKIA_G-2425G-A
                                                            </option>
                                                            <option value="ONT_FIBERHOME_HG6145D2">
                                                                ONT_FIBERHOME_HG6145D2
                                                            </option>
                                                            <option value="ONT_FIBERHOME_HG6145F">
                                                                ONT_FIBERHOME_HG6145F
                                                            </option>
                                                            <option value="ONT_HUAWEI_HG8145V5">ONT_HUAWEI_HG8145V5
                                                            </option>
                                                            <option value="ONT_ZTE_F670 V2.0">ONT_ZTE_F670 V2.0
                                                            </option>
                                                            <option value="ONT_ZTE_F670">ONT_ZTE_F670</option>
                                                            <option value="ONT_FIBERHOME_HG6245N">
                                                                ONT_FIBERHOME_HG6245N
                                                            </option>
                                                            <option value="ONT_HUAWEI HG8245W5-6T">ONT_HUAWEI
                                                                HG8245W5-6T
                                                            </option>
                                                            <option value="ONT_HW_HG8245W5-6T">ONT_HW_HG8245W5-6T
                                                            </option>
                                                        </select>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="col-5 ms-5 mt-3">
                                            <!---------Number Starts Here---------->
                                            <li class="zf-tempFrmWrapper">
                                                <label class="">Jumlah</label>
                                                <div class="zf-tempContDiv">
                                                    <span class="zf-addOne"><input type="number" name="qty"
                                                            value="" maxlength="18" placeholder=""
                                                            required /></span>
                                                </div>
                                            </li>
                                        </div>

                                    </div>
                                </div>



                                <div class="card">
                                    <div class="row">
                                        <div class="col-5">
                                            <li class="zf-tempFrmWrapper zf-name zf-namemedium">
                                                <label class="zf-labelName">Pengirim: </label>
                                        </div>
                                        <div class="col- mt-3">
                                            <div class="zf-tempContDiv zf-twoType">
                                                <div class="zf-nameWrapper">
                                                    <span>
                                                        <label>PIC</label>
                                                        <input type="text" maxlength="255" fieldType=7
                                                            placeholder="" name="pic_pengirim" required />

                                                    </span>
                                                </div>
                                            </div>
                                            <div class="zf-clearBoth"></div>
                                            </li>
                                        </div>

                                        <div class="col-5  "></div>

                                        <div class="col-5 ">
                                            <li class="zf-tempFrmWrapper zf-name zf-namemedium">
                                                <div class="zf-tempContDiv zf-twoType">
                                                    <div class="zf-nameWrapper">
                                                        <span>
                                                            <label>Alamat</label>
                                                            <textarea checktype="c1" maxlength="65535" fieldType=7 name="alamat_pengirim" placeholder="" required></textarea>

                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="zf-clearBoth"></div>
                                            </li>
                                        </div>

                                    </div>

                                </div>



                                <!---------Name Starts Here---------->
                                <div class="card">
                                    <div class="row">
                                        <div class="col-5">
                                            <li class="zf-tempFrmWrapper zf-name zf-namemedium"><label
                                                    class="zf-labelName">Penerima: </label>
                                        </div>
                                        <div class="col- mt-3">
                                            <div class="zf-tempContDiv zf-twoType">
                                                <div class="zf-nameWrapper">
                                                    <span><label>PIC</label> <input type="text" maxlength="255"
                                                            name="pic_penerima" fieldType=7 placeholder="" required />
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-5"></div>
                                        <div class="zf-tempContDiv zf-twoType">
                                            <div class="zf-nameWrapper">

                                                <div class="col-1 mt-3 ">
                                                    <span>
                                                        <label>Warehouse</label>
                                                        <select class="zf-form-sBox" name="warehouse_penerima"
                                                            checktype="c1" required>
                                                            <option selected="true" value="">-Pilih Warehouse-
                                                            </option>
                                                            @foreach ($data['warehouse'] as $wh)
                                                                <option value="{{ $wh->lokasi_wh }}">
                                                                    {{ $wh->lokasi_wh }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                    </span>
                                                </div>
                                            </div>
                                            <div class="zf-clearBoth"></div>
                                            </li>
                                        </div>
                                        <div class="col-5 ms-5 mt-3"></div>
                                        <div class="col-5 ms-5 mt-3">

                                            <li class="zf-tempFrmWrapper zf-name zf-namemedium">
                                                <div class="zf-tempContDiv zf-twoType">
                                                    <div class="zf-nameWrapper">
                                                        <span>
                                                            <label>Alamat</label>
                                                            <textarea checktype="c1" maxlength="65535" name="alamat_penerima" fieldType=7 placeholder="" required></textarea>

                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="zf-clearBoth"></div>
                                            </li>
                                        </div>
                                    </div>
                                </div>



                                <div class="card mb-2">
                                    <li class="zf-tempFrmWrapper zf-name zf-namemedium"><label
                                            class="zf-labelName">Waktu
                                            Pengiriman</label>
                                        <div class="zf-tempContDiv zf-twoType">
                                            <div class="zf-nameWrapper">
                                                <span><input type="date" maxlength="255" name="tanggal_pengiriman"
                                                        fieldType=7 placeholder="" /> <label>Tanggal Kirim</label>
                                                </span>
                                                <span><input type="date" maxlength="255" name="tanggal_sampai"
                                                        fieldType=7 placeholder="" /> <label>Tanggal Sampai</label>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="zf-clearBoth"></div>
                                    </li>
                                </div>
                                </li>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="row mb-3 mt-3">
                            <div class="col-6">
                            </div>
                            <div class="col-6">
                                <div class="float-right mr-3">
                                    <button class="btn btn-secondary" type="button"
                                        data-dismiss="modal">Cancel</button>
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
<script type="text/javascript">
    var penerima = <?php echo json_encode($data['penerima']); ?>;
    // var array 

    function deletePenerimaById(id, i) {
        console.log(id)
        document.getElementById('modal-hapus-body').innerHTML =
            "Apakah anda yakin ingin menghapus semua data pengiriman nomor " + i + "?"
        document.getElementById('hapusBtn').href = "{{ URL('delete_on_delivery_by_id') }}" + "/" + id;
    }

    function editPenerimaById(id) {
        document.getElementById('form_edit').action = "{{ URL('edit_penerimaan_by_id') }}" + "/" + id;
        document.getElementById('modal-hapus-body').innerHTML;

        penerima_filter = penerima.filter(function(val) {
            return val.id == id;
        });

        document.getElementById('edit_tanggal_pengiriman').value = penerima_filter[0].tanggal_pengiriman;
        document.getElementById('edit_tanggal_sampai').value = penerima_filter[0].tanggal_sampai;
        document.getElementById('edit_ido_gd').value = penerima_filter[0].ido_gd;
    }

    $("#batch-filter").on('change', function(i) {
        var data = table.rows().data();
        var selectedBatch = $('#batch-filter').val();

        var searchTerm = selectedBatch.toLowerCase();
        regex = '^' + searchTerm + '$';

        console.log(regex);
        if (selectedBatch != "") {
            @if (session('role') == 'Administrator')
                console.log(1);
                table.column(11).search(regex, true, false).draw();
            @else
                console.log(2);
                table.column(12).search(regex, true, false).draw();
            @endif
        } else {
            @if (session('role') == 'Administrator')
                table.column(13).search("").draw();
            @else
                table.column(12).search("").draw();
            @endif
        }
    });

    var table = $('#dataTable-pengiriman').DataTable({
        "ajax": "{{ url('/all_rekap_delivery') }}",
        "searching": true,
        "deferRender": true,
        "ordering": false,
        "scrollX": true,
        "columns": [{
                "data": 'DT_RowIndex'
            },
            @if (session('role') == 'Administrator')
                {
                    "data": "id"
                },
            @endif {
                "data": "type"
            },
            {
                "data": "qty"
            },
            {
                "data": "alamat_pengirim"
            },
            {
                "data": "pic_pengirim"
            },
            {
                "data": "alamat_penerima"
            },
            {
                "data": "warehouse_penerima"
            },
            {
                "data": "pic_penerima"
            },
            {
                "data": "tanggal_pengiriman"
            },
            {
                "data": "tanggal_sampai"
            },
            {
                "data": "batch"
            },
            {
                "data": "id"
            },
            {
                "data": "regional",
                visible: false
            },
        ],
        columnDefs: [
            @if (session('role') == 'Administrator')
            {
                "searchable": false,
                "orderable": false,
                "targets": 1,
                "render": function(data, type, row) {
                    var btn =
                        '<a class="btn btn-danger" onclick="deletePenerimaById(' +
                        data + ',' + row.DT_RowIndex +
                        ')" data-target="#hapusModalById" data-toggle="modal">Delete</a>';
                    return btn;
                },
                "className": "text-center first-col sticky-col"
            }, {
                "searchable": true,
                "orderable": false,
                "targets": [10, 11, 12],
                "className": "text-center"
            },
            @endif 
            {
                "searchable": true,
                "orderable": true,
                @if (session('role') == 'Administrator')
                    "targets": 12,
                @else
                    "targets": 11,
                @endif
                "render": function(data, type, row) {
                    href = "{{ URL('download_serial_number') }}" + "/" + data;
                    var btn =
                        '<a class="btn btn-warning" onclick="editPenerimaById(' +
                        data +
                        ')" data-target="#editModalById" data-toggle="modal">Edit</a>'
                    if (row.sn_mac_barcode != '') {
                        btn += '<a class="btn btn-secondary mt-2" href=' +
                            href +
                            '>Download SN</a>';
                    }
                    return btn;
                },
                "className": "text-center first-col sticky-col"
            }
        ],
    });

    $("document").ready(function() {
        $("#categoryFilter").on('change', function(i) {
            var data = table.rows().data();
            var selectedItem = $('#categoryFilter').val()

            var searchTerm = selectedItem.toLowerCase();
            regex = '^' + searchTerm + '$';
            
            if (selectedItem != "") {
                @if (session('role') == 'Administrator')
                    table.column(13).search(regex, true, false).draw();
                @else
                    table.column(12).search(regex, true, false).draw();
                @endif
            } else {
                @if (session('role') == 'Administrator')
                    table.column(13).search("").draw();
                @else
                    table.column(12).search("").draw();
                @endif
            }
        });
    });

    @if (session('role') == 'Administrator')
        $("#dataTable-pengiriman_filter.dataTables_filter").append($("#batch-filter"));
    @endif

    @if (session('role') == 'Administrator')
        $("#dataTable-pengiriman_filter.dataTables_filter").append($("#categoryFilter"));
    @endif
</script>

</html>
