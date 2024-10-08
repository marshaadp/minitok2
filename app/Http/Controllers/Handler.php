<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gudang;
use App\Models\Data;
use App\Models\DataTmp;
use App\Models\User;
use App\Models\Penerima;
use App\Models\RequestOutbond;
use App\Models\Messages;

use App\Http\Controllers\FTP;
use Response;
use Session;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;

use League\Flysystem\Ftp\FtpAdapter;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use phpseclib3\NET\SFTP;
use Yajra\DataTables\DataTables;

class Handler extends Controller
{
	public function login()
	{
		echo view('login');
	}

	public function prosesLogin(Request $request)
	{
		$username = $request->input("username");
		$password = $request->input("password");

		$tmpUser = User::GetUser($username, $password);
		if (count($tmpUser) == 1) {
			session(['username' => $tmpUser[0]->username]);
			session(['nama_user' => $tmpUser[0]->fullname]);
			session(['role' => $tmpUser[0]->role]);
			session(['mitra' => $tmpUser[0]->asal]);
			session(['asal' => $tmpUser[0]->asal]);
			session(['jenis_akun' => $tmpUser[0]->jenis_akun]);

			if ($tmpUser[0]->fullname == "Administrator") {
				return redirect("/rekap_delivery");
			} else {
				return redirect("/home");
			}
		}

		return redirect("/");
	}

	public function home()
	{
		echo view('home');
	}

	public function dashboardDID(Request $request)
	{
		$data = $this::countDataPerWitelTmp();
		$data = $this::hitungQtyKirim($data);

		// $data["witel"] = array_merge(Gudang::getTregQtyMinimum(), Gudang::getQtyMinimum());
		$data["jenis_warehouse"] = "Witel";

		$data["total_qty_minimum"] = array_sum(array_column($data["witel"], 'minimum_qty'));
		$data["total_retail_fh_minimum"] = array_sum(array_column($data["witel"], 'retail_fh'));
		$data["total_retail_hw_minimum"] = array_sum(array_column($data["witel"], 'retail_hw'));
		$data["total_retail_zte_minimum"] = array_sum(array_column($data["witel"], 'retail_zte'));
		$data["total_retail_alu_minimum"] = array_sum(array_column($data["witel"], 'retail_alu'));
		$data["total_retail_minimum"] = array_sum(array_column($data["witel"], 'total_retail'));

		$data["total_premium_fh_minimum"] = array_sum(array_column($data["witel"], 'premium_fh'));
		$data["total_premium_hw_minimum"] = array_sum(array_column($data["witel"], 'premium_hw'));
		$data["total_premium_zte_minimum"] = array_sum(array_column($data["witel"], 'premium_zte'));
		$data["total_premium_minimum"] = array_sum(array_column($data["witel"], 'total_premium'));

		$data["total_retail_stock_fh"] = array_sum(array_column($data["witel"], 'retail_stock_fiberhome'));
		$data["total_retail_stock_hw"] = array_sum(array_column($data["witel"], 'retail_stock_huawei'));
		$data["total_retail_stock_zte"] = array_sum(array_column($data["witel"], 'retail_stock_zte'));
		$data["total_retail_stock_alu"] = array_sum(array_column($data["witel"], 'retail_stock_nokia'));
		$data["total_retail_stock_all"] = array_sum(array_column($data["witel"], 'total_retail_stock'));

		$data["total_premium_stock_fh"] = array_sum(array_column($data["witel"], 'premium_stock_fiberhome'));
		$data["total_premium_stock_hw"] = array_sum(array_column($data["witel"], 'premium_stock_huawei'));
		$data["total_premium_stock_zte"] = array_sum(array_column($data["witel"], 'premium_stock_zte'));
		$data["total_premium_stock_all"] = array_sum(array_column($data["witel"], 'total_premium_stock'));

		$data["total_gap_retail_stock_fh"] = $data["total_retail_stock_fh"] - $data["total_retail_fh_minimum"];
		$data["total_gap_retail_stock_hw"] = $data["total_retail_stock_hw"] - $data["total_retail_hw_minimum"];
		$data["total_gap_retail_stock_zte"] = $data["total_retail_stock_zte"] - $data["total_retail_zte_minimum"];
		$data["total_gap_retail_stock_alu"] = $data["total_retail_stock_alu"] - $data["total_retail_alu_minimum"];
		$data["total_gap_stock_retail"] = $data["total_retail_stock_all"] - $data["total_retail_minimum"];

		$data["total_gap_premium_stock_fh"] = $data["total_premium_stock_fh"] - $data["total_premium_fh_minimum"];
		$data["total_gap_premium_stock_hw"] = $data["total_premium_stock_hw"] - $data["total_premium_hw_minimum"];
		$data["total_gap_premium_stock_zte"] = $data["total_premium_stock_zte"] - $data["total_premium_zte_minimum"];
		$data["total_gap_premium_stock"] = $data["total_premium_stock_all"] - $data["total_premium_minimum"];

		session(['data' => $data]);

		return view("dashboard")->with("data", $data);
	}

	public function logout()
	{
		session(['username' => ""]);
		session(['nama_user' => ""]);
		session(['role' => ""]);
		session(['mitra' => ""]);
		Session::flush();
		return redirect('/login');
	}

