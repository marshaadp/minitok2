<!doctype html>
<html lang="en">

<head>
    <title>Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @include('template.import_datatable')
    <style>
        select.form-control {
            display: inline;
            width: 200px;
            margin-left: 25px;
        }

        .first-col {
            width: 200px;
            min-width: 200px;
            max-width: 200px;
            left: 0px;
        }

        .sticky-col {
            position: -webkit-sticky !importance;
            position: sticky;
            background-color: white !importance;
        }

        .first-less-col {
            width: 200px;
            /*min-width: 400px;*/
            max-width: 200px;
            left: 0px;
        }

        .sticky-less-col {
            position: -webkit-sticky !importance;
            position: sticky;
            background-color: white !importance;
        }

        .minColumnWidth {
            width: 100px;
            min-width: 100px;
            max-width: 100px;
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

        .multiselect {
            width: 200px;
        }

        .selectBox {
            position: relative;
        }

        .selectBox select {
            width: 100%;
            font-weight: bold;
        }

        .overSelect {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
        }

        #checkboxes {
            display: none;
            border: 1px #dadada solid;
        }

        #checkboxes label {
            display: block;
        }

        #checkboxes label:hover {
            background-color: #d3d3d3;
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
                <div class="card mb-3 mt-3">
                    <div class="card-body mb-2">
                        <div class="category-filter">


                            <div class="table-responsive">
                                <div class="category-filter mb-3">
                                    <form>
                                        <div class="multiselect">
                                            <div class="selectBox" id="categoryFilter" onclick="showCheckboxes()">
                                                <select>
                                                    <option>Select an option</option>
                                                </select>
                                                <div class="overSelect"></div>
                                            </div>
                                            <div id="checkboxes" id="categoryFilter">
                                                <label for="one">
                                                    <input type="checkbox" id="one" />First checkbox</label>
                                                <label for="two">
                                                    <input type="checkbox" id="two" />Second checkbox</label>
                                                <label for="three">
                                                    <input type="checkbox" id="three" />Third checkbox</label>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- <select id="categoryFilter" class="form-control" style="height: 30px" onchange="giveSelection(this.value)" multiple>
              <option value="">All TREG</option>
              <option value="WH TR TREG 1">TREG 1</option>
              <option value="WH TR TREG 2">TREG 2</option>
              <option value="WH TR TREG 3">TREG 3</option>
              <option value="WH TR TREG 4">TREG 4</option>
              <option value="WH TR TREG 5">TREG 5</option>
              <option value="WH TR TREG 6">TREG 6</option>
              <option value="WH TR TREG 7">TREG 7</option>
            </select> -->
                                </div>

                                <div id="tableBiasa">
                                    <table class="table table-bordered" id="filterTable" width="100%">
                                        <thead>
                                            <tr class="text-center"
                                                style="color:black; background-color:gray; color:white;">
                                                <th class="first-less-col sticky-less-col"
                                                    style="text-align: center; vertical-align: middle; background-color:gray; color:white;">
                                                    Warehouse</th>
                                                <th hidden>regional</th>
                                                <th hidden>witel</th>
                                                <th class="minColumnWidth" colspan="1">Total Stock STB</th>
                                                <th class="minColumnWidth" colspan="1">Total GAP Stock</th>
                                                <th class="minColumnWidth" colspan="1">Total Kebutuhan</th>
                                                <th class="minColumnWidth" colspan="1">Total Minimum Stock
                                                    Requirement STB</th>
                                                <th class="minColumnWidth" colspan="1">Total On Delivery STB</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $kebutuhan_stb = 0; ?>
                                            @foreach ($data['witel'] as $idx => $d)
                                                <tr class="text-center">
                                                    <td class="first-less-col sticky-less-col"
                                                        style="background-color:gray; color:white; font-weight: bold;">
                                                        @if ($data['jenis_warehouse'] == 'Witel' || $data['jenis_warehouse'] == 'TA SO')
                                                            <a style="text-decoration:none; color: white; font-weight: bold;"
                                                                href="<?php echo url('/rekap_delivery_stb/') . '/' . $data['jenis_warehouse'] . '/' . $d->lokasi_wh; ?>">{{ $d->lokasi_wh }}</a>
                                                        @else($data["jenis_warehouse"] == "Witel")
                                                            {{ $d->lokasi_wh }}
                                                        @endif
                                                    </td>
                                                    <td hidden>{{ $d->regional }}</td>
                                                    <td hidden>{{ $d->witel }}</td>

                                                    <td class="minColumnWidth text-center">{{ $d->total_stb }}</td>

                                                    <td class="minColumnWidth"
                                                        style="@if ($d->stb_stock_zte - $d->stb_zte < -($d->stb_zte * 0.75)) background-color : red; color: white; @elseif($d->stb_stock_zte - $d->stb_zte < 0) background-color: yellow; @else background-color: #77DD77; @endif ">
                                                        <?php echo number_format((int) $d->stb_stock_zte - $d->stb_zte, 0, ',', '.'); ?></td>

                                                    <td>
                                                        @if ($d->qty_kirim_stb_zte != 0)
                                                            <?php echo number_format((int) $d->qty_kirim_stb_zte, 0, ',', '.'); ?> <?php $kebutuhan_stb += $d->qty_kirim_stb_zte; ?>
                                                        @endif
                                                    </td>

                                                    <td class="minColumnWidth text-center">{{ $d->stb_zte }}</td>
                                                    <td class="minColumnWidth text-center">
                                                        {{ $d->on_delivery_total_stb }}</td>
                                                </tr>
                                            @endforeach
                                            <tr class="text-center"
                                                style="font-weight: bold; background-color:gray; color:white;">
                                                <td value="" class="sticky-less-col first-less-col text-center"
                                                    style="background-color:gray; color:white;">
                                                    <div hidden>Z</div>Total
                                                </td>
                                                <td hidden></td>
                                                <td hidden></td>

                                                <div class="text-center">
                                                    <td class="minColumnWidth"><?php echo number_format((int) $data['total_stb'], 0, ',', '.'); ?></td>
                                                    <td class="minColumnWidth"><?php echo number_format((int) $data['total_gap_stb_stock_zte'], 0, ',', '.'); ?></td>
                                                    <td class="minColumnWidth"><?php echo number_format((int) $kebutuhan_stb, 0, ',', '.'); ?></td>
                                                    <td class="minColumnWidth"><?php echo number_format((int) $data['total_stb_zte_minimum'], 0, ',', '.'); ?></td>
                                                    <td class="minColumnWidth"><?php echo number_format((int) $data['on_delivery_total_stb'], 0, ',', '.'); ?></td>
                                                </div>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div id="tableDetail">
                                    <table class="table table-bordered" id="filterTableDetail" width="100%">
                                        <thead>
                                            <tr class="text-center"
                                                style="color:black; background-color:gray; color:white;">
                                                <th rowspan="2" class="first-col sticky-col"
                                                    style="text-align: center; vertical-align: middle; color:black; background-color:gray; color:white;">
                                                    Warehouse</th>
                                                <th colspan="2">Total Stock STB</th>
                                                <th colspan="2">GAP Stock</th>
                                                <th colspan="2">Kebutuhan</th>
                                                <th colspan="2">Minimum Stock Requirement STB</th>
                                                <th colspan="2">On Delivery STB</th>
                                            </tr>
                                            <tr class="text-center" style="background-color:gray; color:white;">
                                                <th hidden>regional</th>
                                                <th hidden>witel</th>
                                                <th class="minColumnWidth"
                                                    style="text-align: center; vertical-align: middle;">ZTE</th>
                                                <th class="minColumnWidth"
                                                    style="text-align: center; vertical-align: middle;">FH</th>

                                                <th class="minColumnWidth"
                                                    style="text-align: center; vertical-align: middle;">ZTE</th>
                                                <th class="minColumnWidth"
                                                    style="text-align: center; vertical-align: middle;">FH</th>

                                                <th class="minColumnWidth"
                                                    style="text-align: center; vertical-align: middle;">ZTE</th>
                                                <th class="minColumnWidth"
                                                    style="text-align: center; vertical-align: middle;">FH</th>

                                                <th class="minColumnWidth"
                                                    style="text-align: center; vertical-align: middle;">ZTE</th>
                                                <th class="minColumnWidth"
                                                    style="text-align: center; vertical-align: middle;">FH</th>

                                                <th class="minColumnWidth"
                                                    style="text-align: center; vertical-align: middle;">ZTE</th>
                                                <th class="minColumnWidth"
                                                    style="text-align: center; vertical-align: middle;">FH</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $kebutuhan_stb = 0; ?>
                                            @foreach ($data['witel'] as $idx => $d)
                                                <tr class="text-center">
                                                    <td value="" class="first-col sticky-col"
                                                        style="background-color:gray; color:white;">
                                                        @if ($data['jenis_warehouse'] == 'Witel' || $data['jenis_warehouse'] == 'TA SO')
                                                            <a style="text-decoration:none; color: white; font-weight: bold"
                                                                href="<?php echo url('/rekap_delivery_stb/') . '/' . $data['jenis_warehouse'] . '/' . $d->lokasi_wh; ?>">{{ $d->lokasi_wh }}</a>
                                                        @else($data["jenis_warehouse"] == "Witel")
                                                            {{ $d->lokasi_wh }}
                                                        @endif
                                                    </td>
                                                    <td hidden>{{ $d->regional }}</td>
                                                    <td hidden>{{ $d->witel }}</td>

                                                    <td class="minColumnWidth text-center">{{ $d->stb_stock_zte }}
                                                    </td>
                                                    <td class="minColumnWidth"></td>

                                                    <td class="minColumnWidth"
                                                        style="@if ($d->stb_stock_zte - $d->stb_zte < -($d->stb_zte * 0.75)) background-color : red; color: white; @elseif($d->stb_stock_zte - $d->stb_zte < 0) background-color: yellow; @else background-color: #77DD77; @endif ">
                                                        <?php echo number_format((int) $d->stb_stock_zte - $d->stb_zte, 0, ',', '.'); ?></td>
                                                    <td class="minColumnWidth"></td>

                                                    <td class="minColumnWidth">
                                                        @if ($d->qty_kirim_stb_zte != 0)
                                                            <?php echo number_format((int) $d->qty_kirim_stb_zte, 0, ',', '.'); ?> <?php $kebutuhan_stb += $d->qty_kirim_stb_zte; ?>
                                                        @endif
                                                    </td>
                                                    <td class="minColumnWidth"></td>

                                                    <td class="minColumnWidth text-center">{{ $d->stb_zte }}</td>
                                                    <td class="minColumnWidth"></td>

                                                    <td class="minColumnWidth text-center">
                                                        {{ $d->on_delivery_stb_zte }}</td>
                                                    <td class="minColumnWidth"></td>
                                                </tr>
                                            @endforeach
                                            <tr class="text-center"
                                                style="font-weight: bold; background-color:gray; color:white;">
                                                <td value="" class="first-col sticky-col text-center"
                                                    style="background-color:gray; color:white;">
                                                    <div hidden>Z</div>Total
                                                </td>
                                                <td hidden></td>
                                                <td hidden></td>

                                                <div class="text-center">
                                                    <td class="minColumnWidth"><?php echo number_format((int) $data['total_stb_stock_zte'], 0, ',', '.'); ?></td>
                                                    <td class="minColumnWidth"></td>

                                                    <td class="minColumnWidth"><?php echo number_format((int) $data['total_gap_stb_stock_zte'], 0, ',', '.'); ?></td>
                                                    <td class="minColumnWidth"></td>

                                                    <td class="minColumnWidth"><?php echo number_format((int) $kebutuhan_stb, 0, ',', '.'); ?></td>
                                                    <td class="minColumnWidth"></td>

                                                    <td class="minColumnWidth"><?php echo number_format((int) $data['total_stb_zte_minimum'], 0, ',', '.'); ?></td>
                                                    <td class="minColumnWidth"></td>

                                                    <td class="minColumnWidth"><?php echo number_format((int) $data['total_on_delivery_stb_zte'], 0, ',', '.'); ?></td>
                                                    <td class="minColumnWidth"></td>
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
                    " entries <a class='btn btn-primary' onClick='showTableDetail()'>View Detail</a>";
            }
        });

        var tableDetail = $("#filterTableDetail").dataTable({
            "searching": true,
            // "scrollX": true,
            "bPaginate": false,
            "ordering": false,
            "fnInfoCallback": function(oSettings, iStart, iEnd, iMax, iTotal, sPre) {
                return "Showing " + iStart + " to " + iEnd + " of " + iMax +
                    " entries <a class='btn btn-primary' onClick='unshowTableDetail()'>View Less</a>";
            }
        });

        var table = $('#filterTable').DataTable();
        var tableDetail = $('#filterTableDetail').DataTable();

        tableDetail.draw();
        document.getElementById("tableDetail").hidden = true;
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

    // var expanded = false;

    // function showCheckboxes() {
    //   var checkboxes = document.getElementById("checkboxes");
    //   if (!expanded) {
    //     checkboxes.style.display = "block";
    //     expanded = true;
    //   } else {
    //     checkboxes.style.display = "none";
    //     expanded = false;
    //   }
    // }
</script>

</html>
