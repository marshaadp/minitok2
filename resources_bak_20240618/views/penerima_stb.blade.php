<!doctype html>
<html lang="en">

<head>
    <title>Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @include('template.import_datatable')
    <link rel="icon" href="{{ asset('resources/img/minitok.jpeg') }}">
    <link href="{{ asset('resources/css/form.css') }}" rel="stylesheet">
    <!-- <script src="{{ asset('resources/js/validation.js') }}"></script> -->
    <style type="text/css">
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
    </style>
</head>

<body>
    <div class="wrapper d-flex align-items-stretch">
        @include('template.sidebar')
        <div id="content" class="p-md-5" style=" margin: 0 auto;  box-sizing: border-box;">
            <div class="container-fluid" style=" width: 105.5%">
                @include('template.navbar')

                <div class="card">
                    <form class="mt-3" style="padding-left: 15px; padding-right: 15px; padding-bottom: 15px;"
                        method="POST" action="{{ URL('/upload_file_penerima/stb') }}" enctype="multipart/form-data">

                        @csrf
                        <div class="form-group row">
                            <label class="ml-4">Insert bulk data pengiriman:</label>
                        </div>

                        <div class="row mt-3">
                            <div class="col-sm-12 col-md-4 mb-3">
                                <input class="form-control" type="file" style="height:45px;" name="file_penerima"
                                    required>
                            </div>

                            <div class="row col-sm-12 col-md-8">
                                <div class="col-md-6 mb-2">
                                    <button type="submit" class="btn btn-primary" style="height:40px">Upload</button>

                                    <button href="{{ URL('download_template_penerima') }}"
                                        class="btn btn-secondary">Download
                                        Template</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card mb-3 mt-3">
                    <div class="card-body mb-2">
                        <div class="row mb-3">
                            <div class="ccol-md-6 col-lg-5">
                                <a class="btn btn-secondary mb-2" href="{{ URL('/export_penerima/STB') }}"
                                    value="false">Export</a>
                            </div>
                            <div class="col-md-6 col-lg-7 col-xl-7">
                                <div class="d-flex justify-content-end align-items-center">
                                    <a class='btn btn-primary btn-sm mx-1' data-toggle="modal"
                                        data-target="#tambahModal">Tambah</a>
                                    <a class='btn btn-danger btn-sm mx-1' data-toggle="modal"
                                        data-target="#hapusModal">Delete All</a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%">
                                <thead class="text-center">
                                    <tr>
                                        <th rowspan="2" class="align-middle">Type</th>
                                        <th rowspan="2" class="align-middle">Qty</th>
                                        <th colspan="2">Pengirim</th>
                                        <th colspan="3">Penerima</th>
                                        <th rowspan="2" class="align-middle">Tanggal Pengiriman</th>
                                        <th rowspan="2" class="align-middle">Tanggal Sampai</th>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <th>PIC</th>
                                        <th>Alamat</th>
                                        <th>Warehouse</th>
                                        <th>PIC</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['penerima'] as $idx => $d)
                                        <tr>
                                            <td>{{ $d->type }}</td>
                                            <td>{{ $d->qty }}</td>
                                            <td>{{ $d->alamat_pengirim }}</td>
                                            <td>{{ $d->pic_pengirim }}</td>
                                            <td>{{ $d->alamat_penerima }}</td>
                                            <td>{{ $d->warehouse_penerima }}</td>
                                            <td>{{ $d->pic_penerima }}</td>
                                            <td>{{ $d->tanggal_pengiriman }}</td>
                                            <td>{{ $d->tanggal_sampai }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tambah Modal-->
    <div class="modal fade" id="a" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="zf-templateWidth card">
            <form action='{{ URL('tambah_penerima') }}' name='form' method='POST' accept-charset='UTF-8'
                enctype='multipart/form-data' id='form'>
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
                        <ul>
                            <!---------Dropdown Starts Here---------->
                            <li class="zf-tempFrmWrapper zf-small">
                                <label class="zf-labelName">Type</label>
                                <div class="zf-tempContDiv">
                                    <select class="zf-form-sBox" name="Dropdown" name="type" checktype="c1">
                                        <option selected="true" value="-Select-">-Select-</option>
                                        <option value="First&#x20;Choice">First Choice</option>
                                        <option value="Second&#x20;Choice">Second Choice</option>
                                        <option value="Third&#x20;Choice">Third Choice</option>
                                    </select>
                                    <p id="Dropdown_error" class="zf-errorMessage" style="display:none;">Invalid
                                        value
                                    </p>
                                </div>
                            </li>
                        </ul>
                        <!---------Number Starts Here---------->
                        <li class="zf-tempFrmWrapper">
                            <label class="">Jumlah</label>
                            <div class="zf-tempContDiv">
                                <span><input type="number" name="qty" value="" maxlength="18"
                                        placeholder="" /></span>
                                <p id="Number_error" class="zf-errorMessage" style="display:none;">Invalid value</p>
                            </div>
                            <!---------Name Starts Here---------->
                        <li class="zf-tempFrmWrapper zf-name zf-namemedium"><label class="zf-labelName">Jumlah</label>
                            <div class="zf-tempContDiv zf-twoType">
                                <div class="zf-nameWrapper">
                                    <span><input type="text" maxlength="255" name="Name_First" fieldType=7
                                            placeholder="" /> <label>First</label> </span>
                                    <span> <input type="text" maxlength="255" name="Name_Last" fieldType=7
                                            placeholder="" /> <label>Last</label> </span>
                                    <div class="zf-clearBoth"></div>
                                </div>
                                <p id="Name_error" class="zf-errorMessage" style="display:none;">Invalid value</p>
                            </div>

                            <div class="zf-clearBoth"></div>
                        </li>
                        <li class="zf-tempFrmWrapper zf-address zf-addrlarge "><label class="zf-labelName">Address<em
                                    class="zf-important">*</em></label>
                            <div class="zf-tempContDiv zf-address">
                                <div class="zf-addrCont">
                                    <span class="zf-addOne"> <input type="text" maxlength="255"
                                            name="Address_AddressLine1" checktype="c1" placeholder="" /><label>Street
                                            Address</label></span>
                                    <span class="zf-addOne"> <input type="text" maxlength="255"
                                            name="Address_AddressLine2" checktype="c1"
                                            placeholder="" /><label>Address Line 2</label></span>
                                    <span class="zf-flLeft zf-addtwo"> <input type="text" maxlength="255"
                                            name="Address_City" checktype="c1" placeholder="" />
                                        <label>City</label>
                                    </span>
                                    <span class="zf-flLeft zf-addtwo"> <input type="text" maxlength="255"
                                            name="Address_Region" checktype="c1" placeholder="" />
                                        <label>State/Region/Province</label>
                                    </span>
                                    <span class="zf-flLeft zf-addtwo"> <input type="text" maxlength="255"
                                            name="Address_ZipCode" checktype="c1" placeholder="" />
                                        <label>Postal / Zip Code</label>
                                    </span>
                                    <label>Country</label>
                                    <div class="zf-clearBoth"></div>
                                    <p id="Address_error" class="zf-errorMessage" style="display:none;">Invalid value
                                    </p>
                                </div>
                            </div>
                        </li>
                        <div class="zf-eclearBoth"></div>
                        </li>
                        <!---------Multiple Line Starts Here---------->
                        <li class="zf-tempFrmWrapper zf-small"><label class="zf-labelName">Multi Line</label>
                            <div class="zf-tempContDiv">
                                <span>
                                    <textarea name="MultiLine" checktype="c1" maxlength="65535" placeholder=""></textarea>
                                </span>
                                <p id="MultiLine_error" class="zf-errorMessage" style="display:none;">Invalid value
                                </p>
                            </div>
                        </li>
                    </div>
                </div>
                <div class="row mb-3 mt-3">
                    <div class="col-9">
                    </div>
                    <div class="col-3">
                        <div>
                            <button class="btn btn-secondary mr-1" type="button"
                                data-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Hapus Modal-->
    <div class="modal fade" id="hapusModal" tabindex="-1" role="dialog" aria-hidden="true">
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
                <div class="modal-body">Apakah anda yakin ingin menghapus semua data Pengiriman?</div>
                <div class="modal-footer--sticky">
                    <button class="btn btn-secondary mr-1 ml-auto" type="button"
                        data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger mr-1" href="{{ URL('/delete_all_data_pengiriman') }}">Hapus</a>
                </div>
            </div>
        </div>
    </div>

    <!-- QR Modal -->
    <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="qr_modal"
        aria-hidden="true">
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
                                                <label class="zf-labelName" style="color: black;">Type</label>
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
                                                <span class="zf-addOne"><input style=" border: 1px solid black;"
                                                        type="number" name="qty" value="" maxlength="18"
                                                        placeholder="" required /></span>
                                            </div>
                                        </li>
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="zf-labelName" style="color: black;">Pengirim: </label>
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
                                    <td><label class="zf-labelName" style="color: black;">Penerima: </label></td>
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
                            </table>
                            <div class="zf-subContWrap zf-topAlign">
                                <li class="zf-tempFrmWrapper zf-name zf-namemedium"><label class="zf-labelName">Waktu
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

</html>
