<!doctype html>
<html lang="en">

<head>
    <title>Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @include('template.import_datatable')
    <style>
        html {
            font-size: 14px;
        }

        select.form-control {
            display: inline;
            width: 200px;
            margin-left: 25px;
        }

        .first-col {
            width: 90px;
            min-width: 90px;
            max-width: 90px;
            left: 0px;
        }

        .first-col-biasa {
            width: 400px;
            min-width: 400px;
            max-width: 400px;
            left: 0px;
        }

        .sticky-col-biasa {
            position: -webkit-sticky !importance;
            position: sticky;
            background-color: white !importance;
        }

        .minColumnWidth {
            width: 55px;
            min-width: 55px;
            max-width: 55px;
        }

        .sticky-col {
            position: -webkit-sticky !importance;
            position: sticky;
            background-color: white !importance;
        }

        body {
            font-family: "Quicksand", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        }

        #filterTableDetail_filter {
            width: 50%;
            float: right;
            text-align: right;
        }

        #filterTable_filter {
            width: 50%;
            float: right;
            text-align: right;
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
                <!-- <div class="row" style="margin-top:-60px">
         <div class="col-4">
         </div>
         <div class="col-4">
            <h1 class="text-center">MINITOK TUNTAS</h1>
         </div>
         <div class="col-4">
         </div>
      </div> -->
                <div class="card mb-3 mt-3">
                    <div class="card-body mb-2">
                        <div class="table-responsive">
                            <div class="category-filter">
                                <select id="categoryFilter" class="form-control mb-3"
                                    onchange="giveSelection(this.value)">
                                    <option value="All">All</option>
                                    <option value="WH TR TREG 1">TREG 1</option>
                                    <option value="WH TR TREG 2">TREG 2</option>
                                    <option value="WH TR TREG 3">TREG 3</option>
                                    <option value="WH TR TREG 4">TREG 4</option>
                                    <option value="WH TR TREG 5">TREG 5</option>
                                    <option value="WH TR TREG 6">TREG 6</option>
                                    <option value="WH TR TREG 7">TREG 7</option>
                                </select>
                            </div>

                            <div id="tableBiasa">
                                <table class="table table-bordered" id="filterTable" width="100%">
                                    <thead>
                                        <tr class="text-center"
                                            style="color:black; background-color:gray; color:white;">
                                            <th rowspan="2" class="first-col sticky-col"
                                                style="min-width: 400px; text-align: center; vertical-align: middle;">
                                                Warehouse</th>
                                            <th rowspan="2" hidden>regional</th>
                                            <th rowspan="2" hidden>witel</th>
                                            <th rowspan="2" style="text-align: center; vertical-align: middle;"
                                                style="max-width:70px" hidden>Minimum Qty</th>
                                            <th colspan="2">Stock SCMT</th>
                                            <th colspan="2">GAP Stock</th>
                                            <th colspan="2">Kebutuhan</th>
                                            <th colspan="2">Minimum Stock Requirement Retail</th>
                                            <th colspan="2">On Delivery</th>
                                        </tr>
                                        <tr class="text-center" style="background-color:gray; color:white;">
                                            <!-- <th colspan="4"></th> -->
                                            <th style="text-align: center; vertical-align: middle;">Total Retail</th>
                                            <th style="text-align: center; vertical-align: middle;">Total Premium</th>

                                            <th style="max-width:100px; text-align: center; vertical-align: middle;">
                                                Total Retail</th>
                                            <th style="max-width:100px; text-align: center; vertical-align: middle;">
                                                Total Premium</th>

                                            <th style="max-width:100px; text-align: center; vertical-align: middle;">
                                                Total Retail</th>
                                            <th style="max-width:100px; text-align: center; vertical-align: middle;">
                                                Total Premium</th>

                                            <th style="max-width:100px; text-align: center; vertical-align: middle;">
                                                Total Retail</th>
                                            <th style="max-width:100px; text-align: center; vertical-align: middle;">
                                                Total Premium</th>

                                            <th style="max-width:100px; text-align: center; vertical-align: middle;">
                                                Total Retail</th>
                                            <th style="max-width:100px; text-align: center; vertical-align: middle;">
                                                Total Premium</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $kebutuhan_premium = 0;
                                        $kebutuhan_retail = 0; ?>
                                        @foreach ($data['witel'] as $idx => $d)
                                            <tr>
                                                <td value="" class="first-col sticky-col"
                                                    style="background-color:gray; color:white; font-weight: bold;">
                                                    @if ($data['jenis_warehouse'] == 'Witel' || $data['jenis_warehouse'] == 'TA SO')
                                                        <a style="text-decoration:none; color: white; font-weight: bold"
                                                            href="<?php echo url('/rekap_delivery_biasa/') . '/' . $data['jenis_warehouse'] . '/' . $d->lokasi_wh; ?>">{{ $d->lokasi_wh }}</a>
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

                                                    <td
                                                        style="@if ($d->total_retail_stock - $d->total_retail < -($d->total_retail * 0.75)) background-color : red; color: white; @elseif($d->total_retail_stock - $d->total_retail < 0) background-color: yellow; @else background-color: #77DD77; @endif ">
                                                        <?php echo number_format((int) $d->total_retail_stock - $d->total_retail, 0, ',', '.'); ?></td>
                                                    <td
                                                        style="background-color: #77DD77; @if ($d->total_premium_stock - $d->total_premium < -($d->total_premium * 0.75)) background-color : red; color: white; @elseif($d->total_premium_stock - $d->total_premium < 0) background-color: yellow; @else background-color: #77DD77; @endif ">
                                                        <?php echo number_format((int) $d->total_premium_stock - $d->total_premium, 0, ',', '.'); ?></td>

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

                                                    <td><?php echo number_format((int) $d->on_delivery_total_retail, 0, ',', '.'); ?></td>
                                                    <td><?php echo number_format((int) $d->on_delivery_total_premium, 0, ',', '.'); ?></td>
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


                                                <td><?php echo number_format((int) $data['total_on_delivery_retail_all'], 0, ',', '.'); ?></td>
                                                <td><?php echo number_format((int) $data['total_on_delivery_premium_all'], 0, ',', '.'); ?></td>
                                            </div>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div id="tableDetail" hidden>
                                <table class="table table-bordered" id="filterTableDetail" width="100%"
                                    style="font-size:8px; color:black;">
                                    <thead>
                                        <tr class="text-center" style="background-color:gray; color:white;">
                                            <th rowspan="3" class="first-col sticky-col"
                                                style="text-align: center; vertical-align: middle; background-color:gray; color:white;">
                                                Warehouse</th>
                                            <th rowspan="3"hidden>regional</th>
                                            <th rowspan="3"hidden>witel</th>
                                            <th rowspan="3" style="text-align: center; vertical-align: middle;">
                                                Minimum Qty</th>

                                            <th colspan="9">Stock SCMT</th>

                                            <th colspan="9">GAP Stock</th>

                                            <th colspan="7">Kebutuhan</th>

                                            <th rowspan="2" colspan="4">Minimum Stock Requirement Retail</th>
                                            <th class="minColumnWidth" rowspan="3" style="vertical-align: middle;">
                                                Total</th>
                                            <th rowspan="2" colspan="3">Minimum Stock Requirement Premium</th>
                                            <th class="minColumnWidth" rowspan="3"
                                                style="vertical-align: middle;">Total</th>

                                            <th rowspan="2" colspan="4">On Delivery Retail</th>
                                            <th class="minColumnWidth" rowspan="3"
                                                style="vertical-align: middle;">Total</th>
                                            <th rowspan="2" colspan="3">On Delivery Premium</th>
                                            <th class="minColumnWidth" rowspan="3"
                                                style="vertical-align: middle;">Total</th>


                                            <!--<th colspan="7">Threshold Atas</th>-->

                                            <!--<th colspan="7">Threshold Bawah</th>-->
                                        </tr>
                                        <tr class="text-center" style="background-color:gray; color:white;">
                                            <th colspan="4">Retail</th>
                                            <th class="minColumnWidth" rowspan="2"
                                                style="vertical-align: middle;">Total</th>
                                            <th colspan="3">Premium</th>
                                            <th class="minColumnWidth" rowspan="2"
                                                style="vertical-align: middle;">Total</th>

                                            <th colspan="4">Retail</th>
                                            <th class="minColumnWidth" rowspan="2"
                                                style="vertical-align: middle;">Total</th>
                                            <th colspan="3">Premium</th>
                                            <th class="minColumnWidth" rowspan="2"
                                                style="vertical-align: middle;">Total</th>

                                            <th colspan="4">Retail</th>
                                            <th colspan="3">Premium</th>


                                            <!--<th colspan="4">Retail</th>-->
                                            <!--<th colspan="3">Premium</th>-->

                                            <!--<th colspan="4">Retail</th>-->
                                            <!--<th colspan="3">Premium</th>-->
                                        </tr>
                                        <tr class="text-center"
                                            style="max-width:70px; background-color:gray; color:white;">
                                            <!-- <th>FH</th>
                    <th>HW</th>
                    <th>ZTE</th>
                    <th>ALU</th>

                    <th>FH</th>
                    <th>HW</th>
                    <th>ZTE</th> -->

                                            <th class="minColumnWidth">FH</th>
                                            <th class="minColumnWidth">HW</th>
                                            <th class="minColumnWidth">ZTE</th>
                                            <th class="minColumnWidth">ALU</th>

                                            <th class="minColumnWidth">FH</th>
                                            <th class="minColumnWidth">HW</th>
                                            <th class="minColumnWidth">ZTE</th>

                                            <th class="minColumnWidth">FH</th>
                                            <th class="minColumnWidth">HW</th>
                                            <th class="minColumnWidth">ZTE</th>
                                            <th class="minColumnWidth">ALU</th>

                                            <th class="minColumnWidth">FH</th>
                                            <th class="minColumnWidth">HW</th>
                                            <th class="minColumnWidth">ZTE</th>

                                            <th class="minColumnWidth">FH</th>
                                            <th class="minColumnWidth">HW</th>
                                            <th class="minColumnWidth">ZTE</th>
                                            <th class="minColumnWidth">ALU</th>

                                            <th class="minColumnWidth">FH</th>
                                            <th class="minColumnWidth">HW</th>
                                            <th class="minColumnWidth">ZTE</th>

                                            <th class="minColumnWidth">FH</th>
                                            <th class="minColumnWidth">HW</th>
                                            <th class="minColumnWidth">ZTE</th>
                                            <th class="minColumnWidth">ALU</th>

                                            <th class="minColumnWidth">FH</th>
                                            <th class="minColumnWidth">HW</th>
                                            <th class="minColumnWidth">ZTE</th>

                                            <th class="minColumnWidth">FH</th>
                                            <th class="minColumnWidth">HW</th>
                                            <th class="minColumnWidth">ZTE</th>
                                            <th class="minColumnWidth">ALU</th>

                                            <th class="minColumnWidth">FH</th>
                                            <th class="minColumnWidth">HW</th>
                                            <th class="minColumnWidth">ZTE</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $qty_kirim_retail_zte = 0; ?>
                                        <?php $qty_kirim_retail_fh = 0; ?>
                                        <?php $qty_kirim_retail_hw = 0; ?>
                                        <?php $qty_kirim_retail_alu = 0; ?>

                                        <?php $qty_kirim_premium_zte = 0; ?>
                                        <?php $qty_kirim_premium_fh = 0; ?>
                                        <?php $qty_kirim_premium_hw = 0; ?>
                                        @foreach ($data['witel'] as $idx => $d)
                                            <tr>
                                                <td value="" class="first-col sticky-col"
                                                    style="background-color:gray; color:white; max-width: 80px;">
                                                    @if ($data['jenis_warehouse'] == 'Witel' || $data['jenis_warehouse'] == 'TA SO')
                                                        <a style="text-decoration:none; color: white; font-weight: bold"
                                                            href="<?php echo url('/rekap_delivery_biasa/') . '/' . $data['jenis_warehouse'] . '/' . $d->lokasi_wh; ?>">{{ $d->lokasi_wh }}</a>
                                                    @else($data["jenis_warehouse"] == "Witel")
                                                        {{ $d->lokasi_wh }}
                                                    @endif
                                                </td>
                                                <td hidden>{{ $d->regional }}</td>
                                                <td hidden>{{ $d->witel }}</td>
                                                <td><?php echo number_format((int) $d->minimum_qty, 0, ',', '.'); ?></td>

                                                <div class="text-center">
                                                    <td class="minColumnWidth"><?php echo number_format((int) $d->retail_stock_fiberhome, 0, ',', '.'); ?></td>
                                                    <td class="minColumnWidth"><?php echo number_format((int) $d->retail_stock_huawei, 0, ',', '.'); ?></td>
                                                    <td class="minColumnWidth"><?php echo number_format((int) $d->retail_stock_zte, 0, ',', '.'); ?></td>
                                                    <td class="minColumnWidth"><?php echo number_format((int) $d->retail_stock_nokia, 0, ',', '.'); ?></td>
                                                    <td class="minColumnWidth" style="max-width:90px">
                                                        <?php echo number_format((int) $d->total_retail_stock, 0, ',', '.'); ?></td>

                                                    <td class="minColumnWidth"><?php echo number_format((int) $d->premium_stock_fiberhome, 0, ',', '.'); ?></td>
                                                    <td class="minColumnWidth"><?php echo number_format((int) $d->premium_stock_huawei, 0, ',', '.'); ?></td>
                                                    <td class="minColumnWidth"><?php echo number_format((int) $d->premium_stock_zte, 0, ',', '.'); ?></td>
                                                    <td class="minColumnWidth"><?php echo number_format((int) $d->total_premium_stock, 0, ',', '.'); ?></td>

                                                    <td class="minColumnWidth"
                                                        style="min-width:50px; background-color: #77DD77; @if ($d->retail_stock_fiberhome - $d->retail_fh < -($d->retail_fh * 0.75)) background-color : red; color: white; @elseif($d->total_retail_stock - $d->retail_hw < 0) background-color: yellow; @endif">
                                                        <?php echo number_format((int) $d->retail_stock_fiberhome - $d->retail_fh, 0, ',', '.'); ?></td>
                                                    <td class="minColumnWidth"
                                                        style="min-width:50px; background-color: #77DD77; @if ($d->retail_stock_huawei - $d->retail_hw < -($d->retail_hw * 0.75)) background-color : red; color: white; @elseif($d->retail_stock_huawei - $d->retail_hw < 0) background-color: yellow; @endif ">
                                                        <?php echo number_format((int) $d->retail_stock_huawei - $d->retail_hw, 0, ',', '.'); ?></td>
                                                    <td class="minColumnWidth"
                                                        style="min-width:50px; background-color: #77DD77; @if ($d->retail_stock_zte - $d->retail_zte < -($d->retail_zte * 0.75)) background-color : red; color: white; @elseif($d->retail_stock_zte - $d->retail_zte < 0) background-color: yellow; @endif ">
                                                        <?php echo number_format((int) $d->retail_stock_zte - $d->retail_zte, 0, ',', '.'); ?></td>
                                                    <td class="minColumnWidth"
                                                        style="min-width:50px; background-color: #77DD77; @if ($d->retail_stock_nokia - $d->retail_alu < -($d->retail_alu * 0.75)) background-color : red; color: white; @elseif($d->retail_stock_nokia - $d->retail_alu < 0) background-color: yellow; @endif ">
                                                        <?php echo number_format((int) $d->retail_stock_nokia - $d->retail_alu, 0, ',', '.'); ?></td>
                                                    <td class="minColumnWidth"
                                                        style="min-width:50px; background-color: #77DD77; @if ($d->total_retail_stock - $d->total_retail < -($d->total_retail * 0.75)) background-color : red; color: white; @elseif($d->total_retail_stock - $d->total_retail < 0) background-color: yellow; @endif ">
                                                        <?php echo number_format((int) $d->total_retail_stock - $d->total_retail, 0, ',', '.'); ?></td>

                                                    <td class="minColumnWidth"
                                                        style="min-width:50px; background-color: #77DD77; @if ($d->premium_stock_fiberhome - $d->premium_fh < -($d->premium_fh * 0.75)) background-color : red; color: white; @elseif($d->total_premium_stock - $d->total_premium < 0) background-color: yellow; @endif ">
                                                        <?php echo number_format((int) $d->premium_stock_fiberhome - $d->premium_fh, 0, ',', '.'); ?> </td>
                                                    <td class="minColumnWidth"
                                                        style="min-width:50px; background-color: #77DD77; @if ($d->premium_stock_huawei - $d->premium_hw < -($d->premium_hw * 0.75)) background-color : red; color: white; @elseif($d->total_premium_stock - $d->total_premium < 0) background-color: yellow; @endif ">
                                                        <?php echo number_format((int) $d->premium_stock_huawei - $d->premium_hw, 0, ',', '.'); ?> </td>
                                                    <td class="minColumnWidth"
                                                        style="min-width:50px; background-color: #77DD77; @if ($d->premium_stock_zte - $d->premium_zte < -($d->premium_zte * 0.75)) background-color : red; color: white; @elseif($d->total_premium_stock - $d->total_premium < 0) background-color: yellow; @endif">
                                                        <?php echo number_format((int) $d->premium_stock_zte - $d->premium_zte, 0, ',', '.'); ?></td>
                                                    <td class="minColumnWidth"
                                                        style="min-width:50px; background-color: #77DD77; @if ($d->total_premium_stock - $d->total_premium < -($d->total_premium * 0.75)) background-color : red; color: white; @elseif($d->total_premium_stock - $d->total_premium < 0) background-color: yellow; @endif ">
                                                        <?php echo number_format((int) $d->total_premium_stock - $d->total_premium, 0, ',', '.'); ?></td>

                                                    <td class="minColumnWidth">
                                                        @if ($d->qty_kirim_retail_fh != 0)
                                                            <?php echo number_format((int) $d->qty_kirim_retail_fh, 0, ',', '.'); ?><?php $qty_kirim_retail_fh += $d->qty_kirim_retail_fh; ?>
                                                        @endif
                                                    </td>
                                                    <td class="minColumnWidth">
                                                        @if ($d->qty_kirim_retail_hw != 0)
                                                            <?php echo number_format((int) $d->qty_kirim_retail_hw, 0, ',', '.'); ?><?php $qty_kirim_retail_hw += $d->qty_kirim_retail_hw; ?>
                                                        @endif
                                                    </td>
                                                    <td class="minColumnWidth">
                                                        @if ($d->qty_kirim_retail_zte != 0)
                                                            <?php echo number_format((int) $d->qty_kirim_retail_zte, 0, ',', '.'); ?><?php $qty_kirim_retail_zte += $d->qty_kirim_retail_zte; ?>
                                                        @endif
                                                    </td>
                                                    <td class="minColumnWidth">
                                                        @if ($d->qty_kirim_retail_alu != 0)
                                                            <?php echo number_format((int) $d->qty_kirim_retail_alu, 0, ',', '.'); ?><?php $qty_kirim_retail_alu += $d->qty_kirim_retail_alu; ?>
                                                        @endif
                                                    </td>

                                                    <td class="minColumnWidth">
                                                        @if ($d->qty_kirim_premium_fh != 0)
                                                            <?php echo number_format((int) $d->qty_kirim_premium_fh, 0, ',', '.'); ?><?php $qty_kirim_premium_fh += $d->qty_kirim_premium_fh; ?>
                                                        @endif
                                                    </td>
                                                    <td class="minColumnWidth">
                                                        @if ($d->qty_kirim_premium_hw != 0)
                                                            <?php echo number_format((int) $d->qty_kirim_premium_hw, 0, ',', '.'); ?> <?php $qty_kirim_premium_hw += $d->qty_kirim_premium_hw; ?>
                                                        @endif
                                                    </td>
                                                    <td class="minColumnWidth">
                                                        @if ($d->qty_kirim_premium_zte != 0)
                                                            <?php echo number_format((int) $d->qty_kirim_premium_zte, 0, ',', '.'); ?> <?php $qty_kirim_premium_zte += $d->qty_kirim_premium_zte; ?>
                                                        @endif
                                                    </td>


                                                    <td class="minColumnWidth"><?php echo number_format((int) $d->retail_fh, 0, ',', '.'); ?></td>
                                                    <td class="minColumnWidth"><?php echo number_format((int) $d->retail_hw, 0, ',', '.'); ?></td>
                                                    <td class="minColumnWidth"><?php echo number_format((int) $d->retail_zte, 0, ',', '.'); ?></td>
                                                    <td class="minColumnWidth"><?php echo number_format((int) $d->retail_alu, 0, ',', '.'); ?></td>
                                                    <td class="minColumnWidth"><?php echo number_format((int) $d->total_retail, 0, ',', '.'); ?></td>

                                                    <td class="minColumnWidth"><?php echo number_format((int) $d->premium_fh, 0, ',', '.'); ?></td>
                                                    <td class="minColumnWidth"><?php echo number_format((int) $d->premium_hw, 0, ',', '.'); ?></td>
                                                    <td class="minColumnWidth"><?php echo number_format((int) $d->premium_zte, 0, ',', '.'); ?></td>
                                                    <td class="minColumnWidth"><?php echo number_format((int) $d->total_premium, 0, ',', '.'); ?></td>

                                                    <td class="minColumnWidth"><?php echo number_format((int) $d->on_delivery_retail_fiberhome, 0, ',', '.'); ?></td>
                                                    <td class="minColumnWidth"><?php echo number_format((int) $d->on_delivery_retail_huawei, 0, ',', '.'); ?></td>
                                                    <td class="minColumnWidth"><?php echo number_format((int) $d->on_delivery_retail_zte, 0, ',', '.'); ?></td>
                                                    <td class="minColumnWidth"><?php echo number_format((int) $d->on_delivery_retail_nokia, 0, ',', '.'); ?></td>
                                                    <td class="minColumnWidth"><?php echo number_format((int) $d->on_delivery_total_retail, 0, ',', '.'); ?></td>

                                                    <td class="minColumnWidth"><?php echo number_format((int) $d->on_delivery_premium_fiberhome, 0, ',', '.'); ?></td>
                                                    <td class="minColumnWidth"><?php echo number_format((int) $d->on_delivery_premium_huawei, 0, ',', '.'); ?></td>
                                                    <td class="minColumnWidth"><?php echo number_format((int) $d->on_delivery_premium_zte, 0, ',', '.'); ?></td>
                                                    <td class="minColumnWidth"><?php echo number_format((int) $d->on_delivery_total_premium, 0, ',', '.'); ?></td>
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
                                        <tr class="font-weight-bold" style="background-color:gray; color:white;">
                                            <td value="" class="sticky-col first-col text-center"
                                                style="background-color:gray; color:white; max-width:80px">
                                                <div hidden>Z</div>Total
                                            </td>
                                            <td class="minColumnWidth" hidden></td>
                                            <td class="minColumnWidth" hidden></td>
                                            <td class="minColumnWidth"><?php echo number_format((int) $data['total_qty_minimum'], 0, ',', '.'); ?></td>

                                            <div class="text-center">
                                                <td class="minColumnWidth"><?php echo number_format((int) $data['total_retail_stock_fh'], 0, ',', '.'); ?></td>
                                                <td class="minColumnWidth"><?php echo number_format((int) $data['total_retail_stock_hw'], 0, ',', '.'); ?></td>
                                                <td class="minColumnWidth"><?php echo number_format((int) $data['total_retail_stock_zte'], 0, ',', '.'); ?></td>
                                                <td class="minColumnWidth"><?php echo number_format((int) $data['total_retail_stock_alu'], 0, ',', '.'); ?></td>
                                                <td class="minColumnWidth"><?php echo number_format((int) $data['total_retail_stock_all'], 0, ',', '.'); ?></td>

                                                <td class="minColumnWidth"><?php echo number_format((int) $data['total_premium_stock_fh'], 0, ',', '.'); ?></td>
                                                <td class="minColumnWidth"><?php echo number_format((int) $data['total_premium_stock_hw'], 0, ',', '.'); ?></td>
                                                <td class="minColumnWidth"><?php echo number_format((int) $data['total_premium_stock_zte'], 0, ',', '.'); ?></td>
                                                <td class="minColumnWidth"><?php echo number_format((int) $data['total_premium_stock_all'], 0, ',', '.'); ?></td>

                                                <td class="minColumnWidth"><?php echo number_format((int) $data['total_gap_retail_stock_fh'], 0, ',', '.'); ?></td>
                                                <td class="minColumnWidth"><?php echo number_format((int) $data['total_gap_retail_stock_hw'], 0, ',', '.'); ?></td>
                                                <td class="minColumnWidth"><?php echo number_format((int) $data['total_gap_retail_stock_zte'], 0, ',', '.'); ?></td>
                                                <td class="minColumnWidth"><?php echo number_format((int) $data['total_gap_retail_stock_alu'], 0, ',', '.'); ?></td>
                                                <td class="minColumnWidth"><?php echo number_format((int) $data['total_gap_stock_retail'], 0, ',', '.'); ?></td>

                                                <td class="minColumnWidth"><?php echo number_format((int) $data['total_gap_premium_stock_fh'], 0, ',', '.'); ?></td>
                                                <td class="minColumnWidth"><?php echo number_format((int) $data['total_gap_premium_stock_hw'], 0, ',', '.'); ?></td>
                                                <td class="minColumnWidth"><?php echo number_format((int) $data['total_gap_premium_stock_zte'], 0, ',', '.'); ?></td>
                                                <td class="minColumnWidth"><?php echo number_format((int) $data['total_gap_premium_stock'], 0, ',', '.'); ?></td>

                                                <td class="minColumnWidth">{{ $qty_kirim_retail_fh }}</td>
                                                <td class="minColumnWidth">{{ $qty_kirim_retail_hw }}</td>
                                                <td class="minColumnWidth">{{ $qty_kirim_retail_zte }}</td>
                                                <td class="minColumnWidth">{{ $qty_kirim_retail_alu }}</td>

                                                <td class="minColumnWidth">{{ $qty_kirim_premium_fh }}</td>
                                                <td class="minColumnWidth">{{ $qty_kirim_premium_hw }}</td>
                                                <td class="minColumnWidth">{{ $qty_kirim_premium_zte }}</td>

                                                <td class="minColumnWidth"><?php echo number_format((int) $data['total_retail_fh_minimum'], 0, ',', '.'); ?></td>
                                                <td class="minColumnWidth"><?php echo number_format((int) $data['total_retail_hw_minimum'], 0, ',', '.'); ?></td>
                                                <td class="minColumnWidth"><?php echo number_format((int) $data['total_retail_zte_minimum'], 0, ',', '.'); ?></td>
                                                <td class="minColumnWidth"><?php echo number_format((int) $data['total_retail_alu_minimum'], 0, ',', '.'); ?></td>
                                                <td class="minColumnWidth"><?php echo number_format((int) $data['total_retail_minimum'], 0, ',', '.'); ?></td>

                                                <td class="minColumnWidth"><?php echo number_format((int) $data['total_premium_fh_minimum'], 0, ',', '.'); ?></td>
                                                <td class="minColumnWidth"><?php echo number_format((int) $data['total_premium_hw_minimum'], 0, ',', '.'); ?></td>
                                                <td class="minColumnWidth"><?php echo number_format((int) $data['total_premium_zte_minimum'], 0, ',', '.'); ?></td>
                                                <td class="minColumnWidth"><?php echo number_format((int) $data['total_premium_minimum'], 0, ',', '.'); ?></td>

                                                <td class="minColumnWidth"><?php echo number_format((int) $data['total_on_delivery_retail_fiberhome'], 0, ',', '.'); ?></td>
                                                <td class="minColumnWidth"><?php echo number_format((int) $data['total_on_delivery_retail_huawei'], 0, ',', '.'); ?></td>
                                                <td class="minColumnWidth"><?php echo number_format((int) $data['total_on_delivery_retail_zte'], 0, ',', '.'); ?></td>
                                                <td class="minColumnWidth"><?php echo number_format((int) $data['total_on_delivery_retail_nokia'], 0, ',', '.'); ?></td>
                                                <td class="minColumnWidth"><?php echo number_format((int) $data['total_on_delivery_retail_all'], 0, ',', '.'); ?></td>

                                                <td class="minColumnWidth"><?php echo number_format((int) $data['total_on_delivery_premium_fiberhome'], 0, ',', '.'); ?></td>
                                                <td class="minColumnWidth"><?php echo number_format((int) $data['total_on_delivery_premium_huawei'], 0, ',', '.'); ?></td>
                                                <td class="minColumnWidth"><?php echo number_format((int) $data['total_on_delivery_premium_zte'], 0, ',', '.'); ?></td>
                                                <td class="minColumnWidth"><?php echo number_format((int) $data['total_on_delivery_premium_all'], 0, ',', '.'); ?></td>
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