	public function file_get_contents_utf8($fn)
	{
		$content = file_get_contents($fn);
		return mb_convert_encoding($content, 'UTF-8', mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
	}

	public function addStockCount($jenis_stock, $data, $merk)
	{
		$array_stock = $data[$merk];
		$witel = Data::getWitelsFromDataByMerk($merk);

		for ($i = 0; $i < count($data["witel"]); $i++) {
			$nama_witel = $data["witel"][$i]->lokasi_wh;

			$filtered_array = array_filter($array_stock, function ($obj) use ($nama_witel) {
				return str_contains(strtolower($nama_witel), strtolower($obj->witel));
			});

			// $idx = 0;
			// foreach ($data["witel"] as $key => $value) {
			//     if (str_contains($value->wilayah, $nama_witel)) {
			//         $result = $value;
			//         $idx = $key;
			//         break;
			//     }
			// }

			if (count($filtered_array) == 0) {
				$data["witel"][$i]->{$jenis_stock . "_stock_" . $merk} = 0;
			} else {
				$tmp_stock = current($filtered_array)->stock;

				$data["witel"][$i]->{$jenis_stock . "_stock_" . $merk} = $tmp_stock;
			}
		}

		return $data;
	}

	public function addStockCountTmp($jenis_stock, $data, $merk)
	{
		$array_stock = $data[$merk];
		$array_penerima = $data["penerima"][$merk];
		// $witel = Data::getWitelsFromDataByMerk($merk);

		for ($i = 0; $i < count($data["witel"]); $i++) {
			$lokasi_wh = $data["witel"][$i]->lokasi_wh;

			$filtered_array = array_filter($array_stock, function ($obj) use ($lokasi_wh) {
				return str_contains(strtolower($obj->lokasi_wh), strtolower($lokasi_wh));
			});

			$filtered_array_penerima = array_filter($array_penerima, function ($obj) use ($lokasi_wh) {
				return str_contains(strtolower($obj->warehouse_penerima), strtolower($lokasi_wh));
			});

			if (str_contains($lokasi_wh, "TA SO CCAN")) {
				$lokasi_wh = substr($lokasi_wh, strpos($lokasi_wh, "CCAN") + 5, strlen($lokasi_wh));
				$count_word = count(explode($lokasi_wh, " "));


				if ($count_word > 2) {
					$filtered_array = array_filter($array_stock, function ($obj) use ($lokasi_wh) {
						return str_contains(strtolower($obj->lokasi_wh), strtolower($lokasi_wh));
					});

					$filtered_array_penerima = array_filter($array_penerima, function ($obj) use ($lokasi_wh) {
						return str_contains(strtolower($obj->warehouse_penerima), strtolower($lokasi_wh));
					});
				} else {
					$lokasi_wh = $data["witel"][$i]->lokasi_wh;
					// echo $count_word." ".$lokasi_wh;
					$filtered_array = array_filter($array_stock, function ($obj) use ($lokasi_wh) {
						return strtolower($obj->lokasi_wh) == strtolower($lokasi_wh);
					});

					$filtered_array_penerima = array_filter($array_penerima, function ($obj) use ($lokasi_wh) {
						return strtolower($obj->warehouse_penerima) == strtolower($lokasi_wh);
					});
				}
			} else if (str_contains($lokasi_wh, "TA SO")) {
				$lokasi_wh = substr($lokasi_wh, strpos($lokasi_wh, "TA SO") + 5, strlen($lokasi_wh));
				$filtered_array = array_filter($array_stock, function ($obj) use ($lokasi_wh) {
					return str_contains(strtolower($obj->lokasi_wh), strtolower($lokasi_wh));
				});

				$filtered_array_penerima = array_filter($array_penerima, function ($obj) use ($lokasi_wh) {
					return str_contains(strtolower($obj->warehouse_penerima), strtolower($lokasi_wh));
				});
			} else if (str_contains($lokasi_wh, "WITEL CCAN")) {
				$lokasi_wh = substr($lokasi_wh, strpos($lokasi_wh, "WITEL CCAN") + 11, strlen($lokasi_wh));

				// if(str_contains($lokasi_wh, "(")){
				// 	$open = strpos($lokasi_wh, "(");
				// 	$close = strpos($lokasi_wh, ")");
				// 	$lokasi_wh = substr($lokasi_wh, $open+1, $close-$open-1);
				// }

				$filtered_array = array_filter($array_stock, function ($obj) use ($lokasi_wh) {
					return str_contains(strtolower($obj->lokasi_wh), strtolower($lokasi_wh)) && str_contains($obj->lokasi_wh, "WITEL");
				});

				$filtered_array_penerima = array_filter($array_penerima, function ($obj) use ($lokasi_wh) {
					return str_contains(strtolower($obj->warehouse_penerima), strtolower($lokasi_wh)) && str_contains($obj->warehouse_penerima, "WITEL");
				});
			} else if (str_contains($lokasi_wh, "WITEL")) {
				$lokasi_wh = substr($lokasi_wh, strpos($lokasi_wh, "WITEL") + 6, strlen($lokasi_wh));

				// if(str_contains($lokasi_wh, "(")){
				// 	$open = strpos($lokasi_wh, "(");
				// 	$close = strpos($lokasi_wh, ")");
				// 	$lokasi_wh = substr($lokasi_wh, $open+1, $close-$open-1);
				// }

				$filtered_array = array_filter($array_stock, function ($obj) use ($lokasi_wh) {
					return str_contains(strtolower($obj->lokasi_wh), strtolower($lokasi_wh)) && str_contains($obj->lokasi_wh, "WITEL");
				});

				$filtered_array_penerima = array_filter($array_penerima, function ($obj) use ($lokasi_wh) {
					return str_contains(strtolower($obj->warehouse_penerima), strtolower($lokasi_wh)) && str_contains($obj->warehouse_penerima, "WITEL");
				});
				// echo $lokasi_wh." ";
			}

			if (count($filtered_array) == 0) {
				$data["witel"][$i]->{$jenis_stock . "_stock_" . $merk} = 0;
			} else {
				$tmp_stock = current($filtered_array)->stock;

				$data["witel"][$i]->{$jenis_stock . "_stock_" . $merk} = $tmp_stock;
			}

			if (count($filtered_array_penerima) == 0) {
				$data["witel"][$i]->{"on_delivery_" . $jenis_stock . "_" . $merk} = 0;
			} else {
				$tmp_stock = current($filtered_array_penerima)->stock;
				// print_r($tmp_stock);

				$data["witel"][$i]->{"on_delivery_" . $jenis_stock . "_" . $merk} = $tmp_stock;
				// if(str_contains($lokasi_wh, "SOLO")){
				// 	echo $lokasi_wh;
				// 	print_r($data["witel"][$i]->lokasi_wh);
				// }
			}
		}

		return $data;
	}

	public function addTotalStockCount($jenis_stock, $data)
	{
		// if(empty(session("data")["jenis_warehouse"]) or session("data")["jenis_warehouse"] == "Witel"){
		for ($i = 0; $i < count($data["witel"]); $i++) {
			$data["witel"][$i]->{"total_" . $jenis_stock . "_stock"} = 0;

			if ($jenis_stock == "retail") {
				$data["witel"][$i]->{"total_" . $jenis_stock . "_stock"} = $data["witel"][$i]->{$jenis_stock . "_stock_huawei"} + $data["witel"][$i]->{$jenis_stock . "_stock_fiberhome"} + $data["witel"][$i]->{$jenis_stock . "_stock_nokia"} + $data["witel"][$i]->{$jenis_stock . "_stock_zte"};

				$data["witel"][$i]->{"total_" . $jenis_stock} = $data["witel"][$i]->{$jenis_stock . "_hw"} + $data["witel"][$i]->{$jenis_stock . "_fh"} + $data["witel"][$i]->{$jenis_stock . "_alu"} + $data["witel"][$i]->{$jenis_stock . "_zte"};

				$data["witel"][$i]->{"on_delivery_total_" . $jenis_stock} = $data["witel"][$i]->{"on_delivery_" . $jenis_stock . "_huawei"} + $data["witel"][$i]->{"on_delivery_" . $jenis_stock . "_zte"} + $data["witel"][$i]->{"on_delivery_" . $jenis_stock . "_fiberhome"} + $data["witel"][$i]->{"on_delivery_" . $jenis_stock . "_nokia"};
				// echo $data["witel"][$i]->{$jenis_stock."_stock_huawei"}." ";
			} else if ($jenis_stock == "premium") {
				$data["witel"][$i]->{"total_" . $jenis_stock . "_stock"} = $data["witel"][$i]->{$jenis_stock . "_stock_huawei"} + $data["witel"][$i]->{$jenis_stock . "_stock_fiberhome"} + $data["witel"][$i]->{$jenis_stock . "_stock_zte"};
				$data["witel"][$i]->{"total_" . $jenis_stock} = $data["witel"][$i]->{$jenis_stock . "_hw"} + $data["witel"][$i]->{$jenis_stock . "_fh"} + $data["witel"][$i]->{$jenis_stock . "_zte"};
				$data["witel"][$i]->{"on_delivery_total_" . $jenis_stock} = $data["witel"][$i]->{"on_delivery_" . $jenis_stock . "_huawei"} + $data["witel"][$i]->{"on_delivery_" . $jenis_stock . "_zte"} + $data["witel"][$i]->{"on_delivery_" . $jenis_stock . "_fiberhome"};
			}
		}
		// }

		return $data;
	}

	public function addStockTregCountTmp($jenis_stock, $data, $merk)
	{
		$treg_array = array_values(array_filter($data["witel"], function ($obj) {
			return str_contains($obj->lokasi_wh, "WH TR TREG");
		}));

		for ($i = 0; $i < count($treg_array); $i++) {
			$regional = $treg_array[$i]->regional;
			$wh_array = array_values(array_filter($data["witel"], function ($obj) use ($regional) {
				return str_contains($obj->regional, $regional) && $obj->lokasi_wh != $regional;
			}));

			$idx = 0;
			foreach ($data["witel"] as $key => $value) {
				if (str_contains($value->lokasi_wh, $regional)) {
					$result = $value;
					$idx = $key;
					break;
				}
			}

			$data["witel"][$idx]->retail_stock_zte = array_sum(array_column($wh_array, 'retail_stock_zte'));
			$data["witel"][$idx]->retail_stock_fiberhome = array_sum(array_column($wh_array, 'retail_stock_fiberhome'));
			$data["witel"][$idx]->retail_stock_huawei = array_sum(array_column($wh_array, 'retail_stock_huawei'));
			$data["witel"][$idx]->retail_stock_nokia = array_sum(array_column($wh_array, 'retail_stock_nokia'));

			$data["witel"][$idx]->on_delivery_retail_zte = array_sum(array_column($wh_array, 'on_delivery_retail_zte'));
			$data["witel"][$idx]->on_delivery_retail_fiberhome = array_sum(array_column($wh_array, 'on_delivery_retail_fiberhome'));
			$data["witel"][$idx]->on_delivery_retail_huawei = array_sum(array_column($wh_array, 'on_delivery_retail_huawei'));
			$data["witel"][$idx]->on_delivery_retail_nokia = array_sum(array_column($wh_array, 'on_delivery_retail_nokia'));

			$data["witel"][$i]->{"total_retail_stock"} = $data["witel"][$i]->{"retail_stock_huawei"} + $data["witel"][$i]->{"retail_stock_fiberhome"} + $data["witel"][$i]->{"retail_stock_nokia"} + $data["witel"][$i]->{"retail_stock_zte"};
			$data["witel"][$i]->{"total_retail"} = $data["witel"][$i]->{"retail_hw"} + $data["witel"][$i]->{"retail_fh"} + $data["witel"][$i]->{"retail_alu"} + $data["witel"][$i]->{"retail_zte"};
			$data["witel"][$i]->on_delivery_total_retail = $data["witel"][$i]->on_delivery_retail_huawei + $data["witel"][$i]->on_delivery_retail_fiberhome + $data["witel"][$i]->on_delivery_retail_zte + $data["witel"][$i]->on_delivery_retail_nokia;

			$data["witel"][$idx]->premium_stock_zte = array_sum(array_column($wh_array, 'premium_stock_zte'));
			$data["witel"][$idx]->premium_stock_fiberhome = array_sum(array_column($wh_array, 'premium_stock_fiberhome'));
			$data["witel"][$idx]->premium_stock_huawei = array_sum(array_column($wh_array, 'premium_stock_huawei'));

			$data["witel"][$idx]->on_delivery_premium_zte = array_sum(array_column($wh_array, 'on_delivery_premium_zte'));
			$data["witel"][$idx]->on_delivery_premium_fiberhome = array_sum(array_column($wh_array, 'on_delivery_premium_fiberhome'));
			$data["witel"][$idx]->on_delivery_premium_huawei = array_sum(array_column($wh_array, 'on_delivery_premium_huawei'));

			$data["witel"][$i]->{"total_premium_stock"} = $data["witel"][$i]->{"premium_stock_huawei"} + $data["witel"][$i]->{"premium_stock_fiberhome"} + $data["witel"][$i]->{"premium_stock_zte"};
			$data["witel"][$i]->{"total_premium"} = $data["witel"][$i]->{"premium_hw"} + $data["witel"][$i]->{"premium_fh"} + $data["witel"][$i]->{"premium_zte"};

			$data["witel"][$i]->on_delivery_total_premium = $data["witel"][$i]->on_delivery_premium_huawei + $data["witel"][$i]->on_delivery_premium_fiberhome + $data["witel"][$i]->on_delivery_premium_zte;

			// $data["witel"][$idx]->batas_atas_retail_stock_zte = $data["witel"][$idx]->retail_stock_zte * 120 / 100;
			// $data["witel"][$idx]->batas_atas_retail_stock_fiberhome = $data["witel"][$idx]->retail_stock_fiberhome * 120 / 100;
			// $data["witel"][$idx]->batas_atas_retail_stock_huawei = $data["witel"][$idx]->retail_stock_huawei * 120 / 100;
			// $data["witel"][$idx]->batas_atas_retail_stock_nokia = $data["witel"][$idx]->retail_stock_nokia * 120 / 100;

			// $data["witel"][$idx]->batas_atas_premium_stock_zte = $data["witel"][$idx]->premium_stock_zte * 120 / 100;
			// $data["witel"][$idx]->batas_atas_premium_stock_fiberhome = $data["witel"][$idx]->premium_stock_fiberhome * 120 / 100;
			// $data["witel"][$idx]->batas_atas_premium_stock_huawei = $data["witel"][$idx]->premium_stock_huawei * 120 / 100;

			// $data["witel"][$idx]->batas_bawah_retail_stock_zte = $data["witel"][$idx]->retail_stock_zte * 70 / 100;
			// $data["witel"][$idx]->batas_bawah_retail_stock_fiberhome = $data["witel"][$idx]->retail_stock_fiberhome * 70 / 100;
			// $data["witel"][$idx]->batas_bawah_retail_stock_huawei = $data["witel"][$idx]->retail_stock_huawei * 70 / 100;
			// $data["witel"][$idx]->batas_bawah_retail_stock_nokia = $data["witel"][$idx]->retail_stock_nokia * 70 / 100;

			// $data["witel"][$idx]->batas_bawah_premium_stock_zte = $data["witel"][$idx]->premium_stock_zte * 70 / 100;
			// $data["witel"][$idx]->batas_bawah_premium_stock_fiberhome = $data["witel"][$idx]->premium_stock_fiberhome * 70 / 100;
			// $data["witel"][$idx]->batas_bawah_premium_stock_huawei = $data["witel"][$idx]->premium_stock_huawei * 70 / 100;
		}

		return $data;
	}

	public function countDataPerWitel(Request $request)
	{
		$file = $request->file("file");
		$file->move('file', "uploaded_data.csv");

		Data::deleteAllData();

		// $file = fopen("file/uploaded_data.csv","r");

		$file = $this::file_get_contents_utf8("file/uploaded_data.csv");
		$tempFile = tempnam(sys_get_temp_dir(), '');
		$handle = fopen($tempFile, "w+");
		fwrite($handle, $file);
		fseek($handle, 0);
		$filename = $tempFile;
		// END -- dealing with fgetcsv() special chars

		while (($line = fgetcsv($handle, 0, "\t", '"', "\"")) !== false) {
			if (count($line) == 1) {
				break;
			}

			$data["status_perangkat"] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $line[1]);
			$data["witel"] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $line[10]);
			$data["device_id"] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $line[14]);
			$data["item_code"] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $line[16]);
			$data["merk"] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $line[4]);
			$data["treg_wh"] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $line[9]);
			$data["tipe"] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $line[8]);

			if ($data["witel"] == "") {
				$data["witel"] = $data["treg_wh"];
			}

			// if(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $line[1]) == "AVAILABLE" || preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $line[1]) == "INTECHNICIAN"){
			Data::insertData($data);
			// }
		}
		fclose($handle);

		// $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

		// // $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
		// // $reader->setInputEncoding('CP1252');
		// // $reader->setDelimiter('t');
		// // $reader->setEnclosure('');
		// // $reader->setSheetIndex(0);
		// // $sheetData = $spreadsheet->getActiveSheet()->toArray();

		// $spreadsheet = $reader->load("file/uploaded_data.xlsx");
		// $sheet = $spreadsheet->getSheetByName("Data");

		// $maxRow = $sheet->getHighestRow();
		// Data::deleteAllData();

		// for ($i=2; $i < $maxRow; $i++){
		// 	$witel = $sheet->getCell("K".$i)->getValue();
		// 	$device_id = $sheet->getCell("O".$i)->getValue();
		// 	$item_code = $sheet->getCell("Q".$i)->getValue();
		// 	$merk = $sheet->getCell("E".$i)->getValue();
		// 	$treg_wh = $sheet->getCell("J".$i)->getValue();
		// 	$tipe = $sheet->getCell("I".$i)->getValue();

		// 	if($witel == ""){
		// 		$witel = $treg_wh;
		// 	}

		// 	$data["witel"] = $witel;
		// 	$data["merk"] = $merk;
		// 	$data["device_id"] = $device_id;
		// 	$data["item_code"] = $item_code;
		// 	$data["treg_wh"] = $treg_wh;
		// 	$data["tipe"] = $tipe;

		// 	// Data::insertData($data);
		// }

		Data::resetIndex();

		$data["witel"] = array_merge(Gudang::getTregQtyMinimum(), Gudang::getQtyMinimum());

		$jenis_stock = "retail";

		$merk = "fiberhome";
		$data[$merk] = Data::countRetailPerWitel($merk);
		$data = $this::addStockCountTmp($jenis_stock, $data, $merk);

		$merk = "zte";
		$data[$merk] = Data::countRetailPerWitel($merk);
		$data = $this::addStockCount($jenis_stock, $data, $merk);

		$merk = "nokia";
		$data[$merk] = Data::countRetailPerWitel($merk);
		$data = $this::addStockCount($jenis_stock, $data, $merk);

		$merk = "huawei";
		$data[$merk] = Data::countRetailPerWitel($merk);
		$data = $this::addStockCount($jenis_stock, $data, $merk);

		$data = $this::addTotalStockCount($jenis_stock, $data);

		$jenis_stock = "premium";

		$merk = "fiberhome";
		$data[$merk] = Data::countPremiumPerWitel($merk);
		$data = $this::addStockCount($jenis_stock, $data, $merk);

		$merk = "zte";
		$data[$merk] = Data::countPremiumPerWitel($merk);
		$data = $this::addStockCount($jenis_stock, $data, $merk);

		$merk = "huawei";
		$data[$merk] = Data::countPremiumPerWitel($merk);
		$data = $this::addStockCount($jenis_stock, $data, $merk);


		File::delete("file/uploaded_data.csv");
		// return view("dashboard_insert")->with("data", $data);
	}

	public function inputDataStock(Request $request)
	{
		return view("input_data_stock");
	}

	public function inputDataDatabase(Request $request)
	{
		return view("input_data_database");
	}

	public function inputDataPengiriman(Request $request)
	{
		return view("input_data_penerimaan");
	}

	public function roundUpToAny($n, $x = 20)
	{
		return round(($n + $x / 2) / $x) * $x;
	}

	public function dashboard(Request $request)
	{
		$data = $this::countDataPerWitelTmp();
		$data = $this::hitungQtyKirim($data);

		// $data["witel"] = array_merge(Gudang::getTregQtyMinimum(), Gudang::getQtyMinimum());
		$data["treg_with_so"] = $data["witel"];

		$data["jenis_warehouse"] = "Witel";
		$data["witel"] = array_filter($data["witel"], function ($obj) {
			return str_contains(strtolower($obj->witel), "treg");
		});

		$data = $this::hitungQtyKirimTreg($data);

		for ($i = 0; $i < count($data["witel"]); $i++) {
			$value_regional = $data["witel"][$i]->regional;
			$data["so"] = array_values(array_filter($data["treg_with_so"], function ($obj) use ($value_regional) {
				return str_contains(strtolower($obj->regional), strtolower($value_regional));
			}));
			// 	$minimum_qty = 0;
			// 	$retail_zte = 0;
			// 	$retail_fh = 0;
			// 	$retail_hw = 0;
			// 	$retail_alu = 0;

			// 	$total_retail = 0;

			// 	$premium_zte = 0;
			// 	$premium_fh = 0;
			// 	$premium_hw = 0;

			// 	$total_premium = 0;

			$batas_atas_retail_zte = 0;
			$batas_atas_retail_fh = 0;
			$batas_atas_retail_hw = 0;
			$batas_atas_retail_alu = 0;

			$batas_atas_premium_fh = 0;
			$batas_atas_premium_hw = 0;
			$batas_atas_premium_zte = 0;

			$batas_bawah_retail_zte = 0;
			$batas_bawah_retail_fh = 0;
			$batas_bawah_retail_hw = 0;
			$batas_bawah_retail_alu = 0;

			$batas_bawah_premium_fh = 0;
			$batas_bawah_premium_hw = 0;
			$batas_bawah_premium_zte = 0;

			// 	$retail_stock_zte = 0;
			// 	$retail_stock_fh = 0;
			// 	$retail_stock_hw = 0;
			// 	$retail_stock_nokia = 0;

			// 	$total_retail_stock = 0;

			// 	$premium_stock_zte = 0;
			// 	$premium_stock_fh = 0;
			// 	$premium_stock_hw = 0;

			// 	$total_premium_stock = 0;

			// 	$qty_kirim_retail_zte = 0;
			// 	$qty_kirim_retail_fh = 0;
			// 	$qty_kirim_retail_hw = 0;
			// 	$qty_kirim_retail_alu = 0;

			// 	$qty_kirim_premium_zte = 0;
			// 	$qty_kirim_premium_fh = 0;
			// 	$qty_kirim_premium_hw = 0;

			for ($j = 0; $j < count($data["so"]); $j++) {
				// 		$minimum_qty += $data["so"][$j]->minimum_qty;
				// 		$retail_zte += $data["so"][$j]->retail_zte;;
				// 		$retail_fh += $data["so"][$j]->retail_fh;
				// 		$retail_hw += $data["so"][$j]->retail_hw;
				// 		$retail_alu += $data["so"][$j]->retail_alu;

				// 		$total_retail += $data["so"][$j]->total_retail;

				// 		$premium_zte += $data["so"][$j]->premium_zte;
				// 		$premium_fh += $data["so"][$j]->premium_fh;
				// 		$premium_hw += $data["so"][$j]->premium_hw;

				// 		$total_premium += $data["so"][$j]->total_premium;

				$batas_atas_retail_zte += $data["so"][$j]->batas_atas_retail_zte;
				$batas_atas_retail_fh += $data["so"][$j]->batas_atas_retail_fh;
				$batas_atas_retail_hw += $data["so"][$j]->batas_atas_retail_hw;
				$batas_atas_retail_alu += $data["so"][$j]->batas_atas_retail_alu;

				$batas_atas_premium_fh += $data["so"][$j]->batas_atas_premium_fh;
				$batas_atas_premium_hw += $data["so"][$j]->batas_atas_premium_hw;
				$batas_atas_premium_zte += $data["so"][$j]->batas_atas_premium_zte;

				$batas_bawah_retail_zte += $data["so"][$j]->batas_bawah_retail_zte;
				$batas_bawah_retail_fh += $data["so"][$j]->batas_bawah_retail_fh;
				$batas_bawah_retail_hw += $data["so"][$j]->batas_bawah_retail_hw;
				$batas_bawah_retail_alu += $data["so"][$j]->batas_bawah_retail_alu;

				$batas_bawah_premium_fh += $data["so"][$j]->batas_bawah_premium_fh;
				$batas_bawah_premium_hw += $data["so"][$j]->batas_bawah_premium_hw;
				$batas_bawah_premium_zte += $data["so"][$j]->batas_bawah_premium_zte;

				// 		$retail_stock_zte += $data["so"][$j]->retail_stock_zte;
				// 		$retail_stock_fh += $data["so"][$j]->retail_stock_fiberhome;
				// 		$retail_stock_hw += $data["so"][$j]->retail_stock_huawei;
				// 		$retail_stock_nokia += $data["so"][$j]->retail_stock_nokia;

				// 		$total_retail_stock += $data["so"][$j]->total_retail_stock;

				// 		$premium_stock_zte += $data["so"][$j]->premium_stock_zte;
				// 		$premium_stock_fh += $data["so"][$j]->premium_stock_fiberhome;
				// 		$premium_stock_hw += $data["so"][$j]->premium_stock_huawei;

				// 		$total_premium_stock += $data["so"][$j]->total_premium_stock;

				// 		$qty_kirim_retail_zte += $data["so"][$j]->qty_kirim_retail_zte;
				// 		$qty_kirim_retail_fh += $data["so"][$j]->qty_kirim_retail_fh;
				// 		$qty_kirim_retail_hw += $data["so"][$j]->qty_kirim_retail_hw;
				// 		$qty_kirim_retail_alu += $data["so"][$j]->qty_kirim_retail_alu;

				// 		$qty_kirim_premium_zte += $data["so"][$j]->qty_kirim_premium_zte;
				// 		$qty_kirim_premium_fh += $data["so"][$j]->qty_kirim_premium_fh;
				// 		$qty_kirim_premium_hw += $data["so"][$j]->qty_kirim_premium_hw;
			}

			// 	$data["witel"][$i]->minimum_qty = $minimum_qty;
			// 	$data["witel"][$i]->retail_zte = $retail_zte;
			// 	$data["witel"][$i]->retail_fh = $retail_fh;
			// 	$data["witel"][$i]->retail_hw = $retail_hw;
			// 	$data["witel"][$i]->retail_alu = $retail_alu;

			// 	$data["witel"][$i]->total_retail = $total_retail;

			// 	$data["witel"][$i]->premium_zte = $premium_zte;
			// 	$data["witel"][$i]->premium_fh = $premium_fh;
			// 	$data["witel"][$i]->premium_hw = $premium_hw;

			// 	$data["witel"][$i]->total_premium = $total_premium;

			$data["witel"][$i]->batas_atas_retail_zte = $batas_atas_retail_zte;
			$data["witel"][$i]->batas_atas_retail_fh = $batas_atas_retail_fh;
			$data["witel"][$i]->batas_atas_retail_hw = $batas_atas_retail_hw;
			$data["witel"][$i]->batas_atas_retail_alu = $batas_atas_retail_alu;

			$data["witel"][$i]->batas_atas_premium_fh = $batas_atas_premium_fh;
			$data["witel"][$i]->batas_atas_premium_hw = $batas_atas_premium_hw;
			$data["witel"][$i]->batas_atas_premium_zte = $batas_atas_premium_zte;

			$data["witel"][$i]->batas_bawah_retail_zte = $batas_bawah_retail_zte;
			$data["witel"][$i]->batas_bawah_retail_fh = $batas_bawah_retail_fh;
			$data["witel"][$i]->batas_bawah_retail_hw = $batas_bawah_retail_hw;
			$data["witel"][$i]->batas_bawah_retail_alu = $batas_bawah_retail_alu;

			$data["witel"][$i]->batas_bawah_premium_fh = $batas_bawah_premium_fh;
			$data["witel"][$i]->batas_bawah_premium_hw = $batas_bawah_premium_hw;
			$data["witel"][$i]->batas_bawah_premium_zte = $batas_bawah_premium_zte;


			// 	$data["witel"][$i]->retail_stock_zte = $retail_stock_zte;
			// 	$data["witel"][$i]->retail_stock_fiberhome = $retail_stock_fh;
			// 	$data["witel"][$i]->retail_stock_huawei = $retail_stock_hw;
			// 	$data["witel"][$i]->retail_stock_nokia = $retail_stock_nokia;

			// 	$data["witel"][$i]->total_retail_stock = $total_retail_stock;				

			// 	$data["witel"][$i]->premium_stock_zte = $premium_stock_zte;
			// 	$data["witel"][$i]->premium_stock_fiberhome = $premium_stock_fh;
			// 	$data["witel"][$i]->premium_stock_huawei = $premium_stock_hw;

			// 	$data["witel"][$i]->total_premium_stock = $total_premium_stock;

			// 	$data["witel"][$i]->qty_kirim_retail_zte = $qty_kirim_retail_zte;
			// 	$data["witel"][$i]->qty_kirim_retail_fh = $qty_kirim_retail_fh;
			// 	$data["witel"][$i]->qty_kirim_retail_hw = $qty_kirim_retail_hw;
			// 	$data["witel"][$i]->qty_kirim_retail_alu = $qty_kirim_retail_alu;

			// 	$data["witel"][$i]->qty_kirim_premium_fh = $qty_kirim_premium_fh;
			// 	$data["witel"][$i]->qty_kirim_premium_hw = $qty_kirim_premium_hw;
			// 	$data["witel"][$i]->qty_kirim_premium_zte = $qty_kirim_premium_zte;
		}

		// $data = $this::hitungQtyKirim($data);

		// print_r($data["witel"]);

		$data["total_qty_minimum"] = array_sum(array_column($data["witel"], 'minimum_qty'));
		$data["total_retail_fh_minimum"] = array_sum(array_column($data["witel"], 'retail_fh'));
		$data["total_retail_hw_minimum"] = array_sum(array_column($data["witel"], 'retail_hw'));
		$data["total_retail_zte_minimum"] = array_sum(array_column($data["witel"], 'retail_zte'));
		$data["total_retail_alu_minimum"] = array_sum(array_column($data["witel"], 'retail_alu'));
		$data["total_retail_minimum"] = array_sum(array_column($data["witel"], 'total_retail'));

		$data["total_premium_fh_minimum"] = array_sum(array_column($data["witel"], 'premium_fh'));
		$data["total_premium_hw_minimum"] = array_sum(array_column($data["witel"], 'premium_hw'));
		$data["total_premium_zte_minimum"] = array_sum(array_column($data["witel"], 'premium_zte'));
		$data["total_premium_minimum"] = array_sum(array_column($data["witel"], 'total_premium'));

		$data["total_retail_stock_fh"] = array_sum(array_column($data["witel"], 'retail_stock_fiberhome'));
		$data["total_retail_stock_hw"] = array_sum(array_column($data["witel"], 'retail_stock_huawei'));
		$data["total_retail_stock_zte"] = array_sum(array_column($data["witel"], 'retail_stock_zte'));
		$data["total_retail_stock_alu"] = array_sum(array_column($data["witel"], 'retail_stock_nokia'));
		$data["total_retail_stock_all"] = array_sum(array_column($data["witel"], 'total_retail_stock'));

		$data["total_premium_stock_fh"] = array_sum(array_column($data["witel"], 'premium_stock_fiberhome'));
		$data["total_premium_stock_hw"] = array_sum(array_column($data["witel"], 'premium_stock_huawei'));
		$data["total_premium_stock_zte"] = array_sum(array_column($data["witel"], 'premium_stock_zte'));
		$data["total_premium_stock_all"] = array_sum(array_column($data["witel"], 'total_premium_stock'));

		$data["total_gap_retail_stock_fh"] = $data["total_retail_stock_fh"] - $data["total_retail_fh_minimum"];
		$data["total_gap_retail_stock_hw"] = $data["total_retail_stock_hw"] - $data["total_retail_hw_minimum"];
		$data["total_gap_retail_stock_zte"] = $data["total_retail_stock_zte"] - $data["total_retail_zte_minimum"];
		$data["total_gap_retail_stock_alu"] = $data["total_retail_stock_alu"] - $data["total_retail_alu_minimum"];
		$data["total_gap_stock_retail"] = $data["total_retail_stock_all"] - $data["total_retail_minimum"];

		$data["total_gap_premium_stock_fh"] = $data["total_premium_stock_fh"] - $data["total_premium_fh_minimum"];
		$data["total_gap_premium_stock_hw"] = $data["total_premium_stock_hw"] - $data["total_premium_hw_minimum"];
		$data["total_gap_premium_stock_zte"] = $data["total_premium_stock_zte"] - $data["total_premium_zte_minimum"];
		$data["total_gap_premium_stock"] = $data["total_premium_stock_all"] - $data["total_premium_minimum"];

		$data["total_on_delivery_retail_fiberhome"] = array_sum(array_column($data["witel"], 'on_delivery_retail_fiberhome'));
		$data["total_on_delivery_retail_huawei"] = array_sum(array_column($data["witel"], 'on_delivery_retail_huawei'));
		$data["total_on_delivery_retail_zte"] = array_sum(array_column($data["witel"], 'on_delivery_retail_zte'));
		$data["total_on_delivery_retail_nokia"] = array_sum(array_column($data["witel"], 'on_delivery_retail_nokia'));
		$data["total_on_delivery_retail_all"] = array_sum(array_column($data["witel"], 'on_delivery_total_retail'));

		$data["total_on_delivery_premium_fiberhome"] = array_sum(array_column($data["witel"], 'on_delivery_premium_fiberhome'));
		$data["total_on_delivery_premium_huawei"] = array_sum(array_column($data["witel"], 'on_delivery_premium_huawei'));
		$data["total_on_delivery_premium_zte"] = array_sum(array_column($data["witel"], 'on_delivery_premium_zte'));
		$data["total_on_delivery_premium_all"] = array_sum(array_column($data["witel"], 'on_delivery_total_premium'));


		session(['jenis_halaman' => ""]);
		session(['data' => $data]);
		return view("rekap_delivery_biasa")->with("data", $data);
	}

	public function deleteAllDataPengiriman()
	{
		if (session("jenis_akun") == "treg") {
			Penerima::deleteDataByTreg('WH TR ' . session("asal"));
		} else {
			Penerima::deleteAllData();
		}

		return back()->with("message", "Semua data pengiriman berhasil dihapus!");
	}

	public function pengirimanONT(Request $request)
	{
		$data["warehouse"] = Gudang::getAllWarehouse();
		$data["penerima"] = Penerima::getAllDataONT();

		return view("report_delivery_ont")->with("data", $data);
	}

	public function pengirimanAP(Request $request)
	{
		$data["warehouse"] = Gudang::getAllWarehouse();
		$data["penerima"] = Penerima::getAllDataONT();

		return view("report_delivery_ont")->with("data", $data);
	}

	public function pengirimanSTB(Request $request)
	{
		$data["penerima"] = Penerima::getAllDataSTB();
		$data["warehouse"] = Gudang::getAllWarehouse();

		return view("penerima_stb")->with("data", $data);
	}

	public function countDataPerWitelTmp()
	{
		$data["witel"] = array_merge(Gudang::getTregQtyMinimum(), Gudang::getQtyMinimum());

		$jenis_stock = "retail";

		$merk = "fiberhome";
		$data[$merk] = DataTmp::countRetailPerWitel($merk);
		$data["penerima"][$merk] = Penerima::countRetailPerWitel($merk);
		$data = $this::addStockCountTmp($jenis_stock, $data, $merk);

		$merk = "zte";
		$data[$merk] = DataTmp::countRetailPerWitel($merk);
		$data["penerima"][$merk] = Penerima::countRetailPerWitel($merk);
		$data = $this::addStockCountTmp($jenis_stock, $data, $merk);

		$merk = "nokia";
		$data[$merk] = DataTmp::countRetailPerWitel($merk);
		$data["penerima"][$merk] = Penerima::countRetailPerWitel($merk);
		$data = $this::addStockCountTmp($jenis_stock, $data, $merk);

		$merk = "huawei";
		$data[$merk] = DataTmp::countRetailPerWitel($merk);
		$data["penerima"][$merk] = Penerima::countRetailPerWitel($merk);
		$data = $this::addStockCountTmp($jenis_stock, $data, $merk);

		$data = $this::addTotalStockCount($jenis_stock, $data);

		$jenis_stock = "premium";

		$merk = "fiberhome";
		$data[$merk] = DataTmp::countPremiumPerWitel($merk);
		$data["penerima"][$merk] = Penerima::countPremiumPerWitel($merk);
		$data = $this::addStockCountTmp($jenis_stock, $data, $merk);

		$merk = "zte";
		$data[$merk] = DataTmp::countPremiumPerWitel($merk);
		$data["penerima"][$merk] = Penerima::countPremiumPerWitel($merk);
		$data = $this::addStockCountTmp($jenis_stock, $data, $merk);

		$merk = "huawei";
		$data[$merk] = DataTmp::countPremiumPerWitel($merk);
		$data["penerima"][$merk] = Penerima::countPremiumPerWitel($merk);
		$data = $this::addStockCountTmp($jenis_stock, $data, $merk);

		$data = $this::addTotalStockCount($jenis_stock, $data);

		$data = $this::addStockTregCountTmp($jenis_stock, $data, $merk);

		return $data;
	}

	public function insertDataDelivery(Request $request)
	{
		$file = $request->file("file_tmp");
		$file->move('file', "uploaded_data_tmp.xlsx");

		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		$spreadsheet = $reader->load("file/uploaded_data_tmp.xlsx");
		// 		$sheet = $spreadsheet->getSheetByName("Data");
		$sheet = $spreadsheet->getActiveSheet();

		$maxRow = $sheet->getHighestRow();
		DataTmp::deleteAllData();

		DataTmp::resetIndex();
		for ($i = 2; $i < $maxRow + 1; $i++) {
			$region = $sheet->getCell("A" . $i)->getValue();
			$lokasi_wh = $sheet->getCell("B" . $i)->getValue();
			$status = $sheet->getCell("C" . $i)->getValue();
			$jumlah = $sheet->getCell("D" . $i)->getValue();
			$deskripsi = $sheet->getCell("E" . $i)->getValue();

			$data["id"] = $i - 1;
			$data["region"] = $region;
			$data["lokasi_wh"] = $lokasi_wh;
			$data["status"] = $status;
			$data["jumlah"] = $jumlah;
			$data["deskripsi"] = $deskripsi;

			DataTmp::insertData($data);
		}

		File::delete("file/uploaded_data_tmp.xlsx");
		session(['data' => $data]);
		return redirect("rekap_delivery");
	}

	public function exportDataTmpSCMT(Request $request, $jenis_export, $jumlah_data_export)
	{
		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		$spreadsheet_export = $reader->load("file/template_qty_kirim.xlsx");

		$sheet = $spreadsheet_export->getSheetByName("Qty Kirim");
		$filename = "Hasil_Rekap_Stock_SCMT_" . date('Y-m-d') . ".xlsx";
		$tmp_data_witel = session("data")["witel"];

		$idx_awal = 7;
		if ($jumlah_data_export == "rekap_delivery") {
			$idx_awal = 0;
		} else if ($jumlah_data_export == "all") {
			$data = $this::countDataPerWitelTmp();
			$data = $this::hitungQtyKirim($data);

			if (session("jenis_akun") == "treg") {
				$data["witel"] = array_values(array_filter($data["witel"], function ($obj) {
					return str_contains(strtolower($obj->regional), session("asal"));
				}));
			}
			session(["data" => $data]);
		}

		if ($jenis_export == "all") {
			$i = 4;
			for ($j = $idx_awal; $j < count(session("data")["witel"]); $j++) {
				$sheet->setCellValue('A' . $i, session("data")["witel"][$j]->regional);
				$sheet->setCellValue('B' . $i, session("data")["witel"][$j]->lokasi_wh);
				$sheet->setCellValue('C' . $i, session("data")["witel"][$j]->minimum_qty);

				$sheet->setCellValue('D' . $i, session("data")["witel"][$j]->retail_fh);
				$sheet->setCellValue('E' . $i, session("data")["witel"][$j]->retail_hw);
				$sheet->setCellValue('F' . $i, session("data")["witel"][$j]->retail_zte);
				$sheet->setCellValue('G' . $i, session("data")["witel"][$j]->retail_alu);
				$sheet->setCellValue('H' . $i, session("data")["witel"][$j]->total_retail);

				$sheet->setCellValue('I' . $i, session("data")["witel"][$j]->premium_fh);
				$sheet->setCellValue('J' . $i, session("data")["witel"][$j]->premium_hw); //estimasi nilai
				$sheet->setCellValue('K' . $i, session("data")["witel"][$j]->premium_zte);
				$sheet->setCellValue('L' . $i, session("data")["witel"][$j]->total_premium);

				$sheet->setCellValue('M' . $i, session("data")["witel"][$j]->retail_stock_fiberhome);
				$sheet->setCellValue('N' . $i, session("data")["witel"][$j]->retail_stock_huawei);
				$sheet->setCellValue('O' . $i, session("data")["witel"][$j]->retail_stock_zte);
				$sheet->setCellValue('P' . $i, session("data")["witel"][$j]->retail_stock_nokia);
				$sheet->setCellValue('Q' . $i, session("data")["witel"][$j]->total_retail_stock);

				$sheet->setCellValue('R' . $i, session("data")["witel"][$j]->premium_stock_fiberhome);
				$sheet->setCellValue('S' . $i, session("data")["witel"][$j]->premium_stock_huawei);
				$sheet->setCellValue('T' . $i, session("data")["witel"][$j]->premium_stock_zte);
				$sheet->setCellValue('U' . $i, session("data")["witel"][$j]->total_premium_stock);

				$sheet->setCellValue('V' . $i, session("data")["witel"][$j]->retail_stock_fiberhome - session("data")["witel"][$j]->retail_fh);
				$sheet->setCellValue('W' . $i, session("data")["witel"][$j]->retail_stock_huawei - session("data")["witel"][$j]->retail_hw);
				$sheet->setCellValue('X' . $i, session("data")["witel"][$j]->retail_stock_zte - session("data")["witel"][$j]->retail_zte);
				$sheet->setCellValue('Y' . $i, session("data")["witel"][$j]->retail_stock_nokia - session("data")["witel"][$j]->retail_alu);
				$sheet->setCellValue('Z' . $i, session("data")["witel"][$j]->total_retail_stock - session("data")["witel"][$j]->total_retail);

				$sheet->setCellValue('AA' . $i, session("data")["witel"][$j]->premium_stock_fiberhome - session("data")["witel"][$j]->premium_fh);
				$sheet->setCellValue('AB' . $i, session("data")["witel"][$j]->premium_stock_huawei - session("data")["witel"][$j]->premium_hw);
				$sheet->setCellValue('AC' . $i, session("data")["witel"][$j]->premium_stock_zte - session("data")["witel"][$j]->premium_zte);
				$sheet->setCellValue('AD' . $i, session("data")["witel"][$j]->total_premium_stock - session("data")["witel"][$j]->total_premium);

				$sheet->setCellValue('AE' . $i, session("data")["witel"][$j]->batas_atas_retail_fh);
				$sheet->setCellValue('AF' . $i, session("data")["witel"][$j]->batas_atas_retail_hw);
				$sheet->setCellValue('AG' . $i, session("data")["witel"][$j]->batas_atas_retail_zte);
				$sheet->setCellValue('AH' . $i, session("data")["witel"][$j]->batas_atas_retail_alu);
				$sheet->setCellValue('AI' . $i, session("data")["witel"][$j]->batas_atas_retail_fh + session("data")["witel"][$j]->batas_atas_retail_hw + session("data")["witel"][$j]->batas_atas_retail_zte + session("data")["witel"][$j]->batas_atas_retail_alu);

				$sheet->setCellValue('AJ' . $i, session("data")["witel"][$j]->batas_atas_premium_fh);
				$sheet->setCellValue('AK' . $i, session("data")["witel"][$j]->batas_atas_premium_hw); //estimasi nilai
				$sheet->setCellValue('AL' . $i, session("data")["witel"][$j]->batas_atas_premium_zte);
				$sheet->setCellValue('AM' . $i, session("data")["witel"][$j]->batas_atas_premium_fh + session("data")["witel"][$j]->batas_atas_premium_hw + session("data")["witel"][$j]->batas_atas_premium_zte);

				$sheet->setCellValue('AN' . $i, session("data")["witel"][$j]->batas_bawah_retail_fh);
				$sheet->setCellValue('AO' . $i, session("data")["witel"][$j]->batas_bawah_retail_hw);
				$sheet->setCellValue('AP' . $i, session("data")["witel"][$j]->batas_bawah_retail_zte);
				$sheet->setCellValue('AQ' . $i, session("data")["witel"][$j]->batas_bawah_retail_alu);
				$sheet->setCellValue('AR' . $i, session("data")["witel"][$j]->batas_bawah_retail_fh + session("data")["witel"][$j]->batas_bawah_retail_hw + session("data")["witel"][$j]->batas_bawah_retail_zte + session("data")["witel"][$j]->batas_bawah_retail_alu);

				$sheet->setCellValue('AS' . $i, session("data")["witel"][$j]->batas_bawah_premium_fh);
				$sheet->setCellValue('AT' . $i, session("data")["witel"][$j]->batas_bawah_premium_hw); //estimasi nilai
				$sheet->setCellValue('AU' . $i, session("data")["witel"][$j]->batas_bawah_premium_zte);
				$sheet->setCellValue('AV' . $i, session("data")["witel"][$j]->batas_bawah_premium_fh + session("data")["witel"][$j]->batas_bawah_premium_hw + session("data")["witel"][$j]->batas_bawah_premium_zte);

				$sheet->setCellValue('AW' . $i, session("data")["witel"][$j]->qty_kirim_retail_fh);
				$sheet->setCellValue('AX' . $i, session("data")["witel"][$j]->qty_kirim_retail_hw);
				$sheet->setCellValue('AY' . $i, session("data")["witel"][$j]->qty_kirim_retail_zte);
				$sheet->setCellValue('AZ' . $i, session("data")["witel"][$j]->qty_kirim_retail_alu);
				$sheet->setCellValue('BA' . $i, session("data")["witel"][$j]->qty_kirim_retail_fh + session("data")["witel"][$j]->qty_kirim_retail_hw + session("data")["witel"][$j]->qty_kirim_retail_zte + session("data")["witel"][$j]->qty_kirim_retail_alu);

				$sheet->setCellValue('BB' . $i, session("data")["witel"][$j]->qty_kirim_premium_fh);
				$sheet->setCellValue('BC' . $i, session("data")["witel"][$j]->qty_kirim_premium_hw);
				$sheet->setCellValue('BD' . $i, session("data")["witel"][$j]->qty_kirim_premium_zte);
				$sheet->setCellValue('BE' . $i, session("data")["witel"][$j]->qty_kirim_premium_fh + session("data")["witel"][$j]->qty_kirim_premium_hw + session("data")["witel"][$j]->qty_kirim_premium_zte);


				if (session("data")["witel"][$j]->total_retail_stock - session("data")["witel"][$j]->total_retail < -(session("data")["witel"][$j]->total_retail * 0.75)) {
					$sheet
						->getStyle('Z' . $i)
						->getFill()
						->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
						->getStartColor('red')
						->setARGB('red');
				} else if (session("data")["witel"][$j]->total_retail_stock - session("data")["witel"][$j]->total_retail < 0) {
					$sheet
						->getStyle('Z' . $i)
						->getFill()
						->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
						->getStartColor('yellow')
						->setARGB('yellow');
				}

				if (session("data")["witel"][$j]->total_premium_stock - session("data")["witel"][$j]->total_premium < -(session("data")["witel"][$j]->total_premium * 0.75)) {
					$sheet
						->getStyle('AD' . $i)
						->getFill()
						->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
						->getStartColor('red')
						->setARGB('red');
				} else if (session("data")["witel"][$j]->total_premium_stock - session("data")["witel"][$j]->total_premium < 0) {
					$sheet
						->getStyle('AD' . $i)
						->getFill()
						->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
						->getStartColor('yellow')
						->setARGB('yellow');
				}

				$sheet->setCellValue('BF' . $i, session("data")["witel"][$j]->on_delivery_retail_fiberhome);
				$sheet->setCellValue('BG' . $i, session("data")["witel"][$j]->on_delivery_retail_huawei);
				$sheet->setCellValue('BH' . $i, session("data")["witel"][$j]->on_delivery_retail_zte);
				$sheet->setCellValue('BI' . $i, session("data")["witel"][$j]->on_delivery_retail_nokia);
				$sheet->setCellValue('BJ' . $i, session("data")["witel"][$j]->on_delivery_total_retail);

				$sheet->setCellValue('BK' . $i, session("data")["witel"][$j]->on_delivery_premium_fiberhome);
				$sheet->setCellValue('BL' . $i, session("data")["witel"][$j]->on_delivery_premium_huawei);
				$sheet->setCellValue('BM' . $i, session("data")["witel"][$j]->on_delivery_premium_zte);
				$sheet->setCellValue('BN' . $i, session("data")["witel"][$j]->on_delivery_total_premium);

				$i++;
			}
		} else if ($jenis_export == "kuning") {
			$i = 4;
			for ($j = $idx_awal; $j < count(session("data")["witel"]); $j++) {
				if ((session("data")["witel"][$j]->total_retail_stock - session("data")["witel"][$j]->total_retail < 0 && session("data")["witel"][$j]->total_retail_stock - session("data")["witel"][$j]->total_retail > -(session("data")["witel"][$j]->total_retail * 0.75)) || (session("data")["witel"][$j]->total_premium_stock - session("data")["witel"][$j]->total_premium < 0 && session("data")["witel"][$j]->total_premium_stock - session("data")["witel"][$j]->total_premium > -(session("data")["witel"][$j]->total_premium * 0.75))) {
					$sheet->setCellValue('A' . $i, session("data")["witel"][$j]->regional);
					$sheet->setCellValue('B' . $i, session("data")["witel"][$j]->lokasi_wh);
					$sheet->setCellValue('C' . $i, session("data")["witel"][$j]->minimum_qty);

					$sheet->setCellValue('D' . $i, session("data")["witel"][$j]->retail_fh);
					$sheet->setCellValue('E' . $i, session("data")["witel"][$j]->retail_hw);
					$sheet->setCellValue('F' . $i, session("data")["witel"][$j]->retail_zte);
					$sheet->setCellValue('G' . $i, session("data")["witel"][$j]->retail_alu);
					$sheet->setCellValue('H' . $i, session("data")["witel"][$j]->total_retail);

					$sheet->setCellValue('I' . $i, session("data")["witel"][$j]->premium_fh);
					$sheet->setCellValue('J' . $i, session("data")["witel"][$j]->premium_hw); //estimasi nilai
					$sheet->setCellValue('K' . $i, session("data")["witel"][$j]->premium_zte);
					$sheet->setCellValue('L' . $i, session("data")["witel"][$j]->total_premium);

					$sheet->setCellValue('M' . $i, session("data")["witel"][$j]->retail_stock_fiberhome);
					$sheet->setCellValue('N' . $i, session("data")["witel"][$j]->retail_stock_huawei);
					$sheet->setCellValue('O' . $i, session("data")["witel"][$j]->retail_stock_zte);
					$sheet->setCellValue('P' . $i, session("data")["witel"][$j]->retail_stock_nokia);
					$sheet->setCellValue('Q' . $i, session("data")["witel"][$j]->total_retail_stock);

					$sheet->setCellValue('R' . $i, session("data")["witel"][$j]->premium_stock_fiberhome);
					$sheet->setCellValue('S' . $i, session("data")["witel"][$j]->premium_stock_huawei);
					$sheet->setCellValue('T' . $i, session("data")["witel"][$j]->premium_stock_zte);
					$sheet->setCellValue('U' . $i, session("data")["witel"][$j]->total_premium_stock);

					$sheet->setCellValue('V' . $i, session("data")["witel"][$j]->retail_stock_fiberhome - session("data")["witel"][$j]->retail_fh);
					$sheet->setCellValue('W' . $i, session("data")["witel"][$j]->retail_stock_huawei - session("data")["witel"][$j]->retail_hw);
					$sheet->setCellValue('X' . $i, session("data")["witel"][$j]->retail_stock_zte - session("data")["witel"][$j]->retail_zte);
					$sheet->setCellValue('Y' . $i, session("data")["witel"][$j]->retail_stock_nokia - session("data")["witel"][$j]->retail_alu);
					$sheet->setCellValue('Z' . $i, session("data")["witel"][$j]->total_retail_stock - session("data")["witel"][$j]->total_retail);

					$sheet->setCellValue('AA' . $i, session("data")["witel"][$j]->premium_stock_fiberhome - session("data")["witel"][$j]->premium_fh);
					$sheet->setCellValue('AB' . $i, session("data")["witel"][$j]->premium_stock_huawei - session("data")["witel"][$j]->premium_hw);
					$sheet->setCellValue('AC' . $i, session("data")["witel"][$j]->premium_stock_zte - session("data")["witel"][$j]->premium_zte);
					$sheet->setCellValue('AD' . $i, session("data")["witel"][$j]->total_premium_stock - session("data")["witel"][$j]->total_premium);

					$sheet->setCellValue('AE' . $i, session("data")["witel"][$j]->batas_atas_retail_fh);
					$sheet->setCellValue('AF' . $i, session("data")["witel"][$j]->batas_atas_retail_hw);
					$sheet->setCellValue('AG' . $i, session("data")["witel"][$j]->batas_atas_retail_zte);
					$sheet->setCellValue('AH' . $i, session("data")["witel"][$j]->batas_atas_retail_alu);
					$sheet->setCellValue('AI' . $i, session("data")["witel"][$j]->batas_atas_retail_fh + session("data")["witel"][$j]->batas_atas_retail_hw + session("data")["witel"][$j]->batas_atas_retail_zte + session("data")["witel"][$j]->batas_atas_retail_alu);

					$sheet->setCellValue('AJ' . $i, session("data")["witel"][$j]->batas_atas_premium_fh);
					$sheet->setCellValue('AK' . $i, session("data")["witel"][$j]->batas_atas_premium_hw); //estimasi nilai
					$sheet->setCellValue('AL' . $i, session("data")["witel"][$j]->batas_atas_premium_zte);
					$sheet->setCellValue('AM' . $i, session("data")["witel"][$j]->batas_atas_premium_fh + session("data")["witel"][$j]->batas_atas_premium_hw + session("data")["witel"][$j]->batas_atas_premium_zte);

					$sheet->setCellValue('AN' . $i, session("data")["witel"][$j]->batas_bawah_retail_fh);
					$sheet->setCellValue('AO' . $i, session("data")["witel"][$j]->batas_bawah_retail_hw);
					$sheet->setCellValue('AP' . $i, session("data")["witel"][$j]->batas_bawah_retail_zte);
					$sheet->setCellValue('AQ' . $i, session("data")["witel"][$j]->batas_bawah_retail_alu);
					$sheet->setCellValue('AR' . $i, session("data")["witel"][$j]->batas_bawah_retail_fh + session("data")["witel"][$j]->batas_bawah_retail_hw + session("data")["witel"][$j]->batas_bawah_retail_zte + session("data")["witel"][$j]->batas_bawah_retail_alu);

					$sheet->setCellValue('AS' . $i, session("data")["witel"][$j]->batas_bawah_premium_fh);
					$sheet->setCellValue('AT' . $i, session("data")["witel"][$j]->batas_bawah_premium_hw); //estimasi nilai
					$sheet->setCellValue('AU' . $i, session("data")["witel"][$j]->batas_bawah_premium_zte);
					$sheet->setCellValue('AV' . $i, session("data")["witel"][$j]->batas_bawah_premium_fh + session("data")["witel"][$j]->batas_bawah_premium_hw + session("data")["witel"][$j]->batas_bawah_premium_zte);

					$sheet->setCellValue('AW' . $i, session("data")["witel"][$j]->qty_kirim_retail_fh);
					$sheet->setCellValue('AX' . $i, session("data")["witel"][$j]->qty_kirim_retail_hw);
					$sheet->setCellValue('AY' . $i, session("data")["witel"][$j]->qty_kirim_retail_zte);
					$sheet->setCellValue('AZ' . $i, session("data")["witel"][$j]->qty_kirim_retail_alu);
					$sheet->setCellValue('BA' . $i, session("data")["witel"][$j]->qty_kirim_retail_fh + session("data")["witel"][$j]->qty_kirim_retail_hw + session("data")["witel"][$j]->qty_kirim_retail_zte + session("data")["witel"][$j]->qty_kirim_retail_alu);

					$sheet->setCellValue('BB' . $i, session("data")["witel"][$j]->qty_kirim_premium_fh);
					$sheet->setCellValue('BC' . $i, session("data")["witel"][$j]->qty_kirim_premium_hw);
					$sheet->setCellValue('BD' . $i, session("data")["witel"][$j]->qty_kirim_premium_zte);
					$sheet->setCellValue('BE' . $i, session("data")["witel"][$j]->qty_kirim_premium_fh + session("data")["witel"][$j]->qty_kirim_premium_hw + session("data")["witel"][$j]->qty_kirim_premium_zte);

					if (session("data")["witel"][$j]->total_retail_stock - session("data")["witel"][$j]->total_retail < 0 && session("data")["witel"][$j]->total_retail_stock - session("data")["witel"][$j]->total_retail > -(session("data")["witel"][$j]->total_retail * 0.75)) {
						$sheet
							->getStyle('Z' . $i)
							->getFill()
							->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
							->getStartColor('yellow')
							->setARGB('yellow');
					} else {
						$sheet->setCellValue('Z' . $i, "");
					}

					if (session("data")["witel"][$j]->total_premium_stock - session("data")["witel"][$j]->total_premium < 0 && session("data")["witel"][$j]->total_premium_stock - session("data")["witel"][$j]->total_premium > -(session("data")["witel"][$j]->total_premium * 0.75)) {
						$sheet
							->getStyle('AD' . $i)
							->getFill()
							->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
							->getStartColor('yellow')
							->setARGB('yellow');
					} else {
						$sheet->setCellValue('AD' . $i, "");
					}

					$sheet->setCellValue('BF' . $i, session("data")["witel"][$j]->on_delivery_retail_fiberhome);
					$sheet->setCellValue('BG' . $i, session("data")["witel"][$j]->on_delivery_retail_huawei);
					$sheet->setCellValue('BH' . $i, session("data")["witel"][$j]->on_delivery_retail_zte);
					$sheet->setCellValue('BI' . $i, session("data")["witel"][$j]->on_delivery_retail_nokia);
					$sheet->setCellValue('BJ' . $i, session("data")["witel"][$j]->on_delivery_total_retail);

					$sheet->setCellValue('BK' . $i, session("data")["witel"][$j]->on_delivery_premium_fiberhome);
					$sheet->setCellValue('BL' . $i, session("data")["witel"][$j]->on_delivery_premium_huawei);
					$sheet->setCellValue('BM' . $i, session("data")["witel"][$j]->on_delivery_premium_zte);
					$sheet->setCellValue('BN' . $i, session("data")["witel"][$j]->on_delivery_total_premium);

					$i++;
				}
			}
			$filename = "Hasil_Rekap_Stock_SCMT_Kuning_" . date('Y-m-d') . ".xlsx";
		} else if ($jenis_export == "merah") {
			$i = 4;
			for ($j = $idx_awal; $j < count(session("data")["witel"]); $j++) {
				if ((session("data")["witel"][$j]->total_retail_stock - session("data")["witel"][$j]->total_retail < -(session("data")["witel"][$j]->total_retail * 0.75)) || (session("data")["witel"][$j]->total_premium_stock - session("data")["witel"][$j]->total_premium < -(session("data")["witel"][$j]->total_premium * 0.75))) {
					$sheet->setCellValue('A' . $i, session("data")["witel"][$j]->regional);
					$sheet->setCellValue('B' . $i, session("data")["witel"][$j]->lokasi_wh);
					$sheet->setCellValue('C' . $i, session("data")["witel"][$j]->minimum_qty);

					$sheet->setCellValue('D' . $i, session("data")["witel"][$j]->retail_fh);
					$sheet->setCellValue('E' . $i, session("data")["witel"][$j]->retail_hw);
					$sheet->setCellValue('F' . $i, session("data")["witel"][$j]->retail_zte);
					$sheet->setCellValue('G' . $i, session("data")["witel"][$j]->retail_alu);
					$sheet->setCellValue('H' . $i, session("data")["witel"][$j]->total_retail);

					$sheet->setCellValue('I' . $i, session("data")["witel"][$j]->premium_fh);
					$sheet->setCellValue('J' . $i, session("data")["witel"][$j]->premium_hw); //estimasi nilai
					$sheet->setCellValue('K' . $i, session("data")["witel"][$j]->premium_zte);
					$sheet->setCellValue('L' . $i, session("data")["witel"][$j]->total_premium);

					$sheet->setCellValue('M' . $i, session("data")["witel"][$j]->retail_stock_fiberhome);
					$sheet->setCellValue('N' . $i, session("data")["witel"][$j]->retail_stock_huawei);
					$sheet->setCellValue('O' . $i, session("data")["witel"][$j]->retail_stock_zte);
					$sheet->setCellValue('P' . $i, session("data")["witel"][$j]->retail_stock_nokia);
					$sheet->setCellValue('Q' . $i, session("data")["witel"][$j]->total_retail_stock);

					$sheet->setCellValue('R' . $i, session("data")["witel"][$j]->premium_stock_fiberhome);
					$sheet->setCellValue('S' . $i, session("data")["witel"][$j]->premium_stock_huawei);
					$sheet->setCellValue('T' . $i, session("data")["witel"][$j]->premium_stock_zte);
					$sheet->setCellValue('U' . $i, session("data")["witel"][$j]->total_premium_stock);

					$sheet->setCellValue('V' . $i, session("data")["witel"][$j]->retail_stock_fiberhome - session("data")["witel"][$j]->retail_fh);
					$sheet->setCellValue('W' . $i, session("data")["witel"][$j]->retail_stock_huawei - session("data")["witel"][$j]->retail_hw);
					$sheet->setCellValue('X' . $i, session("data")["witel"][$j]->retail_stock_zte - session("data")["witel"][$j]->retail_zte);
					$sheet->setCellValue('Y' . $i, session("data")["witel"][$j]->retail_stock_nokia - session("data")["witel"][$j]->retail_alu);
					$sheet->setCellValue('Z' . $i, session("data")["witel"][$j]->total_retail_stock - session("data")["witel"][$j]->total_retail);

					$sheet->setCellValue('AA' . $i, session("data")["witel"][$j]->premium_stock_fiberhome - session("data")["witel"][$j]->premium_fh);
					$sheet->setCellValue('AB' . $i, session("data")["witel"][$j]->premium_stock_huawei - session("data")["witel"][$j]->premium_hw);
					$sheet->setCellValue('AC' . $i, session("data")["witel"][$j]->premium_stock_zte - session("data")["witel"][$j]->premium_zte);
					$sheet->setCellValue('AD' . $i, session("data")["witel"][$j]->total_premium_stock - session("data")["witel"][$j]->total_premium);

					$sheet->setCellValue('AE' . $i, session("data")["witel"][$j]->batas_atas_retail_fh);
					$sheet->setCellValue('AF' . $i, session("data")["witel"][$j]->batas_atas_retail_hw);
					$sheet->setCellValue('AG' . $i, session("data")["witel"][$j]->batas_atas_retail_zte);
					$sheet->setCellValue('AH' . $i, session("data")["witel"][$j]->batas_atas_retail_alu);
					$sheet->setCellValue('AI' . $i, session("data")["witel"][$j]->batas_atas_retail_fh + session("data")["witel"][$j]->batas_atas_retail_hw + session("data")["witel"][$j]->batas_atas_retail_zte + session("data")["witel"][$j]->batas_atas_retail_alu);

					$sheet->setCellValue('AJ' . $i, session("data")["witel"][$j]->batas_atas_premium_fh);
					$sheet->setCellValue('AK' . $i, session("data")["witel"][$j]->batas_atas_premium_hw); //estimasi nilai
					$sheet->setCellValue('AL' . $i, session("data")["witel"][$j]->batas_atas_premium_zte);
					$sheet->setCellValue('AM' . $i, session("data")["witel"][$j]->batas_atas_premium_fh + session("data")["witel"][$j]->batas_atas_premium_hw + session("data")["witel"][$j]->batas_atas_premium_zte);

					$sheet->setCellValue('AN' . $i, session("data")["witel"][$j]->batas_bawah_retail_fh);
					$sheet->setCellValue('AO' . $i, session("data")["witel"][$j]->batas_bawah_retail_hw);
					$sheet->setCellValue('AP' . $i, session("data")["witel"][$j]->batas_bawah_retail_zte);
					$sheet->setCellValue('AQ' . $i, session("data")["witel"][$j]->batas_bawah_retail_alu);
					$sheet->setCellValue('AR' . $i, session("data")["witel"][$j]->batas_bawah_retail_fh + session("data")["witel"][$j]->batas_bawah_retail_hw + session("data")["witel"][$j]->batas_bawah_retail_zte + session("data")["witel"][$j]->batas_bawah_retail_alu);

					$sheet->setCellValue('AS' . $i, session("data")["witel"][$j]->batas_bawah_premium_fh);
					$sheet->setCellValue('AT' . $i, session("data")["witel"][$j]->batas_bawah_premium_hw); //estimasi nilai
					$sheet->setCellValue('AU' . $i, session("data")["witel"][$j]->batas_bawah_premium_zte);
					$sheet->setCellValue('AV' . $i, session("data")["witel"][$j]->batas_bawah_premium_fh + session("data")["witel"][$j]->batas_bawah_premium_hw + session("data")["witel"][$j]->batas_bawah_premium_zte);

					$sheet->setCellValue('AW' . $i, session("data")["witel"][$j]->qty_kirim_retail_fh);
					$sheet->setCellValue('AX' . $i, session("data")["witel"][$j]->qty_kirim_retail_hw);
					$sheet->setCellValue('AY' . $i, session("data")["witel"][$j]->qty_kirim_retail_zte);
					$sheet->setCellValue('AZ' . $i, session("data")["witel"][$j]->qty_kirim_retail_alu);
					$sheet->setCellValue('BA' . $i, session("data")["witel"][$j]->qty_kirim_retail_fh + session("data")["witel"][$j]->qty_kirim_retail_hw + session("data")["witel"][$j]->qty_kirim_retail_zte + session("data")["witel"][$j]->qty_kirim_retail_alu);

					$sheet->setCellValue('BB' . $i, session("data")["witel"][$j]->qty_kirim_premium_fh);
					$sheet->setCellValue('BC' . $i, session("data")["witel"][$j]->qty_kirim_premium_hw);
					$sheet->setCellValue('BD' . $i, session("data")["witel"][$j]->qty_kirim_premium_zte);
					$sheet->setCellValue('BE' . $i, session("data")["witel"][$j]->qty_kirim_premium_fh + session("data")["witel"][$j]->qty_kirim_premium_hw + session("data")["witel"][$j]->qty_kirim_premium_zte);

					if (session("data")["witel"][$j]->total_retail_stock - session("data")["witel"][$j]->total_retail < -(session("data")["witel"][$j]->total_retail * 0.75)) {
						$sheet
							->getStyle('Z' . $i)
							->getFill()
							->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
							->getStartColor('red')
							->setARGB('red');
					} else {
						$sheet->setCellValue('Z' . $i, "");
					}

					if (session("data")["witel"][$j]->total_premium_stock - session("data")["witel"][$j]->total_premium < -(session("data")["witel"][$j]->total_premium * 0.75)) {
						$sheet
							->getStyle('AD' . $i)
							->getFill()
							->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
							->getStartColor('red')
							->setARGB('red');
					} else {
						$sheet->setCellValue('AD' . $i, "");
					}

					$sheet->setCellValue('BF' . $i, session("data")["witel"][$j]->on_delivery_retail_fiberhome);
					$sheet->setCellValue('BG' . $i, session("data")["witel"][$j]->on_delivery_retail_huawei);
					$sheet->setCellValue('BH' . $i, session("data")["witel"][$j]->on_delivery_retail_zte);
					$sheet->setCellValue('BI' . $i, session("data")["witel"][$j]->on_delivery_retail_nokia);
					$sheet->setCellValue('BJ' . $i, session("data")["witel"][$j]->on_delivery_total_retail);

					$sheet->setCellValue('BK' . $i, session("data")["witel"][$j]->on_delivery_premium_fiberhome);
					$sheet->setCellValue('BL' . $i, session("data")["witel"][$j]->on_delivery_premium_huawei);
					$sheet->setCellValue('BM' . $i, session("data")["witel"][$j]->on_delivery_premium_zte);
					$sheet->setCellValue('BN' . $i, session("data")["witel"][$j]->on_delivery_total_premium);

					$i++;
					$filename = "Hasil_Rekap_Stock_SCMT_Merah_" . date('Y-m-d') . ".xlsx";
				}
			}
		}

		$data["witel"] = $tmp_data_witel;
		if ($jumlah_data_export == "all") {
			session(["data" => $data]);
		}

		//write it again to Filesystem with the same name (=replace)
		$writer = new Xlsx($spreadsheet_export);
		$writer->save("file/hasil_export.xlsx");

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="' . urlencode($filename) . '"');
		$writer->save('php://output');
	}

	public function updateDatabaseMinimumStock(Request $request)
	{
		if ($request->hasFile("file_database")) {
			$file = $request->file("file_database");
			$file->move('file', "uploaded_database.xlsx");

			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			$spreadsheet = $reader->load("file/uploaded_database.xlsx");
			$sheet = $spreadsheet->getSheetByName("Database");

			$maxRow = $sheet->getHighestRow();
			Gudang::deleteAllData();

			Gudang::resetIndex();
			for ($i = 4; $i < $maxRow + 1; $i++) {
				$data["treg"] = $sheet->getCell("A" . $i)->getValue();
				$data["witel"] = $sheet->getCell("B" . $i)->getValue();
				$data["lokasi_wh"] = $sheet->getCell("C" . $i)->getValue();
				$data["lokasi"] = $sheet->getCell("D" . $i)->getValue();
				$data["wilayah"] = $sheet->getCell("E" . $i)->getValue();
				$data["minimum_qty"] = $sheet->getCell("F" . $i)->getValue();
				$data["retail_fh"] = $sheet->getCell("G" . $i)->getValue();
				$data["retail_hw"] = $sheet->getCell("H" . $i)->getValue();
				$data["retail_zte"] = $sheet->getCell("I" . $i)->getValue();
				$data["retail_alu"] = $sheet->getCell("J" . $i)->getValue();
				$data["premium_fh"] = $sheet->getCell("K" . $i)->getValue();
				$data["premium_hw"] = $sheet->getCell("L" . $i)->getValue();
				$data["premium_zte"] = $sheet->getCell("M" . $i)->getValue();
				$data["stb_zte"] = $sheet->getCell("N" . $i)->getValue();

				Gudang::insertData($data);
			}
		}

		$data["witel"] = array_merge(Gudang::getTregQtyMinimum(), Gudang::getQtyMinimum());
		return back()->with('data', $data);
	}

	public function downloadTemplateDatabase(Request $request)
	{
		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		$spreadsheet_export = $reader->load("file/template_database.xlsx");

		$sheet = $spreadsheet_export->getSheetByName("Database");

		//write it again to Filesystem with the same name (=replace)
		$writer = new Xlsx($spreadsheet_export);

		$filename = "Template_database_minimum_stock.xlsx";
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="' . urlencode($filename) . '"');
		$writer->save('php://output');
	}

	public function downloadTemplateDataTmp(Request $request)
	{
		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		$spreadsheet_export = $reader->load("file/template_data_tmp.xlsx");

		$sheet = $spreadsheet_export->getSheetByName("Database");

		//write it again to Filesystem with the same name (=replace)
		$writer = new Xlsx($spreadsheet_export);

		$filename = "Template_data_sementara.xlsx";
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="' . urlencode($filename) . '"');
		$writer->save('php://output');
	}

	public function downloadTemplatePenerima(Request $request)
	{
		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		$spreadsheet_export = $reader->load("file/template_penerima.xlsx");

		$sheet = $spreadsheet_export->getSheetByName("Database");

		//write it again to Filesystem with the same name (=replace)
		$writer = new Xlsx($spreadsheet_export);

		$filename = "Template_data_penerima.xlsx";
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="' . urlencode($filename) . '"');
		$writer->save('php://output');
	}

	public function exportDatabaseToExcel(Request $request)
	{
		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		$spreadsheet_export = $reader->load("file/template_database.xlsx");

		$sheet = $spreadsheet_export->getSheetByName("Database");

		$data = Gudang::getAllData();
		$j = 0;
		for ($i = 4; $i < count($data) + 4; $i++) {
			$sheet->setCellValue('A' . $i, $data[$j]->regional);
			$sheet->setCellValue('B' . $i, $data[$j]->witel);
			$sheet->setCellValue('C' . $i, $data[$j]->lokasi_wh);
			$sheet->setCellValue('D' . $i, $data[$j]->lokasi);
			$sheet->setCellValue('E' . $i, $data[$j]->wilayah);
			$sheet->setCellValue('F' . $i, $data[$j]->minimum_qty);
			$sheet->setCellValue('G' . $i, $data[$j]->retail_fh);
			$sheet->setCellValue('H' . $i, $data[$j]->retail_hw);
			$sheet->setCellValue('I' . $i, $data[$j]->retail_zte);
			$sheet->setCellValue('J' . $i, $data[$j]->retail_alu);

			$sheet->setCellValue('K' . $i, $data[$j]->premium_fh);
			$sheet->setCellValue('L' . $i, $data[$j]->premium_hw);
			$sheet->setCellValue('M' . $i, $data[$j]->premium_zte);
			$sheet->setCellValue('N' . $i, $data[$j]->stb_zte);
			$j += 1;
		}

		//write it again to Filesystem with the same name (=replace)
		$writer = new Xlsx($spreadsheet_export);

		$filename = "Database_minimum_stock_" . date('Y-m-d') . ".xlsx";
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="' . urlencode($filename) . '"');
		$writer->save('php://output');
	}

	public function dashboardMonitoring(Request $request)
	{
		$data = $this::countDataPerWitelTmp();
		$data["witel"] = array_filter($data["witel"], function ($obj) {
			return str_contains(strtolower($obj->lokasi_wh), "treg");
		});

		$data["jenis_warehouse"] = "Witel";
		$data = $this::hitungQtyKirim($data);

		session(['data' => $data]);
		return view("dashboard_monitoring")->with('data', $data);
	}

	//     public function dashboardMonitoring(Request $request){
