<!doctype html>
<html lang="en">
  <head>
    <title>Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @include('template.import_datatable')
    <style>
      select.form-control{
        display: inline;
        width: 200px;
        margin-left: 25px;
      }
    </style>
  </head>
  <body>
    @include('template.navbar')
    <div class="container-fluid" style=" width: 105.5%">
      <!-- <div class="mb-3">
          <div class="card mt-3" style="">
              <div class="row justify-content-start">
                  <form class="mt-3" style="margin-left:40px" method="POST" action="{{URL('/upload_file')}}" enctype="multipart/form-data">
                  @csrf
                      <div class="form-group row">
                          <label tyle="margin-left:-10px">Masukan file retail untuk diupload:</label>
                      </div>
                      <div class="row">
                          <input class="form-control col-sm-6 mb-3" type="file" name="file" required>

                          <div class="col-4">
                              <button type="submit" class="btn btn-primary">Upload</button>
                              <a class="btn btn-secondary" href="{{URL('/download_template_upload')}}">Download Template</a>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      </div> -->

      <div class="mb-3">
          <!-- <b>All Data</b> -->
          <div class="card mt-3" style="">
              <div class="row justify-content-start">
                  <form class="mt-3" style="margin-left:40px" method="POST" action="{{URL('/upload_file_tmp')}}" enctype="multipart/form-data">
                  @csrf
                      <div class="form-group row">
                          <label tyle="margin-left:-10px">Masukan file retail sementara untuk diupload:</label>
                      </div>
                      <div class="row">
                          <input class="form-control col-sm-6 mb-3" type="file" name="file_tmp" required>

                          <div class="col-4">
                              <!-- <button class="btn" style="background-color: darkblue; color: white;">Upload</button> -->
                              <button type="submit" class="btn btn-primary">Upload</button>
                              <a class="btn btn-secondary" href="{{URL('/download_template_sementara')}}">Download Template</a>
                              <!-- <button class="btn" style="background-color: darkgreen; color: white;">Download Template</button> -->
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      </div>

      <div class="mb-3">
          <!-- <b>All Data</b> -->
          <div class="card mt-3" style="">
              <div class="row justify-content-start">
                  <form class="mt-3" style="margin-left:40px" method="POST" action="{{URL('/upload_database_minimum_stock')}}" enctype="multipart/form-data">
                  @csrf
                      <div class="form-group row">
                          <label tyle="margin-left:-10px">Upload untuk update database minimum stock:</label>
                      </div>
                      <div class="row">
                          <input class="form-control col-6 mb-3" type="file" name="file_database" required>

                          <div class="col-4">
                              <!-- <button class="btn" style="background-color: darkblue; color: white;">Upload</button> -->
                              <button type="submit" class="btn btn-primary">Upload</button>
                              <a class="btn btn-secondary" href="{{URL('/download_template_database')}}">Download Template</a>
                              <!-- <button class="btn" style="background-color: darkgreen; color: white;">Download Template</button> -->
                          </div>
                          <div class="col-2">       
                              <a class="btn btn-warning" href="{{URL('/export_database_to_excel')}}">Export Database</a>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      </div>

      <div class="card mb-3 mt-3">
        <div class="card-body mb-2">
        <div class="export-filter mb-3" style="left:0;">
          <form id="form_export" action="{{URL('/export_data_tmp/all')}}" method="POST">
          @csrf
          <select id="exportFilter" class="form-control" style="margin-left:0;" onchange="giveExportSelection()">
            <option value="all">All</option>
            <option value="merah">Merah</option>
            <option value="kuning">Kuning</option>
          </select>
          <button class="btn btn-secondary" value="false" type="submit">Export</button>
          </form>
        </div>
        <div class="table-responsive">
          <div class="category-filter">
            <select id="categoryFilter" class="form-control" onchange="giveSelection(this.value)">
              <option value="">All TREG</option>
              <option value="WH TR TREG 1">TREG 1</option>
              <option value="WH TR TREG 2">TREG 2</option>
              <option value="WH TR TREG 3">TREG 3</option>
              <option value="WH TR TREG 4">TREG 4</option>
              <option value="WH TR TREG 5">TREG 5</option>
              <option value="WH TR TREG 6">TREG 6</option>
              <option value="WH TR TREG 7">TREG 7</option>
            </select>
          </div>

          <div class="category-filter">
            <select id="soFilter" class="form-control mt-3">
              <option data-option="" value="">All SO</option>
              @foreach($data["witel"] as $witel)
                @if(str_contains(strtolower($witel->lokasi_wh), 'so') || str_contains(strtolower($witel->lokasi_wh), 'wh so'))
                  <option data-option="{{$witel->regional}}" value="{{$witel->witel}}">{{$witel->lokasi_wh}}</option>
                @endif
              @endforeach
            </select>
          </div>

          <div class="category-filter">
            <select id="witelFilter" class="form-control mt-3" onchange="giveSelectionTASO(this.options[this.selectedIndex].text)">
              <option data-option="" value="">All Witel</option>
              @foreach($data["witel"] as $witel)
                @if(str_contains(strtolower($witel->lokasi_wh), 'witel') || str_contains(strtolower($witel->lokasi_wh), 'treg'))
                  <option data-option="{{$witel->regional}}" value="{{$witel->regional}}">{{$witel->lokasi_wh}}</option>
                @endif
              @endforeach
            </select>
          </div>

          <table class="table table-bordered" id="filterTable" width="100%">
            <thead>
                <tr class="text-center">
                    <th rowspan="3" style="min-width: 400px;">Warehouse</th>
                    <th rowspan="3"hidden>regional</th>
                    <th rowspan="3"hidden>witel</th>
                    <th rowspan="3">Minimum Qty</th>
                    <th rowspan="2" colspan="4">Minimum Stock Requirement Retail</th>
                    <th rowspan="2" colspan="3">Minimum Stock Requirement Premium</th>

                    <th colspan="7">Stock SCMT</th>

                    <th colspan="7">GAP Stock</th>
                </tr>
                <tr class="text-center">
                  <th colspan="4">Retail</th>
                  <th colspan="3">Premium</th>

                  <th colspan="4">Retail</th>
                  <th colspan="3">Premium</th>
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
                </tr>
            </thead>
            <tbody>
              @foreach($data["witel"] as $idx => $d)
              <tr>
                <td value="">
                  @if($data["jenis_warehouse"] == "Witel" || $data["jenis_warehouse"] == "TA SO")
                  <a href="<?php echo url('/dashboard_monitoring/').'/'.$data["jenis_warehouse"].'/'.$d->lokasi_wh ?>">{{$d->lokasi_wh}}<a>
                  @else($data["jenis_warehouse"] == "Witel")
                  {{$d->lokasi_wh}}
                  @endif
                </td>
                <td hidden>{{$d->regional}}</td>
                <td hidden>{{$d->witel}}</td>
                <td>{{$d->minimum_qty}}</td>

                <div class="text-center">
                  <td style="min-width:50px;">{{$d->retail_fh}}</td>
                  <td style="min-width:50px;">{{$d->retail_hw}}</td>
                  <td style="min-width:50px;">{{$d->retail_zte}}</td>
                  <td style="min-width:50px;">{{$d->retail_alu}}</td>

                  <td style="min-width:50px;">{{$d->premium_fh}}</td>
                  <td style="min-width:50px;">{{$d->premium_hw}}</td>
                  <td style="min-width:50px;">{{$d->premium_zte}}</td>

                  <td style="min-width:50px;">{{$d->retail_stock_fiberhome}}</td>
                  <td style="min-width:50px;">{{$d->retail_stock_huawei}}</td>
                  <td style="min-width:50px;">{{$d->retail_stock_zte}}</td>
                  <td style="min-width:50px;">{{$d->retail_stock_nokia}}</td>

                  <td style="min-width:50px;">{{$d->premium_stock_fiberhome}}</td>
                  <td style="min-width:50px;">{{$d->premium_stock_huawei}}</td>
                  <td style="min-width:50px;">{{$d->premium_stock_zte}}</td>

                  <td style="min-width:50px; @if($d->retail_stock_fiberhome - $d->retail_fh < -($d->retail_fh/2)) background-color : red; @elseif($d->retail_stock_fiberhome - $d->retail_fh < 0) background-color: yellow; @endif ">{{$d->retail_stock_fiberhome - $d->retail_fh}}</td>
                  <td style="min-width:50px; @if($d->retail_stock_huawei - $d->retail_hw < -($d->retail_hw/2)) background-color : red; @elseif($d->retail_stock_huawei - $d->retail_hw < 0) background-color: yellow; @endif ">{{$d->retail_stock_huawei - $d->retail_hw}}</td>
                  <td style="min-width:50px; @if($d->retail_stock_zte - $d->retail_zte < -($d->retail_zte/2)) background-color : red; @elseif($d->retail_stock_zte - $d->retail_zte < 0) background-color: yellow; @endif ">{{$d->retail_stock_zte - $d->retail_zte}}</td>
                  <td style="min-width:50px; @if($d->retail_stock_nokia - $d->retail_alu < -($d->retail_alu/2)) background-color : red; @elseif($d->retail_stock_nokia - $d->retail_alu < 0) background-color: yellow; @endif ">{{$d->retail_stock_nokia - $d->retail_alu}}</td>

                  <td style="min-width:50px; @if($d->premium_stock_fiberhome - $d->premium_fh < -($d->premium_fh/2)) background-color : red; @elseif($d->premium_stock_fiberhome - $d->premium_fh < 0) background-color: yellow; @endif ">{{$d->premium_stock_fiberhome - $d->premium_fh}}</td>
                  <td style="min-width:50px; @if($d->premium_stock_huawei - $d->premium_hw < -($d->premium_hw/2)) background-color : red; @elseif($d->premium_stock_huawei - $d->premium_hw < 0) background-color: yellow; @endif ">{{$d->premium_stock_huawei - $d->premium_hw}}</td>
                  <td style="min-width:50px; @if($d->premium_stock_zte - $d->premium_zte < -($d->premium_zte/2)) background-color : red; @elseif($d->premium_stock_zte - $d->premium_zte < 0) background-color: yellow; @endif ">{{$d->premium_stock_zte - $d->premium_zte}}</td>
                </div>
              </tr>
              @endforeach
            </tbody>
        </table>
        </div>
        </div>
      </div>
      </div>

  </body>
  <script>
      $("document").ready(function () {
        $("#filterTable").dataTable({
          "searching": true,
          "scrollX": true
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
        $("#categoryFilter").on('change', function(i){
            categoryIndex = 1;
            $("#filterTable th").each(function (i) {
              if ($($(this)).html() == "regional") {
                categoryIndex = i; return false;
              }
            })

            $("#witelFilter").val('');
            $("#soFilter").val('');

            $.fn.dataTable.ext.search.push(
              function (settings, data, dataIndex, value) {
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

        $("#witelFilter").on('change', function(i){
          categoryIndex = 0;
          $("#filterTable th").each(function (i) {
            if ($($(this)).html() == "Witel") {
              categoryIndex = i; return false;
            }
          })

          if($('#witelFilter option:selected').text() == "All Witel"){
            $("#soFilter").val('');
            
            var selectedItem = $('#categoryFilter option:selected').text()

            giveSelectionTASO(selectedItem); 
            if(selectedItem == "All TREG"){
              giveSelectionTASO(''); 
            }
          }

          $.fn.dataTable.ext.search.push(
            function (settings, data, dataIndex, value) {
              var selectedItem = $('#witelFilter option:selected').text()
              if(selectedItem == "All Witel"){
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

        $("#soFilter").on('change', function(i){
          categoryIndex = 0;
          $("#filterTable th").each(function (i) {
            if ($($(this)).html() == "Witel") {
              categoryIndex = i; return false;
            }
          })

          $.fn.dataTable.ext.search.push(
            function (settings, data, dataIndex, value) {
              var selectedItem = $('#soFilter option:selected').text()
              if(selectedItem == "All SO"){
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
        for(var i = 0; i < options2.length; i++) {
          // if(options2[i].dataset.option === selValue) {
          if(options2[i].value.includes(selValue) || options2[i].value == "") {
            sel2.appendChild(options2[i]);
          }
        }

        sel3.innerHTML = '';
        for(var i = 0; i < options3.length; i++) {
          // if(options2[i].dataset.option === selValue) {
          if(options3[i].dataset.option.includes(selValue) || options3[i].value == "") {
            sel3.appendChild(options3[i]);
          }
        }
      }

      function giveSelectionTASO(selValue) {
        sel3.innerHTML = '';

        if(selValue == "All SO"){
          selValue = "";
        }


        if(selValue.includes("TREG") && !selValue.includes("WH")){
          for(var i = 0; i < options3.length; i++) {
            // if(options2[i].dataset.option === selValue) {
            if(options3[i].dataset.option.includes(selValue) || options3[i].value == "") {
              sel3.appendChild(options3[i]);
            }
          }
        }else{
          for(var i = 0; i < options3.length; i++) {
            // if(options2[i].dataset.option === selValue) {
            if(options3[i].value.includes(selValue) || options3[i].value == "") {
              sel3.appendChild(options3[i]);
            }
          }
        }
      }

      function giveExportSelection(){
        value = document.getElementById('exportFilter').value;
        document.getElementById("form_export").action = "{{URL('/export_data_tmp')}}"+"/"+value;
      }
    </script>
</html>