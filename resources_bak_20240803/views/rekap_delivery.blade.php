<!doctype html>
<html lang="en">

<head>
    <title>Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @include('template.import_datatable')
    <style>
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
        /* background-color: white !important; */
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

    select.form-control {
        display: inline;
        width: 200px;
        margin-left: 25px;
    }

    .first-col {
        width: 60px;
        min-width: 60px;
        max-width: 60px;
        left: 0px;
        background-color: gray;
        color: white;
    }

    .grey-col {
        background-color: gray;
        color: white;
        font-weight: bold;
    }

    .sticky-col {
        position: -webkit-sticky !importance;
        position: sticky;
        background-color: white !importance;
    }

    .minColumnWidth {
        width: 55px;
        min-width: 55px;
        max-width: 55px;
    }

    #filterTableDetail_filter {
        width: 50%;
        float: right;
        text-align: right;
        margin-top: -20px;
    }

    #filterTable_filter {
        width: 50%;
        float: right;
        text-align: right;
        margin-top: -20px;
    }

    /* Header fixed to the top of the modal */
    .modal-header--sticky {
        display: flex;
        align-items: flex-start;
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
        justify-content: flex-end;
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

    .bgc-yellow{
        background-color: yellow;
    }

    .bgc-green{
        background-color: #77DD77;
    }

    .blink-red {
        -webkit-animation: blink-red 1000ms step-end infinite;
                animation: blink-red 1000ms step-end infinite;
    }
    @-webkit-keyframes blink-red { 50% { background-color: red; color: white }}
            @keyframes blink-red { 50% { background-color: red; color: white }}
    
    /*=============*/
    
    .blink-yellow {
        -webkit-animation: blink-yellow 1000ms step-end infinite;
                animation: blink-yellow 1000ms step-end infinite;
    }
    @-webkit-keyframes blink-yellow { 50% { background-color: yellow; }}
            @keyframes blink-yellow { 50% { background-color: yellow; }}
    
    /*=============*/
    
    .blink-green {
        -webkit-animation: blink-green 1000ms step-end infinite;
                animation: blink-green 1000ms step-end infinite;
    }
    @-webkit-keyframes blink-green { 50% { background-color: #77DD77; }}
            @keyframes blink-green { 50% { background-color: #77DD77; }}

    </style>
    <link rel="icon" href="{{ asset('resources/img/minitok.jpeg') }}">
    <script src="{{ asset('resources/js/virtual-select.min.js') }}"></script>
    <link href="{{ asset('resources/css/virtual-select.min.css') }}" rel="stylesheet">
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
        <div id="content" style=" margin: 0 auto;  box-sizing: border-box;">
            <div class="container-fluid" style=" width: 105.5%">
                @include('template.navbar')
                <div class="card mb-3 mt-3">
                    <div class="card-body mb-2">

                        @if (session('asal') == 'DID' || session('jenis_akun') == 'treg')
                            <div class="container-fluid p-0" style="width: 100%">
                                <div class="export-filter mb-1 row">
                                    <div class="col-md-6 order-md-1 order-2">
                                        <form class="mt-3" id="form_export"
                                            action="{{ URL('/export_data_tmp_scmt/all/rekap_delivery') }}"
                                            method="POST">
                                            @csrf
                                            <select id="exportFilter" class="form-control" style="margin-left:0;"
                                                onchange="giveExportSelection()">
                                                <option value="all">All</option>
                                                <option value="merah">Merah</option>
                                                <option value="kuning">Kuning</option>
                                                <option value="kuning">Hijau</option>
                                            </select>
                                            <button class="btn btn-secondary mt-md-0" value="false"
                                                type="submit">Export Data</button>
                                        </form>

                                        @if (session('asal') == 'DID')
                                            <span class="ml-1">Last update: {{ $data['last_update'] }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-6 order-md-2 order-1 d-flex justify-content-md-end">
                                        <form class="mt-3" id="form_export_all"
                                            action="{{ URL('/export_data_tmp_scmt/all/all') }}" method="POST">
                                            @csrf
                                            <select id="exportFilterAll" class="form-control" style="margin-left:0;"
                                                onchange="giveExportAllSelection()">
                                                <option value="all">All</option>
                                                <option value="merah">Merah</option>
                                                <option value="kuning">Kuning</option>
                                                <option value="kuning">Hijau</option>
                                            </select>
                                            <button class="btn btn-secondary mt-md-0" value="false"
                                                type="submit">Export All Data</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif



                        <div class="category-filter">
                            <div class="table-responsive">
                                <div class="category-filter mb-3">
                                    <form class="d-flex flex-row-reverse mb-4">
                                        <select onclick="changeTableContent(this.value)" id="select-filter" multiple
                                            name="native-select" placeholder="Filter Data" data-search="true"
                                            data-silent-initial-value-set="true">
                                            @foreach ($data['all_witel'] as $idx => $value)
                                                <option value="{{ $value['id'] }}"
                                                    @if (in_array($value['lokasi_wh'], array_column($data['witel'], 'lokasi_wh'))) selected @endif>
                                                    {{ $value['lokasi_wh'] }}</option>
                                            @endforeach
                                        </select>
                                    </form>

                                    @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg')
                                        <div id="tableBiasa">
                                            <table class="table table-bordered" id="filterTable" width="100%">
                                                <thead>
                                                    <tr class="text-center"
                                                        style="color:black; background-color:gray; color:white;">
                                                        <th rowspan="2" class="first-col sticky-col"
                                                            style="min-width: 250px; text-align: center; vertical-align: middle;">
                                                            Warehouse</th>
                                                        <th rowspan="2" hidden>regional</th>
                                                        <th rowspan="2" hidden>witel</th>
                                                        <th rowspan="2"
                                                            style="text-align: center; vertical-align: middle;"
                                                            style="max-width:70px" hidden>Minimum Qty</th>
                                                        <th colspan="2">Stock SCMT</th>
                                                        <th colspan="2">GAP Stock</th>
                                                        <th colspan="2">Kebutuhan</th>
                                                        <th colspan="2">Minimum Stock Requirement Retail</th>
                                                        <th colspan="2">On Delivery</th>
                                                    </tr>
                                                    <tr class="text-center" style="background-color:gray; color:white;">
                                                        <!-- <th @if (session('asal') == 'DID' || session('jenis_akun') == 'sda') colspan="4" @endif></th> -->
                                                        <th style="text-align: center; vertical-align: middle;">Total
                                                            Retail</th>
                                                        <th style="text-align: center; vertical-align: middle;">Total
                                                            Premium</th>

                                                        <th
                                                            style="max-width:100px; text-align: center; vertical-align: middle;">
                                                            Total Retail</th>
                                                        <th
                                                            style="max-width:100px; text-align: center; vertical-align: middle;">
                                                            Total Premium</th>

                                                        <th
                                                            style="max-width:100px; text-align: center; vertical-align: middle;">
                                                            Total Retail</th>
                                                        <th
                                                            style="max-width:100px; text-align: center; vertical-align: middle;">
                                                            Total Premium</th>

                                                        <th
                                                            style="max-width:100px; text-align: center; vertical-align: middle;">
                                                            Total Retail</th>
                                                        <th
                                                            style="max-width:100px; text-align: center; vertical-align: middle;">
                                                            Total Premium</th>

                                                        <th
                                                            style="max-width:100px; text-align: center; vertical-align: middle;">
                                                            Total Retail</th>
                                                        <th
                                                            style="max-width:100px; text-align: center; vertical-align: middle;">
                                                            Total Premium</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tableBiasa-body">
                                                    <?php $kebutuhan_premium = 0;
                                                    $kebutuhan_retail = 0; ?>
                                                    @foreach ($data['witel'] as $idx => $d)
                                                        <tr>
                                                            <td value="" class="first-col sticky-col"
                                                                style="background-color:gray; color:white; font-weight: bold;">
                                                                @if ($data['jenis_warehouse'] == 'Witel' || $data['jenis_warehouse'] == 'TA SO')
                                                                    <a style="text-decoration:none; color: white; font-weight: bold; cursor: pointer;"
                                                                        <?php if (!str_contains($d->witel, 'REGIONAL')) {
                                                                            echo 'href="' . url('/rekap_delivery/') . '/' . $data['jenis_warehouse'] . '/' . $d->lokasi_wh;
                                                                        } ?>">{{ $d->lokasi_wh }}</a>
                                                                @else($data["jenis_warehouse"] == "Witel")
                                                                    {{ $d->lokasi_wh }}
                                                                @endif
                                                            </td>
                                                            <td hidden>{{ $d->regional }}</td>
                                                            <td hidden>{{ $d->witel }}</td>
                                                            <td hidden><?php echo number_format((int) $d->minimum_qty, 0, ',', '.'); ?></td>

                                                            <div class="text-center">
                                                                <td><?php echo number_format((int) $d->total_retail_stock, 0, ',', '.'); ?></td>
                                                                <td><?php echo number_format((int) $d->total_premium_stock, 0, ',', '.'); ?></td>
                                                                
                                                                @if($data["jenis_warehouse"] == "Witel" && ($d->retail_stock_fiberhome - $d->retail_fh < -($d->retail_fh * 0.50) || $d->retail_stock_huawei - $d->retail_hw < -($d->retail_hw * 0.50) || $d->retail_stock_zte - $d->retail_zte < -($d->retail_zte * 0.50) || $d->retail_stock_nokia - $d->retail_alu < -($d->retail_alu * 0.50) ))
                                                                <td
                                                                    class="@if ($d->total_retail_stock - $d->total_retail < -($d->total_retail * 0.50))blink-red @elseif($d->total_retail_stock - $d->total_retail < 0)blink-yellow @else blink-green @endif"
                                                                >
                                                                    <span><?php echo number_format((int) $d->total_retail_stock - $d->total_retail, 0, ',', '.'); ?></span>
                                                                </td>
                                                                @else
                                                                <td
                                                                    class="@if ($d->total_retail_stock - $d->total_retail < -($d->total_retail * 0.50))blink-red @elseif($d->total_retail_stock - $d->total_retail < 0)bgc-yellow @else bgc-green @endif ">
                                                                    <?php echo number_format((int) $d->total_retail_stock - $d->total_retail, 0, ',', '.'); ?>
                                                                </td>
                                                                @endif

                                                                @if($data["jenis_warehouse"] == "Witel" && ($d->premium_stock_fiberhome - $d->premium_fh < -($d->premium_fh * 0.50) || $d->premium_stock_huawei - $d->premium_hw < -($d->premium_hw * 0.50) || $d->premium_stock_zte - $d->premium_zte < -($d->premium_zte * 0.50)))
                                                                <td
                                                                    class="@if ($d->total_premium_stock - $d->total_premium < -($d->total_retail * 0.50))blink-red @elseif($d->total_premium_stock - $d->total_premium < 0)blink-yellow @else blink-green @endif"
                                                                >
                                                                    <span><?php echo number_format((int) $d->total_premium_stock - $d->total_premium, 0, ',', '.'); ?></span>
                                                                </td>
                                                                @else
                                                                <td
                                                                    class="@if ($d->total_premium_stock - $d->total_premium < -($d->total_premium * 0.50))blink-red @elseif($d->total_premium_stock - $d->total_premium < 0)bgc-yellow @else bgc-green @endif ">
                                                                    <?php echo number_format((int) $d->total_premium_stock - $d->total_premium, 0, ',', '.'); ?>
                                                                </td>
                                                                @endif

                                                                <td>
                                                                    @if ($d->qty_kirim_retail_alu + $d->qty_kirim_retail_fh + $d->qty_kirim_retail_hw + $d->qty_kirim_retail_zte != 0)
                                                                        <?php echo number_format((int) $d->qty_kirim_retail_alu + (int) $d->qty_kirim_retail_fh + (int) $d->qty_kirim_retail_hw + (int) $d->qty_kirim_retail_zte, 0, ',', '.'); ?> <?php $kebutuhan_retail += $d->qty_kirim_retail_alu + $d->qty_kirim_retail_fh + $d->qty_kirim_retail_hw + $d->qty_kirim_retail_zte; ?>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($d->qty_kirim_premium_fh + $d->qty_kirim_premium_hw + $d->qty_kirim_premium_zte != 0)
                                                                        <?php echo number_format((int) $d->qty_kirim_premium_fh + $d->qty_kirim_premium_hw + $d->qty_kirim_premium_zte, 0, ',', '.'); ?> <?php $kebutuhan_premium += $d->qty_kirim_premium_fh + $d->qty_kirim_premium_hw + $d->qty_kirim_premium_zte; ?>
                                                                    @endif
                                                                </td>

                                                                <td><?php echo number_format((int) $d->total_retail, 0, ',', '.'); ?></td>
                                                                <td><?php echo number_format((int) $d->total_premium, 0, ',', '.'); ?></td>

                                                                <td><a onClick='setOnDelivery("{{ $d->lokasi_wh }}","retail")'
                                                                        data-toggle='modal'
                                                                        data-target='#onDeliveryModal'
                                                                        style="cursor: pointer; color:grey;"><?php echo number_format((int) $d->on_delivery_total_retail, 0, ',', '.'); ?></a>
                                                                </td>
                                                                <td><a onClick='setOnDelivery("{{ $d->lokasi_wh }}","premium")'
                                                                        data-toggle='modal'
                                                                        data-target='#onDeliveryModal'
                                                                        style="cursor: pointer; color:grey;"><?php echo number_format((int) $d->on_delivery_total_premium, 0, ',', '.'); ?></a>
                                                                </td>
                                                            </div>
                                                        </tr>
                                                    @endforeach
                                                    <tr style="font-weight: bold; background-color:gray; color:white;">
                                                        <td value="" class="sticky-col first-col text-center"
                                                            style="background-color:gray; color:white;">
                                                            <div hidden>Z</div>Total
                                                        </td>
                                                        <td hidden></td>
                                                        <td hidden></td>
                                                        <td hidden><?php echo number_format((int) $data['total_qty_minimum'], 0, ',', '.'); ?></td>

                                                        <div class="text-center">
                                                            <td><?php echo number_format((int) $data['total_retail_stock_all'], 0, ',', '.'); ?></td>
                                                            <td><?php echo number_format((int) $data['total_premium_stock_all'], 0, ',', '.'); ?></td>

                                                            <td><?php echo number_format((int) $data['total_gap_stock_retail'], 0, ',', '.'); ?></td>
                                                            <td><?php echo number_format((int) $data['total_gap_premium_stock'], 0, ',', '.'); ?></td>

                                                            <td><?php echo number_format((int) $kebutuhan_retail, 0, ',', '.'); ?></td>
                                                            <td><?php echo number_format((int) $kebutuhan_premium, 0, ',', '.'); ?></td>

                                                            <td><?php echo number_format((int) $data['total_retail_minimum'], 0, ',', '.'); ?></td>
                                                            <td><?php echo number_format((int) $data['total_premium_minimum'], 0, ',', '.'); ?></td>

                                                            <td><a href=""
                                                                    style="color:white;"><?php echo number_format((int) $data['total_on_delivery_retail_all'], 0, ',', '.'); ?> </a></td>
                                                            <td><a href=""
                                                                    style="color:white;"><?php echo number_format((int) $data['total_on_delivery_premium_all'], 0, ',', '.'); ?> </a></td>
                                                        </div>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif

                                    <div id="tableDetail" @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg') hidden @endif>
                                        <table class="table table-bordered" id="filterTableDetail" width="100%"
                                            style="font-size:8px; color:black;">
                                            <thead>
                                                <tr class="text-center" style="background-color:gray; color:white;">
                                                    <th @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg') rowspan="3" @elseif(session('asal') == 'Nokia') @else rowspan="2" @endif
                                                        class="first-col sticky-col"
                                                        style="text-align: center; vertical-align: middle; background-color:gray; color:white;">
                                                        Warehouse</th>
                                                    <th @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg') rowspan="3" @elseif(session('asal') == 'Nokia') @else rowspan="2" @endif
                                                        hidden>regional</th>
                                                    <th @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg') rowspan="3" @elseif(session('asal') == 'Nokia') @else rowspan="2" @endif
                                                        hidden>witel</th>
                                                    <th @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg') rowspan="3" @elseif(session('asal') == 'Nokia') @else rowspan="2" @endif
                                                        style="text-align: center; vertical-align: middle;">Minimum Qty
                                                    </th>

                                                    <th
                                                        @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg') colspan="9" @elseif(session('asal') == 'Nokia') @else colspan="2" @endif>
                                                        Stock SCMT @if (session('asal') == 'Nokia')
                                                            Retail
                                                        @endif
                                                    </th>
                                                    <th
                                                        @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg') colspan="9" @elseif(session('asal') == 'Nokia') @else colspan="2" @endif>
                                                        GAP Stock</th>

                                                    <th
                                                        @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg') colspan="7" @elseif(session('asal') == 'Nokia') @else colspan="2" @endif>
                                                        Kebutuhan @if (session('asal') == 'Nokia')
                                                            Retail
                                                        @endif
                                                    </th>

                                                    <th
                                                        @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg') colspan="4" rowspan="2" class="align-middle" @elseif(session('asal') == 'Nokia') @else rowspan="2" @endif>
                                                        Minimum Stock Requirement Retail</th>
                                                    @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg')
                                                        <th class="minColumnWidth"
                                                            @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg') rowspan="3" @elseif(session('asal') == 'Nokia') @else rowspan="2" @endif
                                                            style="vertical-align: middle;">Total</th>
                                                    @endif
                                                    @if (session('asal') != 'Nokia')
                                                        <th
                                                            @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg') colspan="3" rowspan="2" class="align-middle" @elseif(session('asal') == 'Nokia') @else rowspan="2" @endif>
                                                            Minimum Stock Requirement Premium</th>
                                                    @endif
                                                    @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg')
                                                        <th class="minColumnWidth"
                                                            @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg') rowspan="3" @elseif(session('asal') == 'Nokia') @else rowspan="2" @endif
                                                            style="vertical-align: middle;">Total</th>
                                                    @endif

                                                    <th
                                                        @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg') colspan="4" rowspan="2" class="align-middle" @elseif(session('asal') == 'Nokia') @else rowspan="2" @endif>
                                                        On Delivery Retail</th>
                                                    @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg')
                                                        <th class="minColumnWidth"
                                                            @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg') rowspan="3" @elseif(session('asal') == 'Nokia') @else rowspan="2" @endif
                                                            style="vertical-align: middle;">Total</th>
                                                    @endif
                                                    @if (session('asal') != 'Nokia')
                                                        <th
                                                            @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg') colspan="3" rowspan="2" class="align-middle" @elseif(session('asal') == 'Nokia') @else rowspan="2" @endif>
                                                            On Delivery Premium</th>
                                                    @endif
                                                    @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg')
                                                        <th class="minColumnWidth"
                                                            @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg') rowspan="3" @elseif(session('asal') == 'Nokia') @else rowspan="2" @endif
                                                            style="vertical-align: middle;">Total</th>
                                                    @endif
                                                </tr>
                                                @if (session('asal') != 'Nokia')
                                                    <tr class="text-center"
                                                        style="background-color:gray; color:white;">
                                                        <th @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg') colspan="4" @endif>
                                                            Retail</th>
                                                        @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg')
                                                            <th class="minColumnWidth" rowspan="2"
                                                                style="vertical-align: middle;">Total</th>
                                                        @endif
                                                        <th @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg') colspan="3" @endif>
                                                            Premium</th>
                                                        @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg')
                                                            <th class="minColumnWidth" rowspan="2"
                                                                style="vertical-align: middle;">Total</th>
                                                        @endif

                                                        @if (session('asal') != 'Nokia')
                                                            <th @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg') colspan="4" @endif>
                                                                Retail</th>
                                                        @endif
                                                        @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg')
                                                            <th class="minColumnWidth" rowspan="2"
                                                                style="vertical-align: middle;">Total</th>
                                                        @endif
                                                        @if (session('asal') != 'Nokia')
                                                            <th @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg') colspan="3" @endif>
                                                                Premium</th>
                                                        @endif
                                                        @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg')
                                                            <th class="minColumnWidth" rowspan="2"
                                                                style="vertical-align: middle;">Total</th>
                                                        @endif

                                                        <th @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg') colspan="4" @endif>
                                                            Retail</th>
                                                        <th @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg') colspan="3" @endif>
                                                            Premium</th>
                                                    </tr>
                                                @endif
                                                @if (session('asal') != 'Nokia')
                                                    <tr class="text-center"
                                                        style="max-width:70px; background-color:gray; color:white;">
                                                        @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg')
                                                            <th class="minColumnWidth">FH</th>
                                                            <th class="minColumnWidth">HW</th>
                                                            <th class="minColumnWidth">ZTE</th>
                                                            <th class="minColumnWidth">ALU</th>

                                                            <th class="minColumnWidth">FH</th>
                                                            <th class="minColumnWidth">HW</th>
                                                            <th class="minColumnWidth">ZTE</th>
                                                        @endif

                                                        @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg')
                                                            <th class="minColumnWidth">FH</th>
                                                            <th class="minColumnWidth">HW</th>
                                                            <th class="minColumnWidth">ZTE</th>
                                                            <th class="minColumnWidth">ALU</th>

                                                            <th class="minColumnWidth">FH</th>
                                                            <th class="minColumnWidth">HW</th>
                                                            <th class="minColumnWidth">ZTE</th>
                                                        @endif

                                                        @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg')
                                                            <th class="minColumnWidth">FH</th>
                                                            <th class="minColumnWidth">HW</th>
                                                            <th class="minColumnWidth">ZTE</th>
                                                            <th class="minColumnWidth">ALU</th>

                                                            <th class="minColumnWidth">FH</th>
                                                            <th class="minColumnWidth">HW</th>
                                                            <th class="minColumnWidth">ZTE</th>
                                                        @endif

                                                        @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg')
                                                            <th class="minColumnWidth">FH</th>
                                                            <th class="minColumnWidth">HW</th>
                                                            <th class="minColumnWidth">ZTE</th>
                                                            <th class="minColumnWidth">ALU</th>

                                                            <th class="minColumnWidth">FH</th>
                                                            <th class="minColumnWidth">HW</th>
                                                            <th class="minColumnWidth">ZTE</th>
                                                        @endif

                                                        @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg')
                                                            <th class="minColumnWidth">FH</th>
                                                            <th class="minColumnWidth">HW</th>
                                                            <th class="minColumnWidth">ZTE</th>
                                                            <th class="minColumnWidth">ALU</th>

                                                            <th class="minColumnWidth">FH</th>
                                                            <th class="minColumnWidth">HW</th>
                                                            <th class="minColumnWidth">ZTE</th>
                                                        @endif
                                                    </tr>
                                                @endif
                                            </thead>

                                            <tbody id="tableDetail-body">
                                                <?php $qty_kirim_retail_zte = 0; ?>
                                                <?php $qty_kirim_retail_fh = 0; ?>
                                                <?php $qty_kirim_retail_hw = 0; ?>
                                                <?php $qty_kirim_retail_alu = 0; ?>

                                                <?php $qty_kirim_premium_zte = 0; ?>
                                                <?php $qty_kirim_premium_fh = 0; ?>
                                                <?php $qty_kirim_premium_hw = 0; ?>
                                                <?php $total_qty_minimum = 0; ?>
                                                @foreach ($data['witel'] as $idx => $d)
                                                    <tr class="text-center">
                                                        <td value="" class="first-col sticky-col"
                                                            style="background-color:gray; color:white; max-width: 80px;">
                                                            @if ($data['jenis_warehouse'] == 'Witel' || $data['jenis_warehouse'] == 'TA SO')
                                                                <a style="text-decoration:none; color: white; font-weight: bold"
                                                                    <?php if (!str_contains($d->witel, 'REGIONAL')) {
                                                                        echo 'href="' . url('/rekap_delivery/') . '/' . $data['jenis_warehouse'] . '/' . $d->lokasi_wh;
                                                                    } ?>">{{ $d->lokasi_wh }}</a>
                                                            @else($data["jenis_warehouse"] == "Witel")
                                                                {{ $d->lokasi_wh }}
                                                            @endif
                                                        </td>
                                                        <td hidden>{{ $d->regional }}</td>
                                                        <td hidden>{{ $d->witel }}</td>
                                                        <td><?php if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg') {
                                                            $total_qty_minimum += $d->minimum_qty;
                                                            echo number_format((int) $d->minimum_qty, 0, ',', '.');
                                                        } elseif (session('asal') == 'Fiberhome') {
                                                            $total_qty_minimum += $d->retail_fh + $d->premium_fh;
                                                            echo number_format((int) $d->retail_fh + $d->premium_fh, 0, ',', '.');
                                                        } elseif (session('asal') == 'Huawei') {
                                                            $total_qty_minimum += $d->retail_hw + $d->premium_hw;
                                                            echo number_format((int) $d->retail_hw + $d->premium_hw, 0, ',', '.');
                                                        } elseif (session('asal') == 'ZTE') {
                                                            $total_qty_minimum += $d->retail_zte + $d->premium_zte;
                                                            echo number_format((int) $d->retail_zte + $d->premium_zte, 0, ',', '.');
                                                        } elseif (session('asal') == 'Nokia') {
                                                            $total_qty_minimum += $d->retail_alu;
                                                            echo number_format((int) $d->retail_alu, 0, ',', '.');
                                                        } ?>

                                                        </td>

                                                        <div class="text-center">
                                                            @if (session('asal') == 'Fiberhome' ||
                                                                    session('asal') == 'DID' ||
                                                                    session('jenis_akun') == 'sda' ||
                                                                    session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth"><?php echo number_format((int) $d->retail_stock_fiberhome, 0, ',', '.'); ?></td>
                                                            @endif
                                                            @if (session('asal') == 'Huawei' ||
                                                                    session('asal') == 'DID' ||
                                                                    session('jenis_akun') == 'sda' ||
                                                                    session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth"><?php echo number_format((int) $d->retail_stock_huawei, 0, ',', '.'); ?></td>
                                                            @endif
                                                            @if (session('asal') == 'ZTE' ||
                                                                    session('asal') == 'DID' ||
                                                                    session('jenis_akun') == 'sda' ||
                                                                    session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth"><?php echo number_format((int) $d->retail_stock_zte, 0, ',', '.'); ?></td>
                                                            @endif
                                                            @if (session('asal') == 'Nokia' ||
                                                                    session('asal') == 'DID' ||
                                                                    session('jenis_akun') == 'sda' ||
                                                                    session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth"><?php echo number_format((int) $d->retail_stock_nokia, 0, ',', '.'); ?></td>
                                                            @endif
                                                            @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth" style="max-width:90px">
                                                                    <?php echo number_format((int) $d->total_retail_stock, 0, ',', '.'); ?></td>
                                                            @endif

                                                            @if (session('asal') == 'Fiberhome' ||
                                                                    session('asal') == 'DID' ||
                                                                    session('jenis_akun') == 'sda' ||
                                                                    session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth"><?php echo number_format((int) $d->premium_stock_fiberhome, 0, ',', '.'); ?></td>
                                                            @endif
                                                            @if (session('asal') == 'Huawei' ||
                                                                    session('asal') == 'DID' ||
                                                                    session('jenis_akun') == 'sda' ||
                                                                    session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth"><?php echo number_format((int) $d->premium_stock_huawei, 0, ',', '.'); ?></td>
                                                            @endif
                                                            @if (session('asal') == 'ZTE' ||
                                                                    session('asal') == 'DID' ||
                                                                    session('jenis_akun') == 'sda' ||
                                                                    session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth"><?php echo number_format((int) $d->premium_stock_zte, 0, ',', '.'); ?></td>
                                                            @endif
                                                            @if (session('asal') == 'Nokia' ||
                                                                    session('asal') == 'DID' ||
                                                                    session('jenis_akun') == 'sda' ||
                                                                    session('jenis_akun') == 'treg')
                                                            @endif
                                                            @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth"><?php echo number_format((int) $d->total_premium_stock, 0, ',', '.'); ?></td>
                                                            @endif

                                                            @if (session('asal') == 'Fiberhome' ||
                                                                    session('asal') == 'DID' ||
                                                                    session('jenis_akun') == 'sda' ||
                                                                    session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth"
                                                                    style="min-width:50px; background-color: #77DD77; @if ($d->retail_stock_fiberhome - $d->retail_fh < -($d->retail_fh * 0.50)) background-color : red; color: white; @elseif($d->retail_stock_fiberhome - $d->retail_fh < 0) background-color: yellow; @endif">
                                                                    <?php echo number_format((int) $d->retail_stock_fiberhome - $d->retail_fh, 0, ',', '.'); ?></td>
                                                            @endif
                                                            @if (session('asal') == 'Huawei' ||
                                                                    session('asal') == 'DID' ||
                                                                    session('jenis_akun') == 'sda' ||
                                                                    session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth"
                                                                    style="min-width:50px; background-color: #77DD77; @if ($d->retail_stock_huawei - $d->retail_hw < -($d->retail_hw * 0.50)) background-color : red; color: white; @elseif($d->retail_stock_huawei - $d->retail_hw < 0) background-color: yellow; @endif ">
                                                                    <?php echo number_format((int) $d->retail_stock_huawei - $d->retail_hw, 0, ',', '.'); ?></td>
                                                            @endif
                                                            @if (session('asal') == 'ZTE' ||
                                                                    session('asal') == 'DID' ||
                                                                    session('jenis_akun') == 'sda' ||
                                                                    session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth"
                                                                    style="min-width:50px; background-color: #77DD77; @if ($d->retail_stock_zte - $d->retail_zte < -($d->retail_zte * 0.50)) background-color : red; color: white; @elseif($d->retail_stock_zte - $d->retail_zte < 0) background-color: yellow; @endif ">
                                                                    <?php echo number_format((int) $d->retail_stock_zte - $d->retail_zte, 0, ',', '.'); ?></td>
                                                            @endif
                                                            @if (session('asal') == 'Nokia' ||
                                                                    session('asal') == 'DID' ||
                                                                    session('jenis_akun') == 'sda' ||
                                                                    session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth"
                                                                    style="min-width:50px; background-color: #77DD77; @if ($d->retail_stock_nokia - $d->retail_alu < -($d->retail_alu * 0.50)) background-color : red; color: white; @elseif($d->retail_stock_nokia - $d->retail_alu < 0) background-color: yellow; @endif ">
                                                                    <?php echo number_format((int) $d->retail_stock_nokia - $d->retail_alu, 0, ',', '.'); ?></td>
                                                            @endif
                                                            @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth"
                                                                    style="min-width:50px; background-color: #77DD77; @if ($d->total_retail_stock - $d->total_retail < -($d->total_retail * 0.50)) background-color : red; color: white; @elseif($d->total_retail_stock - $d->total_retail < 0) background-color: yellow; @endif ">
                                                                    <?php echo number_format((int) $d->total_retail_stock - $d->total_retail, 0, ',', '.'); ?></td>
                                                            @endif

                                                            @if (session('asal') == 'Fiberhome' ||
                                                                    session('asal') == 'DID' ||
                                                                    session('jenis_akun') == 'sda' ||
                                                                    session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth"
                                                                    style="min-width:50px; background-color: #77DD77; @if ($d->premium_stock_fiberhome - $d->premium_fh < -($d->premium_fh * 0.50)) background-color : red; color: white; @elseif($d->premium_stock_fiberhome - $d->premium_fh < 0) background-color: yellow; @endif ">
                                                                    <?php echo number_format((int) $d->premium_stock_fiberhome - $d->premium_fh, 0, ',', '.'); ?> </td>
                                                            @endif
                                                            @if (session('asal') == 'Huawei' ||
                                                                    session('asal') == 'DID' ||
                                                                    session('jenis_akun') == 'sda' ||
                                                                    session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth"
                                                                    style="min-width:50px; background-color: #77DD77; @if ($d->premium_stock_huawei - $d->premium_hw < -($d->premium_hw * 0.50)) background-color : red; color: white; @elseif($d->premium_stock_huawei - $d->premium_hw < 0) background-color: yellow; @endif ">
                                                                    <?php echo number_format((int) $d->premium_stock_huawei - $d->premium_hw, 0, ',', '.'); ?> </td>
                                                            @endif
                                                            @if (session('asal') == 'ZTE' ||
                                                                    session('asal') == 'DID' ||
                                                                    session('jenis_akun') == 'sda' ||
                                                                    session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth"
                                                                    style="min-width:50px; background-color: #77DD77; @if ($d->premium_stock_zte - $d->premium_zte < -($d->premium_zte * 0.50)) background-color : red; color: white; @elseif($d->premium_stock_zte - $d->premium_zte < 0) background-color: yellow; @endif">
                                                                    <?php echo number_format((int) $d->premium_stock_zte - $d->premium_zte, 0, ',', '.'); ?></td>
                                                            @endif
                                                            @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth"
                                                                    style="min-width:50px; background-color: #77DD77; @if ($d->total_premium_stock - $d->total_premium < -($d->total_premium * 0.50)) background-color : red; color: white; @elseif($d->total_premium_stock - $d->total_premium < 0) background-color: yellow; @endif ">
                                                                    <?php echo number_format((int) $d->total_premium_stock - $d->total_premium, 0, ',', '.'); ?></td>
                                                            @endif

                                                            @if (session('asal') == 'Fiberhome' ||
                                                                    session('asal') == 'DID' ||
                                                                    session('jenis_akun') == 'sda' ||
                                                                    session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth">
                                                                    @if ($d->qty_kirim_retail_fh != 0)
                                                                        <?php echo number_format((int) $d->qty_kirim_retail_fh, 0, ',', '.'); ?><?php $qty_kirim_retail_fh += $d->qty_kirim_retail_fh; ?>
                                                                    @endif
                                                                </td>
                                                            @endif
                                                            @if (session('asal') == 'Huawei' ||
                                                                    session('asal') == 'DID' ||
                                                                    session('jenis_akun') == 'sda' ||
                                                                    session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth">
                                                                    @if ($d->qty_kirim_retail_hw != 0)
                                                                        <?php echo number_format((int) $d->qty_kirim_retail_hw, 0, ',', '.'); ?><?php $qty_kirim_retail_hw += $d->qty_kirim_retail_hw; ?>
                                                                    @endif
                                                                </td>
                                                            @endif
                                                            @if (session('asal') == 'ZTE' ||
                                                                    session('asal') == 'DID' ||
                                                                    session('jenis_akun') == 'sda' ||
                                                                    session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth">
                                                                    @if ($d->qty_kirim_retail_zte != 0)
                                                                        <?php echo number_format((int) $d->qty_kirim_retail_zte, 0, ',', '.'); ?><?php $qty_kirim_retail_zte += $d->qty_kirim_retail_zte; ?>
                                                                    @endif
                                                                </td>
                                                            @endif
                                                            @if (session('asal') == 'Nokia' ||
                                                                    session('asal') == 'DID' ||
                                                                    session('jenis_akun') == 'sda' ||
                                                                    session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth">
                                                                    @if ($d->qty_kirim_retail_alu != 0)
                                                                        <?php echo number_format((int) $d->qty_kirim_retail_alu, 0, ',', '.'); ?><?php $qty_kirim_retail_alu += $d->qty_kirim_retail_alu; ?>
                                                                    @endif
                                                                </td>
                                                            @endif

                                                            @if (session('asal') == 'Fiberhome' ||
                                                                    session('asal') == 'DID' ||
                                                                    session('jenis_akun') == 'sda' ||
                                                                    session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth">
                                                                    @if ($d->qty_kirim_premium_fh != 0)
                                                                        <?php echo number_format((int) $d->qty_kirim_premium_fh, 0, ',', '.'); ?><?php $qty_kirim_premium_fh += $d->qty_kirim_premium_fh; ?>
                                                                    @endif
                                                                </td>
                                                            @endif
                                                            @if (session('asal') == 'Huawei' ||
                                                                    session('asal') == 'DID' ||
                                                                    session('jenis_akun') == 'sda' ||
                                                                    session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth">
                                                                    @if ($d->qty_kirim_premium_hw != 0)
                                                                        <?php echo number_format((int) $d->qty_kirim_premium_hw, 0, ',', '.'); ?> <?php $qty_kirim_premium_hw += $d->qty_kirim_premium_hw; ?>
                                                                    @endif
                                                                </td>
                                                            @endif
                                                            @if (session('asal') == 'ZTE' ||
                                                                    session('asal') == 'DID' ||
                                                                    session('jenis_akun') == 'sda' ||
                                                                    session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth">
                                                                    @if ($d->qty_kirim_premium_zte != 0)
                                                                        <?php echo number_format((int) $d->qty_kirim_premium_zte, 0, ',', '.'); ?> <?php $qty_kirim_premium_zte += $d->qty_kirim_premium_zte; ?>
                                                                    @endif
                                                                </td>
                                                            @endif

                                                            @if (session('asal') == 'Fiberhome' ||
                                                                    session('asal') == 'DID' ||
                                                                    session('jenis_akun') == 'sda' ||
                                                                    session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth"><?php echo number_format((int) $d->retail_fh, 0, ',', '.'); ?></td>
                                                            @endif
                                                            @if (session('asal') == 'Huawei' ||
                                                                    session('asal') == 'DID' ||
                                                                    session('jenis_akun') == 'sda' ||
                                                                    session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth"><?php echo number_format((int) $d->retail_hw, 0, ',', '.'); ?></td>
                                                            @endif
                                                            @if (session('asal') == 'ZTE' ||
                                                                    session('asal') == 'DID' ||
                                                                    session('jenis_akun') == 'sda' ||
                                                                    session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth"><?php echo number_format((int) $d->retail_zte, 0, ',', '.'); ?></td>
                                                            @endif
                                                            @if (session('asal') == 'Nokia' ||
                                                                    session('asal') == 'DID' ||
                                                                    session('jenis_akun') == 'sda' ||
                                                                    session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth"><?php echo number_format((int) $d->retail_alu, 0, ',', '.'); ?></td>
                                                            @endif
                                                            @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth"><?php echo number_format((int) $d->total_retail, 0, ',', '.'); ?></td>
                                                            @endif

                                                            @if (session('asal') == 'Fiberhome' ||
                                                                    session('asal') == 'DID' ||
                                                                    session('jenis_akun') == 'sda' ||
                                                                    session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth"><?php echo number_format((int) $d->premium_fh, 0, ',', '.'); ?></td>
                                                            @endif
                                                            @if (session('asal') == 'Huawei' ||
                                                                    session('asal') == 'DID' ||
                                                                    session('jenis_akun') == 'sda' ||
                                                                    session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth"><?php echo number_format((int) $d->premium_hw, 0, ',', '.'); ?></td>
                                                            @endif
                                                            @if (session('asal') == 'ZTE' ||
                                                                    session('asal') == 'DID' ||
                                                                    session('jenis_akun') == 'sda' ||
                                                                    session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth"><?php echo number_format((int) $d->premium_zte, 0, ',', '.'); ?></td>
                                                            @endif
                                                            @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth"><?php echo number_format((int) $d->total_premium, 0, ',', '.'); ?></td>
                                                            @endif

                                                            @if (session('asal') == 'Fiberhome' ||
                                                                    session('asal') == 'DID' ||
                                                                    session('jenis_akun') == 'sda' ||
                                                                    session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth"><?php echo number_format((int) $d->on_delivery_retail_fiberhome, 0, ',', '.'); ?></td>
                                                            @endif
                                                            @if (session('asal') == 'Huawei' ||
                                                                    session('asal') == 'DID' ||
                                                                    session('jenis_akun') == 'sda' ||
                                                                    session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth"><?php echo number_format((int) $d->on_delivery_retail_huawei, 0, ',', '.'); ?></td>
                                                            @endif
                                                            @if (session('asal') == 'ZTE' ||
                                                                    session('asal') == 'DID' ||
                                                                    session('jenis_akun') == 'sda' ||
                                                                    session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth"><?php echo number_format((int) $d->on_delivery_retail_zte, 0, ',', '.'); ?></td>
                                                            @endif
                                                            @if (session('asal') == 'Nokia' ||
                                                                    session('asal') == 'DID' ||
                                                                    session('jenis_akun') == 'sda' ||
                                                                    session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth"><?php echo number_format((int) $d->on_delivery_retail_nokia, 0, ',', '.'); ?></td>
                                                            @endif
                                                            @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth"><?php echo number_format((int) $d->on_delivery_total_retail, 0, ',', '.'); ?></td>
                                                            @endif

                                                            @if (session('asal') == 'Fiberhome' ||
                                                                    session('asal') == 'DID' ||
                                                                    session('jenis_akun') == 'sda' ||
                                                                    session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth"><?php echo number_format((int) $d->on_delivery_premium_fiberhome, 0, ',', '.'); ?></td>
                                                            @endif
                                                            @if (session('asal') == 'Huawei' ||
                                                                    session('asal') == 'DID' ||
                                                                    session('jenis_akun') == 'sda' ||
                                                                    session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth"><?php echo number_format((int) $d->on_delivery_premium_huawei, 0, ',', '.'); ?></td>
                                                            @endif
                                                            @if (session('asal') == 'ZTE' ||
                                                                    session('asal') == 'DID' ||
                                                                    session('jenis_akun') == 'sda' ||
                                                                    session('jenis_akun') == 'treg')
                                                                <td class="minColumnWidth"><?php echo number_format((int) $d->on_delivery_premium_zte, 0, ',', '.'); ?></td>
                                                            @endif
                                                            @if (session('asal') == 'DID' || session('jenis_akun') == 'treg' || session('jenis_akun') == 'sda')
                                                                <td class="minColumnWidth"><?php echo number_format((int) $d->on_delivery_total_premium, 0, ',', '.'); ?></td>
                                                            @endif
                                                        </div>
                                                    </tr>
                                                @endforeach

                                                <!--<tr> -->
                                                <!--<td class="minColumnWidth">Total</td>-->
                                                <!--<td class="minColumnWidth" hidden></td>-->
                                                <!--<td class="minColumnWidth" hidden></td>-->
                                                <!--<td class="minColumnWidth">34765</td>-->
                                                <!--<td class="minColumnWidth" colspan="28"></td>-->
                                                <!--</tr>-->
                                                <tr class="font-weight-bold text-center"
                                                    style="background-color:gray; color:white;">
                                                    <td value="" class="sticky-col first-col text-center"
                                                        style="background-color:gray; color:white; max-width:80px">
                                                        <div hidden>Z</div>Total
                                                    </td>
                                                    <td class="minColumnWidth" hidden></td>
                                                    <td class="minColumnWidth" hidden></td>
                                                    <td class="minColumnWidth"><?php echo number_format((int) $total_qty_minimum, 0, ',', '.'); ?></td>

                                                    <div class="text-center">
                                                        @if (session('asal') == 'Fiberhome' ||
                                                                session('asal') == 'DID' ||
                                                                session('jenis_akun') == 'sda' ||
                                                                session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_retail_stock_fh'], 0, ',', '.'); ?></td>
                                                        @endif
                                                        @if (session('asal') == 'Huawei' ||
                                                                session('asal') == 'DID' ||
                                                                session('jenis_akun') == 'sda' ||
                                                                session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_retail_stock_hw'], 0, ',', '.'); ?></td>
                                                        @endif
                                                        @if (session('asal') == 'ZTE' ||
                                                                session('asal') == 'DID' ||
                                                                session('jenis_akun') == 'sda' ||
                                                                session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_retail_stock_zte'], 0, ',', '.'); ?></td>
                                                        @endif
                                                        @if (session('asal') == 'Nokia' ||
                                                                session('asal') == 'DID' ||
                                                                session('jenis_akun') == 'sda' ||
                                                                session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_retail_stock_alu'], 0, ',', '.'); ?></td>
                                                        @endif
                                                        @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_retail_stock_all'], 0, ',', '.'); ?></td>
                                                        @endif

                                                        @if (session('asal') == 'Fiberhome' ||
                                                                session('asal') == 'DID' ||
                                                                session('jenis_akun') == 'sda' ||
                                                                session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_premium_stock_fh'], 0, ',', '.'); ?></td>
                                                        @endif
                                                        @if (session('asal') == 'Huawei' ||
                                                                session('asal') == 'DID' ||
                                                                session('jenis_akun') == 'sda' ||
                                                                session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_premium_stock_hw'], 0, ',', '.'); ?></td>
                                                        @endif
                                                        @if (session('asal') == 'ZTE' ||
                                                                session('asal') == 'DID' ||
                                                                session('jenis_akun') == 'sda' ||
                                                                session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_premium_stock_zte'], 0, ',', '.'); ?></td>
                                                        @endif
                                                        @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_premium_stock_all'], 0, ',', '.'); ?></td>
                                                        @endif

                                                        @if (session('asal') == 'Fiberhome' ||
                                                                session('asal') == 'DID' ||
                                                                session('jenis_akun') == 'sda' ||
                                                                session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_gap_retail_stock_fh'], 0, ',', '.'); ?></td>
                                                        @endif
                                                        @if (session('asal') == 'Huawei' ||
                                                                session('asal') == 'DID' ||
                                                                session('jenis_akun') == 'sda' ||
                                                                session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_gap_retail_stock_hw'], 0, ',', '.'); ?></td>
                                                        @endif
                                                        @if (session('asal') == 'ZTE' ||
                                                                session('asal') == 'DID' ||
                                                                session('jenis_akun') == 'sda' ||
                                                                session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_gap_retail_stock_zte'], 0, ',', '.'); ?></td>
                                                        @endif
                                                        @if (session('asal') == 'Nokia' ||
                                                                session('asal') == 'DID' ||
                                                                session('jenis_akun') == 'sda' ||
                                                                session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_gap_retail_stock_alu'], 0, ',', '.'); ?></td>
                                                        @endif
                                                        @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_gap_stock_retail'], 0, ',', '.'); ?></td>
                                                        @endif

                                                        @if (session('asal') == 'Fiberhome' ||
                                                                session('asal') == 'DID' ||
                                                                session('jenis_akun') == 'sda' ||
                                                                session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_gap_premium_stock_fh'], 0, ',', '.'); ?></td>
                                                        @endif
                                                        @if (session('asal') == 'Huawei' ||
                                                                session('asal') == 'DID' ||
                                                                session('jenis_akun') == 'sda' ||
                                                                session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_gap_premium_stock_hw'], 0, ',', '.'); ?></td>
                                                        @endif
                                                        @if (session('asal') == 'ZTE' ||
                                                                session('asal') == 'DID' ||
                                                                session('jenis_akun') == 'sda' ||
                                                                session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_gap_premium_stock_zte'], 0, ',', '.'); ?></td>
                                                        @endif
                                                        @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_gap_premium_stock'], 0, ',', '.'); ?></td>
                                                        @endif

                                                        @if (session('asal') == 'Fiberhome' ||
                                                                session('asal') == 'DID' ||
                                                                session('jenis_akun') == 'sda' ||
                                                                session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth">{{ $qty_kirim_retail_fh }}</td>
                                                        @endif
                                                        @if (session('asal') == 'Huawei' ||
                                                                session('asal') == 'DID' ||
                                                                session('jenis_akun') == 'sda' ||
                                                                session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth">{{ $qty_kirim_retail_hw }}</td>
                                                        @endif
                                                        @if (session('asal') == 'ZTE' ||
                                                                session('asal') == 'DID' ||
                                                                session('jenis_akun') == 'sda' ||
                                                                session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth">{{ $qty_kirim_retail_zte }}
                                                            </td>
                                                        @endif
                                                        @if (session('asal') == 'Nokia' ||
                                                                session('asal') == 'DID' ||
                                                                session('jenis_akun') == 'sda' ||
                                                                session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth">{{ $qty_kirim_retail_alu }}
                                                            </td>
                                                        @endif

                                                        @if (session('asal') == 'Fiberhome' ||
                                                                session('asal') == 'DID' ||
                                                                session('jenis_akun') == 'sda' ||
                                                                session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth">{{ $qty_kirim_premium_fh }}
                                                            </td>
                                                        @endif
                                                        @if (session('asal') == 'Huawei' ||
                                                                session('asal') == 'DID' ||
                                                                session('jenis_akun') == 'sda' ||
                                                                session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth">{{ $qty_kirim_premium_hw }}
                                                            </td>
                                                        @endif
                                                        @if (session('asal') == 'ZTE' ||
                                                                session('asal') == 'DID' ||
                                                                session('jenis_akun') == 'sda' ||
                                                                session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth">{{ $qty_kirim_premium_zte }}
                                                            </td>
                                                        @endif

                                                        @if (session('asal') == 'Fiberhome' ||
                                                                session('asal') == 'DID' ||
                                                                session('jenis_akun') == 'sda' ||
                                                                session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_retail_fh_minimum'], 0, ',', '.'); ?></td>
                                                        @endif
                                                        @if (session('asal') == 'Huawei' ||
                                                                session('asal') == 'DID' ||
                                                                session('jenis_akun') == 'sda' ||
                                                                session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_retail_hw_minimum'], 0, ',', '.'); ?></td>
                                                        @endif
                                                        @if (session('asal') == 'ZTE' ||
                                                                session('asal') == 'DID' ||
                                                                session('jenis_akun') == 'sda' ||
                                                                session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_retail_zte_minimum'], 0, ',', '.'); ?></td>
                                                        @endif
                                                        @if (session('asal') == 'Nokia' ||
                                                                session('asal') == 'DID' ||
                                                                session('jenis_akun') == 'sda' ||
                                                                session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_retail_alu_minimum'], 0, ',', '.'); ?></td>
                                                        @endif
                                                        @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_retail_minimum'], 0, ',', '.'); ?></td>
                                                        @endif

                                                        @if (session('asal') == 'Fiberhome' ||
                                                                session('asal') == 'DID' ||
                                                                session('jenis_akun') == 'sda' ||
                                                                session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_premium_fh_minimum'], 0, ',', '.'); ?></td>
                                                        @endif
                                                        @if (session('asal') == 'Huawei' ||
                                                                session('asal') == 'DID' ||
                                                                session('jenis_akun') == 'sda' ||
                                                                session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_premium_hw_minimum'], 0, ',', '.'); ?></td>
                                                        @endif
                                                        @if (session('asal') == 'ZTE' ||
                                                                session('asal') == 'DID' ||
                                                                session('jenis_akun') == 'sda' ||
                                                                session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_premium_zte_minimum'], 0, ',', '.'); ?></td>
                                                        @endif
                                                        @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_premium_minimum'], 0, ',', '.'); ?></td>
                                                        @endif

                                                        @if (session('asal') == 'Fiberhome' ||
                                                                session('asal') == 'DID' ||
                                                                session('jenis_akun') == 'sda' ||
                                                                session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_on_delivery_retail_fiberhome'], 0, ',', '.'); ?></td>
                                                        @endif
                                                        @if (session('asal') == 'Huawei' ||
                                                                session('asal') == 'DID' ||
                                                                session('jenis_akun') == 'sda' ||
                                                                session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_on_delivery_retail_huawei'], 0, ',', '.'); ?></td>
                                                        @endif
                                                        @if (session('asal') == 'ZTE' ||
                                                                session('asal') == 'DID' ||
                                                                session('jenis_akun') == 'sda' ||
                                                                session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_on_delivery_retail_zte'], 0, ',', '.'); ?></td>
                                                        @endif
                                                        @if (session('asal') == 'Nokia' ||
                                                                session('asal') == 'DID' ||
                                                                session('jenis_akun') == 'sda' ||
                                                                session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_on_delivery_retail_nokia'], 0, ',', '.'); ?></td>
                                                        @endif
                                                        @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_on_delivery_retail_all'], 0, ',', '.'); ?></td>
                                                        @endif

                                                        @if (session('asal') == 'Fiberhome' ||
                                                                session('asal') == 'DID' ||
                                                                session('jenis_akun') == 'sda' ||
                                                                session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_on_delivery_premium_fiberhome'], 0, ',', '.'); ?></td>
                                                        @endif
                                                        @if (session('asal') == 'Huawei' ||
                                                                session('asal') == 'DID' ||
                                                                session('jenis_akun') == 'sda' ||
                                                                session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_on_delivery_premium_huawei'], 0, ',', '.'); ?></td>
                                                        @endif
                                                        @if (session('asal') == 'ZTE' ||
                                                                session('asal') == 'DID' ||
                                                                session('jenis_akun') == 'sda' ||
                                                                session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_on_delivery_premium_zte'], 0, ',', '.'); ?></td>
                                                        @endif
                                                        @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg')
                                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_on_delivery_premium_all'], 0, ',', '.'); ?></td>
                                                        @endif
                                                    </div>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Inventory Modal-->
        <div class="modal fade" id="onDeliveryModal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header--sticky">
                        <div class="row">
                            <div class="col-12">
                                <h5 class="modal-title">On Delivery</h5>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body" id="modal-body">
                    </div>
                    <div class="modal-footer--sticky">
                        <div class="ml-auto">

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" id="asalSession" data-value="{{ session('asal') }}" />
        <input type="hidden" id="jenisAkunSession" data-value="{{ session('jenis_akun') }}" />
</body>
<script>
    all_witel = <?php echo json_encode($data['all_witel']); ?>;
    jenis_warehouse = <?php echo json_encode($data['jenis_warehouse']); ?>;
    witel = <?php echo json_encode($data['witel']); ?>;

    var asalSession = $("#asalSession").data('value');
    var jenisAkunSession = $("#jenisAkunSession").data('value');

    VirtualSelect.init({
        ele: '#select-filter',
        search: true,
        searchGroup: false, // Include group title for searching
        searchByStartsWith: false, // Search options by startsWith() method
    });

    table = $("#filterTable").dataTable({
        "searching": true,
        "scrollX": true,
        "bPaginate": false,
        "ordering": false,
        "fnInfoCallback": function(oSettings, iStart, iEnd, iMax, iTotal, sPre) {
            return "Showing " + iStart + " to " + iEnd + " of " + iMax +
                " entries <a class='btn btn-primary' onClick='showTableDetail()'>View Detail</a>";
        }
    });

    table = $('#filterTable').DataTable();
    table.columns(1).visible(false);
    table.columns(2).visible(false);
    table.columns(3).visible(false);

    document.querySelector('#select-filter').addEventListener('change', function() {
        changeTableContent(this.value);
        changeTableDetailContent(this.value);
    });

    function changeTableContent(arr_val) {
        var pathURL = window.location.pathname;
        var boolRootURL = true;

        if(pathURL.includes("Witel"))
        {
            boolRootURL = false;
        }

        arr_val = arr_val.sort(function(a, b) {
            return a - b
        })

        $('#tableBiasa-body').html('');

        total_retail = 0;
        total_premium = 0;

        total_gap_retail = 0;
        total_gap_premium = 0;

        total_retail_stock = 0;
        total_premium_stock = 0;

        total_qty_kirim_retail = 0;
        total_qty_kirim_premium = 0;

        total_on_delivery_retail = 0;
        total_on_delivery_premium = 0;

        html = ''
        for (var i = 0; i < arr_val.length; i++) {
            html += "<tr>"

            obj_val = all_witel.find((element) => element.id == arr_val[i]);
            if (arr_val[i].includes("TREG")) {
                obj_val = all_witel.find((element) => element.lokasi_wh == arr_val[i]);
            }

            html += "<td class='first-col sticky-col text-center'>" + obj_val.lokasi_wh + "</td>"
            html += "<td hidden>" + obj_val.regional + "</td>"
            html += "<td hidden>" + obj_val.witel + "</td>"
            html += "<td hidden>" + obj_val.minimum_qty + "</td>"

            html += "<td>" + obj_val.total_retail_stock + "</td>"
            html += "<td>" + obj_val.total_premium_stock + "</td>"

            html += "<td";
            if (obj_val.total_retail_stock - obj_val.total_retail < -(obj_val.total_retail * 0.50)) {
                if (boolRootURL && (obj_val.retail_stock_fiberhome - obj_val.retail_fh < -(obj_val.retail_fh * 0.50) || obj_val.retail_stock_huawei - obj_val.retail_hw < -(obj_val.retail_hw * 0.50) || obj_val.retail_stock_zte - obj_val.retail_zte < -(obj_val.retail_zte * 0.50) || obj_val.retail_stock_nokia - obj_val.retail_alu < -(obj_val.retail_alu * 0.50)))
                {
                    html += " class='blink-red'";
                }
                else{
                    html += " class='blink-red'";
                }
            } else if (obj_val.total_retail_stock - obj_val.total_retail < 0) {
                if(boolRootURL && (obj_val.retail_stock_fiberhome - obj_val.retail_fh < -(obj_val.retail_fh * 0.50) || obj_val.retail_stock_huawei - obj_val.retail_hw < -(obj_val.retail_hw * 0.50) || obj_val.retail_stock_zte - obj_val.retail_zte < -(obj_val.retail_zte * 0.50) || obj_val.retail_stock_nokia - obj_val.retail_alu < -(obj_val.retail_alu * 0.50)))
                {
                    html += " class='blink-yellow'";
                }
                else{
                    html += " class='bgc-yellow'";
                }
            } else {
                if (boolRootURL && (obj_val.retail_stock_fiberhome - obj_val.retail_fh < -(obj_val.retail_fh * 0.50) || obj_val.retail_stock_huawei - obj_val.retail_hw < -(obj_val.retail_hw * 0.50) || obj_val.retail_stock_zte - obj_val.retail_zte < -(obj_val.retail_zte * 0.50) || obj_val.retail_stock_nokia - obj_val.retail_alu < -(obj_val.retail_alu * 0.50)))
                {
                    html += " class='blink-green'";
                }
                else{
                    html += " class='bgc-green'";
                }
            }

            html += "> " + (obj_val.total_retail_stock - obj_val.total_retail) + "</td>";

            html += "<td "
            if (obj_val.total_premium_stock - obj_val.total_premium < -(obj_val.total_premium * 0.50)) {
                if(boolRootURL && (obj_val.premium_stock_fiberhome - obj_val.premium_fh < -(obj_val.premium_fh * 0.50) || obj_val.premium_stock_huawei - obj_val.premium_hw < -(obj_val.premium_hw * 0.50) || obj_val.premium_stock_zte - obj_val.premium_zte < -(obj_val.premium_zte * 0.50)))
                {
                    html += " class='blink-red'";
                }
                else{
                    html += " class='blink-red'";
                }
            } else if (obj_val.total_premium_stock - obj_val.total_premium < 0) {
                if(boolRootURL && (obj_val.premium_stock_fiberhome - obj_val.premium_fh < -(obj_val.premium_fh * 0.50) || obj_val.premium_stock_huawei - obj_val.premium_hw < -(obj_val.premium_hw * 0.50) || obj_val.premium_stock_zte - obj_val.premium_zte < -(obj_val.premium_zte * 0.50)))
                {
                    html += " class='blink-yellow'";
                }
                else{
                    html += " class='bgc-yellow'";
                }
            } else {
                if(boolRootURL && (obj_val.premium_stock_fiberhome - obj_val.premium_fh < -(obj_val.premium_fh * 0.50) || obj_val.premium_stock_huawei - obj_val.premium_hw < -(obj_val.premium_hw * 0.50) || obj_val.premium_stock_zte - obj_val.premium_zte < -(obj_val.premium_zte * 0.50)))
                {
                    html += " class='blink-green'";
                }
                else{
                    html += " class='bgc-green'";
                }
            }
            html += "> " + (obj_val.total_premium_stock - obj_val.total_premium) + "</td>"

            html += "<td>"
            if (obj_val.qty_kirim_retail_alu + obj_val.qty_kirim_retail_fh + obj_val.qty_kirim_retail_hw + obj_val
                .qty_kirim_retail_zte != 0) {
                html += (obj_val.qty_kirim_retail_alu + obj_val.qty_kirim_retail_fh + obj_val.qty_kirim_retail_hw +
                    obj_val.qty_kirim_retail_zte)
            }
            html += "</td><td>"
            if (obj_val.qty_kirim_premium_fh + obj_val.qty_kirim_premium_hw + obj_val.qty_kirim_premium_zte != 0) {
                html += (obj_val.qty_kirim_premium_fh + obj_val.qty_kirim_premium_hw + obj_val.qty_kirim_premium_zte)
            }
            html += "</td>"


            html += "<td>" + obj_val.total_retail + "</td>"
            html += "<td>" + obj_val.total_premium + "</td>"

            html += "<td>" + obj_val.on_delivery_total_retail + "</td>"
            html += "<td>" + obj_val.on_delivery_total_premium + "</td>"

            html += "</tr>"


            total_retail += obj_val.total_retail;
            total_premium += obj_val.total_premium;

            total_gap_retail += obj_val.total_retail_stock - obj_val.total_retail;
            total_gap_premium += obj_val.total_premium_stock - obj_val.total_premium;

            total_retail_stock += obj_val.total_retail_stock;
            total_premium_stock += obj_val.total_premium_stock;

            total_qty_kirim_retail += obj_val.qty_kirim_retail_fh + obj_val.qty_kirim_retail_hw + obj_val
                .qty_kirim_retail_alu + obj_val.qty_kirim_retail_zte;
            total_qty_kirim_premium += obj_val.qty_kirim_premium_fh + obj_val.qty_kirim_premium_hw + obj_val
                .qty_kirim_premium_zte;

            total_on_delivery_retail += obj_val.on_delivery_total_retail;
            total_on_delivery_premium += obj_val.on_delivery_total_premium;
        }

        html += "<td class='first-col sticky-col text-center'>Total</td>"
        html += "<td hidden></td>"
        html += "<td hidden></td>"
        html += "<td hidden></td>"

        html += "<td class='grey-col'>" + total_retail_stock + "</td>"
        html += "<td class='grey-col'>" + total_premium_stock + "</td>"

        html += "<td class='grey-col'>" + total_gap_retail + "</td>"
        html += "<td class='grey-col'>" + total_gap_premium + "</td>"

        html += "<td class='grey-col'>" + total_qty_kirim_retail + "</td>"
        html += "<td class='grey-col'>" + total_qty_kirim_premium + "</td>"

        html += "<td class='grey-col'>" + total_retail + "</td>"
        html += "<td class='grey-col'>" + total_premium + "</td>"

        html += "<td class='grey-col'>" + total_on_delivery_retail + "</td>"
        html += "<td class='grey-col'>" + total_on_delivery_premium + "</td>"

        html += "</tr>"

        $('#tableBiasa-body').html(html);
    }

    function changeTableDetailContent(arr_val) {
        $('#tableDetail-body').html('');

        total_qty_minimum = Number(0);
        qty_kirim_retail_fh = 0;
        qty_kirim_retail_hw = 0;
        qty_kirim_retail_zte = 0;
        qty_kirim_retail_alu = 0;

        qty_kirim_premium_fh = 0;
        qty_kirim_premium_zte = 0;
        qty_kirim_premium_hw = 0;

        total_retail_stock_fh = 0;
        total_retail_stock_hw = 0;
        total_retail_stock_zte = 0;
        total_retail_stock_alu = 0;
        total_retail_stock = 0;

        total_premium_stock_fh = 0;
        total_premium_stock_zte = 0;
        total_premium_stock_hw = 0;
        total_premium_stock = 0;

        total_gap_retail_stock_fh = 0;
        total_gap_retail_stock_alu = 0;
        total_gap_retail_stock_hw = 0;
        total_gap_retail_stock_zte = 0;
        total_gap_retail_stock = 0;

        total_gap_premium_stock_fh = 0;
        total_gap_premium_stock_hw = 0;
        total_gap_premium_stock_zte = 0;
        total_gap_premium_stock = 0;

        total_retail_minimum_fh = 0;
        total_retail_minimum_hw = 0;
        total_retail_minimum_zte = 0;
        total_retail_minimum_alu = 0;
        total_retail_minimum = 0;

        total_premium_minimum_fh = 0;
        total_premium_minimum_hw = 0;
        total_premium_minimum_zte = 0;
        total_premium_minimum = 0;

        total_on_delivery_retail_fh = 0;
        total_on_delivery_retail_hw = 0;
        total_on_delivery_retail_zte = 0;
        total_on_delivery_retail_alu = 0;
        total_on_delivery_retail = 0;

        total_on_delivery_premium_fh = 0;
        total_on_delivery_premium_hw = 0;
        total_on_delivery_premium_zte = 0;
        total_on_delivery_premium = 0;

        html = ''
        for (var i = 0; i < arr_val.length; i++) {
            html += "<tr>"
            obj_val = all_witel.find((element) => element.id == arr_val[i]);
            if (arr_val[i].includes("TREG")) {
                obj_val = all_witel.find((element) => element.lokasi_wh == arr_val[i]);
            }

            html +=
                '<td value="" class="first-col sticky-col" style="background-color:gray; color:white; max-width: 80px;">'
            if (jenis_warehouse == "Witel" || jenis_warehouse == "TA SO") {
                html += '<a style="text-decoration:none; color: white; font-weight: bold"'
                if (!obj_val.witel.includes("REGIONAL")) {
                    html += 'href="'
                    html += '{{ url('/rekap_delivery/') }}'
                    html += '/' + jenis_warehouse + '/' + obj_val.lokasi_wh + '" >' + obj_val.lokasi_wh + '</a>';
                }
            } else if ($data["jenis_warehouse"] == "Witel") {
                html += obj_val.lokasi_wh
            }
            html += '</td>'

            html += '<td hidden>' + obj_val.regional + '</td><td hidden>' + obj_val.witel + '</td>'

            html += '<td>'
            if (asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession == "treg") {
                total_qty_minimum += Number(obj_val.minimum_qty);
                html += obj_val.minimum_qty;
            } else if (asalSession == "Fiberhome") {
                total_qty_minimum += Number(obj_val.retail_fh + obj_val.premium_fh);
                html += obj_val.retail_fh + obj_val.premium_fh;
            } else if (asalSession == "Huawei") {
                total_qty_minimum += Number(obj_val.retail_hw + obj_val.premium_hw);
                html += obj_val.retail_hw + obj_val.premium_hw;
            } else if (asalSession == "ZTE") {
                total_qty_minimum += Number(obj_val.retail_zte + obj_val.premium_zte);
                html += obj_val.retail_zte + obj_val.premium_zte;
            } else if (asalSession == "Nokia") {
                total_qty_minimum += Number(obj_val.retail_alu);
                html += obj_val.retail_alu;
            }

            html += '</td>'

            html += '<div class="text-center">'

            if (asalSession == "Fiberhome" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
                "treg") {
                html += '<td class="minColumnWidth" >' + obj_val.retail_stock_fiberhome + '</td>'
                total_retail_stock_fh += Number(obj_val.retail_stock_fiberhome);
            }
            if (asalSession == "Huawei" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
                "treg") {
                html += '<td class="minColumnWidth" >' + obj_val.retail_stock_huawei + '</td>'
                total_retail_stock_hw += Number(obj_val.retail_stock_huawei);
            }
            if (asalSession == "ZTE" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
                "treg") {
                html += '<td class="minColumnWidth" >' + obj_val.retail_stock_zte + '</td>'
                total_retail_stock_zte += Number(obj_val.retail_stock_zte);
            }
            if (asalSession == "Nokia" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
                "treg") {
                html += '<td class="minColumnWidth" >' + obj_val.retail_stock_nokia + '</td>'
                total_retail_stock_alu += Number(obj_val.retail_stock_nokia);
            }
            if (asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession == "treg") {
                html += '<td class="minColumnWidth" style="max-width:90px">' + obj_val.total_retail_stock + '</td>'
                total_retail_stock += Number(obj_val.total_retail_stock);
            }

            if (asalSession == "Fiberhome" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
                "treg") {
                html += '<td class="minColumnWidth" >' + obj_val.premium_stock_fiberhome + '</td>'
                total_premium_stock_fh += Number(obj_val.premium_stock_fiberhome);
            }
            if (asalSession == "Huawei" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
                "treg") {
                html += '<td class="minColumnWidth" >' + obj_val.premium_stock_huawei + '</td>'
                total_premium_stock_hw += Number(obj_val.premium_stock_huawei);
            }
            if (asalSession == "ZTE" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
                "treg") {
                html += '<td class="minColumnWidth" >' + obj_val.premium_stock_zte + '</td>'
                total_premium_stock_zte += Number(obj_val.premium_stock_zte);
            }
            if (asalSession == "Nokia" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
                "treg") {}
            if (asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession == "treg") {
                html += '<td class="minColumnWidth" >' + obj_val.total_premium_stock + '</td>'
                total_premium_stock += Number(obj_val.total_premium_stock);
            }

            if (asalSession == "Fiberhome" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
                "treg") {
                html += '<td class="minColumnWidth" style="min-width:50px; background-color: #77DD77;'
                if (obj_val.retail_stock_fiberhome - obj_val.retail_fh < -(obj_val.retail_fh * 0.50)) {
                    html += 'background-color : totared; color: white;'
                } else if (obj_val.total_retail_stock - obj_val.retail_hw < 0) {
                    html += 'background-color: yellow;'
                }
                html += '">' + (obj_val.retail_stock_fiberhome - obj_val.retail_fh) + '</td>'
                total_gap_retail_stock_fh += Number(obj_val.retail_stock_fiberhome - obj_val.retail_fh);
            }

            if (asalSession == "Huawei" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
                "treg") {
                html += '<td class="minColumnWidth" style="min-width:50px; background-color: #77DD77;'
                if (obj_val.retail_stock_huawei - obj_val.retail_hw < -(obj_val.retail_hw * 0.50)) {
                    html += 'background-color : red; color: white;'
                } else if (obj_val.retail_stock_huawei - obj_val.retail_hw < 0) {
                    html += 'background-color: yellow;'
                }
                html += '">' + (obj_val.retail_stock_huawei - obj_val.retail_hw) + '</td>'
                total_gap_retail_stock_hw += Number(obj_val.retail_stock_huawei - obj_val.retail_hw);
            }

            if (asalSession == "ZTE" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
                "treg") {
                html += '<td class="minColumnWidth" style="min-width:50px; background-color: #77DD77;'
                if (obj_val.retail_stock_zte - obj_val.retail_zte < -(obj_val.retail_zte * 0.50)) {
                    html += 'background-color : red; color: white;'
                } else if (obj_val.retail_stock_zte - obj_val.retail_zte < 0) {
                    html += 'background-color: yellow;'
                }
                html += '">' + (obj_val.retail_stock_zte - obj_val.retail_zte) + '</td>'
                total_gap_retail_stock_zte += Number(obj_val.retail_stock_zte - obj_val.retail_zte);
            }
            if (asalSession == "Nokia" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
                "treg") {
                html += '<td class="minColumnWidth" style="min-width:50px; background-color: #77DD77;'
                if (obj_val.retail_stock_nokia - obj_val.retail_alu < -(obj_val.retail_alu * 0.50)) {
                    html += 'background-color : red; color: white;'
                } else if (obj_val.retail_stock_nokia - obj_val.retail_alu < 0) {
                    html += 'background-color: yellow;'
                }
                html += '">' + (obj_val.retail_stock_nokia - obj_val.retail_alu) + '</td>'
                total_gap_retail_stock_alu += Number(obj_val.retail_stock_nokia - obj_val.retail_alu);
            }
            if (asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession == "treg") {
                html += '<td class="minColumnWidth" style="min-width:50px; background-color: #77DD77;'
                if (obj_val.total_retail_stock - obj_val.total_retail < -(obj_val.total_retail * 0.50)) {
                    html += 'background-color : red; color: white;'
                } else if (obj_val.total_retail_stock - obj_val.total_retail < 0) {
                    html += 'background-color: yellow;'
                }
                html += '">' + (obj_val.total_retail_stock - obj_val.total_retail) + '</td>'
                total_gap_retail_stock += Number(obj_val.total_retail_stock - obj_val.total_retail);
            }

            if (asalSession == "Fiberhome" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
                "treg") {
                html += '<td class="minColumnWidth" style="min-width:50px; background-color: #77DD77;'
                if (obj_val.premium_stock_fiberhome - obj_val.premium_fh < -(obj_val.premium_fh * 0.50)) {
                    html += 'background-color : red; color: white;'
                } else if (obj_val.total_premium_stock - obj_val.total_premium < 0) {
                    html += 'background-color: yellow;'
                }
                html += '">' + (obj_val.premium_stock_fiberhome - obj_val.premium_fh) + '</td>'
                total_gap_premium_stock_fh += Number(obj_val.premium_stock_fiberhome - obj_val.premium_fh);
            }
            if (asalSession == "Huawei" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
                "treg") {
                html += '<td class="minColumnWidth" style="min-width:50px; background-color: #77DD77;'
                if (obj_val.premium_stock_huawei - obj_val.premium_hw < -(obj_val.premium_hw * 0.50)) {
                    html += 'background-color : red; color: white;'
                } else if (obj_val.total_premium_stock - obj_val.total_premium < 0) {
                    html += 'background-color: yellow;'
                }
                html += '">' + (obj_val.premium_stock_huawei - obj_val.premium_hw) + '</td>'
                total_gap_premium_stock_hw += Number(obj_val.premium_stock_huawei - obj_val.premium_hw);
            }

            if (asalSession == "ZTE" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
                "treg") {
                html += '<td class="minColumnWidth" style="min-width:50px; background-color: #77DD77;'
                if (obj_val.premium_stock_zte - obj_val.premium_zte < -(obj_val.premium_zte * 0.50)) {
                    html += 'background-color : red; color: white;'
                } else if (obj_val.total_premium_stock - obj_val.total_premium < 0) {
                    html += ' background-color: yellow;'
                }
                html += '">' + (obj_val.premium_stock_zte - obj_val.premium_zte) + '</td>'
                total_gap_premium_stock_zte += Number(obj_val.premium_stock_zte - obj_val.premium_zte);
            }

            if (asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession == "treg") {
                html += '<td class="minColumnWidth" style="min-width:50px; background-color: #77DD77;'
                if (obj_val.total_premium_stock - obj_val.total_premium < -(obj_val.total_premium * 0.50)) {
                    html += 'background-color : red; color: white;'
                } else if (obj_val.total_premium_stock - obj_val.total_premium < 0) {
                    html += 'background-color: yellow;'
                }
                html += '">' + (obj_val.total_premium_stock - obj_val.total_premium) + '</td>'
                total_gap_premium_stock += Number(obj_val.total_premium_stock - obj_val.total_premium);
            }

            if (asalSession == "Fiberhome" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
                "treg") {
                html += '<td class="minColumnWidth" >';
                if (obj_val.qty_kirim_retail_fh != 0) {
                    html += obj_val.qty_kirim_retail_fh;
                    qty_kirim_retail_fh += obj_val.qty_kirim_retail_fh;
                }
                html += '</td>'
            }

            if (asalSession == "Huawei" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
                "treg") {
                html += '<td class="minColumnWidth" >';
                if (obj_val.qty_kirim_retail_hw != 0) {
                    html += obj_val.qty_kirim_retail_hw
                    qty_kirim_retail_hw += obj_val.qty_kirim_retail_hw;
                }
                html += '</td>'
            }

            if (asalSession == "ZTE" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
                "treg") {
                html += '<td class="minColumnWidth" >'
                if (obj_val.qty_kirim_retail_zte != 0) {
                    html += obj_val.qty_kirim_retail_zte
                    qty_kirim_retail_zte += obj_val.qty_kirim_retail_zte;
                }
                html += '</td>'
            }

            if (asalSession == "Nokia" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
                "treg") {
                html += '<td class="minColumnWidth" >'
                if (obj_val.qty_kirim_retail_alu != 0) {
                    html += obj_val.qty_kirim_retail_alu
                    qty_kirim_retail_alu += obj_val.qty_kirim_retail_alu;
                }
                html += '</td>'
            }

            if (asalSession == "Fiberhome" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
                "treg") {
                html += '<td class="minColumnWidth" >'
                if (obj_val.qty_kirim_premium_fh != 0) {
                    html += obj_val.qty_kirim_premium_fh
                    qty_kirim_premium_fh += obj_val.qty_kirim_premium_fh;
                }
                html += '</td>'
            }

            if (asalSession == "Huawei" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
                "treg") {
                html += '<td class="minColumnWidth" >'
                if (obj_val.qty_kirim_premium_hw != 0) {
                    html += obj_val.qty_kirim_premium_hw
                    qty_kirim_premium_hw += obj_val.qty_kirim_premium_hw;
                }
                html += '</td>'
            }

            if (asalSession == "ZTE" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
                "treg") {
                html += '<td class="minColumnWidth" >'
                if (obj_val.qty_kirim_premium_zte != 0) {
                    html += obj_val.qty_kirim_premium_zte
                    qty_kirim_premium_zte += obj_val.qty_kirim_premium_zte;
                }
                html += '</td>'
            }

            if (asalSession == "Fiberhome" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
                "treg") {
                html += '<td class="minColumnWidth" >'
                html += obj_val.retail_fh + '</td>'
                total_retail_minimum_fh += Number(obj_val.retail_fh);
            }

            if (asalSession == "Huawei" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
                "treg") {
                html += '<td class="minColumnWidth" >'
                html += obj_val.retail_hw + '</td>'
                total_retail_minimum_hw += Number(obj_val.retail_hw);
            }

            if (asalSession == "ZTE" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
                "treg") {
                html += '<td class="minColumnWidth" >'
                html += obj_val.retail_zte + '</td>'
                total_retail_minimum_zte += Number(obj_val.retail_zte);
            }

            if (asalSession == "Nokia" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
                "treg") {
                html += '<td class="minColumnWidth" >'
                html += obj_val.retail_alu + '</td>'
                total_retail_minimum_alu += Number(obj_val.retail_alu);
            }

            if (asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession == "treg") {
                html += '<td class="minColumnWidth" >'
                html += obj_val.total_retail + '</td>'
                total_retail_minimum += Number(obj_val.total_retail);
            }

            if (asalSession == "Fiberhome" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
                "treg") {
                html += '<td class="minColumnWidth" >'
                html += obj_val.premium_fh + '</td>'
                total_premium_minimum_fh += Number(obj_val.premium_fh);
            }

            if (asalSession == "Huawei" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
                "treg") {
                html += '<td class="minColumnWidth" >'
                html += obj_val.premium_hw + '</td>'
                total_premium_minimum_hw += Number(obj_val.premium_hw);
            }

            if (asalSession == "ZTE" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
                "treg") {
                html += '<td class="minColumnWidth" >'
                html += obj_val.premium_zte + '</td>'
                total_premium_minimum_zte += Number(obj_val.premium_zte);
            }

            if (asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession == "treg") {
                html += '<td class="minColumnWidth" >'
                html += obj_val.total_premium + '</td>'
                total_premium_minimum += Number(obj_val.total_premium);
            }

            if (asalSession == "Fiberhome" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
                "treg") {
                html += '<td class="minColumnWidth" >'
                html += obj_val.on_delivery_retail_fiberhome + '</td>'
                total_on_delivery_retail_fh += Number(obj_val.on_delivery_retail_fiberhome);
            }

            if (asalSession == "Huawei" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
                "treg") {
                html += '<td class="minColumnWidth" >'
                html += obj_val.on_delivery_retail_huawei + '</td>'
                total_on_delivery_retail_hw += Number(obj_val.on_delivery_retail_huawei);
            }

            if (asalSession == "ZTE" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
                "treg") {
                html += '<td class="minColumnWidth" >'
                html += obj_val.on_delivery_retail_zte + '</td>'
                total_on_delivery_retail_zte += Number(obj_val.on_delivery_retail_zte);
            }

            if (asalSession == "Nokia" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
                "treg") {
                html += '<td class="minColumnWidth" >'
                html += obj_val.on_delivery_retail_nokia + '</td>'
                total_on_delivery_retail_alu += Number(obj_val.on_delivery_retail_nokia);
            }

            if (asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession == "treg") {
                html += '<td class="minColumnWidth" >'
                html += obj_val.on_delivery_total_retail + '</td>'
                total_on_delivery_retail += Number(obj_val.on_delivery_total_retail);
            }

            if (asalSession == "Fiberhome" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
                "treg") {
                html += '<td class="minColumnWidth" >'
                html += obj_val.on_delivery_premium_fiberhome + '</td>'
                total_on_delivery_premium_fh += Number(obj_val.on_delivery_premium_fiberhome);
            }

            if (asalSession == "Huawei" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
                "treg") {
                html += '<td class="minColumnWidth" >'
                html += obj_val.on_delivery_premium_huawei + '</td>'
                total_on_delivery_premium_hw += Number(obj_val.on_delivery_premium_huawei);
            }

            if (asalSession == "ZTE" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
                "treg") {
                html += '<td class="minColumnWidth" >'
                html += obj_val.on_delivery_premium_zte + '</td>'
                total_on_delivery_premium_zte += Number(obj_val.on_delivery_premium_zte);
            }

            if (asalSession == "DID" || jenisAkunSession == "treg" || jenisAkunSession == "sda") {
                html += '<td class="minColumnWidth" >'
                html += obj_val.on_delivery_total_premium + '</td>'
                total_on_delivery_premium += Number(obj_val.on_delivery_total_premium);
            }

            html += '</div>'
            html += "</tr>";
        }

        html += '<tr class="font-weight-bold text-center" style="background-color:gray; color:white;">'
        html +=
            '<td value="" class="sticky-col first-col text-center" style="background-color:gray; color:white; max-width:80px"><div hidden>Z</div>Total</td><td class="minColumnWidth" hidden></td><td class="minColumnWidth" hidden></td>';

        html += '<td class="minColumnWidth">' + total_qty_minimum + '</td> '

        if (asalSession == "Fiberhome" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
            "treg") {
            html += '<td class="minColumnWidth">' + total_retail_stock_fh + '</td> '
        }
        if (asalSession == "Huawei" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
            "treg") {
            html += '<td class="minColumnWidth">' + total_retail_stock_hw + '</td> '
        }
        if (asalSession == "ZTE" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession == "treg") {
            html += '<td class="minColumnWidth">' + total_retail_stock_zte + '</td> '
        }
        if (asalSession == "Nokia" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession == "treg") {
            html += '<td class="minColumnWidth">' + total_retail_stock_alu + '</td> '
        }
        if (asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession == "treg") {
            html += '<td class="minColumnWidth">' + total_retail_stock + '</td> '
        }

        if (asalSession == "Fiberhome" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
            "treg") {
            html += '<td class="minColumnWidth">' + total_premium_stock_fh + '</td> '
        }
        if (asalSession == "Huawei" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
            "treg") {
            html += '<td class="minColumnWidth">' + total_premium_stock_hw + '</td> '
        }
        if (asalSession == "ZTE" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession == "treg") {
            html += '<td class="minColumnWidth">' + total_premium_stock_zte + '</td> '
        }
        if (asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession == "treg") {
            html += '<td class="minColumnWidth">' + total_premium_stock + '</td> '
        }

        if (asalSession == "Fiberhome" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
            "treg") {
            html += '<td class="minColumnWidth">' + total_gap_retail_stock_fh + '</td> '
        }
        if (asalSession == "Huawei" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
            "treg") {
            html += '<td class="minColumnWidth">' + total_gap_retail_stock_hw + '</td> '
        }
        if (asalSession == "ZTE" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession == "treg") {
            html += '<td class="minColumnWidth">' + total_gap_retail_stock_zte + '</td> '
        }
        if (asalSession == "Nokia" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession == "treg") {
            html += '<td class="minColumnWidth">' + total_gap_retail_stock_alu + '</td> '
        }
        if (asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession == "treg") {
            html += '<td class="minColumnWidth">' + total_gap_retail_stock + '</td> '
        }

        if (asalSession == "Fiberhome" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
            "treg") {
            html += '<td class="minColumnWidth">' + total_gap_premium_stock_fh + '</td> '
        }
        if (asalSession == "Huawei" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
            "treg") {
            html += '<td class="minColumnWidth">' + total_gap_premium_stock_hw + '</td> '
        }
        if (asalSession == "ZTE" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession == "treg") {
            html += '<td class="minColumnWidth">' + total_gap_premium_stock_zte + '</td> '
        }
        if (asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession == "treg") {
            html += '<td class="minColumnWidth">' + total_gap_premium_stock + '</td> '
        }

        if (asalSession == "Fiberhome" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
            "treg") {
            html += '<td class="minColumnWidth">' + qty_kirim_retail_fh + '</td> '
        }
        if (asalSession == "Huawei" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
            "treg") {
            html += '<td class="minColumnWidth">' + qty_kirim_retail_hw + '</td> '
        }
        if (asalSession == "ZTE" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession == "treg") {
            html += '<td class="minColumnWidth">' + qty_kirim_retail_zte + '</td> '
        }
        if (asalSession == "Nokia" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession == "treg") {
            html += '<td class="minColumnWidth">' + qty_kirim_retail_alu + '</td> '
        }

        if (asalSession == "Fiberhome" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
            "treg") {
            html += '<td class="minColumnWidth">' + qty_kirim_premium_fh + '</td> '
        }
        if (asalSession == "Huawei" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
            "treg") {
            html += '<td class="minColumnWidth">' + qty_kirim_premium_hw + '</td> '
        }
        if (asalSession == "ZTE" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession == "treg") {
            html += '<td class="minColumnWidth">' + qty_kirim_premium_zte + '</td> '
        }

        if (asalSession == "Fiberhome" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
            "treg") {
            html += '<td class="minColumnWidth">' + total_retail_minimum_fh + '</td> '
        }
        if (asalSession == "Huawei" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
            "treg") {
            html += '<td class="minColumnWidth">' + total_retail_minimum_hw + '</td> '
        }
        if (asalSession == "ZTE" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession == "treg") {
            html += '<td class="minColumnWidth">' + total_retail_minimum_zte + '</td> '
        }
        if (asalSession == "Nokia" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession == "treg") {
            html += '<td class="minColumnWidth">' + total_retail_minimum_alu + '</td> '
        }
        if (asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession == "treg") {
            html += '<td class="minColumnWidth">' + total_retail_minimum + '</td> '
        }

        if (asalSession == "Fiberhome" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
            "treg") {
            html += '<td class="minColumnWidth">' + total_premium_minimum_fh + '</td> '
        }
        if (asalSession == "Huawei" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
            "treg") {
            html += '<td class="minColumnWidth">' + total_premium_minimum_hw + '</td> '
        }
        if (asalSession == "ZTE" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession == "treg") {
            html += '<td class="minColumnWidth">' + total_premium_minimum_zte + '</td> '
        }
        if (asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession == "treg") {
            html += '<td class="minColumnWidth">' + total_premium_minimum + '</td> '
        }

        if (asalSession == "Fiberhome" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
            "treg") {
            html += '<td class="minColumnWidth">' + total_on_delivery_retail_fh + '</td> '
        }
        if (asalSession == "Huawei" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
            "treg") {
            html += '<td class="minColumnWidth">' + total_on_delivery_retail_hw + '</td> '
        }
        if (asalSession == "ZTE" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession == "treg") {
            html += '<td class="minColumnWidth">' + total_on_delivery_retail_zte + '</td> '
        }
        if (asalSession == "Nokia" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession == "treg") {
            html += '<td class="minColumnWidth">' + total_on_delivery_retail_alu + '</td> '
        }
        if (asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession == "treg") {
            html += '<td class="minColumnWidth">' + total_on_delivery_retail + '</td> '
        }

        if (asalSession == "Fiberhome" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
            "treg") {
            html += '<td class="minColumnWidth">' + total_on_delivery_premium_fh + '</td> '
        }
        if (asalSession == "Huawei" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession ==
            "treg") {
            html += '<td class="minColumnWidth">' + total_on_delivery_premium_hw + '</td> '
        }
        if (asalSession == "ZTE" || asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession == "treg") {
            html += '<td class="minColumnWidth">' + total_on_delivery_premium_zte + '</td> '
        }
        if (asalSession == "DID" || jenisAkunSession == "sda" || jenisAkunSession == "treg") {
            html += '<td class="minColumnWidth">' + total_on_delivery_premium + '</td> '
        }

        html += "</tr>"
        $('#tableDetail-body').html(html);
    }

    @if (session('asal') == 'DID' || session('jenis_akun') == 'sda' || session('jenis_akun') == 'treg')
        $("document").ready(function() {
            $("#filterTableDetail").dataTable({
                "searching": true,
                // "scrollX": true,
                "bPaginate": false,
                "ordering": false,
                "fnInfoCallback": function(oSettings, iStart, iEnd, iMax, iTotal, sPre) {
                    return "Showing " + iStart + " to " + iEnd + " of " + iMax +
                        " entries <a class='btn btn-primary' onClick='unshowTableDetail()'>View Less</a>";
                }
            });
            
            $("#filterTable_filter.dataTables_filter").append($("#witelFilter"));
            $("#filterTable_filter.dataTables_filter").append($("#categoryFilter"));
            $("#filterTable_filter.dataTables_filter").append($("#soFilter"));

            $("#filterTableDetail_filter.dataTables_filter").append($("#witelDetailFilter"));
            $("#filterTableDetail_filter.dataTables_filter").append($("#categoryDetailFilter"));
            $("#filterTableDetail_filter.dataTables_filter").append($("#soDetailFilter"));

            var categoryIndex = 0;
            $("#categoryFilter").on('change', function(i) {
                categoryIndex = 1;
                $("#filterTable th").each(function(i) {
                    if ($($(this)).html() == "regional") {
                        categoryIndex = i;
                        return false;
                    }
                })

                $("#witelFilter").val('');
                $("#soFilter").val('');

                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex, value) {
                        var selectedItem = $('#categoryFilter').val()

                        var category = data[1];
                        if (selectedItem === "" || category.includes(selectedItem)) {
                            return true;
                        }
                        return false;
                    }
                );

                table.draw();
            });

            $("#witelFilter").on('change', function(i) {
                categoryIndex = 0;
                $("#filterTable th").each(function(i) {
                    if ($($(this)).html() == "Witel") {
                        categoryIndex = i;
                        return false;
                    }
                })

                if ($('#witelFilter option:selected').text() == "All Witel") {
                    $("#soFilter").val('');

                    var selectedItem = $('#categoryFilter option:selected').text()

                    giveSelectionTASO(selectedItem);
                    if (selectedItem == "All TREG") {
                        giveSelectionTASO('');
                    }
                }

                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex, value) {
                        var selectedItem = $('#witelFilter option:selected').text()
                        if (selectedItem == "All Witel") {
                            selectedItem = "";
                        }

                        var category = data[2];
                        if (selectedItem === "" || category.includes(selectedItem)) {
                            return true;
                        }
                        return false;
                    }
                );

                table.draw();
            });

            $("#soFilter").on('change', function(i) {
                categoryIndex = 0;
                $("#filterTable th").each(function(i) {
                    if ($($(this)).html() == "Witel") {
                        categoryIndex = i;
                        return false;
                    }
                })

                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex, value) {
                        var selectedItem = $('#soFilter option:selected').text()
                        if (selectedItem == "All SO") {
                            selectedItem = "";
                        }

                        var category = data[0];
                        if (selectedItem === "" || category.includes(selectedItem)) {
                            return true;
                        }
                        return false;
                    }
                );

                table.draw();
            });

            table.draw();
        });

        function showTableDetail() {
            document.getElementById("tableBiasa").hidden = true;
            document.getElementById("tableDetail").hidden = false;
        }

        function unshowTableDetail() {
            document.getElementById("tableBiasa").hidden = false;
            document.getElementById("tableDetail").hidden = true;
        }
    @endif

    function giveExportSelection() {
        value = document.getElementById('exportFilter').value;
        const arr_val = [];
        let filteredUsers = all_witel.filter((witel) => {
            return witel.id.length == 5;
        });

        if(value == "merah"){
            const newWitel = witel.filter((witelData) => {
                return (witelData.total_retail_stock - witelData.total_retail < -(witelData.total_retail * 0.50)) || (witelData.total_premium_stock - witelData.total_premium < -(witelData.total_premium * 0.50));
            });

            if(newWitel.length > 0){
                newWitel.forEach(function(obj) {
                    arr_val.push(obj.id);
                });
            }
        }
        else if(value == "kuning"){
            const newWitel = witel.filter((witelData) => {
                return (witelData.total_retail_stock - witelData.total_retail < 0) || (witelData.total_premium_stock - witelData.total_premium < 0);
            });

            if(newWitel.length > 0){
                newWitel.forEach(function(obj) {
                    arr_val.push(obj.id);
                });
            }
        }
        else{
            const newWitel = witel.filter((witelData) => {
                return (witelData.total_retail_stock - witelData.total_retail >= 0) || (witelData.total_premium_stock - witelData.total_premium >= 0);
            });

            if(newWitel.length > 0){
                newWitel.forEach(function(obj) {
                    arr_val.push(obj.id);
                });
            }
        }

        changeTableContent(arr_val);
        changeTableDetailContent(arr_val);

        document.getElementById("form_export").action = "{{ URL('/export_data_tmp_scmt') }}" + "/" + value +
            '/rekap_delivery';
    }

    function giveExportAllSelection() {
        value = document.getElementById('exportFilterAll').value;

        const arr_val = [];
        let filteredUsers = all_witel.filter((witel) => {
            return witel.id.length == 5;
        });

        if(value == "merah"){
            const newWitel = witel.filter((witelData) => {
                return (witelData.total_retail_stock - witelData.total_retail < -(witelData.total_retail * 0.50)) || (witelData.total_premium_stock - witelData.total_premium < -(witelData.total_premium * 0.50));
            });

            if(newWitel.length > 0){
                newWitel.forEach(function(obj) {
                    arr_val.push(obj.id);
                });
            }
        }
        else if(value == "kuning"){
            const newWitel = witel.filter((witelData) => {
                return (witelData.total_retail_stock - witelData.total_retail < 0) || (witelData.total_premium_stock - witelData.total_premium < 0);
            });

            if(newWitel.length > 0){
                newWitel.forEach(function(obj) {
                    arr_val.push(obj.id);
                });
            }
        }
        else{
            const newWitel = witel.filter((witelData) => {
                return (witelData.total_retail_stock - witelData.total_retail >= 0) || (witelData.total_premium_stock - witelData.total_premium >= 0);
            });

            if(newWitel.length > 0){
                newWitel.forEach(function(obj) {
                    arr_val.push(obj.id);
                });
            }
        }

        changeTableContent(arr_val);
        changeTableDetailContent(arr_val);
        
        document.getElementById("form_export_all").action = "{{ URL('/export_data_tmp_scmt') }}" + "/" + value +
            '/all';
    }

    var expanded = false;

    function showCheckboxes() {
        var checkboxes = document.getElementById("checkboxes");
        if (!expanded) {
            checkboxes.style.display = "block";
            expanded = true;
        } else {
            checkboxes.style.display = "none";
            expanded = false;
        }
    }

    function setOnDelivery(nama_warehouse, jenis_ont) {
        $('#modal-body').html('<div class="table-responsive">' +
            '<table class="table table-striped table-bordered" id="datatable_on_delivery" style="width:100%;border-collapse: collapse; border-spacing: 0; width: 100%;">' +
            '<thead>' +
            '<tr>' +
            '<th rowspan="3" style="width:50px; text-align:center; vertical-align:center;">No</th>' +
            '<th rowspan="2" style="min-width:200px;" class="text-center">Type</th>' +
            '<th rowspan="2" class="text-center">Qty</th>' +
            '<th colspan="2" class="text-center">Pengirim</th>' +
            '<th colspan="3" class="text-center">Penerima</th>' +
            '<th rowspan="2" class="text-center">Tanggal Pengiriman</th>' +
            '<th rowspan="2" class="text-center">Tanggal Sampai</th>' +
            '</tr>' +
            '<tr>' +
            '<th>Alamat</th>' +
            '<th>PIC</th>' +
            '<th>Alamat</th>' +
            '<th>Warehouse</th>' +
            '<th>PIC</th>' +
            '</tr>' +
            '</thead>' +
            '</table>' +
            '<tbody>' +
            '</tbody>' +
            '</div>');

        $('#datatable_on_delivery thead').append('<tr></tr>');

        var arr_val = new Array();

        arr_val = ["Type", "Qty", "Alamat", "PIC", "Alamat", "Warehouse", "PIC", "Tanggal Pengiriman", "Tanggal Sampai",
            "regional"
        ];

        table = $('#datatable_on_delivery thead tr:eq(2)');

        for (var i = 0; i < arr_val.length; i++) {
            table.append('<th><input id="search_' + i + '" type="text" placeholder="Search ' + arr_val[i] + '"/></th>');
        }

        $('#datatable_on_delivery thead tr:eq(2) th').each(function(i) {
            $('input', this).on('keyup change', function() {
                if (table.column(i + 1).search() !== this.value) {
                    // table
                    //     .column(i+1)
                    //     .search( this.value )
                    //     .draw();
                    table.column(i + 1).search(this.value).draw();
                }
            });
        });

        url = "{{ url('/on_delivery_data') }}" + "/" + nama_warehouse + "/" + jenis_ont;

        var table = $('#datatable_on_delivery').DataTable({
            "ajax": url,
            searching: true,
            ordering: false,
            "deferRender": true,
            "processing": true,
            "destroy": true,
            "columns": [{
                    "data": 'DT_RowIndex'
                },
                {
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
                    "data": "regional",
                    visible: false
                },
            ],
            "scrollX": true,
            "bPaginate": true,
        });
    }
</script>
</html>
