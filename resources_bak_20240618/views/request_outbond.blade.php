<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	@include('template.import_datatable')
    <link href="{{asset('resources/css/form.css')}}" rel="stylesheet">
    <link href="{{asset('resources/css/daterangepicker.css')}}" rel="stylesheet">
    <link rel="icon" href="{{asset('resources/img/minitok.jpeg')}}">
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script> -->
    <script type="text/javascript" src="{{asset('resources/js/moment.min.js')}}"></script>
	<title>Request Outbond</title>
    <style type="text/css">
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
            background-color: inherit; /* [1] */
            z-index: 1055; /* [2] */
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
            background-color: inherit; /* [1] */
            z-index: 1055; /* [2] */
        }
        .first-col-modal{
            min-width: 250px;
        }
        .colon-col{
            min-width: 20px;
            max-width: 20px;
        }
        .dataTables_filter {
           float: right;
           text-align: right;
        }

        .small-width{
            min-width: 40px;
            max-width: 40px;
            width: 40px;
        }

        .small-2-width{
            min-width: 60px;
            max-width: 60px;
            width: 60px;
        }

        .medium-width{
            min-width: 80px;
            max-width: 80px;
        }
    </style>

    <script src="{{ asset('resources/js/virtual-select.min.js') }}"></script>
    <link href="{{ asset('resources/css/virtual-select.min.css') }}" rel="stylesheet">
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
                        <div class="row mb-3">
                            <div class="col-md-6 col-lg-5">
                                <a class="btn btn-secondary mb-2"
                                    href="{{ URL('/export_request_outbond') }}">Export</a>
                            </div>
                            @if (session('jenis_akun') == 'Admin')
                            <div class="col-md-6 col-lg-7 col-xl-7">
                                <div class="d-flex justify-content-end align-items-center">
                                    <a class='btn btn-primary btn-sm mx-1' data-toggle="modal"
                                        data-target="#tambahModal">Tambah</a>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="row mb-3">
                            <div class="col-6">
                                <input type="text" style="min-width: 250px; background: #fff; cursor: pointer;" class="mt-2" name="daterange" />

                                {{-- <select id="alamatFilter" placeholder="Filter Alamat" data-search="true" data-silent-initial-value-set="true" class="mt-2 mb-2" >
                                </select> --}}
                                <select id="alamatFilter" name="native-select" placeholder="Filter Alamat" data-search="true" data-silent-initial-value-set="true" class="mt-2 mb-2" >
                                </select>

                                {{-- <select id="alamatFilter" name="native-select" placeholder="Filter Alamat" data-search="true" data-silent-initial-value-set="true" class="mt-2 mb-2" >
                                </select> --}}
                            </div>
                            <div class="category-filter mt-1 col-6">
                                    <div class="row justify-content-end align-items-end float-end">
                                        <div class="col-8">
                                            <select style="max-width:90px;" id="typeFilter" class="col-5 mr-2 mt-2 custom-select custom-select-sm form-control form-control-sm" onchange="changeTableContent()">
                                                <option value="">All Type</option>
                                                @foreach($data["type_unique"] as $idx => $obj)
                                                <option value="{{$obj->type}}">{{$obj->type}}</option>
                                                @endforeach
                                            </select>

                                            <select id="jenisFilter" style="max-width:90px;" class="col-5 mt-2 custom-select custom-select-sm form-control form-control-sm" onchange="changeTableContent()">
                                                <option value="">All Jenis</option>
                                                @foreach($data["jenis_unique"] as $idx => $obj)
                                                <option value="{{$obj->jenis}}">{{$obj->jenis}}</option>
                                                @endforeach
                                            </select>

                                            <select id="merkFilter" style="max-width:90px;" class="col-5 mr-2 mt-2 custom-select custom-select-sm form-control form-control-sm" onchange="changeTableContent()">
                                                <option value="">All Merk</option>
                                                @foreach($data["merk_unique"] as $idx => $obj)
                                                <option value="{{$obj->merk}}">{{$obj->merk}}</option>
                                                @endforeach
                                            </select>

                                            <select id="deliveryFilter" class="col-5 mt-2 custom-select custom-select-sm form-control form-control-sm" onchange="changeTableContent()">
                                                <option selected="true" value="">All Delivery By</option>
                                                <option value="Darat">Darat</option>
                                                <option value="Udara">Udara</option>
                                                <option value="Handcarry">Handcarry</option>
                                                <option value="Gosend">Gosend</option>
                                                <option value="Lalamove">Lalamove</option>
                                            </select>

                                            <select id="statusFilter" class="col-5 mt-2 mr-2 custom-select custom-select-sm form-control form-control-sm" onchange="changeTableContent()">
                                                <option selected="true" value="">All Progress</option>
                                                <option value="On Going">On Going</option>
                                                <option value="Submitted">Submitted</option>
                                                <option value="Approved">Approved</option>
                                            </select>
                                        </div>
                                    </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                        <table class="table table-bordered" id="requestOutbondTable" style="font-size:10px; width: 100%;">
                            <thead>
                            	<tr class="text-center align-middle"
                                    style="color:black; background-color:gray; color:white;">
                            		<th colspan="7" class="medium-width">Request</th>
                            		<th rowspan="2" class="small-2-width" style="vertical-align: middle !important;">PIC</th>
                                    <th rowspan="2" class="small-2-width" style="vertical-align: middle !important;">Approved By</th>
                                    <th rowspan="2" style="vertical-align: middle !important;" class="small-2-width">Respon</th>
                                    <th rowspan="2" style="vertical-align: middle !important;" class="small-2-width">Time Added</th>
                                    <th rowspan="2" style="vertical-align: middle !important;" class="small-2-width">Action</th>
                            	</tr>
                                <tr class="text-center"
                                    style="color:black; background-color:gray; color:white;">
                                    <th class="small-2-width">Type</th>
                                    <th class="small-2-width">Jenis</th>
                                    <th class="medium-width">Merk</th>
                                    <th class="small-width">Qty</th>
                                    <th class="medium-width">Delivery By</th>
                                    <th class="medium-width">Keperluan dan Catatan</th>
                                    <th class="medium-width">Alamat Tujuan</th>
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

    <!-- Tambah Modal -->
    <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="qr_modal"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <form action='{{URL("tambah_request_outbond")}}' name='form' method='POST' accept-charset='UTF-8' enctype='multipart/form-data' id='form'>
            @csrf
            <div class="modal-content">
                 <div class="modal-body" id="isi_qr">
                        <div class="zf-templateWrapper"><!---------template Header Starts Here---------->
                            <ul class="zf-tempHeadBdr">
                                <li class="zf-tempHeadContBdr">
                                    <h2 class="zf-frmTitle"><em>Tambah Request Outbond</em></h2>
                                    <p class="zf-frmDesc"></p>
                                    <div class="zf-clearBoth"></div>
                                </li>
                            </ul><!---------template Header Ends Here---------->
                            <!---------template Container Starts Here---------->
                        </div>
                            <div class="zf-subContWrap zf-topAlign mb-3">
                                <div class="card mb-2">
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
                                                            <option value="ONT_ZTE_F670L|Retail|ZTE">ONT_ZTE_F670L</option>
                                                            <option value="ONT_NOKIA_G240WL|Retail|Nokia">ONT_NOKIA_G240WL
                                                            </option>
                                                            <option value="ONT_NOKIA_G-2425G-A|Retail|Nokia">ONT_NOKIA_G-2425G-A
                                                            </option>
                                                            <option value="ONT_FIBERHOME_HG6145D2|Retail|Fiberhome">
                                                                ONT_FIBERHOME_HG6145D2
                                                            </option>
                                                            <option value="ONT_FIBERHOME_HG6145F|Retail|Fiberhome">
                                                                ONT_FIBERHOME_HG6145F
                                                            </option>
                                                            <option value="ONT_HUAWEI_HG8145V5|Retail|Huawei">ONT_HUAWEI_HG8145V5
                                                            </option>
                                                            <option value="ONT_ZTE_F670 V2.0|Premium|ZTE">ONT_ZTE_F670 V2.0
                                                            </option>
                                                            <option value="ONT_ZTE_F670|Retail|ZTE">ONT_ZTE_F670</option>
                                                            <option value="ONT_FIBERHOME_HG6245N|Premium|Fiberhome">
                                                                ONT_FIBERHOME_HG6245N
                                                            </option>
                                                            <option value="ONT_HUAWEI HG8245W5-6T|Premium|Huawei">ONT_HUAWEI
                                                                HG8245W5-6T
                                                            </option>
                                                            <option value="ONT_HW_HG8245W5-6T|Premium|Huawei">ONT_HW_HG8245W5-6T
                                                            </option>
                                                        </select>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="col-5 ms-5 mt-3">
                                            <!---------Number Starts Here---------->
                                            <ul>
                                                <li class="zf-tempFrmWrapper zf-large">
                                                    <label class="zf-labelName">Jumlah</label>
                                                    <div class="zf-tempContDiv">
                                                        <span class="zf-addOne"><input type="qty_delivery" type="number" name="qty_delivery"
                                                                value="" maxlength="18" placeholder=""
                                                                required /></span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="col-5">
                                            <ul>
                                                <!---------Dropdown Starts Here---------->
                                                <li class="zf-tempFrmWrapper zf-large">
                                                    <label class="zf-labelName">Delivery By: </label>
                                                    <div class="zf-tempContDiv">
                                                        <select class="zf-form-sBox" name="delivery_by" checktype="c1"
                                                            required>
                                                            <option selected="true" value="">-Pilih Delivery By-
                                                            </option>
                                                            <option value="Darat">Darat</option>
                                                            <option value="Udara">Udara</option>
                                                            <option value="Handcarry">Handcarry</option>
                                                            <option value="Gosend">Gosend</option>
                                                            <option value="Lalamove">Lalamove</option>
                                                        </select>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                    </div>
                                </div>

                                <!---------Name Starts Here---------->
                                <div class="card">
                                    <div class="row">
                                        <div class="col-6 ms-5 mt-3">
                                            <ul>
                                                <li class="zf-tempFrmWrapper">
                                                    <label class="zf-labelName">Keperluan: </label>
                                                    <div class="zf-tempContDiv">
                                                        <textarea class="form-control" type="text" maxlength="5000" placeholder="Tambahkan keperluan disini..." fieldType=7 placeholder="" style="min-width:100%;" required /></textarea>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="col-6 ms-5 mt-3">
                                            <ul>
                                                <li class="zf-tempFrmWrapper zf-name zf-namemedium">
                                                    <label class="zf-labelName">Catatan: </label>
                                                    <div class="zf-tempContDiv zf-twoType">
                                                        <div class="zf-nameWrapper">
                                                               <textarea class="form-control" type="text" maxlength="5000" name="catatan" fieldType=7  style="min-width:120%;" placeholder="Tambahkan catatan disini..." required /></textarea>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="col-5 mb-3">
                                            <ul>
                                                <li class="zf-tempFrmWrapper zf-name zf-namemedium">
                                                    <label class="zf-labelName">Alamat Tujuan</label>
                                                    <div class="zf-tempContDiv zf-twoType">
                                                            <select class="zf-form-sBox" name="alamat_tujuan"
                                                                checktype="c1" required>
                                                                <option selected="true" value="">-Pilih Warehouse-
                                                                </option>
                                                                @foreach ($data['warehouse'] as $wh)
                                                                    <option value="{{ $wh->lokasi_wh }}">
                                                                        {{ $wh->lokasi_wh }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="row mb-3 mt-3">
                                        <div class="col-6">
                                        </div>
                                        <div class="col-6">
                                            <div class="float-right mr-3">
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                <button class="btn btn-primary" type="submit">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Upload Modal-->
    <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header--sticky">
                    <div class="row">
                        <div class="col-4">
                        </div>
                        <div class="col-4">
                            <h5 class="modal-title w-100 text-center">Upload Data</h5>
                        </div>
                        <div class="col-4 float-right">
                            <div class="float-right">
                                <a class="btn btn-danger" data-target="#hapusModal" data-toggle="modal">Hapus</a>
                            </div>
                        </div>
                    </div>
                </div>
                <form name='form_upload' method='POST' accept-charset='UTF-8' enctype='multipart/form-data' id='form_upload'>
                @csrf
                <div class="modal-body" id="modal-body">
                         <div class="row mb-3">
                            <div class="col-6" id="isi_konten">
                                
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6">
                                <label>Mohon Upload FILE XLX(SN; MAC)</label>
                                <input type="file" class="form-control" name="edit_sn_mac_barcode" id="edit_sn_mac_barcode" style="height: 45px;" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                            </div>
                            <div class="col-2">
                                <label>Template SN</label>
                                <a class="btn btn-secondary" href="{{URL('/download_template_sn/')}}" value="false">Template</a>
                            </div>
                            <div class="col-3" id="download_mac_sn">
                                   
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6">
                                <label>Mohon Upload Foto Evident</label>
                                <input type="file" class="form-control" name="edit_evident" id="edit_evident" style="height: 45px;" accept=".png, .jpg, .jpeg">
                            </div>
                            <div class="col-3" id="download_evident">
                                   
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <textarea class="form-control" name="edit_respon" id="edit_respon" placeholder="Tambahkan respon disini..." required></textarea>
                            </div>
                        </div>
                </div>
                <div class="modal-footer--sticky" id='approveModalButton'>
                    
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="qr_modal"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <form id="form_edit" name='form' method='POST' accept-charset='UTF-8' enctype='multipart/form-data' id='form_edit'>
            @csrf
            <div class="modal-content">
                 <div class="modal-body" id="isi_qr">
                        <div class="zf-templateWrapper"><!---------template Header Starts Here---------->
                            <ul class="zf-tempHeadBdr">
                                <li class="zf-tempHeadContBdr">
                                    <h2 class="zf-frmTitle"><em>Tambah Request Outbond</em></h2>
                                    <p class="zf-frmDesc"></p>
                                    <div class="zf-clearBoth"></div>
                                </li>
                            </ul><!---------template Header Ends Here---------->
                            <!---------template Container Starts Here---------->
                        </div>
                            <div class="zf-subContWrap zf-topAlign mb-3">
                                <div class="card mb-2">
                                    <div class="row">
                                        <div class="col-5 ms-5 mt-3">
                                            <ul>
                                                <!---------Dropdown Starts Here---------->
                                                <li class="zf-tempFrmWrapper zf-large">
                                                    <label class="zf-labelName">Type</label>
                                                    <div class="zf-tempContDiv">
                                                        <select class="zf-form-sBox" id="edit_type" name="edit_type" checktype="c1"
                                                            required>
                                                            <option selected="true" value="">-Pilih Type-
                                                            </option>
                                                            <option value="ONT_ZTE_F670L|Retail|ZTE">ONT_ZTE_F670L</option>
                                                            <option value="ONT_NOKIA_G240WL|Retail|Nokia">ONT_NOKIA_G240WL
                                                            </option>
                                                            <option value="ONT_NOKIA_G-2425G-A|Retail|Nokia">ONT_NOKIA_G-2425G-A
                                                            </option>
                                                            <option value="ONT_FIBERHOME_HG6145D2|Retail|Fiberhome">
                                                                ONT_FIBERHOME_HG6145D2
                                                            </option>
                                                            <option value="ONT_FIBERHOME_HG6145F|Retail|Fiberhome">
                                                                ONT_FIBERHOME_HG6145F
                                                            </option>
                                                            <option value="ONT_HUAWEI_HG8145V5|Retail|Huawei">ONT_HUAWEI_HG8145V5
                                                            </option>
                                                            <option value="ONT_ZTE_F670 V2.0|Premium|ZTE">ONT_ZTE_F670 V2.0
                                                            </option>
                                                            <option value="ONT_ZTE_F670|Retail|ZTE">ONT_ZTE_F670</option>
                                                            <option value="ONT_FIBERHOME_HG6245N|Premium|Fiberhome">
                                                                ONT_FIBERHOME_HG6245N
                                                            </option>
                                                            <option value="ONT_HUAWEI HG8245W5-6T|Premium|Huawei">ONT_HUAWEI
                                                                HG8245W5-6T
                                                            </option>
                                                            <option value="ONT_HW_HG8245W5-6T|Premium|Huawei">ONT_HW_HG8245W5-6T
                                                            </option>
                                                        </select>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="col-5 ms-5 mt-3">
                                            <!---------Number Starts Here---------->
                                            <ul>
                                                <li class="zf-tempFrmWrapper zf-large">
                                                    <label class="zf-labelName">Jumlah</label>
                                                    <div class="zf-tempContDiv">
                                                        <span class="zf-addOne"><input type="qty_delivery" type="number" id="edit_qty_delivery" name="edit_qty_delivery"
                                                                value="" maxlength="18" placeholder=""
                                                                required /></span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="col-5 ms-5">
                                            <ul>
                                                <!---------Dropdown Starts Here---------->
                                                <li class="zf-tempFrmWrapper zf-large">
                                                    <label class="zf-labelName">Delivery By: </label>
                                                    <div class="zf-tempContDiv">
                                                        <select class="zf-form-sBox" id="edit_delivery_by" name="edit_delivery_by" checktype="c1"
                                                            required>
                                                            <option selected="true" value="">-Pilih Delivery By-
                                                            </option>
                                                            <option value="Darat">Darat</option>
                                                            <option value="Udara">Udara</option>
                                                            <option value="Handcarry">Handcarry</option>
                                                            <option value="Gosend">Gosend</option>
                                                            <option value="Lalamove">Lalamove</option>
                                                        </select>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                    </div>
                                </div>

                                <!---------Name Starts Here---------->
                                <div class="card">
                                    <div class="row">
                                        <div class="col-6 ms-5 mt-3">
                                            <ul>
                                                <li class="zf-tempFrmWrapper">
                                                    <label class="zf-labelName">Keperluan: </label>
                                                    <div class="zf-tempContDiv">
                                                        <textarea class="form-control" type="text" maxlength="5000" placeholder="Edit keperluan disini..." id="edit_keperluan" name="edit_keperluan" fieldType=7 placeholder="" style="min-width:100%;" required /></textarea>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="col-6 ms-5 mt-3">
                                            <ul>
                                                <li class="zf-tempFrmWrapper zf-name zf-namemedium">
                                                    <label class="zf-labelName">Catatan: </label>
                                                    <div class="zf-tempContDiv zf-twoType">
                                                        <div class="zf-nameWrapper">
                                                               <textarea class="form-control" type="text" maxlength="5000" id="edit_catatan" name="edit_catatan" fieldType=7 placeholder="Edit catatan disini..." style="min-width:120%;" required /></textarea>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="col-5 mb-3">
                                            <ul>
                                                <li class="zf-tempFrmWrapper zf-name zf-namemedium">
                                                    <label class="zf-labelName">Alamat Tujuan</label>
                                                    <div class="zf-tempContDiv zf-twoType">
                                                            <select class="zf-form-sBox" id="edit_alamat_tujuan" name="edit_alamat_tujuan"
                                                                checktype="c1" required>
                                                                <option selected="true" value="">-Pilih Warehouse-
                                                                </option>
                                                                @foreach ($data['warehouse'] as $wh)
                                                                    <option value="{{ $wh->lokasi_wh }}">
                                                                        {{ $wh->lokasi_wh }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="row mb-3 mt-3">
                                        <div class="col-6">
                                        </div>
                                        <div class="col-6">
                                            <div class="float-right mr-3">
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                <button class="btn btn-primary" type="submit">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Hapus Modal-->
    <div class="modal fade" id="hapusModal" tabindex="-1" role="dialog"
        aria-hidden="true">
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
                <div class="modal-body" id="modal-hapus-body"></div>
                <div class="modal-footer--sticky">
                    <button class="btn btn-secondary mr-1 ml-auto" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger mr-1" id="deleteButtonRequestOutbond">Hapus</a>
                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript" src="{{asset('resources/js/daterangepicker.js')}}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/datetime/1.5.1/js/dataTables.dateTime.min.js"></script>
<!-- <script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script> -->
<!-- <script type="text/javascript" src="{{asset('resources/js/datatables/jquery.dataTables.js')}}"></script> -->
<script type="text/javascript">
    var request_outbond = <?php echo json_encode($data["request_outbond"]); ?>;

    function uploadModal(id){
        document.getElementById('form_upload').action = "{{URL('upload_respon_request_outbond')}}"+"/"+id;
        document.getElementById("deleteButtonRequestOutbond").href = "{{URL('delete_request_outbond')}}"+"/"+id;

        request_filter = request_outbond.filter(function(val){
              return val.id == id;
        });

        // document.getElementById("modal-hapus-body").innerHTML = "Apakah anda yakin ingin menghapus data ini?<br>";
        // document.getElementById("modal-hapus-body").innerHTML += "Type : "+request_filter[0].type+"<br>";
        // document.getElementById("modal-hapus-body").innerHTML += "Jenis : "+request_filter[0].jenis+"<br>";
        // document.getElementById("modal-hapus-body").innerHTML += "Merk : "+request_filter[0].merk+"<br>";
        // document.getElementById("modal-hapus-body").innerHTML += "Qty : "+request_filter[0].qty_delivery+"<br>";
        // document.getElementById("modal-hapus-body").innerHTML += "Delivery By : "+request_filter[0].delivery_by+"<br>";
        // document.getElementById("modal-hapus-body").innerHTML += "Keperluan : "+request_filter[0].keperluan+"<br>";
        // document.getElementById("modal-hapus-body").innerHTML += "Catatan : "+request_filter[0].catatan+"<br>";
        // document.getElementById("modal-hapus-body").innerHTML += "Added by (PIC) : "+request_filter[0].added_by+"<br>";
        // document.getElementById("modal-hapus-body").innerHTML += "Approved By : "+request_filter[0].approved_by+"<br>";

        html = '<h5 class="mb-2">Apakah anda yakin ingin menghapus data ini?<br></h5>'
        html += '<table>'+
            '<tr><td class="first-col-modal">ID</td><td class="colon-col">:</td><td>'+request_filter[0].id+'</td></tr>'+
            '<tr><td class="first-col-modal">Type</td><td class="colon-col">:</td><td>'+request_filter[0].type+'</td></tr>'+
            '<tr><td class="first-col-modal">Jenis</td><td class="colon-col">:</td><td>'+request_filter[0].jenis+'</td></tr>'+
            '<tr><td class="first-col-modal">Merk</td><td class="colon-col">:</td><td>'+request_filter[0].merk+'</td></tr>'+
            '<tr><td class="first-col-modal">Qty</td><td class="colon-col">:</td><td>'+request_filter[0].qty_delivery+'</td></tr>'+
            '<tr><td class="first-col-modal">Delivery By</td><td class="colon-col">:</td><td>'+request_filter[0].delivery_by+'</td></tr>'+
            '<tr><td class="first-col-modal">Keperluan</td><td class="colon-col">:</td><td>'+request_filter[0].keperluan+'</td></tr>'+
            '<tr><td class="first-col-modal">Catatan</td><td class="colon-col">:</td><td>'+request_filter[0].catatan+'</td></tr>'+
            '<tr><td class="first-col-modal">Added By (PIC)</td><td class="colon-col">:</td><td>'+request_filter[0].added_by+'</td></tr>'+
            '<tr><td class="first-col-modal">Approved By</td><td class="colon-col">:</td><td>'+request_filter[0].approved_by+'</td></tr>'+
            '</table><br>';
        document.getElementById("modal-hapus-body").innerHTML = html;

        document.getElementById('edit_respon').value = request_filter[0].respon;

        document.getElementById('download_mac_sn').innerHTML = ''
        if(request_filter[0].sn_mac_barcode != ''){
            url = "{{URL('download_mac_sn')}}"+"/"+id
            document.getElementById('download_mac_sn').innerHTML = '<label>Download Mac SN</label><a class="btn btn-secondary" href="'+url+'">Download</a>'
        }

        document.getElementById('download_evident').innerHTML = '' 
        if(request_filter[0].evident != ''){
            url = "{{URL('download_evident')}}"+"/"+id
            document.getElementById('download_evident').innerHTML = '<label>Download Evident</label><a class="btn btn-secondary" href="'+url+'">Download</a>'
        }
                                         
        if(request_filter[0].approved_by == ''){
            html = '<div class="col-4 ml-auto">'
            html += '<div class="d-flex flex-row-reverse ml-4" id="">'
            html += '<button class="btn btn-primary" type="submit">Approve</button>'
            // html += '<button class="btn btn-warning mr-1">Edit</button>'
        }else{
            html = '<div class="col-5 ml-auto">'
            html += '<div class="d-flex flex-row-reverse ml-4" id="">'
            html += '<button class="btn btn-primary" type="submit">Submit Change</button>'
        }
        html += '<button class="btn btn-warning mr-1" onclick="editModal('+id+')" data-target="#editModal" data-toggle="modal" type="button">Edit</button>'
        html += '<button class="btn btn-secondary mr-1" type="button" data-dismiss="modal">Tutup</button>'
        html += '</div></div>';

        document.getElementById("approveModalButton").innerHTML = html;
    }

    function editModal(id) {
        document.getElementById("form_edit").action = "{{URL('edit_request_outbond')}}"+"/"+id

        request_outbond_filter = request_outbond.find(function(val){
              return val.id == id;
        });

        $("#edit_type option[value*="+request_outbond_filter["type"].split("|")[0]+"]").prop("selected", true)

        document.getElementById("edit_qty_delivery").value = request_outbond_filter["qty_delivery"];
        document.getElementById("edit_delivery_by").value = request_outbond_filter["delivery_by"];
        document.getElementById("edit_keperluan").value = request_outbond_filter["keperluan"];
        document.getElementById("edit_catatan").value = request_outbond_filter["catatan"];
        document.getElementById("edit_alamat_tujuan").value = request_outbond_filter["alamat_tujuan"];
        document.getElementById("edit_respon").value = request_outbond_filter["respon"];


    }

    var table = $('#requestOutbondTable').DataTable({
        "ajax": "{{ url('/all_request_outbond')}}",
        "searching": true,
        "deferRender": true,
        "ordering" : false,
        "scrollX": true,
        // "responsive":false,
        "columns":[
            {"data" : "type"},
            {"data" : "jenis"},
            {"data" : "merk"},
            {"data" : "qty_delivery"},
            {"data" : "delivery_by"},
            {"data" : "keperluan"},
            {"data" : "alamat_tujuan"},
            {"data" : "added_by"},
            {"data" : "approved_by"},
            {"data" : "respon"},
            {"data" : "time_added"},
            {"data" : "id"},
            {"data" : "status", visible: false},
        ],
        columnDefs : [
            {
                "searchable" : false,
                "orderable" : false,
                "targets": 11,
                "render": function(data, type, row){
                        href = "{{URL('download_serial_number')}}"+"/"+data;
                        var btn = '<a class="btn btn-secondary" onclick="uploadModal('+data+')" data-target="#uploadModal" data-toggle="modal">View</a>'
                        return btn;
                },
                "className" : "text-center small-2-width"
            },
            {
                "targets": [0, 4, 6, 9],
                "className" : "medium-width"
            },
            {
                "targets": [1, 2, 7, 8],
                "className" : "small-width"
            },
            {
                "targets": [3],
                "className" : "small-width text-center"
            },
            {
                "searchable" : false,
                "orderable" : false,
                "targets": 5,
                "render": function(data, type, row){
                        var html = "Keperluan: "+row.keperluan+" <br> Catatan: "+row.catatan;
                        return html;
                },
            }
        ],
    });

    typeFilter = document.getElementById('typeFilter');
    merkFilter = document.getElementById('merkFilter');
    jenisFilter = document.getElementById('jenisFilter');
    deliveryFilter = document.getElementById('deliveryFilter');
    alamatFilter = document.getElementById('alamatFilter');
    statusFilter = document.getElementById('statusFilter');

    var options = [
        @foreach ($data['warehouse'] as $idx => $obj)
            {label: '{{$obj->lokasi_wh}}', value : '{{$obj->lokasi_wh}}' },
        @endforeach
    ];

    VirtualSelect.init({
        ele: '#alamatFilter',
        search: true,
    });

    $(function() {
      $('input[name="daterange"]').daterangepicker({
        opens: 'left',
        locale: {
            cancelLabel: 'Clear'
        }
      }, function(start, end, label) {
        changeTableByDate();
      });
    });

    $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
        const date = new Date();

        let day = date.getDate();
        let month = date.getMonth() + 1;
        let year = date.getFullYear();

        // This arrangement can be altered based on how we want the date's format to appear.
        let currentDate = `${month}/${day}/${year}`;

        $('input[name="daterange"]').data('daterangepicker').setStartDate('');
        $('input[name="daterange"]').data('daterangepicker').setEndDate('');

        changeTableByDate();
        $('input[name="daterange"]').data('daterangepicker').setStartDate(currentDate);
        $('input[name="daterange"]').data('daterangepicker').setEndDate(currentDate);
      });

    $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
            tanggal_filter = document.getElementsByClassName("drp-selected")[0].innerHTML.split(" - ")

            // console.log(tanggal_filter)
            let min = new Date(tanggal_filter[0]).getTime();
            let max = new Date(tanggal_filter[1]).getTime();
            let date = new Date(data[10]).getTime();

            if (
                (min === '' && max === '') ||
                (min === '' && date <= max) ||
                (min <= date && max === '') ||
                (min <= date && date <= max) || 
                (isNaN(min) && isNaN(max))
            ) {
                console.log("true");
                return true;
            }
            console.log("false");
            return false;
        }
    );

    $( document ).ready(function() {
        document.querySelector('#alamatFilter').setOptions(options_filter_warehouse_select);

        document.querySelector('#alamatFilter').addEventListener('change', function() {
            const date = new Date();
            tanggal_filter = document.getElementsByClassName("drp-selected")[0].innerHTML.split(" - ")

            let day = date.getDate();
            let month = date.getMonth() + 1;
            let year = date.getFullYear();

            // This arrangement can be altered based on how we want the date's format to appear.
            let currentDate = `${month}/${day}/${year}`;

            changeTableContent();
            onChangeAlamat(this.value);

            console.log(tanggal_filter[0]+" "+tanggal_filter[1])
            if((currentDate == tanggal_filter[0] && currentDate == tanggal_filter[1]) || (isNaN(tanggal_filter[0]) && isNaN(tanggal_filter[1])) || (tanggal_filter[0] == 'Invalid Date' && tanggal_filter[1] == 'Invalid Date')){
                $('input[name="daterange"]').data('daterangepicker').setStartDate('');
                $('input[name="daterange"]').data('daterangepicker').setEndDate('');
                changeTableByDate();

                $('input[name="daterange"]').data('daterangepicker').setStartDate(currentDate);
                // $('input[name="daterange"]').data('daterangepicker').setEndDate(currentDate);
            }

        });
    });

    function onChangeAlamat(alamat){
        table.column(6).search(alamat).draw()
    }

    function changeTableByDate(){
        table.draw()
    }

    function changeTableContent() {
        valueTypeFilter = typeFilter.options[typeFilter.selectedIndex].value;
        valueMerkFilter = merkFilter.options[merkFilter.selectedIndex].value;
        valueJenisFilter = jenisFilter.options[jenisFilter.selectedIndex].value;
        valueDeliveryFilter = deliveryFilter.options[deliveryFilter.selectedIndex].value;
        valueStatus = statusFilter.options[statusFilter.selectedIndex].value;

        // obj_val = all_witel.find((element) => element.id == arr_val[i]);
        // if (arr_val[i].includes("TREG")) {
        //     obj_val = all_witel.find((element) => element.lokasi_wh == arr_val[i]);
        // }

        // regexType = '^' + valueTypeFilter + '$';
        // regexMerk = '^' + valueMerkFilter + '$';
        // regexJenis = '^' + valueJenisFilter + '$';
        // regexDelivery = '^' + valueDeliveryFilter + '$';
        // regexAlamat = '^' + valueAlamatFilter + '$';

        // table.column(0).search(regexType, true, false).draw();
        table.column(0).search(valueTypeFilter).draw()

        // table.column(1).search(regexMerk, true, false).draw();
        table.column(1).search(valueJenisFilter).draw()

        // table.column(2).search(regexJenis, true, false).draw();
        table.column(2).search(valueMerkFilter).draw()

        // table.column(4).search(regexDelivery, true, false).draw();
        table.column(4).search(valueDeliveryFilter).draw()

        table.column(12).search(valueStatus).draw()

        // table.column(6).search(regexAlamat, true, false).draw();
        // table.column(6).search(valueAlamatFilter).draw()
    }
</script>
</html>