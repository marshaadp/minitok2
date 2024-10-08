<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Handler;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', "Handler@rekapDelivery");
Route::get('/rekap_delivery_stb', "Handler@rekapDeliverySTB");
Route::get('/rekap_delivery_stb/{jenis_warehouse}/{value_warehouse}', "Handler@rekapDeliverySTBPage");
Route::get('/tes', "Handler@dashboard");
Route::get('/rekap_delivery_biasa/{jenis_warehouse}/{value_warehouse}',"Handler@rekapDeliveryBiasaPage");

Route::group( ['middleware' => 'adminAuth' ], function(){
	Route::post('/upload_file',"Handler@countDataPerWitel");
	Route::post('/upload_file_tmp',"Handler@insertDataDelivery");
	Route::post('/upload_file_penerima/{jenis_upload}',"Handler@uploadPenerimaan");
	Route::post('/upload_database_minimum_stock',"Handler@updateDatabaseMinimumStock");
	Route::get('/pengiriman_ont',"Handler@pengirimanONT");
	Route::get('/pengiriman_ap',"Handler@pengirimanAP");
	Route::get('/pengiriman_stb',"Handler@pengirimanSTB");
	Route::post('/tambah_penerima',"Handler@tambahDataPenerima");
	Route::get('/input_data_stock',"Handler@inputDataStock");
	Route::get('/input_data_pengiriman',"Handler@inputDataPengiriman");
	Route::get('/input_data_database',"Handler@inputDataDatabase");
	Route::post('/export_data_tmp_scmt/{jenis_export}/{jumlah_data_export}',"Handler@exportDataTmpSCMT");
	Route::get('/export_penerima/{jenis_export}',"Handler@exportPenerima");
	Route::get('/download_template_database',"Handler@downloadTemplateDatabase");
	Route::get('/download_template_penerima',"Handler@downloadTemplatePenerima");
	Route::get('/download_template_sementara',"Handler@downloadTemplateDataTmp");
	Route::get('/export_database_to_excel',"Handler@exportDatabaseToExcel");
	Route::get('/export_qty_kirim',"Handler@exportQtyKirim");
	Route::get('/dashboard_monitoring/',"Handler@dashboardMonitoring");
	Route::get('/dashboard_monitoring/{jenis_warehouse}/{value_warehouse}',"Handler@dashboardMonitoringPage");
	Route::get('/rekap_delivery',"Handler@rekapDelivery");
	Route::get('/rekap_delivery/{jenis_warehouse}/{value_warehouse}',"Handler@rekapDeliveryPage");
	Route::get('/dashboard_did/',"Handler@dashboardDID");
	Route::get('/stb/rekap_delivery_stb', "Handler@rekapDeliverySTB");
	Route::get('/delete_all_data_pengiriman', "Handler@deleteAllDataPengiriman");
	Route::get('/export_all_data_pengiriman',"Handler@exportAllDataPengiriman");
	Route::get("/delete_on_delivery_by_id/{id}", "Handler@deleteOnDeliveryById");
	Route::post("/edit_penerimaan_by_id/{id}", "Handler@editOnDeliveryById");
	Route::get("/download_serial_number/{id}", "Handler@downloadSerialNumber");
	Route::get("/download_all_serial_number/", "Handler@downloadAllSN");
	Route::get("/download_template_sn/", "Handler@downloadTemplateSN");	
	Route::get("/all_rekap_delivery", "Handler@allRekapDelivery");	

	Route::get('/edit_profile', "Handler@editProfile");
	Route::get('/user_list', "Handler@userList");

	Route::get("/on_delivery_data/{nama_warehouse}/{jenis_ont}", "Handler@getOnDeliveryByWarehouse");	
	Route::get('/ap/rekap_delivery_ap', "Handler@rekapDeliveryAP");
	Route::get('/request_outbond', "Handler@requestOutbond");
	Route::get('/export_request_outbond', "Handler@exportDataRequestOutbond");
	Route::get("/all_request_outbond", "Handler@allRequestOutbond");	
	Route::post('/tambah_request_outbond',"Handler@tambahDataRequestOutbond");
	Route::post('/upload_respon_request_outbond/{id}',"Handler@uploadResponRequestOutbond");
	Route::post('/edit_request_outbond/{id}',"Handler@editRequestOutbond");
	Route::get('/delete_request_outbond/{id}',"Handler@deleteRequestOutbond");

	Route::get('/download_mac_sn/{id}',"Handler@downloadMacSN");
	Route::get('/download_evident/{id}',"Handler@downloadEvident");
});

Route::get("/pull_file_from_ftp", "Handler@pullFileFromFTP");

Route::get('/login', "Handler@login");
Route::post('/proses_login', "Handler@prosesLogin");
Route::get('/logout', "Handler@logout");