</body>
<script>
    $("document").ready(function() {
        $("#filterTable").dataTable({
            "searching": true,
            "scrollX": true,
            "bPaginate": false,
            "ordering": false,
            "fnInfoCallback": function(oSettings, iStart, iEnd, iMax, iTotal, sPre) {
                return "Showing " + iStart + " to " + iEnd + " of " + iMax +
                    " entries <a class='btn btn-primary ml-3' onClick='showTableDetail()'>View Detail</a>";
            }
        });

        $("#filterTableDetail").dataTable({
            "searching": true,
            "scrollX": true,
            "bPaginate": false,
            "ordering": false,
            "fnInfoCallback": function(oSettings, iStart, iEnd, iMax, iTotal, sPre) {
                return "Showing " + iStart + " to " + iEnd + " of " + iMax +
                    " entries <a class='btn btn-primary ml-3' onClick='unshowTableDetail()'>View Less</a>";
            }
        });

        //Take the category filter drop down and append it to the datatables_filter div. 
        //You can use this same idea to move the filter anywhere withing the datatable that you want.
        $("#filterTable_filter.dataTables_filter").append($("#witelFilter"));
        $("#filterTable_filter.dataTables_filter").append($("#categoryFilter"));
        $("#filterTable_filter.dataTables_filter").append($("#soFilter"));
        var table = $('#filterTable').DataTable();
        // var tableDetail = $('#filterTableDetail').DataTable();

        // tableDetail.draw();

        // $('#filterTable_filter.dataTables_info').append(table.fnSettings().fnRecordsDisplay() + ' entries tes');

        //Get the column index for the Category column to be used in the method below ($.fn.dataTable.ext.search.push)
        //This tells datatables what column to filter on when a user selects a value from the dropdown.
        //It's important that the text used here (Category) is the same for used in the header of the column to filter

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

        //Set the change event for the Category Filter dropdown to redraw the datatable each time
        //a user selects a new filter.
        // $("#categoryFilter").change(function (e) {
        //   table.draw();
        // });

        // $("#witelFilter").change(function (e) {
        //   table.draw();
        // });

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

    // var sel1 = document.querySelector('#categoryFilter');
    // var sel2 = document.querySelector('#witelFilter');
    // var sel3 = document.querySelector('#soFilter');
    // var options2 = sel2.querySelectorAll('option');
    // var options3 = sel3.querySelectorAll('option');

    // function giveSelection(selValue) {
    //   sel2.innerHTML = '';
    //   for(var i = 0; i < options2.length; i++) {
    //     // if(options2[i].dataset.option === selValue) {
    //     if(options2[i].value.includes(selValue) || options2[i].value == "") {
    //       sel2.appendChild(options2[i]);
    //     }
    //   }

    //   sel3.innerHTML = '';
    //   for(var i = 0; i < options3.length; i++) {
    //     // if(options2[i].dataset.option === selValue) {
    //     if(options3[i].dataset.option.includes(selValue) || options3[i].value == "") {
    //       sel3.appendChild(options3[i]);
    //     }
    //   }
    // }

    // function giveSelectionTASO(selValue) {
    //   sel3.innerHTML = '';

    //   if(selValue == "All SO"){
    //     selValue = "";
    //   }


    //   if(selValue.includes("TREG") && !selValue.includes("WH")){
    //     for(var i = 0; i < options3.length; i++) {
    //       // if(options2[i].dataset.option === selValue) {
    //       if(options3[i].dataset.option.includes(selValue) || options3[i].value == "") {
    //         sel3.appendChild(options3[i]);
    //       }
    //     }
    //   }else{
    //     for(var i = 0; i < options3.length; i++) {
    //       // if(options2[i].dataset.option === selValue) {
    //       if(options3[i].value.includes(selValue) || options3[i].value == "") {
    //         sel3.appendChild(options3[i]);
    //       }
    //     }
    //   }
    // }

    // function giveExportSelection(){
    //   value = document.getElementById('exportFilter').value;
    //   document.getElementById("form_export").action = "{{ URL('/export_data_tmp') }}"+"/"+value;
    // }
</script>

</html>
