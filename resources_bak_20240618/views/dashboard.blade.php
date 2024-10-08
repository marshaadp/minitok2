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
            width: 400px;
            min-width: 400px;
            max-width: 400px;
            left: 0px;
        }

        .sticky-col {
            position: -webkit-sticky !importance;
            position: sticky;
            background-color: white !importance;
        }
    </style>
    <link rel="icon" href="{{ asset('resources/img/minitok.jpeg') }}">
</head>

<body>
    @if (session('role') == 'Administrator')
        @include('template.navbar')
    @else
        @include('template.navbar_biasa')
    @endif
    <div class="container-fluid" style=" width: 105.5%">
                    <div class="card mb-3 mt-3">
                        <div class="card-body mb-2">

                            @if (session('role') == 'Administrator')
                                <div class="export-filter mb-3">
                                    <form id="form_export" action="{{ URL('/export_data_tmp/all') }}" method="POST"
                                        class="row">
                                        @csrf
                                        <div class="col-2">
                                            <select id="exportFilter" class="form-control" style="margin-left:0;"
                                                onchange="giveExportSelection()">
                                                <option value="all">All</option>
                                                <option value="merah">Merah</option>
                                                <option value="kuning">Kuning</option>
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <button class="btn btn-secondary" value="false" type="submit">Export
                                                Data</button>
                                        </div>
                                        <!-- <div class="col-auto ml-auto">
              <a class="btn btn-secondary" href="{{ URL('export_qty_kirim') }}"value="false" type="submit">Export Qty Kirim</a>
            </div> -->
                                    </form>
                                </div>
                            @endif

                            <div class="table-responsive">
                                <div class="category-filter">
                                    <select id="categoryFilter" class="form-control"
                                        onchange="giveSelection(this.value)">
                                        <option value="">All TREG</option>
                                        <option value="WH TR TREG1">TREG 1</option>
                                        <option value="WH TR TREG2">TREG 2</option>
                                        <option value="WH TR TREG3">TREG 3</option>
                                        <option value="WH TR TREG4">TREG 4</option>
                                        <option value="WH TR TREG5">TREG 5</option>
                                        <option value="WH TR TREG6">TREG 6</option>
                                        <option value="WH TR TREG7">TREG 7</option>
                                    </select>
                                </div>

                                <div class="category-filter">
                                    <select id="soFilter" class="form-control mt-3">
                                        <option data-option="" value="">All SO</option>
                                        @foreach ($data['witel'] as $witel)
                                            @if (str_contains(strtolower($witel->lokasi_wh), 'so') || str_contains(strtolower($witel->lokasi_wh), 'wh so'))
                                                <option data-option="{{ $witel->regional }}"
                                                    value="{{ $witel->witel }}">{{ $witel->lokasi_wh }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="category-filter">
                                    <select id="witelFilter" class="form-control mt-3"
                                        onchange="giveSelectionTASO(this.options[this.selectedIndex].text)">
                                        <option data-option="" value="">All Witel</option>
                                        @foreach ($data['witel'] as $witel)
                                            @if (str_contains(strtolower($witel->lokasi_wh), 'witel') ||
                                                    (str_contains(strtolower($witel->lokasi_wh), 'treg') &&
                                                        !str_contains(strtolower($witel->lokasi_wh), 'wh tr treg')))
                                                <option data-option="{{ $witel->regional }}"
                                                    value="{{ $witel->regional }}">{{ $witel->lokasi_wh }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <table class="table table-bordered" id="filterTable" width="100%">
                                    <thead>
                                        <tr class="text-center">
                                            <th rowspan="3"
                                                style="min-width: 400px; text-align: center; vertical-align: middle; background-color:white"
                                                class="first-col sticky-col">Warehouse</th>
                                            <th rowspan="3"hidden>regional</th>
                                            <th rowspan="3"hidden>witel</th>
                                            <th rowspan="3" style="text-align: center; vertical-align: middle;">
                                                Minimum Qty</th>
                                            <th rowspan="2" colspan="4">Minimum Stock Requirement Retail</th>
                                            <th rowspan="3" style="text-align: center; vertical-align: middle;">Total
                                            </th>
                                            <th rowspan="2" colspan="3">Minimum Stock Requirement Premium</th>
                                            <th rowspan="3" style="text-align: center; vertical-align: middle;">Total
                                            </th>

                                            <th colspan="9">Stock SCMT</th>

                                            <th colspan="9">GAP Stock</th>

                                            <!--<th colspan="7">Threshold Atas</th>-->

                                            <!--<th colspan="7">Threshold Bawah</th>-->

                                            @if (session('role') == 'Administrator')
                                                <th colspan="7">Qty Kirim</th>
                                            @endif
                                        </tr>
                                        <tr class="text-center">
                                            <th colspan="4">Retail</th>
                                            <th rowspan="2"
                                                style="max-width:50px; text-align: center; vertical-align: middle;">
                                                Total</th>
                                            <th colspan="3">Premium</th>
                                            <th rowspan="2"
                                                style="max-width:50px; text-align: center; vertical-align: middle;">
                                                Total</th>

                                            <th colspan="4">Retail</th>
                                            <th rowspan="2"
                                                style="max-width:50px; text-align: center; vertical-align: middle;">
                                                Total</th>
                                            <th colspan="3">Premium</th>
                                            <th rowspan="2"
                                                style="max-width:50px; text-align: center; vertical-align: middle;">
                                                Total</th>

                                            @if (session('role') == 'Administrator')
                                                <th colspan="4">Retail</th>
                                                <th colspan="3">Premium</th>
                                            @endif
                                        </tr>
                                        <tr class="text-center" style="max-width:50px;">
                                            <th>FH</th>
                                            <th>HW</th>
                                            <th>ZTE</th>
                                            <th>ALU</th>

                                            <th>FH</th>
                                            <th>HW</th>
                                            <th>ZTE</th>

                                            <th>FH</th>
                                            <th>HW</th>
                                            <th>ZTE</th>
                                            <th>ALU</th>

                                            <th>FH</th>
                                            <th>HW</th>
                                            <th>ZTE</th>

                                            <th>FH</th>
                                            <th>HW</th>
                                            <th>ZTE</th>
                                            <th>ALU</th>

                                            <th>FH</th>
                                            <th>HW</th>
                                            <th>ZTE</th>

                                            @if (session('role') == 'Administrator')
                                                <th>FH</th>
                                                <th>HW</th>
                                                <th>ZTE</th>
                                                <th>ALU</th>

                                                <th>FH</th>
                                                <th>HW</th>
                                                <th>ZTE</th>
                                            @endif
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($data['witel'] as $idx => $d)
                                            <tr>
                                                <td value="" class="first-col sticky-col"
                                                    style="background-color:white">
                                                    @if ($data['jenis_warehouse'] == 'Witel' || $data['jenis_warehouse'] == 'TA SO')
                                                        <a>{{ $d->lokasi_wh }}<a>
                                                            @else($data["jenis_warehouse"] == "Witel")
                                                                {{ $d->lokasi_wh }}
                                                    @endif
                                                </td>
                                                <td hidden>{{ $d->regional }}</td>
                                                <td hidden>{{ $d->witel }}</td>
                                                <td><?php echo number_format((int) $d->minimum_qty, 0, ',', '.'); ?></td>

                                                <div class="text-center">
                                                    <td style="min-width:50px;"><?php echo number_format((int) $d->retail_fh, 0, ',', '.'); ?></td>
                                                    <td style="min-width:50px;"><?php echo number_format((int) $d->retail_hw, 0, ',', '.'); ?></td>
                                                    <td style="min-width:50px;"><?php echo number_format((int) $d->retail_zte, 0, ',', '.'); ?></td>
                                                    <td style="min-width:50px;"><?php echo number_format((int) $d->retail_alu, 0, ',', '.'); ?></td>
                                                    <td style="min-width:50px;"><?php echo number_format((int) $d->total_retail, 0, ',', '.'); ?></td>

                                                    <td style="min-width:50px;"><?php echo number_format((int) $d->premium_fh, 0, ',', '.'); ?></td>
                                                    <td style="min-width:50px;"><?php echo number_format((int) $d->premium_hw, 0, ',', '.'); ?></td>
                                                    <td style="min-width:50px;"><?php echo number_format((int) $d->premium_zte, 0, ',', '.'); ?></td>
                                                    <td style="min-width:50px;"><?php echo number_format((int) $d->total_premium, 0, ',', '.'); ?></td>

                                                    <td style="min-width:50px;"><?php echo number_format((int) $d->retail_stock_fiberhome, 0, ',', '.'); ?></td>
                                                    <td style="min-width:50px;"><?php echo number_format((int) $d->retail_stock_huawei, 0, ',', '.'); ?></td>
                                                    <td style="min-width:50px;"><?php echo number_format((int) $d->retail_stock_zte, 0, ',', '.'); ?></td>
                                                    <td style="min-width:50px;"><?php echo number_format((int) $d->retail_stock_nokia, 0, ',', '.'); ?></td>
                                                    <td style="min-width:50px;"><?php echo number_format((int) $d->total_retail_stock, 0, ',', '.'); ?></td>

                                                    <td style="min-width:50px;"><?php echo number_format((int) $d->premium_stock_fiberhome, 0, ',', '.'); ?></td>
                                                    <td style="min-width:50px;"><?php echo number_format((int) $d->premium_stock_huawei, 0, ',', '.'); ?></td>
                                                    <td style="min-width:50px;"><?php echo number_format((int) $d->premium_stock_zte, 0, ',', '.'); ?></td>
                                                    <td style="min-width:50px;"><?php echo number_format((int) $d->total_premium_stock, 0, ',', '.'); ?></td>

                                                    <td style="min-width:50px; background-color: #77DD77;">
                                                        <?php echo number_format((int) $d->retail_stock_fiberhome - $d->retail_fh, 0, ',', '.'); ?></td>
                                                    <td style="min-width:50px; background-color: #77DD77;">
                                                        <?php echo number_format((int) $d->retail_stock_huawei - $d->retail_hw, 0, ',', '.'); ?></td>
                                                    <td style="min-width:50px; background-color: #77DD77;">
                                                        <?php echo number_format((int) $d->retail_stock_zte - $d->retail_zte, 0, ',', '.'); ?></td>
                                                    <td style="min-width:50px; background-color: #77DD77;">
                                                        <?php echo number_format((int) $d->retail_stock_nokia - $d->retail_alu, 0, ',', '.'); ?></td>
                                                    <td
                                                        style="min-width:50px; background-color: #77DD77; @if ($d->total_retail_stock - $d->total_retail < -($d->total_retail / 2)) background-color : red; color: white; @elseif($d->total_retail_stock - $d->total_retail < 0) background-color: yellow; @endif ">
                                                        <?php echo number_format((int) $d->total_retail_stock - $d->total_retail, 0, ',', '.'); ?></td>

                                                    <td style="min-width:50px; background-color: #77DD77;">
                                                        <?php echo number_format((int) $d->premium_stock_fiberhome - $d->premium_fh, 0, ',', '.'); ?> </td>
                                                    <td style="min-width:50px; background-color: #77DD77;">
                                                        <?php echo number_format((int) $d->premium_stock_huawei - $d->premium_hw, 0, ',', '.'); ?> </td>
                                                    <td style="min-width:50px; background-color: #77DD77;">
                                                        <?php echo number_format((int) $d->premium_stock_zte - $d->premium_zte, 0, ',', '.'); ?></td>
                                                    <td
                                                        style="min-width:50px; background-color: #77DD77; @if ($d->total_premium_stock - $d->total_premium < -($d->total_premium / 2)) background-color : red; color: white; @elseif($d->total_premium_stock - $d->total_premium < 0) background-color: yellow; @endif ">
                                                        <?php echo number_format((int) $d->total_premium_stock - $d->total_premium, 0, ',', '.'); ?></td>

                                                    <td style="min-width:50px;">
                                                        @if ($d->qty_kirim_retail_fh != 0)
                                                            <?php echo number_format((int) $d->qty_kirim_retail_fh, 0, ',', '.'); ?>
                                                        @endif
                                                    </td>
                                                    <td style="min-width:50px;">
                                                        @if ($d->qty_kirim_retail_hw != 0)
                                                            <?php echo number_format((int) $d->qty_kirim_retail_hw, 0, ',', '.'); ?>
                                                        @endif
                                                    </td>
                                                    <td style="min-width:50px;">
                                                        @if ($d->qty_kirim_retail_zte != 0)
                                                            <?php echo number_format((int) $d->qty_kirim_retail_zte, 0, ',', '.'); ?>
                                                        @endif
                                                    </td>
                                                    <td style="min-width:50px;">
                                                        @if ($d->qty_kirim_retail_alu != 0)
                                                            <?php echo number_format((int) $d->qty_kirim_retail_alu, 0, ',', '.'); ?>
                                                        @endif
                                                    </td>

                                                    <td style="min-width:50px;">
                                                        @if ($d->qty_kirim_premium_fh != 0)
                                                            <?php echo number_format((int) $d->qty_kirim_premium_fh, 0, ',', '.'); ?>
                                                        @endif
                                                    </td>
                                                    <td style="min-width:50px;">
                                                        @if ($d->qty_kirim_premium_hw != 0)
                                                            <?php echo number_format((int) $d->qty_kirim_premium_hw, 0, ',', '.'); ?>
                                                        @endif
                                                    </td>
                                                    <td style="min-width:50px;">
                                                        @if ($d->qty_kirim_premium_zte != 0)
                                                            <?php echo number_format((int) $d->qty_kirim_premium_zte, 0, ',', '.'); ?>
                                                        @endif
                                                    </td>
                                                </div>
                                            </tr>
                                        @endforeach

                                        <!--<tr> -->
                                        <!--<td>Total</td>-->
                                        <!--<td hidden></td>-->
                                        <!--<td hidden></td>-->
                                        <!--<td>34765</td>-->
                                        <!--<td colspan="28"></td>-->
                                        <!--</tr>-->
                                        <tr>
                                            <td value="" class="first-col sticky-col"
                                                style="background-color:white">
                                                <div hidden>Z</div>Total
                                            </td>
                                            <td hidden></td>
                                            <td hidden></td>
                                            <td><?php echo number_format((int) $data['total_qty_minimum'], 0, ',', '.'); ?></td>

                                            <div class="text-center">
                                                <td style="min-width:50px;"><?php echo number_format((int) $data['total_retail_fh_minimum'], 0, ',', '.'); ?></td>
                                                <td style="min-width:50px;"><?php echo number_format((int) $data['total_retail_hw_minimum'], 0, ',', '.'); ?></td>
                                                <td style="min-width:50px;"><?php echo number_format((int) $data['total_retail_zte_minimum'], 0, ',', '.'); ?></td>
                                                <td style="min-width:50px;"><?php echo number_format((int) $data['total_retail_alu_minimum'], 0, ',', '.'); ?></td>
                                                <td style="min-width:50px;"><?php echo number_format((int) $data['total_retail_minimum'], 0, ',', '.'); ?></td>

                                                <td style="min-width:50px;"><?php echo number_format((int) $data['total_premium_fh_minimum'], 0, ',', '.'); ?></td>
                                                <td style="min-width:50px;"><?php echo number_format((int) $data['total_premium_hw_minimum'], 0, ',', '.'); ?></td>
                                                <td style="min-width:50px;"><?php echo number_format((int) $data['total_premium_zte_minimum'], 0, ',', '.'); ?></td>
                                                <td style="min-width:50px;"><?php echo number_format((int) $data['total_premium_minimum'], 0, ',', '.'); ?></td>

                                                <td style="min-width:50px;"><?php echo number_format((int) $data['total_retail_stock_fh'], 0, ',', '.'); ?></td>
                                                <td style="min-width:50px;"><?php echo number_format((int) $data['total_retail_stock_hw'], 0, ',', '.'); ?></td>
                                                <td style="min-width:50px;"><?php echo number_format((int) $data['total_retail_stock_zte'], 0, ',', '.'); ?></td>
                                                <td style="min-width:50px;"><?php echo number_format((int) $data['total_retail_stock_alu'], 0, ',', '.'); ?></td>
                                                <td style="min-width:50px;"><?php echo number_format((int) $data['total_retail_stock_all'], 0, ',', '.'); ?></td>

                                                <td style="min-width:50px;"><?php echo number_format((int) $data['total_premium_stock_fh'], 0, ',', '.'); ?></td>
                                                <td style="min-width:50px;"><?php echo number_format((int) $data['total_premium_stock_hw'], 0, ',', '.'); ?></td>
                                                <td style="min-width:50px;"><?php echo number_format((int) $data['total_premium_stock_zte'], 0, ',', '.'); ?></td>
                                                <td style="min-width:50px;"><?php echo number_format((int) $data['total_premium_stock_all'], 0, ',', '.'); ?></td>

                                                <td style="min-width:50px;"><?php echo number_format((int) $data['total_gap_retail_stock_fh'], 0, ',', '.'); ?></td>
                                                <td style="min-width:50px;"><?php echo number_format((int) $data['total_gap_retail_stock_hw'], 0, ',', '.'); ?></td>
                                                <td style="min-width:50px;"><?php echo number_format((int) $data['total_gap_retail_stock_zte'], 0, ',', '.'); ?></td>
                                                <td style="min-width:50px;"><?php echo number_format((int) $data['total_gap_retail_stock_alu'], 0, ',', '.'); ?></td>
                                                <td style="min-width:50px;"><?php echo number_format((int) $data['total_gap_stock_retail'], 0, ',', '.'); ?></td>

                                                <td style="min-width:50px;"><?php echo number_format((int) $data['total_gap_premium_stock_fh'], 0, ',', '.'); ?></td>
                                                <td style="min-width:50px;"><?php echo number_format((int) $data['total_gap_premium_stock_hw'], 0, ',', '.'); ?></td>
                                                <td style="min-width:50px;"><?php echo number_format((int) $data['total_gap_premium_stock_zte'], 0, ',', '.'); ?></td>
                                                <td style="min-width:50px;"><?php echo number_format((int) $data['total_gap_premium_stock'], 0, ',', '.'); ?></td>

                                                <td style="min-width:50px;"></td>
                                                <td style="min-width:50px;"></td>
                                                <td style="min-width:50px;"></td>
                                                <td style="min-width:50px;"></td>


                                                <td style="min-width:50px;"></td>
                                                <td style="min-width:50px;"></td>
                                                <td style="min-width:50px;"></td>
                                            </div>
                                        </tr>

                                    </tbody>
                                </table>
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
            "ordering": false,
        });

        //Get a reference to the new datatable
        var table = $('#filterTable').DataTable();

        //Take the category filter drop down and append it to the datatables_filter div. 
        //You can use this same idea to move the filter anywhere withing the datatable that you want.
        $("#filterTable_filter.dataTables_filter").append($("#categoryFilter"));
        $("#filterTable_filter.dataTables_filter").append($("#soFilter"));
        $("#filterTable_filter.dataTables_filter").append($("#witelFilter"));

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

    var sel1 = document.querySelector('#categoryFilter');
    var sel2 = document.querySelector('#witelFilter');
    var sel3 = document.querySelector('#soFilter');
    var options2 = sel2.querySelectorAll('option');
    var options3 = sel3.querySelectorAll('option');

    function giveSelection(selValue) {
        sel2.innerHTML = '';
        for (var i = 0; i < options2.length; i++) {
            // if(options2[i].dataset.option === selValue) {
            if (options2[i].value.includes(selValue) || options2[i].value == "") {
                sel2.appendChild(options2[i]);
            }
        }

        sel3.innerHTML = '';
        for (var i = 0; i < options3.length; i++) {
            // if(options2[i].dataset.option === selValue) {
            if (options3[i].dataset.option.includes(selValue) || options3[i].value == "") {
                sel3.appendChild(options3[i]);
            }
        }
    }

    function giveSelectionTASO(selValue) {
        sel3.innerHTML = '';

        if (selValue == "All SO") {
            selValue = "";
        }


        if (selValue.includes("TREG") && !selValue.includes("WH")) {
            for (var i = 0; i < options3.length; i++) {
                // if(options2[i].dataset.option === selValue) {
                if (options3[i].dataset.option.includes(selValue) || options3[i].value == "") {
                    sel3.appendChild(options3[i]);
                }
            }
        } else {
            for (var i = 0; i < options3.length; i++) {
                // if(options2[i].dataset.option === selValue) {
                if (options3[i].value.includes(selValue) || options3[i].value == "") {
                    sel3.appendChild(options3[i]);
                }
            }
        }
    }

    function giveExportSelection() {
        value = document.getElementById('exportFilter').value;
        document.getElementById("form_export").action = "{{ URL('/export_data_tmp') }}" + "/" + value;
    }
</script>

</html>