// 		$data = $this::countDataPerWitelTmp();
// 		$data = $this::hitungQtyKirim($data);

	// 		$data["jenis_warehouse"] = "Witel";
// 		$data["witel"] = array_filter($data["witel"] , function ($obj){
// 			return str_contains(strtolower($obj->lokasi_wh), "treg");
// 		});

	// 		session(['data' => $data]);
// 		return view("rekap_delivery")->with('data', $data);
// 	}

	public function dashboardMonitoringPage(Request $request, $jenis_warehouse, $value_warehouse)
	{
		$value_warehouse = str_replace("%20", " ", $value_warehouse);
		$data = $this::countDataPerWitelTmp();

		if ($jenis_warehouse == "Witel") {
			$data["jenis_warehouse"] = "TA SO";
			$data["witel"] = array_values(array_filter($data["witel"], function ($obj) use ($value_warehouse) {
				return str_contains(strtolower($obj->regional), strtolower($value_warehouse)) && str_contains(strtolower($obj->lokasi_wh), "witel");
			}));
		} else if ($jenis_warehouse == "TA SO") {
			$data["jenis_warehouse"] = "";

			if (str_contains($value_warehouse, "(")) {
				$open = strpos($value_warehouse, "(");
				$close = strpos($value_warehouse, ")");
				$value_warehouse = substr($value_warehouse, $open + 1, $close - $open - 1);
			}

			if (str_contains($value_warehouse, "WH")) {
				$value_warehouse = substr($value_warehouse, 0, strlen($value_warehouse) - 3);
			}

			$tesData = strtolower($data["witel"][92]->witel);
			// print_r($data["witel"][92]);

			$data["witel"] = array_values(array_filter($data["witel"], function ($obj) use ($value_warehouse) {
				// echo strtolower($obj->witel)." ".strtolower($value_warehouse)."<br>";
				return str_contains(strtolower($obj->witel), strtolower($value_warehouse));
			}));
		}

		session(['data' => $data]);
		return view("dashboard_monitoring")->with('data', $data);
	}

	public function addStockSTBTregCountTmp($data, $merk)
	{
		$treg_array = array_values(array_filter($data["witel"], function ($obj) {
			return str_contains($obj->lokasi_wh, "WH TR TREG");
		}));

		for ($i = 0; $i < count($treg_array); $i++) {
			$regional = $treg_array[$i]->regional;
			$wh_array = array_values(array_filter($data["witel"], function ($obj) use ($regional) {
				return str_contains($obj->regional, $regional) && $obj->lokasi_wh != $regional;
			}));

			$idx = 0;
			foreach ($data["witel"] as $key => $value) {
				if (str_contains($value->lokasi_wh, $regional)) {
					$result = $value;
					$idx = $key;
					break;
				}
			}

			$data["witel"][$idx]->stb_stock_zte = array_sum(array_column($wh_array, 'stb_stock_zte'));
			$data["witel"][$idx]->stb_zte = array_sum(array_column($wh_array, 'stb_zte'));
			$data["witel"][$i]->{"total_stb"} = $data["witel"][$i]->{"stb_stock_zte"};
			$data["witel"][$i]->{"total_on_delivery_stb"} = $data["witel"][$i]->{"on_delivery_stb_zte"};
		}

		return $data;
	}

	public function countDataSTBPerWitelTmp()
	{
		$data["witel"] = array_merge(Gudang::getTregSTBQtyMinimum(), Gudang::getSTBQtyMinimum());

		$merk = "zte";
		$data[$merk] = DataTmp::countSTBPerWitel($merk);
		$data["penerima"][$merk] = Penerima::countStbPerWitel($merk);
		$data = $this::addStockCountSTBTmp($data, $merk);

		$data = $this::addStockSTBTregCountTmp($data, $merk);

		return $data;
	}

	public function addStockCountSTBTmp($data, $merk)
	{
		$array_stock = $data[$merk];
		$array_penerima = $data["penerima"][$merk];

		for ($i = 0; $i < count($data["witel"]); $i++) {
			$lokasi_wh = $data["witel"][$i]->lokasi_wh;

			$filtered_array = array_filter($array_stock, function ($obj) use ($lokasi_wh) {
				return str_contains(strtolower($obj->lokasi_wh), strtolower($lokasi_wh));
			});

			$filtered_array_penerima = array_filter($array_penerima, function ($obj) use ($lokasi_wh) {
				return str_contains(strtolower($obj->warehouse_penerima), strtolower($lokasi_wh));
			});

			if (str_contains($lokasi_wh, "TA SO CCAN")) {
				$lokasi_wh = substr($lokasi_wh, strpos($lokasi_wh, "CCAN") + 5, strlen($lokasi_wh));

				$filtered_array = array_filter($array_stock, function ($obj) use ($lokasi_wh) {
					return str_contains(strtolower($obj->lokasi_wh), strtolower($lokasi_wh));
				});

				$filtered_array_penerima = array_filter($array_penerima, function ($obj) use ($lokasi_wh) {
					return str_contains(strtolower($obj->warehouse_penerima), strtolower($lokasi_wh));
				});
			} else if (str_contains($lokasi_wh, "SO")) {
				$lokasi_wh = substr($lokasi_wh, strpos($lokasi_wh, "SO") + 3, strlen($lokasi_wh));
				$filtered_array = array_filter($array_stock, function ($obj) use ($lokasi_wh) {
					return str_contains(strtolower($obj->lokasi_wh), strtolower($lokasi_wh));
				});

				$filtered_array_penerima = array_filter($array_penerima, function ($obj) use ($lokasi_wh) {
					return str_contains(strtolower($obj->warehouse_penerima), strtolower($lokasi_wh));
				});
			} else if (str_contains($lokasi_wh, "WITEL CCAN")) {
				$lokasi_wh = substr($lokasi_wh, strpos($lokasi_wh, "WITEL CCAN") + 11, strlen($lokasi_wh));

				if (str_contains($lokasi_wh, "(")) {
					$open = strpos($lokasi_wh, "(");
					$close = strpos($lokasi_wh, ")");
					$lokasi_wh = substr($lokasi_wh, $open + 1, $close - $open - 1);
				}

				$filtered_array = array_filter($array_stock, function ($obj) use ($lokasi_wh) {
					return str_contains(strtolower($obj->lokasi_wh), strtolower($lokasi_wh)) && str_contains($obj->lokasi_wh, "WITEL");
				});

				$filtered_array_penerima = array_filter($array_penerima, function ($obj) use ($lokasi_wh) {
					return str_contains(strtolower($obj->warehouse_penerima), strtolower($lokasi_wh)) && str_contains($obj->warehouse_penerima, "WITEL");
				});
			} else if (str_contains($lokasi_wh, "WITEL")) {
				$lokasi_wh = substr($lokasi_wh, strpos($lokasi_wh, "WITEL") + 6, strlen($lokasi_wh));

				if (str_contains($lokasi_wh, "(")) {
					$open = strpos($lokasi_wh, "(");
					$close = strpos($lokasi_wh, ")");
					$lokasi_wh = substr($lokasi_wh, $open + 1, $close - $open - 1);
				}

				$filtered_array = array_filter($array_stock, function ($obj) use ($lokasi_wh) {
					return str_contains(strtolower($obj->lokasi_wh), strtolower($lokasi_wh)) && str_contains($obj->lokasi_wh, "WITEL");
				});

				$filtered_array_penerima = array_filter($array_penerima, function ($obj) use ($lokasi_wh) {
					return str_contains(strtolower($obj->warehouse_penerima), strtolower($lokasi_wh)) && str_contains($obj->warehouse_penerima, "WITEL");
				});
				// echo $lokasi_wh." ";
			}
			// echo "<br>";


			// $idx = 0;
			// foreach ($data["witel"] as $key => $value) {
			//     if (str_contains($value->wilayah, $nama_witel)) {
			//         $result = $value;
			//         $idx = $key;
			//         break;
			//     }
			// }

			if (count($filtered_array) == 0) {
				$data["witel"][$i]->{"stb_stock_" . $merk} = 0;
			} else {
				$tmp_stock = current($filtered_array)->stock;

				$data["witel"][$i]->{"stb_stock_" . $merk} = $tmp_stock;
			}

			if (count($filtered_array_penerima) == 0) {
				$data["witel"][$i]->{"on_delivery_stb_" . $merk} = 0;
			} else {
				$tmp_stock = current($filtered_array_penerima)->stock;

				$data["witel"][$i]->{"on_delivery_stb_" . $merk} = $tmp_stock;
			}

			$data["witel"][$i]->stb_zte = 10;
		}

		return $data;
	}

	public function countDataAPPerWitelTmp()
	{
		$data["witel"] = array_merge(Gudang::getTregSTBQtyMinimum(), Gudang::getSTBQtyMinimum());

		$merk = "zte";
		$data[$merk] = DataTmp::countAPPerWitel($merk);
		$data["penerima"][$merk] = Penerima::countStbPerWitel($merk);
		$data = $this::addStockCountAPTmp($data, $merk);

		$data = $this::addStockAPTregCountTmp($data, $merk);

		return $data;
	}

	public function addStockAPTregCountTmp($data, $merk)
	{
		$treg_array = array_values(array_filter($data["witel"], function ($obj) {
			return str_contains($obj->lokasi_wh, "WH TR TREG");
		}));

		for ($i = 0; $i < count($treg_array); $i++) {
			$regional = $treg_array[$i]->regional;
			$wh_array = array_values(array_filter($data["witel"], function ($obj) use ($regional) {
				return str_contains($obj->regional, $regional) && $obj->lokasi_wh != $regional;
			}));

			$idx = 0;
			foreach ($data["witel"] as $key => $value) {
				if (str_contains($value->lokasi_wh, $regional)) {
					$result = $value;
					$idx = $key;
					break;
				}
			}

			$data["witel"][$idx]->ap_stock_zte = array_sum(array_column($wh_array, 'ap_stock_zte'));
			$data["witel"][$idx]->ap_zte = array_sum(array_column($wh_array, 'ap_zte'));
			$data["witel"][$i]->{"total_ap"} = $data["witel"][$i]->{"ap_stock_zte"};
			$data["witel"][$i]->{"total_on_delivery_ap"} = $data["witel"][$i]->{"on_delivery_ap_zte"};
		}

		return $data;
	}

	public function addStockCountAPTmp($data, $merk)
	{
		$array_stock = $data[$merk];
		$array_penerima = $data["penerima"][$merk];

		for ($i = 0; $i < count($data["witel"]); $i++) {
			$lokasi_wh = $data["witel"][$i]->lokasi_wh;

			$filtered_array = array_filter($array_stock, function ($obj) use ($lokasi_wh) {
				return str_contains(strtolower($obj->lokasi_wh), strtolower($lokasi_wh));
			});

			$filtered_array_penerima = array_filter($array_penerima, function ($obj) use ($lokasi_wh) {
				return str_contains(strtolower($obj->warehouse_penerima), strtolower($lokasi_wh));
			});

			if (str_contains($lokasi_wh, "TA SO CCAN")) {
				$lokasi_wh = substr($lokasi_wh, strpos($lokasi_wh, "CCAN") + 5, strlen($lokasi_wh));

				$filtered_array = array_filter($array_stock, function ($obj) use ($lokasi_wh) {
					return str_contains(strtolower($obj->lokasi_wh), strtolower($lokasi_wh));
				});

				$filtered_array_penerima = array_filter($array_penerima, function ($obj) use ($lokasi_wh) {
					return str_contains(strtolower($obj->warehouse_penerima), strtolower($lokasi_wh));
				});
			} else if (str_contains($lokasi_wh, "SO")) {
				$lokasi_wh = substr($lokasi_wh, strpos($lokasi_wh, "SO") + 3, strlen($lokasi_wh));
				$filtered_array = array_filter($array_stock, function ($obj) use ($lokasi_wh) {
					return str_contains(strtolower($obj->lokasi_wh), strtolower($lokasi_wh));
				});

				$filtered_array_penerima = array_filter($array_penerima, function ($obj) use ($lokasi_wh) {
					return str_contains(strtolower($obj->warehouse_penerima), strtolower($lokasi_wh));
				});
			} else if (str_contains($lokasi_wh, "WITEL CCAN")) {
				$lokasi_wh = substr($lokasi_wh, strpos($lokasi_wh, "WITEL CCAN") + 11, strlen($lokasi_wh));

				if (str_contains($lokasi_wh, "(")) {
					$open = strpos($lokasi_wh, "(");
					$close = strpos($lokasi_wh, ")");
					$lokasi_wh = substr($lokasi_wh, $open + 1, $close - $open - 1);
				}

				$filtered_array = array_filter($array_stock, function ($obj) use ($lokasi_wh) {
					return str_contains(strtolower($obj->lokasi_wh), strtolower($lokasi_wh)) && str_contains($obj->lokasi_wh, "WITEL");
				});

				$filtered_array_penerima = array_filter($array_penerima, function ($obj) use ($lokasi_wh) {
					return str_contains(strtolower($obj->warehouse_penerima), strtolower($lokasi_wh)) && str_contains($obj->warehouse_penerima, "WITEL");
				});
			} else if (str_contains($lokasi_wh, "WITEL")) {
				$lokasi_wh = substr($lokasi_wh, strpos($lokasi_wh, "WITEL") + 6, strlen($lokasi_wh));

				if (str_contains($lokasi_wh, "(")) {
					$open = strpos($lokasi_wh, "(");
					$close = strpos($lokasi_wh, ")");
					$lokasi_wh = substr($lokasi_wh, $open + 1, $close - $open - 1);
				}

				$filtered_array = array_filter($array_stock, function ($obj) use ($lokasi_wh) {
					return str_contains(strtolower($obj->lokasi_wh), strtolower($lokasi_wh)) && str_contains($obj->lokasi_wh, "WITEL");
				});

				$filtered_array_penerima = array_filter($array_penerima, function ($obj) use ($lokasi_wh) {
					return str_contains(strtolower($obj->warehouse_penerima), strtolower($lokasi_wh)) && str_contains($obj->warehouse_penerima, "WITEL");
				});
				// echo $lokasi_wh." ";
			}
			// echo "<br>";


			// $idx = 0;
			// foreach ($data["witel"] as $key => $value) {
			//     if (str_contains($value->wilayah, $nama_witel)) {
			//         $result = $value;
			//         $idx = $key;
			//         break;
			//     }
			// }

			if (count($filtered_array) == 0) {
				$data["witel"][$i]->{"ap_stock_" . $merk} = 0;
			} else {
				$tmp_stock = current($filtered_array)->stock;

				$data["witel"][$i]->{"ap_stock_" . $merk} = $tmp_stock;
			}

			if (count($filtered_array_penerima) == 0) {
				$data["witel"][$i]->{"on_delivery_ap_" . $merk} = 0;
			} else {
				$tmp_stock = current($filtered_array_penerima)->stock;

				$data["witel"][$i]->{"on_delivery_ap_" . $merk} = $tmp_stock;
			}

			$data["witel"][$i]->ap_zte = 10;
		}

		return $data;
	}

	public function rekapDeliverySTBPage(Request $request, $jenis_warehouse, $value_warehouse)
	{
		$value_warehouse = str_replace("%20", " ", $value_warehouse);

		$data = $this::countDataSTBPerWitelTmp();

		$data["treg_with_so"] = $data["witel"];

		if ($jenis_warehouse == "Witel") {
			$data["jenis_warehouse"] = "TA SO";
			$data["witel_with_so"] = $data["witel"];
			$data["witel"] = array_values(array_filter($data["witel"], function ($obj) use ($value_warehouse) {
				return str_contains(strtolower($obj->regional), strtolower($value_warehouse)) && (str_contains(strtolower($obj->lokasi_wh), "witel") || str_contains(strtolower($obj->witel), "regional"));
			}));

			for ($i = 0; $i < count($data["witel"]); $i++) {
				$value_witel = $data["witel"][$i]->witel;
				$data["so"] = array_values(array_filter($data["witel_with_so"], function ($obj) use ($value_witel) {
					return str_contains(strtolower($obj->witel), strtolower($value_witel));
				}));

				$sumStockZTE = 0;
				$sumMinZTE = 0;
				$sumZTE = 0;
				$total_stb = 0;
				$sumOnDeliveryZTE = 0;

				for ($j = 0; $j < count($data["so"]); $j++) {
					$sumStockZTE += $data["so"][$j]->stb_stock_zte;
					$sumMinZTE += $data["so"][$j]->stb_zte;
					;
					$sumOnDeliveryZTE += $data["so"][$j]->on_delivery_stb_zte;

					if ($data["so"][$j]->stb_stock_zte < $data["so"][$j]->batas_bawah_stb_zte) {
						$sumZTE += $data["so"][$j]->batas_atas_stb_zte - $data["so"][$j]->stb_stock_zte;
					}
					$total_stb += $data["so"][$j]->stb_stock_zte;
				}

				$data["witel"][$i]->stb_stock_zte = $sumStockZTE;
				$data["witel"][$i]->stb_zte = $sumMinZTE;

				$data["witel"][$i]->qty_kirim_stb_zte = $sumZTE;
				$data["witel"][$i]->total_stb = $total_stb;

				$data["witel"][$i]->on_delivery_stb_zte = $sumOnDeliveryZTE;
				$data["witel"][$i]->on_delivery_total_stb = $sumOnDeliveryZTE;
			}

			$data["total_stb"] = array_sum(array_column($data["witel"], 'total_stb'));

			$data["total_stb_zte_minimum"] = array_sum(array_column($data["witel"], 'stb_zte'));

			$data["total_stb_stock_zte"] = array_sum(array_column($data["witel"], 'stb_stock_zte'));

			$data["total_on_delivery_stb_zte"] = array_sum(array_column($data["witel"], 'on_delivery_stb_zte'));
			$data["on_delivery_total_stb"] = array_sum(array_column($data["witel"], 'on_delivery_total_stb'));

			$data["total_gap_stb_stock_zte"] = $data["total_stb_stock_zte"] - $data["total_stb_zte_minimum"];
		} else if ($jenis_warehouse == "TA SO") {
			$data["jenis_warehouse"] = "";

			if (str_contains($value_warehouse, "(")) {
				$open = strpos($value_warehouse, "(");
				$close = strpos($value_warehouse, ")");
				$value_warehouse = substr($value_warehouse, $open + 1, $close - $open - 1);
			}

			if (str_contains($value_warehouse, "WH")) {
				$value_warehouse = substr($value_warehouse, 0, strlen($value_warehouse) - 3);
			}

			$tesData = strtolower($data["witel"][92]->witel);

			$data["witel_with_so"] = $data["witel"];

			$data["witel"] = array_values(array_filter($data["witel"], function ($obj) use ($value_warehouse) {
				return str_contains(strtolower($obj->witel), strtolower($value_warehouse));
			}));

			$sumStockZTE = 0;
			$sumMinZTE = 0;
			$sumZTE = 0;
			$total_stb = 0;

			for ($i = 0; $i < count($data["witel"]); $i++) {
				$sumStockZTE += $data["witel"][$i]->stb_stock_zte;
				$sumMinZTE += $data["witel"][$i]->stb_zte;
				;
				$sumOnDeliveryZTE = $data["witel"][$i]->on_delivery_stb_zte;

				if ($data["witel"][$i]->stb_stock_zte < $data["witel"][$i]->batas_bawah_stb_zte) {
					$sumZTE += $data["witel"][$i]->batas_atas_stb_zte - $data["witel"][$i]->stb_stock_zte;
				}

				$data["witel"][$i]->stb_stock_zte = $sumStockZTE;
				$data["witel"][$i]->stb_zte = $sumMinZTE;

				$data["witel"][$i]->qty_kirim_stb_zte = $sumZTE;
				$data["witel"][$i]->total_stb = $data["witel"][$i]->stb_stock_zte;
				$data["witel"][$i]->on_delivery_stb_zte = $sumOnDeliveryZTE;
				$data["witel"][$i]->on_delivery_total_stb = $sumOnDeliveryZTE;

				$sumStockZTE = 0;
				$sumMinZTE = 0;
				$sumZTE = 0;
				$total_stb = 0;
			}

			$data["total_stb"] = array_sum(array_column($data["witel"], 'total_stb'));

			$data["total_stb_zte_minimum"] = array_sum(array_column($data["witel"], 'stb_zte'));

			$data["total_stb_stock_zte"] = array_sum(array_column($data["witel"], 'stb_stock_zte'));

			$data["total_on_delivery_stb_zte"] = array_sum(array_column($data["witel"], 'on_delivery_stb_zte'));

			$data["on_delivery_total_stb"] = array_sum(array_column($data["witel"], 'on_delivery_total_stb'));

			$data["total_gap_stb_stock_zte"] = $data["total_stb_stock_zte"] - $data["total_stb_zte_minimum"];
		} else {
		}


		session(['jenis_halaman' => "rekap_delivery"]);
		session(['data' => $data]);

		if (session("role") != "Administrator") {
			return view("rekap_delivery_stb")->with("data", $data);
		}
		return view("rekap_delivery_stb_admin")->with("data", $data);
	}

	public function rekapDeliverySTB(Request $request)
	{
		$data = $this::countDataSTBPerWitelTmp();

		$data["treg_with_so"] = $data["witel"];

		$data["jenis_warehouse"] = "Witel";
		$data["witel"] = array_filter($data["witel"], function ($obj) {
			return str_contains(strtolower($obj->witel), "treg");
		});

		for ($i = 0; $i < count($data["witel"]); $i++) {
			$value_regional = $data["witel"][$i]->regional;
			$witel = Gudang::getWitelFromTreg($value_regional);

			$sumAllZTE = 0;
			$sumOnDeliveryZTE = 0;

			$total_stb = 0;

			for ($k = 0; $k < count($witel); $k++) {
				$value_witel = $witel[$k]->witel;

				$data["so"] = array_values(array_filter($data["treg_with_so"], function ($obj) use ($value_witel) {
					return str_contains(strtolower($obj->witel), strtolower($value_witel));
				}));

				// echo $data["witel"][$i]->regional;
				// echo "<br>";
				$sumZTE = 0;

				for ($j = 0; $j < count($data["so"]); $j++) {
					if ($data["so"][$j]->stb_stock_zte < $data["so"][$j]->batas_bawah_stb_zte) {
						$sumZTE += $data["so"][$j]->batas_atas_stb_zte - $data["so"][$j]->stb_stock_zte;
					}

					$total_stb += $data["so"][$j]->stb_stock_zte;
					$sumOnDeliveryZTE += $data["so"][$j]->on_delivery_stb_zte;
				}

				$sumAllZTE += $sumZTE;

			}

			$data["witel"][$i]->qty_kirim_stb_zte = $sumAllZTE;
			$data["witel"][$i]->total_stb = $total_stb;

			$data["witel"][$i]->on_delivery_stb_zte = $sumOnDeliveryZTE;
			$data["witel"][$i]->on_delivery_total_stb = $sumOnDeliveryZTE;
		}

		$data["total_stb"] = array_sum(array_column($data["witel"], 'total_stb'));
		$data["on_delivery_total_stb"] = array_sum(array_column($data["witel"], 'on_delivery_total_stb'));

		$data["total_stb_zte_minimum"] = array_sum(array_column($data["witel"], 'stb_zte'));
		$data["total_stb_stock_zte"] = array_sum(array_column($data["witel"], 'stb_stock_zte'));
		$data["total_on_delivery_stb_zte"] = array_sum(array_column($data["witel"], 'on_delivery_stb_zte'));
		$data["total_gap_stb_stock_zte"] = $data["total_stb_stock_zte"] - $data["total_stb_zte_minimum"];

		if (session("role") != "Administrator") {
			return view("rekap_delivery_stb")->with("data", $data);
		}
		return view("rekap_delivery_stb_admin")->with("data", $data);
	}

	public function rekapDeliveryAP(Request $request)
	{
		$data = $this::countDataSTBPerWitelTmp();

		$data["treg_with_so"] = $data["witel"];

		$data["jenis_warehouse"] = "Witel";
		$data["witel"] = array_filter($data["witel"], function ($obj) {
			return str_contains(strtolower($obj->witel), "treg");
		});

		for ($i = 0; $i < count($data["witel"]); $i++) {
			$value_regional = $data["witel"][$i]->regional;
			$witel = Gudang::getWitelFromTreg($value_regional);

			$sumAllZTE = 0;
			$sumOnDeliveryZTE = 0;

			$total_stb = 0;

			for ($k = 0; $k < count($witel); $k++) {
				$value_witel = $witel[$k]->witel;

				$data["so"] = array_values(array_filter($data["treg_with_so"], function ($obj) use ($value_witel) {
					return str_contains(strtolower($obj->witel), strtolower($value_witel));
				}));

				// echo $data["witel"][$i]->regional;
				// echo "<br>";
				$sumZTE = 0;

				for ($j = 0; $j < count($data["so"]); $j++) {
					if ($data["so"][$j]->stb_stock_zte < $data["so"][$j]->batas_bawah_stb_zte) {
						$sumZTE += $data["so"][$j]->batas_atas_stb_zte - $data["so"][$j]->stb_stock_zte;
					}

					$total_stb += $data["so"][$j]->stb_stock_zte;
					$sumOnDeliveryZTE += $data["so"][$j]->on_delivery_stb_zte;
				}

				$sumAllZTE += $sumZTE;

			}

			$data["witel"][$i]->qty_kirim_stb_zte = $sumAllZTE;
			$data["witel"][$i]->total_stb = $total_stb;

			$data["witel"][$i]->on_delivery_stb_zte = $sumOnDeliveryZTE;
			$data["witel"][$i]->on_delivery_total_stb = $sumOnDeliveryZTE;
		}

		$data["total_stb"] = array_sum(array_column($data["witel"], 'total_stb'));
		$data["on_delivery_total_stb"] = array_sum(array_column($data["witel"], 'on_delivery_total_stb'));

		$data["total_stb_zte_minimum"] = array_sum(array_column($data["witel"], 'stb_zte'));
		$data["total_stb_stock_zte"] = array_sum(array_column($data["witel"], 'stb_stock_zte'));
		$data["total_on_delivery_stb_zte"] = array_sum(array_column($data["witel"], 'on_delivery_stb_zte'));
		$data["total_gap_stb_stock_zte"] = $data["total_stb_stock_zte"] - $data["total_stb_zte_minimum"];

		if (session("role") != "Administrator") {
			return view("rekap_delivery_stb")->with("data", $data);
		}
		return view("rekap_delivery_ap")->with("data", $data);
	}

	public function rekapDelivery(Request $request)
	{
		if (session("asal") != "") {
			$data = $this::countDataPerWitelTmp();
			$data = $this::hitungQtyKirim($data);

			$data["treg_with_so"] = $data["witel"];
			$data["all_witel"] = json_decode(json_encode($data["witel"]), true);

			for ($i = 0; $i < count($data["witel"]); $i++) {
				$value_regional = $data["witel"][$i]->regional;
				$witel = Gudang::getWitelFromTreg($value_regional);

				$sumAllZTE = 0;
				$sumAllFH = 0;
				$sumAllHW = 0;
				$sumAllALU = 0;

				$sumAllPZTE = 0;
				$sumAllPFH = 0;
				$sumAllPHW = 0;

				for ($k = 0; $k < count($witel); $k++) {
					$value_witel = $witel[$k]->witel;

					$data["so"] = array_values(array_filter($data["treg_with_so"], function ($obj) use ($value_witel) {
						return str_contains(strtolower($obj->witel), strtolower($value_witel));
					}));

					$sumZTE = 0;
					$sumFH = 0;
					$sumHW = 0;
					$sumALU = 0;

					$sumPZTE = 0;
					$sumPFH = 0;
					$sumPHW = 0;

					for ($j = 0; $j < count($data["so"]); $j++) {
						if ($data["so"][$j]->retail_stock_zte < $data["so"][$j]->batas_bawah_retail_zte) {
							$sumZTE += round(($data["so"][$j]->batas_atas_retail_zte - $data["so"][$j]->retail_stock_zte) / 20, 0) * 20;

						}

						if ($data["so"][$j]->retail_stock_huawei < $data["so"][$j]->batas_bawah_retail_hw) {
							$sumHW += round(($data["so"][$j]->batas_atas_retail_hw - $data["so"][$j]->retail_stock_huawei) / 20, 0) * 20;

						}

						if ($data["so"][$j]->retail_stock_fiberhome < $data["so"][$j]->batas_bawah_retail_fh) {
							$sumFH += round(($data["so"][$j]->batas_atas_retail_fh - $data["so"][$j]->retail_stock_fiberhome) / 20, 0) * 20;

						}

						if ($data["so"][$j]->retail_stock_nokia < $data["so"][$j]->batas_bawah_retail_alu) {
							$sumALU += round(($data["so"][$j]->batas_atas_retail_alu - $data["so"][$j]->retail_stock_nokia) / 20, 0) * 20;

						}

						if ($data["so"][$j]->premium_stock_zte < $data["so"][$j]->batas_bawah_premium_zte) {
							$sumPZTE += round(($data["so"][$j]->batas_atas_premium_zte - $data["so"][$j]->premium_stock_zte) / 20, 0) * 20;

						}

						if ($data["so"][$j]->premium_stock_huawei < $data["so"][$j]->batas_bawah_premium_hw) {
							$sumPHW += round(($data["so"][$j]->batas_atas_premium_hw - $data["so"][$j]->premium_stock_huawei) / 20, 0) * 20;

						}

						if ($data["so"][$j]->premium_stock_fiberhome < $data["so"][$j]->batas_bawah_premium_fh) {
							$sumPFH += round(($data["so"][$j]->batas_atas_premium_fh - $data["so"][$j]->premium_stock_fiberhome) / 20, 0) * 20;

						}
					}

					$sumAllZTE += $sumZTE;
					$sumAllFH += $sumFH;
					$sumAllHW += $sumHW;
					$sumAllALU += $sumALU;

					$sumAllPZTE += $sumPZTE;
					$sumAllPFH += $sumPFH;
					$sumAllPHW += $sumPHW;
				}
				$data["witel"][$i]->qty_kirim_retail_zte = $sumAllZTE;
				$data["witel"][$i]->qty_kirim_retail_fh = $sumAllFH;
				$data["witel"][$i]->qty_kirim_retail_hw = $sumAllHW;
				$data["witel"][$i]->qty_kirim_retail_alu = $sumAllALU;


				$data["witel"][$i]->qty_kirim_premium_zte = $sumAllPZTE;
				$data["witel"][$i]->qty_kirim_premium_fh = $sumAllPFH;
				$data["witel"][$i]->qty_kirim_premium_hw = $sumAllPHW;
			}

			$data["jenis_warehouse"] = "Witel";

			if (session("jenis_akun") == "treg") {
				$data["witel"] = array_values(array_filter($data["witel"], function ($obj) {
					return str_contains(strtolower($obj->regional), session("asal"));
				}));
			}

			$data["witel"] = array_filter($data["witel"], function ($obj) {
				return str_contains(strtolower($obj->witel), "treg");
			});

			$data["total_qty_minimum"] = array_sum(array_column($data["witel"], 'minimum_qty'));
			$data["total_retail_fh_minimum"] = array_sum(array_column($data["witel"], 'retail_fh'));
			$data["total_retail_hw_minimum"] = array_sum(array_column($data["witel"], 'retail_hw'));
			$data["total_retail_zte_minimum"] = array_sum(array_column($data["witel"], 'retail_zte'));
			$data["total_retail_alu_minimum"] = array_sum(array_column($data["witel"], 'retail_alu'));
			$data["total_retail_minimum"] = array_sum(array_column($data["witel"], 'total_retail'));

			$data["total_premium_fh_minimum"] = array_sum(array_column($data["witel"], 'premium_fh'));
			$data["total_premium_hw_minimum"] = array_sum(array_column($data["witel"], 'premium_hw'));
			$data["total_premium_zte_minimum"] = array_sum(array_column($data["witel"], 'premium_zte'));
			$data["total_premium_minimum"] = array_sum(array_column($data["witel"], 'total_premium'));

			$data["total_retail_stock_fh"] = array_sum(array_column($data["witel"], 'retail_stock_fiberhome'));
			$data["total_retail_stock_hw"] = array_sum(array_column($data["witel"], 'retail_stock_huawei'));
			$data["total_retail_stock_zte"] = array_sum(array_column($data["witel"], 'retail_stock_zte'));
			$data["total_retail_stock_alu"] = array_sum(array_column($data["witel"], 'retail_stock_nokia'));
			$data["total_retail_stock_all"] = array_sum(array_column($data["witel"], 'total_retail_stock'));

			$data["total_premium_stock_fh"] = array_sum(array_column($data["witel"], 'premium_stock_fiberhome'));
			$data["total_premium_stock_hw"] = array_sum(array_column($data["witel"], 'premium_stock_huawei'));
			$data["total_premium_stock_zte"] = array_sum(array_column($data["witel"], 'premium_stock_zte'));
			$data["total_premium_stock_all"] = array_sum(array_column($data["witel"], 'total_premium_stock'));

			$data["total_gap_retail_stock_fh"] = $data["total_retail_stock_fh"] - $data["total_retail_fh_minimum"];
			$data["total_gap_retail_stock_hw"] = $data["total_retail_stock_hw"] - $data["total_retail_hw_minimum"];
			$data["total_gap_retail_stock_zte"] = $data["total_retail_stock_zte"] - $data["total_retail_zte_minimum"];
			$data["total_gap_retail_stock_alu"] = $data["total_retail_stock_alu"] - $data["total_retail_alu_minimum"];
			$data["total_gap_stock_retail"] = $data["total_retail_stock_all"] - $data["total_retail_minimum"];

			$data["total_gap_premium_stock_fh"] = $data["total_premium_stock_fh"] - $data["total_premium_fh_minimum"];
			$data["total_gap_premium_stock_hw"] = $data["total_premium_stock_hw"] - $data["total_premium_hw_minimum"];
			$data["total_gap_premium_stock_zte"] = $data["total_premium_stock_zte"] - $data["total_premium_zte_minimum"];
			$data["total_gap_premium_stock"] = $data["total_premium_stock_all"] - $data["total_premium_minimum"];

			$data["total_on_delivery_retail_fiberhome"] = array_sum(array_column($data["witel"], 'on_delivery_retail_fiberhome'));
			$data["total_on_delivery_retail_huawei"] = array_sum(array_column($data["witel"], 'on_delivery_retail_huawei'));
			$data["total_on_delivery_retail_zte"] = array_sum(array_column($data["witel"], 'on_delivery_retail_zte'));
			$data["total_on_delivery_retail_nokia"] = array_sum(array_column($data["witel"], 'on_delivery_retail_nokia'));
			$data["total_on_delivery_retail_all"] = array_sum(array_column($data["witel"], 'on_delivery_total_retail'));

			$data["total_on_delivery_premium_fiberhome"] = array_sum(array_column($data["witel"], 'on_delivery_premium_fiberhome'));
			$data["total_on_delivery_premium_huawei"] = array_sum(array_column($data["witel"], 'on_delivery_premium_huawei'));
			$data["total_on_delivery_premium_zte"] = array_sum(array_column($data["witel"], 'on_delivery_premium_zte'));
			$data["total_on_delivery_premium_all"] = array_sum(array_column($data["witel"], 'on_delivery_total_premium'));

			$tableDataTmp = DataTmp::getTableLastUpdate();

			$data["last_update"] = $tableDataTmp->waktu_update;
			if (strtotime($tableDataTmp->waktu_dibuat) > strtotime($tableDataTmp->waktu_update)) {
				$data["last_update"] = $tableDataTmp->waktu_dibuat;
			}

			session(['jenis_halaman' => "rekap_delivery"]);
			session(['data' => $data]);
			return view("rekap_delivery")->with('data', $data);
		} else {
			return redirect("login");
		}
	}

	public function rekapDeliveryBiasaPage(Request $request, $jenis_warehouse, $value_warehouse)
	{
		$value_warehouse = str_replace("%20", " ", $value_warehouse);

		$data = $this::countDataPerWitelTmp();
		$data = $this::hitungQtyKirim($data);

		if ($jenis_warehouse == "Witel") {
			$data["jenis_warehouse"] = "TA SO";
			$data["witel_with_so"] = $data["witel"];
			$data["witel"] = array_values(array_filter($data["witel"], function ($obj) use ($value_warehouse) {
				return str_contains(strtolower($obj->regional), strtolower($value_warehouse)) && (str_contains(strtolower($obj->lokasi_wh), "witel") || str_contains(strtolower($obj->witel), "regional"));
			}));
			for ($i = 0; $i < count($data["witel"]); $i++) {
				$value_witel = $data["witel"][$i]->witel;
				$data["so"] = array_values(array_filter($data["witel_with_so"], function ($obj) use ($value_witel) {
					return str_contains(strtolower($obj->witel), strtolower($value_witel));
				}));
				$minimum_qty = 0;
				$retail_zte = 0;
				$retail_fh = 0;
				$retail_hw = 0;
				$retail_alu = 0;

				$total_retail = 0;

				$premium_zte = 0;
				$premium_fh = 0;
				$premium_hw = 0;

				$total_premium = 0;

				$batas_atas_retail_zte = 0;
				$batas_atas_retail_fh = 0;
				$batas_atas_retail_hw = 0;
				$batas_atas_retail_alu = 0;

				$batas_atas_premium_fh = 0;
				$batas_atas_premium_hw = 0;
				$batas_atas_premium_zte = 0;

				$batas_bawah_retail_zte = 0;
				$batas_bawah_retail_fh = 0;
				$batas_bawah_retail_hw = 0;
				$batas_bawah_retail_alu = 0;

				$batas_bawah_premium_fh = 0;
				$batas_bawah_premium_hw = 0;
				$batas_bawah_premium_zte = 0;

				$retail_stock_zte = 0;
				$retail_stock_fh = 0;
				$retail_stock_hw = 0;
				$retail_stock_nokia = 0;

				$total_retail_stock = 0;

				$premium_stock_zte = 0;
				$premium_stock_fh = 0;
				$premium_stock_hw = 0;

				$total_premium_stock = 0;

				$on_delivery_retail_zte = 0;
				$on_delivery_retail_fiberhome = 0;
				$on_delivery_retail_huawei = 0;
				$on_delivery_retail_nokia = 0;

				$on_delivery_total_retail = 0;

				$on_delivery_premium_fiberhome = 0;
				$on_delivery_premium_huawei = 0;
				$on_delivery_premium_zte = 0;

				$on_delivery_total_premium = 0;

				// $qty_kirim_retail_zte = 0;
				// $qty_kirim_retail_fh = 0;
				// $qty_kirim_retail_hw = 0;
				// $qty_kirim_retail_alu = 0;

				// $qty_kirim_premium_zte = 0;
				// $qty_kirim_premium_fh = 0;
				// $qty_kirim_premium_hw = 0;

				$sumZTE = 0;
				$sumFH = 0;
				$sumHW = 0;
				$sumALU = 0;

				$sumPZTE = 0;
				$sumPFH = 0;
				$sumPHW = 0;

				for ($j = 0; $j < count($data["so"]); $j++) {
					$minimum_qty += $data["so"][$j]->minimum_qty;
					$retail_zte += $data["so"][$j]->retail_zte;
					;
					$retail_fh += $data["so"][$j]->retail_fh;
					$retail_hw += $data["so"][$j]->retail_hw;
					$retail_alu += $data["so"][$j]->retail_alu;

					$total_retail += $data["so"][$j]->total_retail;

					$premium_zte += $data["so"][$j]->premium_zte;
					$premium_fh += $data["so"][$j]->premium_fh;
					$premium_hw += $data["so"][$j]->premium_hw;

					$total_premium += $data["so"][$j]->total_premium;

					$batas_atas_retail_zte += $data["so"][$j]->batas_atas_retail_zte;
					$batas_atas_retail_fh += $data["so"][$j]->batas_atas_retail_fh;
					$batas_atas_retail_hw += $data["so"][$j]->batas_atas_retail_hw;
					$batas_atas_retail_alu += $data["so"][$j]->batas_atas_retail_alu;

					$batas_atas_premium_fh += $data["so"][$j]->batas_atas_premium_fh;
					$batas_atas_premium_hw += $data["so"][$j]->batas_atas_premium_hw;
					$batas_atas_premium_zte += $data["so"][$j]->batas_atas_premium_zte;

					$batas_bawah_retail_zte += $data["so"][$j]->batas_bawah_retail_zte;
					$batas_bawah_retail_fh += $data["so"][$j]->batas_bawah_retail_fh;
					$batas_bawah_retail_hw += $data["so"][$j]->batas_bawah_retail_hw;
					$batas_bawah_retail_alu += $data["so"][$j]->batas_bawah_retail_alu;

					$batas_bawah_premium_fh += $data["so"][$j]->batas_bawah_premium_fh;
					$batas_bawah_premium_hw += $data["so"][$j]->batas_bawah_premium_hw;
					$batas_bawah_premium_zte += $data["so"][$j]->batas_bawah_premium_zte;

					$retail_stock_zte += $data["so"][$j]->retail_stock_zte;
					$retail_stock_fh += $data["so"][$j]->retail_stock_fiberhome;
					$retail_stock_hw += $data["so"][$j]->retail_stock_huawei;
					$retail_stock_nokia += $data["so"][$j]->retail_stock_nokia;

					$total_retail_stock += $data["so"][$j]->total_retail_stock;

					$premium_stock_zte += $data["so"][$j]->premium_stock_zte;
					$premium_stock_fh += $data["so"][$j]->premium_stock_fiberhome;
					$premium_stock_hw += $data["so"][$j]->premium_stock_huawei;

					$total_premium_stock += $data["so"][$j]->total_premium_stock;

					$on_delivery_retail_zte += $data["so"][$j]->on_delivery_retail_zte;
					$on_delivery_retail_fiberhome += $data["so"][$j]->on_delivery_retail_fiberhome;
					$on_delivery_retail_huawei += $data["so"][$j]->on_delivery_retail_huawei;
					$on_delivery_retail_nokia += $data["so"][$j]->on_delivery_retail_nokia;

					$on_delivery_total_retail += $data["so"][$j]->on_delivery_total_retail;

					$on_delivery_premium_zte += $data["so"][$j]->on_delivery_premium_zte;
					$on_delivery_premium_fiberhome += $data["so"][$j]->on_delivery_premium_fiberhome;
					$on_delivery_premium_huawei += $data["so"][$j]->on_delivery_premium_huawei;

					$on_delivery_total_premium += $data["so"][$j]->on_delivery_total_premium;

					// $qty_kirim_retail_zte += $data["so"][$j]->qty_kirim_retail_zte;
					// $qty_kirim_retail_fh += $data["so"][$j]->qty_kirim_retail_fh;
					// $qty_kirim_retail_hw += $data["so"][$j]->qty_kirim_retail_hw;
					// $qty_kirim_retail_alu += $data["so"][$j]->qty_kirim_retail_alu;

					// $qty_kirim_premium_zte += $data["so"][$j]->qty_kirim_premium_zte;
					// $qty_kirim_premium_fh += $data["so"][$j]->qty_kirim_premium_fh;
					// $qty_kirim_premium_hw += $data["so"][$j]->qty_kirim_premium_hw;

					if ($data["so"][$j]->retail_stock_zte < $data["so"][$j]->batas_bawah_retail_zte) {
						$sumZTE += round(($data["so"][$j]->batas_atas_retail_zte - $data["so"][$j]->retail_stock_zte) / 20, 0) * 20;

					}

					if ($data["so"][$j]->retail_stock_huawei < $data["so"][$j]->batas_bawah_retail_hw) {
						$sumHW += round(($data["so"][$j]->batas_atas_retail_hw - $data["so"][$j]->retail_stock_huawei) / 20, 0) * 20;

					}

					if ($data["so"][$j]->retail_stock_fiberhome < $data["so"][$j]->batas_bawah_retail_fh) {
						$sumFH += round(($data["so"][$j]->batas_atas_retail_fh - $data["so"][$j]->retail_stock_fiberhome) / 20, 0) * 20;

					}

					if ($data["so"][$j]->retail_stock_nokia < $data["so"][$j]->batas_bawah_retail_alu) {
						$sumALU += round(($data["so"][$j]->batas_atas_retail_alu - $data["so"][$j]->retail_stock_nokia) / 20, 0) * 20;

					}

					if ($data["so"][$j]->premium_stock_zte < $data["so"][$j]->batas_bawah_premium_zte) {
						$sumPZTE += round(($data["so"][$j]->batas_atas_premium_zte - $data["so"][$j]->premium_stock_zte) / 20, 0) * 20;

					}

					if ($data["so"][$j]->premium_stock_huawei < $data["so"][$j]->batas_bawah_premium_hw) {
						$sumPHW += round(($data["so"][$j]->batas_atas_premium_hw - $data["so"][$j]->premium_stock_huawei) / 20, 0) * 20;

					}

					if ($data["so"][$j]->premium_stock_fiberhome < $data["so"][$j]->batas_bawah_premium_fh) {
						$sumPFH += round(($data["so"][$j]->batas_atas_premium_hw - $data["so"][$j]->premium_stock_huawei) / 20, 0) * 20;

					}
				}

				$data["witel"][$i]->qty_kirim_retail_zte = $sumZTE;
				$data["witel"][$i]->qty_kirim_retail_fh = $sumFH;
				$data["witel"][$i]->qty_kirim_retail_hw = $sumHW;
				$data["witel"][$i]->qty_kirim_retail_alu = $sumALU;


				$data["witel"][$i]->qty_kirim_premium_zte = $sumPZTE;
				$data["witel"][$i]->qty_kirim_premium_fh = $sumPFH;
				$data["witel"][$i]->qty_kirim_premium_hw = $sumPHW;


				$data["witel"][$i]->minimum_qty = $minimum_qty;
				$data["witel"][$i]->retail_zte = $retail_zte;
				$data["witel"][$i]->retail_fh = $retail_fh;
				$data["witel"][$i]->retail_hw = $retail_hw;
				$data["witel"][$i]->retail_alu = $retail_alu;

				$data["witel"][$i]->total_retail = $total_retail;

				$data["witel"][$i]->premium_zte = $premium_zte;
				$data["witel"][$i]->premium_fh = $premium_fh;
				$data["witel"][$i]->premium_hw = $premium_hw;

				$data["witel"][$i]->total_premium = $total_premium;

				$data["witel"][$i]->batas_atas_retail_zte = $batas_atas_retail_zte;
				$data["witel"][$i]->batas_atas_retail_fh = $batas_atas_retail_fh;
				$data["witel"][$i]->batas_atas_retail_hw = $batas_atas_retail_hw;
				$data["witel"][$i]->batas_atas_retail_alu = $batas_atas_retail_alu;

				$data["witel"][$i]->batas_atas_premium_fh = $batas_atas_premium_fh;
				$data["witel"][$i]->batas_atas_premium_hw = $batas_atas_premium_hw;
				$data["witel"][$i]->batas_atas_premium_zte = $batas_atas_premium_zte;

				$data["witel"][$i]->batas_bawah_retail_zte = $batas_bawah_retail_zte;
				$data["witel"][$i]->batas_bawah_retail_fh = $batas_bawah_retail_fh;
				$data["witel"][$i]->batas_bawah_retail_hw = $batas_bawah_retail_hw;
				$data["witel"][$i]->batas_bawah_retail_alu = $batas_bawah_retail_alu;

				$data["witel"][$i]->batas_bawah_premium_fh = $batas_bawah_premium_fh;
				$data["witel"][$i]->batas_bawah_premium_hw = $batas_bawah_premium_hw;
				$data["witel"][$i]->batas_bawah_premium_zte = $batas_bawah_premium_zte;


				$data["witel"][$i]->retail_stock_zte = $retail_stock_zte;
				$data["witel"][$i]->retail_stock_fiberhome = $retail_stock_fh;
				$data["witel"][$i]->retail_stock_huawei = $retail_stock_hw;
				$data["witel"][$i]->retail_stock_nokia = $retail_stock_nokia;

				$data["witel"][$i]->total_retail_stock = $total_retail_stock;

				$data["witel"][$i]->premium_stock_zte = $premium_stock_zte;
				$data["witel"][$i]->premium_stock_fiberhome = $premium_stock_fh;
				$data["witel"][$i]->premium_stock_huawei = $premium_stock_hw;

				$data["witel"][$i]->total_premium_stock = $total_premium_stock;

				$data["witel"][$i]->on_delivery_retail_zte = $on_delivery_retail_zte;
				$data["witel"][$i]->on_delivery_retail_fiberhome = $on_delivery_retail_fiberhome;
				$data["witel"][$i]->on_delivery_retail_huawei = $on_delivery_retail_huawei;
				$data["witel"][$i]->on_delivery_retail_nokia = $on_delivery_retail_nokia;

				$data["witel"][$i]->on_delivery_total_retail = $on_delivery_total_retail;

				$data["witel"][$i]->on_delivery_premium_zte = $on_delivery_premium_zte;
				$data["witel"][$i]->on_delivery_premium_fiberhome = $on_delivery_premium_fiberhome;
				$data["witel"][$i]->on_delivery_premium_huawei = $on_delivery_premium_huawei;

				$data["witel"][$i]->on_delivery_total_premium = $on_delivery_total_premium;

				// $data["witel"][$i]->qty_kirim_retail_zte = $qty_kirim_retail_zte;
				// $data["witel"][$i]->qty_kirim_retail_fh = $qty_kirim_retail_fh;
				// $data["witel"][$i]->qty_kirim_retail_hw = $qty_kirim_retail_hw;
				// $data["witel"][$i]->qty_kirim_retail_alu = $qty_kirim_retail_alu;

				// $data["witel"][$i]->qty_kirim_premium_fh = $qty_kirim_premium_fh;
				// $data["witel"][$i]->qty_kirim_premium_hw = $qty_kirim_premium_hw;
				// $data["witel"][$i]->qty_kirim_premium_zte = $qty_kirim_premium_zte;
			}
		} else if ($jenis_warehouse == "TA SO") {
			$data["jenis_warehouse"] = "";

			if (str_contains($value_warehouse, "(")) {
				$open = strpos($value_warehouse, "(");
				$close = strpos($value_warehouse, ")");
				$value_warehouse = substr($value_warehouse, $open + 1, $close - $open - 1);
			}

			if (str_contains($value_warehouse, "WH")) {
				$value_warehouse = substr($value_warehouse, 0, strlen($value_warehouse) - 3);
			}

			$tesData = strtolower($data["witel"][92]->witel);

			$data["witel"] = array_values(array_filter($data["witel"], function ($obj) use ($value_warehouse) {
				// echo strtolower($obj->witel)." ".strtolower($value_warehouse)."<br>";
				return str_contains(strtolower($obj->witel), strtolower($value_warehouse));
			}));
		} else {
		}

		$data["total_qty_minimum"] = array_sum(array_column($data["witel"], 'minimum_qty'));
		$data["total_retail_fh_minimum"] = array_sum(array_column($data["witel"], 'retail_fh'));
		$data["total_retail_hw_minimum"] = array_sum(array_column($data["witel"], 'retail_hw'));
		$data["total_retail_zte_minimum"] = array_sum(array_column($data["witel"], 'retail_zte'));
		$data["total_retail_alu_minimum"] = array_sum(array_column($data["witel"], 'retail_alu'));
		$data["total_retail_minimum"] = array_sum(array_column($data["witel"], 'total_retail'));

		$data["total_premium_fh_minimum"] = array_sum(array_column($data["witel"], 'premium_fh'));
		$data["total_premium_hw_minimum"] = array_sum(array_column($data["witel"], 'premium_hw'));
		$data["total_premium_zte_minimum"] = array_sum(array_column($data["witel"], 'premium_zte'));
		$data["total_premium_minimum"] = array_sum(array_column($data["witel"], 'total_premium'));

		$data["total_retail_stock_fh"] = array_sum(array_column($data["witel"], 'retail_stock_fiberhome'));
		$data["total_retail_stock_hw"] = array_sum(array_column($data["witel"], 'retail_stock_huawei'));
		$data["total_retail_stock_zte"] = array_sum(array_column($data["witel"], 'retail_stock_zte'));
		$data["total_retail_stock_alu"] = array_sum(array_column($data["witel"], 'retail_stock_nokia'));
		$data["total_retail_stock_all"] = array_sum(array_column($data["witel"], 'total_retail_stock'));

		$data["total_premium_stock_fh"] = array_sum(array_column($data["witel"], 'premium_stock_fiberhome'));
		$data["total_premium_stock_hw"] = array_sum(array_column($data["witel"], 'premium_stock_huawei'));
		$data["total_premium_stock_zte"] = array_sum(array_column($data["witel"], 'premium_stock_zte'));
		$data["total_premium_stock_all"] = array_sum(array_column($data["witel"], 'total_premium_stock'));

		$data["total_gap_retail_stock_fh"] = $data["total_retail_stock_fh"] - $data["total_retail_fh_minimum"];
		$data["total_gap_retail_stock_hw"] = $data["total_retail_stock_hw"] - $data["total_retail_hw_minimum"];
		$data["total_gap_retail_stock_zte"] = $data["total_retail_stock_zte"] - $data["total_retail_zte_minimum"];
		$data["total_gap_retail_stock_alu"] = $data["total_retail_stock_alu"] - $data["total_retail_alu_minimum"];
		$data["total_gap_stock_retail"] = $data["total_retail_stock_all"] - $data["total_retail_minimum"];

		$data["total_gap_premium_stock_fh"] = $data["total_premium_stock_fh"] - $data["total_premium_fh_minimum"];
		$data["total_gap_premium_stock_hw"] = $data["total_premium_stock_hw"] - $data["total_premium_hw_minimum"];
		$data["total_gap_premium_stock_zte"] = $data["total_premium_stock_zte"] - $data["total_premium_zte_minimum"];
		$data["total_gap_premium_stock"] = $data["total_premium_stock_all"] - $data["total_premium_minimum"];

		$data["total_on_delivery_retail_fiberhome"] = array_sum(array_column($data["witel"], 'on_delivery_retail_fiberhome'));
		$data["total_on_delivery_retail_huawei"] = array_sum(array_column($data["witel"], 'on_delivery_retail_huawei'));
		$data["total_on_delivery_retail_zte"] = array_sum(array_column($data["witel"], 'on_delivery_retail_zte'));
		$data["total_on_delivery_retail_nokia"] = array_sum(array_column($data["witel"], 'on_delivery_retail_nokia'));
		$data["total_on_delivery_retail_all"] = array_sum(array_column($data["witel"], 'on_delivery_total_retail'));

		$data["total_on_delivery_premium_fiberhome"] = array_sum(array_column($data["witel"], 'on_delivery_premium_fiberhome'));
		$data["total_on_delivery_premium_huawei"] = array_sum(array_column($data["witel"], 'on_delivery_premium_huawei'));
		$data["total_on_delivery_premium_zte"] = array_sum(array_column($data["witel"], 'on_delivery_premium_zte'));
		$data["total_on_delivery_premium_all"] = array_sum(array_column($data["witel"], 'on_delivery_total_premium'));

		session(['jenis_halaman' => "rekap_delivery"]);
		session(['data' => $data]);
		return view("rekap_delivery_biasa")->with('data', $data);
	}

	public function rekapDeliveryPage(Request $request, $jenis_warehouse, $value_warehouse)
	{
		$value_warehouse = str_replace("%20", " ", $value_warehouse);
		$data = $this::countDataPerWitelTmp();
		$data = $this::hitungQtyKirim($data);
		$data["all_witel"] = json_decode(json_encode($data["witel"]), true);

		if ($jenis_warehouse == "Witel") {
			$data["jenis_warehouse"] = "TA SO";
			$data["witel_with_so"] = $data["witel"];

			$data["witel"] = array_values(array_filter($data["witel"], function ($obj) use ($value_warehouse) {
				return str_contains(strtolower($obj->regional), strtolower($value_warehouse)) && (str_contains(strtolower($obj->lokasi_wh), "witel") || str_contains(strtolower($obj->witel), "regional"));
			}));
			for ($i = 0; $i < count($data["witel"]); $i++) {
				$value_witel = $data["witel"][$i]->witel;
				$data["so"] = array_values(array_filter($data["witel_with_so"], function ($obj) use ($value_witel) {
					return str_contains(strtolower($obj->witel), strtolower($value_witel));
				}));
				$minimum_qty = 0;
				$retail_zte = 0;
				$retail_fh = 0;
				$retail_hw = 0;
				$retail_alu = 0;

				$total_retail = 0;

				$premium_zte = 0;
				$premium_fh = 0;
				$premium_hw = 0;

				$total_premium = 0;

				$batas_atas_retail_zte = 0;
				$batas_atas_retail_fh = 0;
				$batas_atas_retail_hw = 0;
				$batas_atas_retail_alu = 0;

				$batas_atas_premium_fh = 0;
				$batas_atas_premium_hw = 0;
				$batas_atas_premium_zte = 0;

				$batas_bawah_retail_zte = 0;
				$batas_bawah_retail_fh = 0;
				$batas_bawah_retail_hw = 0;
				$batas_bawah_retail_alu = 0;

				$batas_bawah_premium_fh = 0;
				$batas_bawah_premium_hw = 0;
				$batas_bawah_premium_zte = 0;

				$retail_stock_zte = 0;
				$retail_stock_fh = 0;
				$retail_stock_hw = 0;
				$retail_stock_nokia = 0;

				$total_retail_stock = 0;

				$premium_stock_zte = 0;
				$premium_stock_fh = 0;
				$premium_stock_hw = 0;

				$total_premium_stock = 0;

				$on_delivery_retail_zte = 0;
				$on_delivery_retail_fiberhome = 0;
				$on_delivery_retail_huawei = 0;
				$on_delivery_retail_nokia = 0;

				$on_delivery_total_retail = 0;

				$on_delivery_premium_fiberhome = 0;
				$on_delivery_premium_huawei = 0;
				$on_delivery_premium_zte = 0;

				$on_delivery_total_premium = 0;

				// $qty_kirim_retail_zte = 0;
				// $qty_kirim_retail_fh = 0;
				// $qty_kirim_retail_hw = 0;
				// $qty_kirim_retail_alu = 0;

				// $qty_kirim_premium_zte = 0;
				// $qty_kirim_premium_fh = 0;
				// $qty_kirim_premium_hw = 0;

				$sumZTE = 0;
				$sumFH = 0;
				$sumHW = 0;
				$sumALU = 0;

				$sumPZTE = 0;
				$sumPFH = 0;
				$sumPHW = 0;

				for ($j = 0; $j < count($data["so"]); $j++) {
					$minimum_qty += $data["so"][$j]->minimum_qty;
					$retail_zte += $data["so"][$j]->retail_zte;
					;
					$retail_fh += $data["so"][$j]->retail_fh;
					$retail_hw += $data["so"][$j]->retail_hw;
					$retail_alu += $data["so"][$j]->retail_alu;

					$total_retail += $data["so"][$j]->total_retail;

					$premium_zte += $data["so"][$j]->premium_zte;
					$premium_fh += $data["so"][$j]->premium_fh;
					$premium_hw += $data["so"][$j]->premium_hw;

					$total_premium += $data["so"][$j]->total_premium;

					$batas_atas_retail_zte += $data["so"][$j]->batas_atas_retail_zte;
					$batas_atas_retail_fh += $data["so"][$j]->batas_atas_retail_fh;
					$batas_atas_retail_hw += $data["so"][$j]->batas_atas_retail_hw;
					$batas_atas_retail_alu += $data["so"][$j]->batas_atas_retail_alu;

					$batas_atas_premium_fh += $data["so"][$j]->batas_atas_premium_fh;
					$batas_atas_premium_hw += $data["so"][$j]->batas_atas_premium_hw;
					$batas_atas_premium_zte += $data["so"][$j]->batas_atas_premium_zte;

					$batas_bawah_retail_zte += $data["so"][$j]->batas_bawah_retail_zte;
					$batas_bawah_retail_fh += $data["so"][$j]->batas_bawah_retail_fh;
					$batas_bawah_retail_hw += $data["so"][$j]->batas_bawah_retail_hw;
					$batas_bawah_retail_alu += $data["so"][$j]->batas_bawah_retail_alu;

					$batas_bawah_premium_fh += $data["so"][$j]->batas_bawah_premium_fh;
					$batas_bawah_premium_hw += $data["so"][$j]->batas_bawah_premium_hw;
					$batas_bawah_premium_zte += $data["so"][$j]->batas_bawah_premium_zte;

					$retail_stock_zte += $data["so"][$j]->retail_stock_zte;
					$retail_stock_fh += $data["so"][$j]->retail_stock_fiberhome;
					$retail_stock_hw += $data["so"][$j]->retail_stock_huawei;
					$retail_stock_nokia += $data["so"][$j]->retail_stock_nokia;

					$total_retail_stock += $data["so"][$j]->total_retail_stock;

					$premium_stock_zte += $data["so"][$j]->premium_stock_zte;
					$premium_stock_fh += $data["so"][$j]->premium_stock_fiberhome;
					$premium_stock_hw += $data["so"][$j]->premium_stock_huawei;

					$total_premium_stock += $data["so"][$j]->total_premium_stock;

					$on_delivery_retail_zte += $data["so"][$j]->on_delivery_retail_zte;
					$on_delivery_retail_fiberhome += $data["so"][$j]->on_delivery_retail_fiberhome;
					$on_delivery_retail_huawei += $data["so"][$j]->on_delivery_retail_huawei;
					$on_delivery_retail_nokia += $data["so"][$j]->on_delivery_retail_nokia;

					$on_delivery_total_retail += $data["so"][$j]->on_delivery_total_retail;

					$on_delivery_premium_zte += $data["so"][$j]->on_delivery_premium_zte;
					$on_delivery_premium_fiberhome += $data["so"][$j]->on_delivery_premium_fiberhome;
					$on_delivery_premium_huawei += $data["so"][$j]->on_delivery_premium_huawei;

					$on_delivery_total_premium += $data["so"][$j]->on_delivery_total_premium;

					// $qty_kirim_retail_zte += $data["so"][$j]->qty_kirim_retail_zte;
					// $qty_kirim_retail_fh += $data["so"][$j]->qty_kirim_retail_fh;
					// $qty_kirim_retail_hw += $data["so"][$j]->qty_kirim_retail_hw;
					// $qty_kirim_retail_alu += $data["so"][$j]->qty_kirim_retail_alu;

					// $qty_kirim_premium_zte += $data["so"][$j]->qty_kirim_premium_zte;
					// $qty_kirim_premium_fh += $data["so"][$j]->qty_kirim_premium_fh;
					// $qty_kirim_premium_hw += $data["so"][$j]->qty_kirim_premium_hw;

					if ($data["so"][$j]->retail_stock_zte < $data["so"][$j]->batas_bawah_retail_zte) {
						$sumZTE += $value = round(($data["so"][$j]->batas_atas_retail_zte - $data["so"][$j]->retail_stock_zte) / 20, 0) * 20;

					}

					if ($data["so"][$j]->retail_stock_huawei < $data["so"][$j]->batas_bawah_retail_hw) {
						$sumHW += round(($data["so"][$j]->batas_atas_retail_hw - $data["so"][$j]->retail_stock_huawei) / 20, 0) * 20;

					}

					if ($data["so"][$j]->retail_stock_fiberhome < $data["so"][$j]->batas_bawah_retail_fh) {
						$sumFH += round(($data["so"][$j]->batas_atas_retail_fh - $data["so"][$j]->retail_stock_fiberhome) / 20, 0) * 20;

					}

					if ($data["so"][$j]->retail_stock_nokia < $data["so"][$j]->batas_bawah_retail_alu) {
						$sumALU += round(($data["so"][$j]->batas_atas_retail_alu - $data["so"][$j]->retail_stock_nokia) / 20, 0) * 20;

					}

					if ($data["so"][$j]->premium_stock_zte < $data["so"][$j]->batas_bawah_premium_zte) {
						$sumPZTE += round(($data["so"][$j]->batas_atas_premium_zte - $data["so"][$j]->premium_stock_zte) / 20, 0) * 20;

					}

					if ($data["so"][$j]->premium_stock_huawei < $data["so"][$j]->batas_bawah_premium_hw) {
						$sumPHW += round(($data["so"][$j]->batas_atas_premium_hw - $data["so"][$j]->premium_stock_huawei) / 20, 0) * 20;

					}

					if ($data["so"][$j]->premium_stock_fiberhome < $data["so"][$j]->batas_bawah_premium_fh) {
						$sumPFH += round(($data["so"][$j]->batas_atas_premium_fh - $data["so"][$j]->premium_stock_fiberhome) / 20, 0) * 20;

					}
				}

				$data["witel"][$i]->qty_kirim_retail_zte = $sumZTE;
				$data["witel"][$i]->qty_kirim_retail_fh = $sumFH;
				$data["witel"][$i]->qty_kirim_retail_hw = $sumHW;
				$data["witel"][$i]->qty_kirim_retail_alu = $sumALU;


				$data["witel"][$i]->qty_kirim_premium_zte = $sumPZTE;
				$data["witel"][$i]->qty_kirim_premium_fh = $sumPFH;
				$data["witel"][$i]->qty_kirim_premium_hw = $sumPHW;


				$data["witel"][$i]->minimum_qty = $minimum_qty;
				$data["witel"][$i]->retail_zte = $retail_zte;
				$data["witel"][$i]->retail_fh = $retail_fh;
				$data["witel"][$i]->retail_hw = $retail_hw;
				$data["witel"][$i]->retail_alu = $retail_alu;

				$data["witel"][$i]->total_retail = $total_retail;

				$data["witel"][$i]->premium_zte = $premium_zte;
				$data["witel"][$i]->premium_fh = $premium_fh;
				$data["witel"][$i]->premium_hw = $premium_hw;

				$data["witel"][$i]->total_premium = $total_premium;

				$data["witel"][$i]->batas_atas_retail_zte = $batas_atas_retail_zte;
				$data["witel"][$i]->batas_atas_retail_fh = $batas_atas_retail_fh;
				$data["witel"][$i]->batas_atas_retail_hw = $batas_atas_retail_hw;
				$data["witel"][$i]->batas_atas_retail_alu = $batas_atas_retail_alu;

				$data["witel"][$i]->batas_atas_premium_fh = $batas_atas_premium_fh;
				$data["witel"][$i]->batas_atas_premium_hw = $batas_atas_premium_hw;
				$data["witel"][$i]->batas_atas_premium_zte = $batas_atas_premium_zte;

				$data["witel"][$i]->batas_bawah_retail_zte = $batas_bawah_retail_zte;
				$data["witel"][$i]->batas_bawah_retail_fh = $batas_bawah_retail_fh;
				$data["witel"][$i]->batas_bawah_retail_hw = $batas_bawah_retail_hw;
				$data["witel"][$i]->batas_bawah_retail_alu = $batas_bawah_retail_alu;

				$data["witel"][$i]->batas_bawah_premium_fh = $batas_bawah_premium_fh;
				$data["witel"][$i]->batas_bawah_premium_hw = $batas_bawah_premium_hw;
				$data["witel"][$i]->batas_bawah_premium_zte = $batas_bawah_premium_zte;


				$data["witel"][$i]->retail_stock_zte = $retail_stock_zte;
				$data["witel"][$i]->retail_stock_fiberhome = $retail_stock_fh;
				$data["witel"][$i]->retail_stock_huawei = $retail_stock_hw;
				$data["witel"][$i]->retail_stock_nokia = $retail_stock_nokia;

				$data["witel"][$i]->total_retail_stock = $total_retail_stock;

				$data["witel"][$i]->premium_stock_zte = $premium_stock_zte;
				$data["witel"][$i]->premium_stock_fiberhome = $premium_stock_fh;
				$data["witel"][$i]->premium_stock_huawei = $premium_stock_hw;

				$data["witel"][$i]->total_premium_stock = $total_premium_stock;

				$data["witel"][$i]->on_delivery_retail_zte = $on_delivery_retail_zte;
				$data["witel"][$i]->on_delivery_retail_fiberhome = $on_delivery_retail_fiberhome;
				$data["witel"][$i]->on_delivery_retail_huawei = $on_delivery_retail_huawei;
				$data["witel"][$i]->on_delivery_retail_nokia = $on_delivery_retail_nokia;

				$data["witel"][$i]->on_delivery_total_retail = $on_delivery_total_retail;

				$data["witel"][$i]->on_delivery_premium_zte = $on_delivery_premium_zte;
				$data["witel"][$i]->on_delivery_premium_fiberhome = $on_delivery_premium_fiberhome;
				$data["witel"][$i]->on_delivery_premium_huawei = $on_delivery_premium_huawei;

				$data["witel"][$i]->on_delivery_total_premium = $on_delivery_total_premium;
			}
		} else if ($jenis_warehouse == "TA SO") {
			$data["jenis_warehouse"] = "";

			if (str_contains($value_warehouse, "(")) {
				$open = strpos($value_warehouse, "(");
				$close = strpos($value_warehouse, ")");
				$value_warehouse = substr($value_warehouse, $open + 1, $close - $open - 1);
			}

			if (str_contains($value_warehouse, "WH")) {
				$value_warehouse = substr($value_warehouse, 0, strlen($value_warehouse) - 3);
			}

			// $tesData = strtolower($data["witel"][92]->witel);

			$data["witel"] = array_values(array_filter($data["witel"], function ($obj) use ($value_warehouse) {
				// echo strtolower($obj->witel)." ".strtolower($value_warehouse)."<br>";
				return str_contains(strtolower($obj->witel), strtolower($value_warehouse));
			}));
		} else {
			// print_r($data["witel"]);
		}

		$data["total_qty_minimum"] = array_sum(array_column($data["witel"], 'minimum_qty'));
		$data["total_retail_fh_minimum"] = array_sum(array_column($data["witel"], 'retail_fh'));
		$data["total_retail_hw_minimum"] = array_sum(array_column($data["witel"], 'retail_hw'));
		$data["total_retail_zte_minimum"] = array_sum(array_column($data["witel"], 'retail_zte'));
		$data["total_retail_alu_minimum"] = array_sum(array_column($data["witel"], 'retail_alu'));
		$data["total_retail_minimum"] = array_sum(array_column($data["witel"], 'total_retail'));

		$data["total_premium_fh_minimum"] = array_sum(array_column($data["witel"], 'premium_fh'));
		$data["total_premium_hw_minimum"] = array_sum(array_column($data["witel"], 'premium_hw'));
		$data["total_premium_zte_minimum"] = array_sum(array_column($data["witel"], 'premium_zte'));
		$data["total_premium_minimum"] = array_sum(array_column($data["witel"], 'total_premium'));

		$data["total_retail_stock_fh"] = array_sum(array_column($data["witel"], 'retail_stock_fiberhome'));
		$data["total_retail_stock_hw"] = array_sum(array_column($data["witel"], 'retail_stock_huawei'));
		$data["total_retail_stock_zte"] = array_sum(array_column($data["witel"], 'retail_stock_zte'));
		$data["total_retail_stock_alu"] = array_sum(array_column($data["witel"], 'retail_stock_nokia'));
		$data["total_retail_stock_all"] = array_sum(array_column($data["witel"], 'total_retail_stock'));

		$data["total_premium_stock_fh"] = array_sum(array_column($data["witel"], 'premium_stock_fiberhome'));
		$data["total_premium_stock_hw"] = array_sum(array_column($data["witel"], 'premium_stock_huawei'));
		$data["total_premium_stock_zte"] = array_sum(array_column($data["witel"], 'premium_stock_zte'));
		$data["total_premium_stock_all"] = array_sum(array_column($data["witel"], 'total_premium_stock'));

		$data["total_gap_retail_stock_fh"] = $data["total_retail_stock_fh"] - $data["total_retail_fh_minimum"];
		$data["total_gap_retail_stock_hw"] = $data["total_retail_stock_hw"] - $data["total_retail_hw_minimum"];
		$data["total_gap_retail_stock_zte"] = $data["total_retail_stock_zte"] - $data["total_retail_zte_minimum"];
		$data["total_gap_retail_stock_alu"] = $data["total_retail_stock_alu"] - $data["total_retail_alu_minimum"];
		$data["total_gap_stock_retail"] = $data["total_retail_stock_all"] - $data["total_retail_minimum"];

		$data["total_gap_premium_stock_fh"] = $data["total_premium_stock_fh"] - $data["total_premium_fh_minimum"];
		$data["total_gap_premium_stock_hw"] = $data["total_premium_stock_hw"] - $data["total_premium_hw_minimum"];
		$data["total_gap_premium_stock_zte"] = $data["total_premium_stock_zte"] - $data["total_premium_zte_minimum"];
		$data["total_gap_premium_stock"] = $data["total_premium_stock_all"] - $data["total_premium_minimum"];

		$data["total_on_delivery_retail_fiberhome"] = array_sum(array_column($data["witel"], 'on_delivery_retail_fiberhome'));
		$data["total_on_delivery_retail_huawei"] = array_sum(array_column($data["witel"], 'on_delivery_retail_huawei'));
		$data["total_on_delivery_retail_zte"] = array_sum(array_column($data["witel"], 'on_delivery_retail_zte'));
		$data["total_on_delivery_retail_nokia"] = array_sum(array_column($data["witel"], 'on_delivery_retail_nokia'));
		$data["total_on_delivery_retail_all"] = array_sum(array_column($data["witel"], 'on_delivery_total_retail'));

		$data["total_on_delivery_premium_fiberhome"] = array_sum(array_column($data["witel"], 'on_delivery_premium_fiberhome'));
		$data["total_on_delivery_premium_huawei"] = array_sum(array_column($data["witel"], 'on_delivery_premium_huawei'));
		$data["total_on_delivery_premium_zte"] = array_sum(array_column($data["witel"], 'on_delivery_premium_zte'));
		$data["total_on_delivery_premium_all"] = array_sum(array_column($data["witel"], 'on_delivery_total_premium'));

		$tableDataTmp = DataTmp::getTableLastUpdate();

		$data["last_update"] = $tableDataTmp->waktu_update;
		if (strtotime($tableDataTmp->waktu_dibuat) > strtotime($tableDataTmp->waktu_update)) {
			$data["last_update"] = $tableDataTmp->waktu_dibuat;
		}

		session(['jenis_halaman' => "rekap_delivery"]);
		session(['data' => $data]);
		return view("rekap_delivery")->with('data', $data);
	}

	public function hitungQtyKirimTreg($data)
	{
		for ($i = 0; $i < count($data["witel"]); $i++) {
			$value_regional = $data["witel"][$i]->regional;
			$witel = Gudang::getWitelFromTreg($value_regional);

			$sumAllZTE = 0;
			$sumAllFH = 0;
			$sumAllHW = 0;
			$sumAllALU = 0;

			$sumAllPZTE = 0;
			$sumAllPFH = 0;
			$sumAllPHW = 0;

			for ($k = 0; $k < count($witel); $k++) {
				$value_witel = $witel[$k]->witel;

				$data["so"] = array_values(array_filter($data["treg_with_so"], function ($obj) use ($value_witel) {
					return str_contains(strtolower($obj->witel), strtolower($value_witel));
				}));

				// print_r($data["so"]);
				// echo $data["witel"][$i]->regional;
				// echo "<br>";
				$sumZTE = 0;
				$sumFH = 0;
				$sumHW = 0;
				$sumALU = 0;

				$sumPZTE = 0;
				$sumPFH = 0;
				$sumPHW = 0;

				for ($j = 0; $j < count($data["so"]); $j++) {
					if ($data["so"][$j]->retail_stock_zte < $data["so"][$j]->batas_bawah_retail_zte) {
						$sumZTE += $data["so"][$j]->batas_atas_retail_zte - $data["so"][$j]->retail_stock_zte;

					}

					if ($data["so"][$j]->retail_stock_huawei < $data["so"][$j]->batas_bawah_retail_hw) {
						$sumHW += $data["so"][$j]->batas_atas_retail_hw - $data["so"][$j]->retail_stock_huawei;

					}

					if ($data["so"][$j]->retail_stock_fiberhome < $data["so"][$j]->batas_bawah_retail_fh) {
						$sumFH += $data["so"][$j]->batas_atas_retail_fh - $data["so"][$j]->retail_stock_fiberhome;

					}

					if ($data["so"][$j]->retail_stock_nokia < $data["so"][$j]->batas_bawah_retail_alu) {
						$sumALU += $data["so"][$j]->batas_atas_retail_alu - $data["so"][$j]->retail_stock_nokia;

					}

					if ($data["so"][$j]->premium_stock_zte < $data["so"][$j]->batas_bawah_premium_zte) {
						$sumPZTE += $data["so"][$j]->batas_atas_premium_zte - $data["so"][$j]->premium_stock_zte;

					}

					if ($data["so"][$j]->premium_stock_huawei < $data["so"][$j]->batas_bawah_premium_hw) {
						$sumPHW += $data["so"][$j]->batas_atas_premium_hw - $data["so"][$j]->premium_stock_huawei;

					}

					if ($data["so"][$j]->premium_stock_fiberhome < $data["so"][$j]->batas_bawah_premium_fh) {
						$sumPFH += $data["so"][$j]->batas_atas_premium_fh - $data["so"][$j]->premium_stock_fiberhome;

					}
				}

				$sumAllZTE += $sumZTE;
				$sumAllFH += $sumFH;
				$sumAllHW += $sumHW;
				$sumAllALU += $sumALU;

				$sumAllPZTE += $sumPZTE;
				$sumAllPFH += $sumPFH;
				$sumAllPHW += $sumPHW;
			}
			$data["witel"][$i]->qty_kirim_retail_zte = $sumAllZTE;
			$data["witel"][$i]->qty_kirim_retail_fh = $sumAllFH;
			$data["witel"][$i]->qty_kirim_retail_hw = $sumAllHW;
			$data["witel"][$i]->qty_kirim_retail_alu = $sumAllALU;


			$data["witel"][$i]->qty_kirim_premium_zte = $sumAllPFH;
			$data["witel"][$i]->qty_kirim_premium_fh = $sumAllPHW;
			$data["witel"][$i]->qty_kirim_premium_hw = $sumAllPHW;
		}

		return $data;
	}

	public function hitungQtyKirim($data)
	{
		for ($j = 0; $j < count($data["witel"]); $j++) {
			if ($data["witel"][$j]->retail_stock_fiberhome < $data["witel"][$j]->batas_bawah_retail_fh) {
				$data["witel"][$j]->qty_kirim_retail_fh = $value = round(($data["witel"][$j]->batas_atas_retail_fh - $data["witel"][$j]->retail_stock_fiberhome) / 20, 0) * 20;
			} else {
				$data["witel"][$j]->qty_kirim_retail_fh = 0;
			}

			if ($data["witel"][$j]->retail_stock_huawei < $data["witel"][$j]->batas_bawah_retail_hw) {
				$data["witel"][$j]->qty_kirim_retail_hw = round(($data["witel"][$j]->batas_atas_retail_hw - $data["witel"][$j]->retail_stock_huawei) / 20, 0) * 20;
			} else {
				$data["witel"][$j]->qty_kirim_retail_hw = 0;
			}

			if ($data["witel"][$j]->retail_stock_zte < $data["witel"][$j]->batas_bawah_retail_zte) {
				$data["witel"][$j]->qty_kirim_retail_zte = round(($data["witel"][$j]->batas_atas_retail_zte - $data["witel"][$j]->retail_stock_zte) / 20, 0) * 20;
			} else {
				$data["witel"][$j]->qty_kirim_retail_zte = 0;
			}

			if ($data["witel"][$j]->retail_stock_nokia < $data["witel"][$j]->batas_bawah_retail_alu) {
				$data["witel"][$j]->qty_kirim_retail_alu = round(($data["witel"][$j]->batas_atas_retail_alu - $data["witel"][$j]->retail_stock_nokia) / 20, 0) * 20;
			} else {
				$data["witel"][$j]->qty_kirim_retail_alu = 0;
			}

			if ($data["witel"][$j]->premium_stock_fiberhome < $data["witel"][$j]->batas_bawah_premium_fh) {
				$data["witel"][$j]->qty_kirim_premium_fh = round(($data["witel"][$j]->batas_atas_premium_fh - $data["witel"][$j]->premium_stock_fiberhome) / 20, 0) * 20;
			} else {
				$data["witel"][$j]->qty_kirim_premium_fh = 0;
			}

			if ($data["witel"][$j]->premium_stock_huawei < $data["witel"][$j]->batas_bawah_premium_hw) {
				$data["witel"][$j]->qty_kirim_premium_hw = round(($data["witel"][$j]->batas_atas_premium_hw - $data["witel"][$j]->premium_stock_huawei) / 20, 0) * 20;
			} else {
				$data["witel"][$j]->qty_kirim_premium_hw = 0;
			}

			if ($data["witel"][$j]->premium_stock_zte < $data["witel"][$j]->batas_bawah_premium_zte) {
				$data["witel"][$j]->qty_kirim_premium_zte = round(($data["witel"][$j]->batas_atas_premium_zte - $data["witel"][$j]->premium_stock_zte) / 20, 0) * 20;
			} else {
				$data["witel"][$j]->qty_kirim_premium_zte = 0;
			}
		}

		return $data;
	}

	public function exportQtyKirim(Request $request)
	{
		// foreach(session('data')["witel"] as $data){
		// 	if($data->retail_stock_huawei < $data->batas_bawah_retail_hw){
		// 		print_r($data);
		// 	}
		// }

		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		$spreadsheet_export = $reader->load("file/template_qty_kirim.xlsx");

		$sheet = $spreadsheet_export->getSheetByName("Qty Kirim");

		$i = 4;
		for ($j = 0; $j < count(session("data")["witel"]); $j++) {
			$sheet->setCellValue('A' . $i, session("data")["witel"][$j]->regional);
			$sheet->setCellValue('B' . $i, session("data")["witel"][$j]->lokasi_wh);
			$sheet->setCellValue('C' . $i, session("data")["witel"][$j]->minimum_qty);
			$sheet->setCellValue('D' . $i, session("data")["witel"][$j]->retail_fh);
			$sheet->setCellValue('E' . $i, session("data")["witel"][$j]->retail_hw);
			$sheet->setCellValue('F' . $i, session("data")["witel"][$j]->retail_zte);
			$sheet->setCellValue('G' . $i, session("data")["witel"][$j]->retail_alu);
			$sheet->setCellValue('H' . $i, session("data")["witel"][$j]->premium_fh);
			$sheet->setCellValue('I' . $i, session("data")["witel"][$j]->premium_hw); //estimasi nilai
			$sheet->setCellValue('J' . $i, session("data")["witel"][$j]->premium_zte);
			$sheet->setCellValue('K' . $i, session("data")["witel"][$j]->retail_stock_fiberhome);
			$sheet->setCellValue('L' . $i, session("data")["witel"][$j]->retail_stock_huawei);
			$sheet->setCellValue('M' . $i, session("data")["witel"][$j]->retail_stock_zte);
			$sheet->setCellValue('N' . $i, session("data")["witel"][$j]->retail_stock_nokia);
			$sheet->setCellValue('O' . $i, session("data")["witel"][$j]->premium_stock_fiberhome);
			$sheet->setCellValue('P' . $i, session("data")["witel"][$j]->premium_stock_huawei);
			$sheet->setCellValue('Q' . $i, session("data")["witel"][$j]->premium_stock_zte);
			$sheet->setCellValue('R' . $i, session("data")["witel"][$j]->retail_stock_fiberhome - session("data")["witel"][$j]->retail_fh);
			$sheet->setCellValue('S' . $i, session("data")["witel"][$j]->retail_stock_huawei - session("data")["witel"][$j]->retail_hw);
			$sheet->setCellValue('T' . $i, session("data")["witel"][$j]->retail_stock_zte - session("data")["witel"][$j]->retail_zte);
			$sheet->setCellValue('U' . $i, session("data")["witel"][$j]->retail_stock_nokia - session("data")["witel"][$j]->retail_alu);
			$sheet->setCellValue('V' . $i, session("data")["witel"][$j]->premium_stock_fiberhome - session("data")["witel"][$j]->premium_fh);
			$sheet->setCellValue('W' . $i, session("data")["witel"][$j]->premium_stock_huawei - session("data")["witel"][$j]->premium_hw);
			$sheet->setCellValue('X' . $i, session("data")["witel"][$j]->premium_stock_zte - session("data")["witel"][$j]->premium_zte);
			$sheet->setCellValue('Y' . $i, session("data")["witel"][$j]->batas_atas_retail_fh);
			$sheet->setCellValue('Z' . $i, session("data")["witel"][$j]->batas_atas_retail_hw);
			$sheet->setCellValue('AA' . $i, session("data")["witel"][$j]->batas_atas_retail_zte);
			$sheet->setCellValue('AB' . $i, session("data")["witel"][$j]->batas_atas_retail_alu);
			$sheet->setCellValue('AC' . $i, session("data")["witel"][$j]->batas_atas_premium_fh);
			$sheet->setCellValue('AD' . $i, session("data")["witel"][$j]->batas_atas_premium_hw); //estimasi nilai
			$sheet->setCellValue('AE' . $i, session("data")["witel"][$j]->batas_atas_premium_zte);
			$sheet->setCellValue('AF' . $i, session("data")["witel"][$j]->batas_bawah_retail_fh);
			$sheet->setCellValue('AG' . $i, session("data")["witel"][$j]->batas_bawah_retail_hw);
			$sheet->setCellValue('AH' . $i, session("data")["witel"][$j]->batas_bawah_retail_zte);
			$sheet->setCellValue('AI' . $i, session("data")["witel"][$j]->batas_bawah_retail_alu);
			$sheet->setCellValue('AJ' . $i, session("data")["witel"][$j]->batas_bawah_premium_fh);
			$sheet->setCellValue('AK' . $i, session("data")["witel"][$j]->batas_bawah_premium_hw); //estimasi nilai
			$sheet->setCellValue('AL' . $i, session("data")["witel"][$j]->batas_bawah_premium_zte);

			if (session("data")["witel"][$j]->retail_stock_fiberhome < session("data")["witel"][$j]->batas_bawah_retail_fh && session("data")["witel"][$j]->batas_bawah_retail_fh != 0) {
				$sheet->setCellValue('AM' . $i, session("data")["witel"][$j]->batas_atas_retail_fh - session("data")["witel"][$j]->retail_stock_fiberhome);
			}

			if (session("data")["witel"][$j]->retail_stock_huawei < session("data")["witel"][$j]->batas_bawah_retail_hw && session("data")["witel"][$j]->batas_bawah_retail_hw != 0) {
				$sheet->setCellValue('AN' . $i, session("data")["witel"][$j]->batas_atas_retail_hw - session("data")["witel"][$j]->retail_stock_huawei);
			}

			if (session("data")["witel"][$j]->retail_stock_zte < session("data")["witel"][$j]->batas_bawah_retail_zte && session("data")["witel"][$j]->batas_bawah_retail_zte != 0) {
				$sheet->setCellValue('AO' . $i, session("data")["witel"][$j]->batas_atas_retail_zte - session("data")["witel"][$j]->retail_stock_zte);
			}

			if (session("data")["witel"][$j]->retail_stock_nokia < session("data")["witel"][$j]->batas_bawah_retail_alu && session("data")["witel"][$j]->batas_bawah_retail_alu != 0) {
				$sheet->setCellValue('AP' . $i, session("data")["witel"][$j]->batas_atas_retail_alu - session("data")["witel"][$j]->retail_stock_nokia);
			}

			if (session("data")["witel"][$j]->premium_stock_fiberhome < session("data")["witel"][$j]->batas_bawah_premium_fh && session("data")["witel"][$j]->batas_bawah_premium_fh != 0) {
				$sheet->setCellValue('AQ' . $i, session("data")["witel"][$j]->batas_atas_premium_fh - session("data")["witel"][$j]->premium_stock_fiberhome);
			}

			if (session("data")["witel"][$j]->premium_stock_huawei < session("data")["witel"][$j]->batas_bawah_premium_hw && session("data")["witel"][$j]->batas_bawah_premium_hw != 0) {
				$sheet->setCellValue('AR' . $i, session("data")["witel"][$j]->batas_atas_premium_hw - session("data")["witel"][$j]->premium_stock_huawei);
			}

			if (session("data")["witel"][$j]->premium_stock_zte < session("data")["witel"][$j]->batas_bawah_premium_zte && session("data")["witel"][$j]->batas_bawah_premium_zte != 0) {
				$sheet->setCellValue('AS' . $i, session("data")["witel"][$j]->batas_atas_premium_zte - session("data")["witel"][$j]->premium_stock_zte);
			}

			if (session("data")["witel"][$j]->retail_stock_fiberhome - session("data")["witel"][$j]->retail_fh < -(session("data")["witel"][$j]->retail_fh * 0.75)) {
				$sheet
					->getStyle('R' . $i)
					->getFill()
					->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
					->getStartColor('red')
					->setARGB('red');
			} else if (session("data")["witel"][$j]->retail_stock_fiberhome - session("data")["witel"][$j]->retail_fh < 0) {
				$sheet
					->getStyle('R' . $i)
					->getFill()
					->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
					->getStartColor('yellow')
					->setARGB('yellow');
			}

			if (session("data")["witel"][$j]->retail_stock_huawei - session("data")["witel"][$j]->retail_hw < -(session("data")["witel"][$j]->retail_hw * 0.75)) {
				$sheet
					->getStyle('S' . $i)
					->getFill()
					->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
					->getStartColor('red')
					->setARGB('red');
			} else if (session("data")["witel"][$j]->retail_stock_huawei - session("data")["witel"][$j]->retail_hw < 0) {
				$sheet
					->getStyle('S' . $i)
					->getFill()
					->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
					->getStartColor('yellow')
					->setARGB('yellow');
			}

			if (session("data")["witel"][$j]->retail_stock_zte - session("data")["witel"][$j]->retail_zte < -(session("data")["witel"][$j]->retail_zte * 0.75)) {
				$sheet
					->getStyle('T' . $i)
					->getFill()
					->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
					->getStartColor('red')
					->setARGB('red');
			} else if (session("data")["witel"][$j]->retail_stock_zte - session("data")["witel"][$j]->retail_zte < 0) {
				$sheet
					->getStyle('T' . $i)
					->getFill()
					->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
					->getStartColor('yellow')
					->setARGB('yellow');
			}

			if (session("data")["witel"][$j]->retail_stock_nokia - session("data")["witel"][$j]->retail_alu < -(session("data")["witel"][$j]->retail_alu * 0.75)) {
				$sheet
					->getStyle('U' . $i)
					->getFill()
					->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
					->getStartColor('red')
					->setARGB('red');
			} else if (session("data")["witel"][$j]->retail_stock_nokia - session("data")["witel"][$j]->retail_alu < 0) {
				$sheet
					->getStyle('U' . $i)
					->getFill()
					->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
					->getStartColor('yellow')
					->setARGB('yellow');
			}

			if (session("data")["witel"][$j]->premium_stock_fiberhome - session("data")["witel"][$j]->premium_fh < -(session("data")["witel"][$j]->premium_fh * 0.75)) {
				$sheet
					->getStyle('V' . $i)
					->getFill()
					->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
					->getStartColor('red')
					->setARGB('red');
			} else if (session("data")["witel"][$j]->premium_stock_fiberhome - session("data")["witel"][$j]->premium_fh < 0) {
				$sheet
					->getStyle('V' . $i)
					->getFill()
					->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
					->getStartColor('yellow')
					->setARGB('yellow');
			}

			if (session("data")["witel"][$j]->premium_stock_huawei - session("data")["witel"][$j]->premium_hw < -(session("data")["witel"][$j]->premium_hw * 0.75)) {
				$sheet
					->getStyle('W' . $i)
					->getFill()
					->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
					->getStartColor('red')
					->setARGB('red');
			} else if (session("data")["witel"][$j]->premium_stock_huawei - session("data")["witel"][$j]->premium_hw < 0) {
				$sheet
					->getStyle('W' . $i)
					->getFill()
					->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
					->getStartColor('yellow')
					->setARGB('yellow');
			}

			if (session("data")["witel"][$j]->premium_stock_zte - session("data")["witel"][$j]->premium_zte < -(session("data")["witel"][$j]->premium_zte * 0.75)) {
				$sheet
					->getStyle('X' . $i)
					->getFill()
					->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
					->getStartColor('red')
					->setARGB('red');
			} else if (session("data")["witel"][$j]->premium_stock_zte - session("data")["witel"][$j]->premium_zte < 0) {
				$sheet
					->getStyle('X' . $i)
					->getFill()
					->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
					->getStartColor('yellow')
					->setARGB('yellow');
			}

			$i++;
		}

		$filename = "Qty_Kirim_Stock_SCMT_" . date('Y-m-d') . ".xlsx";

		//write it again to Filesystem with the same name (=replace)
		$writer = new Xlsx($spreadsheet_export);
		$writer->save("file/hasil_export_qty_kirim.xlsx");

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="' . urlencode($filename) . '"');
		$writer->save('php://output');
	}

	public function pullFileFromFTP(Request $require)
	{
		// Upload a file to FTP
		// Storage::disk('ftp')->put('remote-file.txt', 'Local file contents');

		// Download a file from FTP
		// $contents = Storage::disk('ftp')->get('remote-file.txt');

		// $adapter = new League\Flysystem\Ftp\FtpAdapter(
		//    // Connection options
		//    League\Flysystem\Ftp\FtpConnectionOptions::fromArray([
		//         'host' => 'hostname', // required
		//         'root' => '/root/path/', // required
		//         'username' => 'username', // required
		//         'password' => 'password', // required
		//         'port' => 21,
		//         'ssl' => false,
		//         'timeout' => 90,
		//         'utf8' => false,
		//         'passive' => true,
		//         'transferMode' => FTP_BINARY,
		//         'systemType' => null, // 'windows' or 'unix'
		//         'ignorePassiveAddress' => null, // true or false
		//         'timestampsOnUnixListingsEnabled' => false, // true or false
		//         'recurseManually' => true // true 
		//     ])
		// );

		// return Storage::download('');
		// $files = Storage::disk('sftp')->files($this->getBaseDirectory());
		// Storage::disk('ftp')->put('/hasil_export.xlsx', base_path().'/file/hasil_export.xlsx');
		return Storage::disk('ftp')->download('/hasil_export.xlsx');
	}

	public function tambahDataPenerima(Request $request)
	{
		$data["type"] = $request->input("type");
		$data["qty"] = $request->input("qty");
		$data["alamat_pengirim"] = $request->input("alamat_pengirim");
		$data["pic_pengirim"] = $request->input("pic_pengirim");
		$data["alamat_penerima"] = $request->input("alamat_penerima");
		$data["warehouse_penerima"] = $request->input("warehouse_penerima");
		$data["pic_penerima"] = $request->input("pic_penerima");
		$data["tanggal_pengiriman"] = $request->input("tanggal_pengiriman");
		$data["tanggal_sampai"] = $request->input("tanggal_sampai");
		$data["batch"] = $request->input("batch");

		Penerima::insertData($data);
		return back()->with("message", "Data berhasil ditambah!");
	}

	public function exportPenerima(Request $request, $jenis_export)
	{
		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		$spreadsheet_export = $reader->load("file/template_export_pengiriman.xlsx");

		$sheet = $spreadsheet_export->getSheetByName("Sheet1");

		if ($jenis_export == "All") {
			$penerima = Penerima::getAllDataExport();
			$filename = "Rekap_Delivery_All_" . date('Y-m-d') . ".xlsx";
		} else if ($jenis_export == "ONT") {
			$penerima = Penerima::getAllDataONTExport();
			$filename = "Rekap_Delivery_ONT_" . date('Y-m-d') . ".xlsx";
		} else if ($jenis_export == "STB") {
			$penerima = Penerima::getAllDataSTBExport();
			$filename = "Rekap_Delivery_STB_" . date('Y-m-d') . ".xlsx";
		}

		if (session("jenis_akun") == "treg") {
			$penerima = array_values(array_filter($penerima, function ($obj) {
				return str_contains(strtolower($obj->regional), session("asal"));
			}));
		}

		$i = 3;
		for ($j = 0; $j < count($penerima); $j++) {
			$sheet->setCellValue('A' . $i, $penerima[$j]->type);
			$sheet->setCellValue('B' . $i, $penerima[$j]->qty);
			$sheet->setCellValue('C' . $i, $penerima[$j]->alamat_pengirim);
			$sheet->setCellValue('D' . $i, $penerima[$j]->pic_pengirim);
			$sheet->setCellValue('E' . $i, $penerima[$j]->alamat_penerima);
			$sheet->setCellValue('F' . $i, $penerima[$j]->warehouse_penerima);
			$sheet->setCellValue('G' . $i, $penerima[$j]->regional);
			$sheet->setCellValue('H' . $i, $penerima[$j]->pic_penerima);
			$sheet->setCellValue('I' . $i, $penerima[$j]->tanggal_pengiriman);
			$sheet->setCellValue('J' . $i, $penerima[$j]->tanggal_sampai);
			$sheet->setCellValue('K' . $i, $penerima[$j]->ido_gd);
			$sheet->setCellValue('L' . $i, $penerima[$j]->sn_mac_barcode);
			$sheet->setCellValue('M' . $i, $penerima[$j]->batch);
			$sheet->setCellValue('N' . $i, $penerima[$j]->ido_gd_time_added);

			$i += 1;
		}

		//write it again to Filesystem with the same name (=replace)
		$writer = new Xlsx($spreadsheet_export);
		$writer->save("file/hasil_export_penerima.xlsx");

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="' . urlencode($filename) . '"');
		$writer->save('php://output');
	}

	public function downloadTemplateSN(Request $request)
	{
		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		$spreadsheet_export = $reader->load("file/template_upload_serial_number.xlsx");

		$sheet = $spreadsheet_export->getSheetByName("Sheet1");

		//write it again to Filesystem with the same name (=replace)
		$writer = new Xlsx($spreadsheet_export);

		$filename = "Template_serial_number.xlsx";
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="' . urlencode($filename) . '"');
		$writer->save('php://output');
	}

	public function uploadPenerimaan(Request $request, $jenis_upload)
	{
		if ($jenis_upload == "replace") {
			Penerima::deleteAllData();
		}

		if ($request->hasFile("file_penerima")) {
			$file = $request->file("file_penerima");
			$file->move('file', "uploaded_penerima.xlsx");

			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			$spreadsheet = $reader->load("file/uploaded_penerima.xlsx");
			// $sheet = $spreadsheet->getSheetByName("Sheet1");
			$sheet = $spreadsheet->getActiveSheet();

			$maxRow = $sheet->getHighestRow();

			$penerimaanList = array();
			for ($i = 3; $i < $maxRow + 1; $i++) {
				$penerimaan["type"] = $sheet->getCell("A" . $i)->getValue();
				$penerimaan["qty"] = $sheet->getCell("B" . $i)->getValue();
				$penerimaan["alamat_pengirim"] = $sheet->getCell("C" . $i)->getValue();
				$penerimaan["pic_pengirim"] = $sheet->getCell("D" . $i)->getValue();
				$penerimaan["alamat_penerima"] = $sheet->getCell("E" . $i)->getValue();
				$penerimaan["warehouse_penerima"] = $sheet->getCell("F" . $i)->getValue();
				$penerimaan["pic_penerima"] = $sheet->getCell("G" . $i)->getValue();
				$penerimaan["tanggal_pengiriman"] = $sheet->getCell("H" . $i)->getValue();
				$penerimaan["tanggal_sampai"] = $sheet->getCell("I" . $i)->getValue();
				$penerimaan["ido_gd"] = $sheet->getCell("J" . $i)->getValue();
				$penerimaan["sn_mac_barcode"] = $sheet->getCell("K" . $i)->getValue();
				$penerimaan["batch"] = $sheet->getCell("L" . $i)->getValue();
				$penerimaan["ido_gd_time_added"] = $sheet->getCell("M" . $i)->getValue();

				if ($penerimaan["ido_gd"] != '') {
					if ($penerimaan["ido_gd_time_added"] == '') {
						date_default_timezone_set('Asia/Jakarta');
						$penerimaan["ido_gd_time_added"] = date("Y-m-d H:i:s");
					}
				}

				array_push($penerimaanList, $penerimaan);
			}

			$penerimaanList = array_values(array_unique($penerimaanList, SORT_REGULAR));
			for ($i = 0; $i < count($penerimaanList); $i++) {
				Penerima::insertDataBanyak($penerimaanList[$i]);
			}
		}

		return redirect("pengiriman_ont");
	}

	public function deleteOnDeliveryById($id)
	{
		Penerima::deleteOnDeliveryById($id);

		return back()->with("message", "Data ONT berhasil dihapus!");
	}

	public function editOnDeliveryById(Request $request, $id)
	{
		if ($request->hasFile('edit_sn_mac_barcode')) {
			$data["tanggal_pengiriman"] = $request->input("edit_tanggal_pengiriman");
			$data["tanggal_sampai"] = $request->input("edit_tanggal_sampai");
			$file_name = date('Y-m-d') . " " . date("H_i_s") . " " . $request->file('edit_sn_mac_barcode')->getClientOriginalName();

			$file = $request->file("edit_sn_mac_barcode");
			$data["sn_mac_barcode"] = $file_name;
			$file->move('Uploaded SN', $file_name);

			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			$spreadsheet_upload = $reader->load("Uploaded SN/" . $file_name);
			$sheet = $spreadsheet_upload->getActiveSheet();

			$maxRow = $sheet->getHighestRow();

			$penerima = Penerima::getDataById($id);
			for ($i = 1; $i < $maxRow + 1; $i++) {
				if ($sheet->getCell("A" . $i)->getValue() == '') {
					File::delete("Uploaded SN/" . $file_name);
					return back()->with("message", "File gagal diupload dikarenakan data serial number tidak lengkap dengan quantity seharusnya!");
				}
			}

			Penerima::editTanggalPenerimaanById($id, $data);
			return back()->with("message", "Data berhasil diedit!");
		} else if ($request->input("edit_ido_gd") != '') {
			$data["ido_gd"] = $request->input("edit_ido_gd");

			Penerima::editIdoGDById($id, $data);
			return back()->with("message", "Data berhasil diedit!");
		} else {
			$data["tanggal_pengiriman"] = $request->input("edit_tanggal_pengiriman");
			$data["tanggal_sampai"] = $request->input("edit_tanggal_sampai");

			Penerima::editTanggalOnly($id, $data);
			return back()->with("message", "Data berhasil diedit!");
		}
	}

	public function downloadSerialNumber(Request $request, $id)
	{
		$filename = Penerima::getSNById($id)[0]->sn_mac_barcode;
		$file = "Uploaded SN/" . $filename;

		return Response::download($file);
	}

	public function downloadAllSN(Request $request)
	{
		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		$spreadsheet_export = $reader->load("file/template_export_sn.xlsx");

		// $sheet = $spreadsheet_export->getSheetByName("Sheet1");
		$sheet = $spreadsheet_export->getActiveSheet();

		$penerima = Penerima::getAllSNExist();

		if (session("jenis_akun") == "treg") {
			$penerima = array_values(array_filter($penerima, function ($obj) {
				return str_contains(strtolower($obj->regional), session("asal"));
			}));
		}

		$i = 2;

		for ($j = 0; $j < count($penerima); $j++) {
			$filename = Penerima::getSNById($penerima[$j]->id)[0]->sn_mac_barcode;
			$batch = Penerima::getBatchById($penerima[$j]->id)[0]->batch;
			$spreadsheet_import = $reader->load("Uploaded SN/" . $filename);
			// $sheet_import = $spreadsheet_import->getSheetByName("Sheet1");
			$sheet_import = $spreadsheet_import->getActiveSheet();

			$maxRow = $sheet_import->getHighestRow();
			for ($k = 2; $k < $maxRow + 1; $k++) {
				$sheet->setCellValue('A' . $i, $sheet_import->getCell("A" . $k)->getValue());
				$sheet->setCellValue('B' . $i, $sheet_import->getCell("B" . $k)->getValue());
				$sheet->setCellValue('C' . $i, $penerima[$j]->warehouse_penerima);
				$sheet->setCellValue('D' . $i, $penerima[$j]->type);
				$sheet->setCellValue('E' . $i, $batch);

				$i += 1;
			}
		}

		//write it again to Filesystem with the same name (=replace)
		$writer = new Xlsx($spreadsheet_export);
		$writer->save("file/hasil_all_sn.xlsx");

		$filename = "Rekap_All_SN" . date('Y-m-d') . ".xlsx";

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="' . urlencode($filename) . '"');
		$writer->save('php://output');
	}

	public function allRekapDelivery(Request $request)
	{
		$penerima = Penerima::getAllDataONT();
		if (session("jenis_akun") == "treg") {
			$penerima = array_values(array_filter($penerima, function ($obj) {
				return str_contains(strtolower($obj->regional), session("asal"));
			}));
		}

		return Datatables::of($penerima)->addIndexColumn()->make(true);
	}

	public function getOnDeliveryByWarehouse(Request $request, $nama_warehouse, $jenis_ont)
	{
		if ($jenis_ont == "premium") {
			$penerima = Penerima::getOnDeliveryPremiumByWarehouse($nama_warehouse);
		} else {
			$penerima = Penerima::getOnDeliveryRetailByWarehouse($nama_warehouse);
		}

		return Datatables::of($penerima)->addIndexColumn()->make(true);
	}

	public function requestOutbond(Request $request)
	{
		$data["warehouse"] = Gudang::getAllWarehouse();
		$data["type_unique"] = RequestOutbond::getTypeUnique();
		$data["jenis_unique"] = RequestOutbond::getJenisUnique();
		$data["merk_unique"] = RequestOutbond::getMerkUnique();
		$data["request_outbond"] = RequestOutbond::getAllData();

		return view("request_outbond")->with('data', $data);
	}

	public function exportDataRequestOutbond(Request $request)
	{
		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		$spreadsheet_export = $reader->load("file/template_request_outbond.xlsx");
		$sheet = $spreadsheet_export->getActiveSheet();

		$request_outbond = RequestOutbond::getAllData();

		$i = 3;
		for ($j = 0; $j < count($request_outbond); $j++) {
			$sheet->setCellValue("A" . $i, $request_outbond[$j]->type);
			$sheet->setCellValue("B" . $i, $request_outbond[$j]->jenis);
			$sheet->setCellValue("C" . $i, $request_outbond[$j]->merk);
			$sheet->setCellValue("D" . $i, $request_outbond[$j]->qty_delivery);
			$sheet->setCellValue("E" . $i, $request_outbond[$j]->delivery_by);
			$sheet->setCellValue("F" . $i, $request_outbond[$j]->keperluan);
			$sheet->setCellValue("G" . $i, $request_outbond[$j]->catatan);
			$sheet->setCellValue("H" . $i, $request_outbond[$j]->alamat_tujuan);
			$sheet->setCellValue("I" . $i, $request_outbond[$j]->added_by);
			$sheet->setCellValue("J" . $i, $request_outbond[$j]->respon);

			$i += 1;
		}

		//write it again to Filesystem with the same name (=replace)
		$writer = new Xlsx($spreadsheet_export);
		$writer->save("file/hasil_export_request_outbond.xlsx");

		$filename = "Rekap_Request_Outbond" . date('Y-m-d') . ".xlsx";

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="' . urlencode($filename) . '"');
		$writer->save('php://output');
	}

	public function allRequestOutbond(Request $request)
	{
		$requestOutbond = RequestOutbond::getAllData();

		return Datatables::of($requestOutbond)->addIndexColumn()->make(true);
	}

	public function uploadResponRequestOutbond(Request $request, $id)
	{
		$message = '';

		if ($request->hasFile("edit_sn_mac_barcode")) {
			$file_name = date('Y-m-d') . " " . date("H_i_s") . " " . $request->file('edit_sn_mac_barcode')->getClientOriginalName();

			$file = $request->file("edit_sn_mac_barcode");
			$file->move('Uploaded SN', $file_name);

			$data["sn_mac_barcode"] = $file_name;

			RequestOutbond::editSNMac($id, $data);
			$message .= "Data SN Berhasil diupload! <br>";
		}

		if ($request->hasFile("edit_evident")) {
			$file_name = date('Y-m-d') . " " . date("H_i_s") . " " . $request->file('edit_evident')->getClientOriginalName();

			$file = $request->file("edit_evident");
			$file->move('Uploaded Evident', $file_name);

			$data["evident"] = $file_name;

			RequestOutbond::editEvident($id, $data);
			$message .= "Data Evident Berhasil diupload! <br>";

			RequestOutbond::editEvident($id, $data);
		}

		if ($request->hasFile("edit_evident") || $request->hasFile("edit_sn_mac_barcode")) {
			$message .= "<br>";
		}

		$respon = RequestOutbond::getResponById($id)[0];
		if ($respon->respon != '') {
			$message .= "Data respon berhasil diubah!";
		} else {
			$message .= "Data berhasil diapprove!";
		}

		if ($respon->respon != '' && $respon->sn_mac_barcode != '' && $respon->evident != '') {
			RequestOutbond::editStatus($id, "Approved");
		} else {
			RequestOutbond::editStatus($id, "Submitted");
		}


		$data["respon"] = $request->input("edit_respon");
		$data["approved_by"] = session("nama_user");
		RequestOutbond::editRespon($id, $data);


		return back()->with("message", $message);
	}

	public function tambahDataRequestOutbond(Request $request)
	{
		$type = explode("|", $request->input("type"));

		$data["type"] = $type[0];
		$data["jenis"] = $type[1];
		$data["merk"] = $type[2];
		$data["qty_delivery"] = $request->input("qty_delivery");
		$data["delivery_by"] = $request->input("delivery_by");
		$data["keperluan"] = $request->input("keperluan");
		$data["catatan"] = $request->input("catatan");
		$data["alamat_tujuan"] = $request->input("alamat_tujuan");
		$data["respon"] = $request->input("respon");
		$data["added_by"] = session("nama_user");

		RequestOutbond::insertData($data);

		return back()->with("message", "Data Request Outbond Baru Berhasil ditambahkan!");
	}

	public function editRequestOutbond(Request $request, $id)
	{
		$type = explode("|", $request->input("edit_type"));

		$data["type"] = $type[0];
		$data["jenis"] = $type[1];
		$data["merk"] = $type[2];
		$data["qty_delivery"] = $request->input("edit_qty_delivery");
		$data["delivery_by"] = $request->input("edit_delivery_by");
		$data["keperluan"] = $request->input("edit_keperluan");
		$data["catatan"] = $request->input("edit_catatan");
		$data["alamat_tujuan"] = $request->input("edit_alamat_tujuan");

		RequestOutbond::editData($data, $id);

		return back()->with("message", "Data Request Outbond Berhasil diedit!");
	}

	public function deleteRequestOutbond(Request $request, $id)
	{
		RequestOutbond::deleteData($id);

		return back()->with("message", "Data Request Outbond Dengan ID " . $id . " Berhasil dihapus!");
	}

	public function downloadMacSN(Request $request, $id)
	{
		$sn_mac = RequestOutbond::getSNMacById($id)[0]->sn_mac_barcode;

		$file = "Uploaded SN/" . $sn_mac;

		return Response::download($file);
	}

	public function downloadEvident(Request $request, $id)
	{
		$evident = RequestOutbond::getEvidentById($id)[0]->evident;

		$file = "Uploaded Evident/" . $evident;

		return Response::download($file);
	}

	public function editProfile(Request $request)
	{
		return view("edit_profile");
	}

	public function userList(Request $request)
	{
		return view("user_list");
	}

	public function sentMessage()
	{
		if (session("username") == "admin") {
			$data = User::GetAllUserNotAdmin();

			return view("sent_message")->with("data", $data);
		} else {
			$data = User::GetAllUserAdminOnly();

			return view("sent_message")->with("data", $data);
		}
	}

	public function inboxMessage()
	{
		return view("inbox_message");
	}

	public function historyMessage()
	{
		return view("history_message");
	}

	public function addMessage(Request $request)
	{
		$nama_penerima = $request->input("nama_penerima");
		$message = $request->input("message");

		$data["nama_pengirim"] = session("username");
		$data["nama_penerima"] = $request->input("nama_penerima");
		$data["message"] = $request->input("message");
		$data["status"] = "Sent";
		$data["created_date"] = now();

		Messages::insertMessage($data);

		return back()->with("message", "Data Message Berhasil Dikirim");
	}

	public function getAllMessageWithStatusSent()
	{
		$data = Messages::getAllWithStatusSent(session("username"));

		return Datatables::of($data)->addIndexColumn()->make(true);
	}

	public function getAllMessageWithStatusInbox()
	{
		$data = Messages::getAllWithStatusInbox(session("username"));

		return Datatables::of($data)->addIndexColumn()->make(true);
	}

	public function getAllMessage()
	{
		$data = Messages::getAll();

		return Datatables::of($data)->addIndexColumn()->make(true);
	}

	public function getAllNotificationMessage()
	{
		$data = Messages::getAllNotification(session("username"));

		return response()->json($data);
	}

	public function approveMessage($id)
	{
		Messages::approveMessage($id);

		return back()->with("message", "Data berhasil di Approve!");
	}

	public function rejectMessage($id)
	{
		Messages::rejectMessage($id);

		return back()->with("message", "Data berhasil di Reject!");
	}
}
?>