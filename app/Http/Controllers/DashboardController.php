<?php

namespace App\Http\Controllers;

use App\Models\Afdeling;
use App\Models\Blok;
use App\Models\Estate;
use App\Models\Regional;
use App\Models\Wilayah;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\DataTables;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        // $dateToday = new DateTime();
        $dateToday =  Carbon::now()->format('d M Y');
        $getDate = Carbon::parse($dateToday)->locale('id');
        $getDate->settings(['formatFunction' => 'translatedFormat']);

        $pil_reg = $request->has('id_reg') ? $request->get('id_reg') : 0;

        $reg_all = Regional::all()->pluck('nama');
        $reg_all = json_decode($reg_all);

        $reg = Regional::with("wilayah")->get();
        $reg_arr = array();

        foreach ($reg as $key => $value) {
            foreach ($value->wilayah as $key2 => $data) {
                $reg_arr[$key][$data->nama] =  Wilayah::with("estate")->find($data->id)->estate->pluck('nama', 'est');
            }
        }

        $est_wil_reg = array();
        foreach ($reg_arr as $key => $value) {
            foreach ($value as $key2 => $data) {
                foreach ($data as $key3 => $datas) {
                    $est_wil_reg[$key][$key3] = $datas;
                }
            }
        }

        $est_tak = 0;
        $est_pemanen = 0;
        $log_tak_est = '';
        $log_keb_pemanen_est = '';
        $est = '';
        $dateToday = Carbon::now()->format('Y-m-d');
        $tglData = $request->has('tgl') ? $request->input('tgl') : $defaultHari = $dateToday;

        $hariIni =  $tglData . ' 00:00:00';

        $newConvert = new Carbon($hariIni);

        $besok = $newConvert->addDays();
        $besok = $besok->format('Y-m-d') . ' 00:00:00';

        $color_chart = array(
            '#001E3C', '#AB221D', '#5CAF50', '#7CAF50', '#8CAF50', '#AB221D', '#AB221D',
            '#AB221D', '#AB221D', '#AB221D', '#AB221D', '#AB221D', '#AB221D', '#AB221D', '#282C34'
        );

        $afdeling = array('OA', 'OB', 'OC', 'OD', 'OF', 'OA');

        // $query = DB::connection('mysql2')->table('taksasi')
        //     ->select('taksasi.*')
        //     ->whereBetween('taksasi.waktu_upload', [$hariIni, $besok])
        //     ->orderBy('taksasi.afdeling', 'asc')
        //     ->get();

        // if ($query->first() != null) {
        //     $query = json_decode($query);


        //     foreach ($est_wil_reg[$pil_reg] as $key => $value) {
        //         $inc = 0;
        //         $sum_sph = 0;
        //         $sum_bjr = 0;
        //         $sum_path = 0;
        //         $sum_pokok = 0;
        //         $sum_janjang = 0;
        //         $sum_pemanen = 0;
        //         $sum_ritase = 0;
        //         $sum_luas = 0;
        //         foreach ($query as $data) {
        //             if ($data->lokasi_kerja == $key) {

        //                 $sum_luas += $data->luas;
        //                 $sum_sph += $data->sph;
        //                 $sum_bjr += $data->bjr;
        //                 $path_arr = explode(';', $data->br_kanan);
        //                 $jumlah_path = count($path_arr);
        //                 $sum_path += $jumlah_path;
        //                 $sum_pokok += $data->jumlah_pokok;
        //                 $sum_janjang += $data->jumlah_janjang;
        //                 $sum_pemanen += $data->pemanen;
        //             }
        //             $inc++;
        //         }
        //         // ceil($value['taksasi'] / 6500);
        //         $est_array[$key]['est'] = $key;
        //         $est_array[$key]['luas_total'] = $sum_luas;
        //         $sph = round($sum_sph / $inc, 2);
        //         $est_array[$key]['sph_total'] = $sph;
        //         $bjr = round($sum_bjr / $inc, 2);
        //         $est_array[$key]['bjr_total'] = $bjr;
        //         $est_array[$key]['path_total'] = $sum_path;
        //         $est_array[$key]['pokok_total'] = $sum_pokok;
        //         $est_array[$key]['janjang_total'] = $sum_janjang;

        //         if ($sum_janjang != 0 && $sum_pokok != 0) {
        //             $akp = round($sum_janjang / $sum_pokok, 2) * 100;
        //             $est_array[$key]['akp_total'] = $akp;
        //             $tak = ($akp * $sum_luas * $sph * $bjr) / 100;
        //             $est_array[$key]['taksasi_total'] =  number_format($tak, 2, ",", ".");
        //             $est_array[$key]['pemanen_total'] = $sum_pemanen;
        //             $est_array[$key]['ritase_total'] = ceil($tak / 6500);
        //         }
        //     }
        // }
        $pil_est = $request->has('id_reg') ? $request->get('id_reg') : 3;

        $reg_all = Regional::all()->pluck('nama');
        $reg_all = json_decode($reg_all);

        $reg = Regional::with("wilayah")->get();
        $reg_arr = array();
        foreach ($reg as $key => $value) {
            foreach ($value->wilayah as $key2 => $data) {
                $reg_arr[$key][$data->nama] =  Wilayah::with("estate")->find($data->id)->estate->pluck('nama', 'est');
            }
        }

        $est_wil_reg = array();
        foreach ($reg_arr as $key => $value) {
            foreach ($value as $key2 => $data) {
                foreach ($data as $key3 => $datas) {
                    $est_wil_reg[$key][$key3] = $datas;
                }
            }
        }

        // dd(Estate::with('afdeling')->find(3));
        // dd($est_wil_reg[$pil_reg]);

        // $id_est = Estate::where('est', $pil_est)->first()->id;
        $queryEst = Estate::with("afdeling")->find($pil_est);

        $list_afd_est = $queryEst->afdeling->pluck('nama');

        $afd_array = array();
        $keb_pem_array = array();

        $query = DB::connection('mysql2')->table('taksasi')
            ->select('taksasi.*')
            ->whereBetween('taksasi.waktu_upload', [$hariIni, $besok])
            ->where('lokasi_kerja', $queryEst->est)
            ->orderBy('taksasi.afdeling', 'asc')
            ->get();

        foreach ($list_afd_est as $key => $value) {
            $afd_array[$key]['afd'] = $value;
            $afd_array[$key]['taksasi'] = 0;
            $afd_array[$key]['kebutuhan_pemanen'] = 0;
        }

        $list_afd_est = json_decode($list_afd_est);
        if ($query->first() != null) {
            $query = json_decode($query);

            foreach ($list_afd_est as $key => $value) {
                $inc = 0;
                $sum_pemanen = 0;
                $tak = 0;
                $akp = 0;
                foreach ($query as $key2 => $data) {
                    if ($data->afdeling == $value) {
                        $sum_pemanen += $data->pemanen;
                        $akp = round($data->jumlah_janjang / $data->jumlah_pokok, 2) * 100;

                        $tak += ($akp * $data->luas * $data->sph * $data->bjr) / 100;
                    }
                    $inc++;
                }
                $afd_array[$key]['taksasi'] =  number_format($tak, 2, ",", ".");
                $afd_array[$key]['kebutuhan_pemanen'] = $sum_pemanen;

                $est_tak += $tak;
                $est_pemanen += $sum_pemanen;
            }
        }

        $est_tak =  number_format($est_tak, 2, ",", ".");

        return view('homepage', [
            'date' => $getDate->format('l, j F Y'),
            'hour' =>  Carbon::now()->format('H:i:s'),
            'estTak' => $est_tak, // default RDE 
            'estPemanen' => $est_pemanen, // default RDE 
            'dateAfdeling' => $afd_array,
        ]);
    }

    public function ds_taksasi()
    {
        $reg_all = Regional::all()->pluck('nama');
        $reg_all = json_decode($reg_all);

        return view('taksasi.estate', [
            'reg' => $reg_all,
        ]);
    }


    public function ds_taksasi_afdeling(Request $request)
    {

        $reg_all = Regional::all()->pluck('nama');
        $reg_all = json_decode($reg_all);

        // dd($reg_all);
        return view('taksasi.afdeling', [
            'reg' => $reg_all,
        ]);
    }

    public function getTakEst15Days(Request $request)
    {
        $pil_reg = $request->get('id_reg');
        $tglData = $request->get('tgl');
        // $to = !is_null($logMingguan) ?  $logMingguan->timestamp : Carbon::now()->format('Y-m-d');
        // dd($to);
        $formatted = new DateTime($tglData);

        // dd($formatted);
        $formatted = $formatted->format('Y-m-d');

        $to = $formatted . ' 23:59:59';

        $convert = new DateTime($to);

        $to = $convert->format('Y-m-d H:i:s');

        $dateParse = Carbon::parse($to)->subDays(14);
        $dateParse = $dateParse->format('Y-m-d');

        $dateParse = $dateParse . ' 00:00:00';
        $pastWeek = new DateTime($dateParse);
        $pastWeek = $pastWeek->format('Y-m-d H:i:s');


        $reg_all = Regional::all()->pluck('nama');
        $reg_all = json_decode($reg_all);

        $reg = Regional::with("wilayah")->get();
        $reg_arr = array();

        foreach ($reg as $key => $value) {
            foreach ($value->wilayah as $key2 => $data) {
                $reg_arr[$key][$data->nama] =  Wilayah::with("estate")->find($data->id)->estate->pluck('nama', 'est');
            }
        }

        $est_wil_reg = array();
        foreach ($reg_arr as $key => $value) {
            foreach ($value as $key2 => $data) {
                foreach ($data as $key3 => $datas) {
                    $est_wil_reg[$key][$key3] = $datas;
                }
            }
        }

        $query = DB::connection('mysql2')->table('taksasi')
            ->select('taksasi.*')
            ->whereBetween('taksasi.waktu_upload', [$pastWeek, $to])
            ->orderBy('taksasi.afdeling', 'asc')
            ->get();

        $data_per_hari = array();
        for ($i = 0; $i < 15; $i++) {
            $hari = Carbon::parse($pastWeek)->addDays($i);
            $convertHari = $hari->format('Y-m-d');
            $hari = Carbon::parse($hari)->locale('id');
            $hari->settings(['formatFunction' => 'translatedFormat']);
            $tgl = $hari->format('j F');
            $hari = $hari->format('l, j F');

            $data_per_hari[$i]['hari'] = $tgl;
            $data_per_hari[$i]['tanggal'] = $hari;

            $data_per_hari[$i]['taksasi'] = 0;
            $data_per_hari[$i]['kebutuhan_pemanen'] = 0;

            foreach ($est_wil_reg[$pil_reg] as $key => $value) {
                $sum_tak_est = 0;
                $sum_keb_pemanen_est = 0;
                $jumlah_record = 0;
                foreach ($query as $data) {
                    $waktu_upload = new DateTime($data->waktu_upload);
                    $waktu_upload = $waktu_upload->format('Y-m-d');
                    if ($convertHari == $waktu_upload) {
                        $sum_tak_est += $data->taksasi;
                        $sum_keb_pemanen_est += $data->pemanen;
                        $jumlah_record++;
                    }
                }
                $data_per_hari[$i]['countRecord'] = $jumlah_record;
                $data_per_hari[$i]['taksasi'] = $sum_tak_est;
                $data_per_hari[$i]['kebutuhan_pemanen'] = $sum_keb_pemanen_est;
            }
        }

        dd($data_per_hari);
        echo json_encode($data_per_hari);
        exit();
    }

    public function getNameEstate(Request $request)
    {

        $id_reg = $request->get('id_reg');

        $reg_all = Regional::all()->pluck('nama', 'id');
        $reg_all = json_decode($reg_all);

        $reg = Regional::with("wilayah")->get();
        $reg_arr = array();

        foreach ($reg as $key => $value) {
            foreach ($value->wilayah as $key2 => $data) {
                $reg_arr[$key][$data->nama] =  Wilayah::with("estate")->find($data->id)->estate->pluck('nama', 'est');
            }
        }

        $est_wil_reg = array();
        foreach ($reg_arr as $key => $value) {
            foreach ($value as $key2 => $data) {
                foreach ($data as $key3 => $datas) {
                    $est_wil_reg[$key][$key3] = $datas;
                }
            }
        }

        $output = '';
        $inc_est = 1;
        foreach ($est_wil_reg[$id_reg] as $key => $val) {
            $output .= '<option value="' . $key . '">' . $val . '</option>';
            $inc_est++;
        }
        echo $output;
    }

    public function history_taksasi(Request $request)
    {

        $tglData = Carbon::parse('2022-10-20');


        $kemarin = $tglData->subDay()->format('Y-m-d') . ' 00:00:00';

        $newConvert = new Carbon($kemarin);

        $hariIni = $newConvert->addDays(2);

        $hariIni = ($hariIni->format('Y-m-d')) . ' 00:00:00';

        $queryData = DB::connection('mysql2')->table('taksasi')
            ->select('taksasi.*')
            ->whereBetween('taksasi.waktu_upload', [$kemarin, $hariIni])
            ->orderBy('taksasi.waktu_upload', 'desc')
            ->get()
            ->groupBy('lokasi_kerja');

        $queryData = json_decode($queryData, true);

        $list_estate = array();
        foreach ($queryData as $key => $value) {
            foreach ($value as $key2 => $data) {
                if (!in_array($data['lokasi_kerja'], $list_estate)) {
                    $list_estate[] = $data['lokasi_kerja'];
                }
            }
        }

        $list_blok = array();
        foreach ($queryData as $key => $value) {
            foreach ($value as $key2 => $data) {
                $list_blok[$key][] = $data['blok'];
            }
        }

        foreach ($list_estate as $key3 => $val) {
            $estateQuery = Estate::with("afdeling")->where('est', $val)->get();
            $blokPerEstate = array();
            foreach ($estateQuery as $key => $value) {
                $i = 0;
                foreach ($value->afdeling as $key2 => $data) {
                    $blokPerEstate[$val][$data->nama] =  Afdeling::with("blok")->find($data->id)->blok->pluck('nama', 'id');
                    $i++;
                }
            }
        }

        $result_list_blok = array();
        foreach ($list_blok as $key => $value) {
            foreach ($value as $key2 => $data) {
                if (strlen($data) == 5) {
                    $result_list_blok[$key][$data] = substr($data, 0, -2);
                }
                if (strlen($data) == 6) {
                    $sliced = substr_replace($data, '', 1, 1);
                    $result_list_blok[$key][$data] = substr($sliced, 0, -2);
                }
            }
        }

        $result_list_all_blok = array();
        foreach ($blokPerEstate as $key2 => $est) {
            foreach ($est as $key3 => $afd) {
                foreach ($afd as $key4 => $data) {
                    if (strlen($data) == 4) {
                        $result_list_all_blok[$key2][] = substr_replace($data, '', 1, 1);
                    }
                }
            }
        }

        //bandingkan list blok query dan list all blok dan get hanya blok yang cocok
        $result_blok = array();
        foreach ($list_estate as $key => $value) {
            if (array_key_exists($value, $result_list_all_blok)) {
                $query = array_unique($result_list_all_blok[$value]);
                $result_blok[$value] = array_intersect($result_list_blok[$value], $query);
            }
        }

        //get lat lang dan key $result_blok atau semua list_blok
        $blokLatLn = array();
        foreach ($result_blok as $key => $value) {
            $inc = 0;
            foreach ($value as $key2 => $data) {
                $newData = substr_replace($data, '0', 1, 0);
                $query = '';
                $query = DB::connection('mysql2')->table('blok')
                    ->select('blok.*')
                    ->where('blok.nama', $newData)
                    ->get();

                $latln = '';
                foreach ($query as $key3 => $val) {
                    // $blokLatLn[$key][$inc]['lat' . $key3] = $val->lat;
                    // $blokLatLn[$key][$inc]['lon' . $key3] = $val->lon;

                    $latln .= '[' . $val->lat . ',' . $val->lon . '],';
                }
                $blokLatLn[$key][$inc]['blok'] = $key2;
                $blokLatLn[$key][$inc]['latln'] = $latln;
                $inc++;
            }
        }

        // dd($blokLatLn);

        // dd($queryData);

        if ($request->ajax()) {
            $query = DB::connection('mysql2')->table('taksasi')
                ->select('taksasi.*')
                ->orderBy('taksasi.waktu_upload', 'desc')
                ->get();

            $inc = 0;
            foreach ($query as $key => $value) {
                $path_arr = explode(';', $value->br_kanan);
                $value->jumlah_path = count($path_arr);
                $value->tanggal_upload = Carbon::parse($value->waktu_upload)->format('d M Y');
                $value->ritase = ceil($value->taksasi / 6500);
                $value->akp_round = round($value->akp, 2);
                $value->tak_round = number_format($value->taksasi, 2, ",", ".");
                $inc++;
            }
            // dd($query);

            $query = json_decode($query, true);
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($model) {
                    return '<a href="" class=""><i class="nav-icon fa-solid fa-circle-info" style="color:#1E6E42"></i>    </a>';
                })
                ->make(true);
        }

        // dd($queryData);

        return view('taksasi.history', ['list_estate' => $list_estate, 'data_per_estate' => $queryData, 'blok_per_estate' => $blokLatLn]);
    }

    public function getDataRegional(Request $request)
    {
        $pil_reg = $request->get('id_reg');
        $takReq = $request->get('tak');

        $reg_all = Regional::all()->pluck('nama');
        $reg_all = json_decode($reg_all);

        $reg = Regional::with("wilayah")->get();
        $reg_arr = array();

        foreach ($reg as $key => $value) {
            foreach ($value->wilayah as $key2 => $data) {
                $reg_arr[$key][$data->nama] =  Wilayah::with("estate")->find($data->id)->estate->pluck('nama', 'est');
            }
        }

        $est_wil_reg = array();
        foreach ($reg_arr as $key => $value) {
            foreach ($value as $key2 => $data) {
                foreach ($data as $key3 => $datas) {
                    $est_wil_reg[$key][$key3] = $datas;
                }
            }
        }

        $est_array = array();
        $keb_pem_array = array();
        $log_tak_est = '';
        $log_keb_pemanen_est = '';
        $est = '';
        $dateToday = Carbon::now()->format('Y-m-d');
        $tglData = $request->get('tgl');

        $hariIni = $tglData . ' 00:00:00';

        $newConvert = new Carbon($hariIni);

        // dd($hariIni);
        $besok = $newConvert->addDays();
        $besok = ($besok->format('Y-m-d')) . ' 00:00:00';

        $afdeling = array('OA', 'OB', 'OC', 'OD', 'OF', 'OA');

        $query = DB::connection('mysql2')->table('taksasi')
            ->select('taksasi.*')
            ->whereBetween('taksasi.waktu_upload', [$hariIni, $besok])
            ->orderBy('taksasi.afdeling', 'asc')
            ->get();

        if ($query->first() != null) {
            $query = json_decode($query);
            $inc = 0;
            foreach ($est_wil_reg[$pil_reg] as $key => $value) {
                $sum_tak_est = 0;
                $sum_keb_pemanen_est = 0;
                foreach ($query as $data) {
                    if ($data->lokasi_kerja == $key) {
                        $sum_tak_est += $data->taksasi;
                        $sum_keb_pemanen_est += $data->pemanen;
                    }
                }

                $est_array[$key] = $sum_tak_est;
                $keb_pem_array[$key] = $sum_keb_pemanen_est;
                $inc++;
            }
        }

        if ($takReq == 1) {
            echo json_encode($est_array);
        } else {
            echo json_encode($keb_pem_array);
        }
        exit;
    }

    function getDataAfd(Request $request)
    {
        $pil_reg = $request->get('id_reg');
        $pil_est = $request->get('id_est');
        $takReq = $request->get('tak');
        $reg_all = Regional::all()->pluck('nama');
        $reg_all = json_decode($reg_all);

        // dd($pil_est);
        $reg = Regional::with("wilayah")->get();
        $reg_arr = array();
        foreach ($reg as $key => $value) {
            foreach ($value->wilayah as $key2 => $data) {
                $reg_arr[$key][$data->nama] =  Wilayah::with("estate")->find($data->id)->estate->pluck('nama', 'est');
            }
        }

        $est_wil_reg = array();
        foreach ($reg_arr as $key => $value) {
            foreach ($value as $key2 => $data) {
                foreach ($data as $key3 => $datas) {
                    $est_wil_reg[$key][$key3] = $datas;
                }
            }
        }

        $id_est = Estate::where('est', $pil_est)->first()->id;
        $queryEst = Estate::with("afdeling")->find($id_est);

        $list_afd_est = $queryEst->afdeling->pluck('nama');

        $afd_array = array();
        $keb_pem_array = array();
        $dateToday = Carbon::now()->format('Y-m-d');
        $tglData = $request->has('tgl') ? $request->input('tgl') : $defaultHari = $dateToday;

        $hariIni = $tglData . ' 00:00:00';

        dd($hariIni);
        $newConvert = new Carbon($hariIni);

        $besok = $newConvert->addDays();
        $besok = ($besok->format('Y-m-d')) . ' 00:00:00';

        $color_chart = array(
            '#001E3C', '#AB221D', '#5CAF50', '#7CAF50', '#8CAF50', '#AB221D', '#AB221D',
            '#AB221D', '#AB221D', '#AB221D', '#AB221D', '#AB221D', '#AB221D', '#AB221D', '#282C34'
        );

        $query = DB::connection('mysql2')->table('taksasi')
            ->select('taksasi.*')
            ->whereBetween('taksasi.waktu_upload', [$hariIni, $besok])
            ->where('lokasi_kerja', $queryEst->est)
            ->orderBy('taksasi.afdeling', 'asc')
            ->get();

        $list_afd_est = json_decode($list_afd_est);
        if ($query->first() != null) {
            $query = json_decode($query);
            foreach ($list_afd_est as $key => $value) {
                $sum_tak_afd = 0;
                $sum_keb_pemanen_afd = 0;
                foreach ($query as $key2 => $data) {
                    if ($data->afdeling == $value) {
                        $sum_tak_afd += $data->taksasi;
                        $sum_keb_pemanen_afd += $data->pemanen;
                    }
                }
                $afd_array[$value] = round($sum_tak_afd, 2);
                $keb_pem_array[$value] = $sum_keb_pemanen_afd;
            }
        }


        // dd($afd_array);
        // dd(json_encode($afd_array));
        if ($takReq == 1) {
            echo json_encode($afd_array);
        } else {
            echo json_encode($keb_pem_array);
        }
        exit;
    }

    public function ds_pemupukan(Request $request)
    {

        if ($request->ajax()) {
            $query = DB::connection('mysql2')->table('monitoring_pemupukan')
                ->select('monitoring_pemupukan.*', 'pupuk.nama as nama_pupuk')
                ->join('pupuk', 'monitoring_pemupukan.jenis_pupuk_id', '=', 'pupuk.id')
                ->orderBy('monitoring_pemupukan.waktu_upload', 'DESC')
                ->get();

            foreach ($query as $item) {
                $hari = Carbon::parse($item->waktu_upload)->locale('id');
                $hari->settings(['formatFunction' => 'translatedFormat']);
                $item->tanggal = $hari->format('j F Y');
            }


            // dd($query);
            $listEst = array();
            foreach ($query as $key => $value) {
                if (!in_array($value->estate, $listEst)) {
                    $listEst[] = $value->estate;
                }
            }

            $allEst = Estate::with("afdeling")->get();

            $listAfdEst = array();
            foreach ($allEst as $key => $value) {
                foreach ($listEst as $key2 => $value2) {
                    if ($value->est == $value2) {
                        foreach ($value->afdeling as $key => $value3) {
                            $listAfdEst[$value2][] = $value3->nama;
                        }
                    }
                }
            }
            // dd($listAfdEst);

            // dd($query[0]->estate);

            $arrValPerEstAfd = array();
            foreach ($listAfdEst as $key => $value) {
                foreach ($value as $key2 => $val) {
                    foreach ($query as $key3 => $value2) {
                        if ($val == $value2->afdeling && $key == $value2->estate) {
                            $arrValPerEstAfd[$key][$val][] = $value2;
                        }
                    }
                }
            }

            // dd($arrValPerEstAfd);
            $raw = array();
            $inc = 0;
            foreach ($arrValPerEstAfd as $key => $est) {
                foreach ($est as $key2 => $afd) {
                    // dd($afd);
                    foreach ($afd as $key3 => $data) {
                        $raw[$inc][$key2]['tanggal'] = $data->tanggal;
                        $raw[$inc][$key2]['estate'] = $key;
                        $raw[$inc][$key2]['afdeling'] = $key2;
                        $raw[$inc][$key2]['jenis_pupuk'] = $data->nama_pupuk;
                    }
                }
                $inc++;
            }

            $arrView = array();
            $inc = 0;
            foreach ($raw as $key => $value) {
                foreach ($value as $key2 => $val) {
                    $arrView[$inc] = $val;
                    $inc++;
                }
            }
            // dd($arrView);

            // $arrView = json_decode($arrView, true);
            return DataTables::of($arrView)
                ->editColumn('afdeling', function ($model) {
                    return '<a href="' . route('detail_pemupukan', ['estate' => $model['estate'], 'afdeling' => $model['afdeling']]) . '">  ' . $model['afdeling'] . '    </a>';
                })
                ->rawColumns(['afdeling'])
                ->editColumn('biSm1Rekom', function ($model) {
                    return '-';
                })
                ->editColumn('sbiSm1Rekom', function ($model) {
                    return '-';
                })
                ->editColumn('biSm2Rekom', function ($model) {
                    return '-';
                })
                ->editColumn('sbiSm2Rekom', function ($model) {
                    return '-';
                })
                ->editColumn('biSm1Apl', function ($model) {
                    return '-';
                })
                ->editColumn('sbiSm1Apl', function ($model) {
                    return '-';
                })
                ->editColumn('biSm2Apl', function ($model) {
                    return '-';
                })
                ->editColumn('sbiSm2Apl', function ($model) {
                    return '-';
                })
                ->editColumn('achieve', function ($model) {
                    return '-';
                })
                ->editColumn('varian', function ($model) {
                    return '-';
                })
                ->editColumn('annual', function ($model) {
                    return '-';
                })
                ->editColumn('kgpokok', function ($model) {
                    return '-';
                })
                ->addColumn('action', function ($model) {
                    return '<a href="" class="" >  <i class="nav-icon fa fa-eye" style="color:#1E6E42"></i>    </a>';
                })
                ->make(true);
        }

        return view('mon_pemupukan.dashboard');
    }

    public function detail_pemupukan(Request $request)
    {
        $estate = request()->route('estate');
        $afdeling = request()->route('afdeling');
        if ($request->ajax()) {
            $query = DB::connection('mysql2')->table('monitoring_pemupukan')
                ->select('monitoring_pemupukan.*', 'pupuk.nama as nama_pupuk')
                ->join('pupuk', 'monitoring_pemupukan.jenis_pupuk_id', '=', 'pupuk.id')
                ->where('monitoring_pemupukan.estate', $estate)
                ->where('monitoring_pemupukan.afdeling', $afdeling)
                ->orderBy('monitoring_pemupukan.waktu_upload', 'DESC')
                ->get();

            // dd($inc);
            foreach ($query as $item) {
                $hari = Carbon::parse($item->waktu_upload)->locale('id');
                $hari->settings(['formatFunction' => 'translatedFormat']);
                $item->tanggal = $hari->format('j F Y');

                //terpupuk
                $sub = substr($item->dipupuk, 1, -1);
                $formatted = explode(", ", $sub);
                $countDipupuk = 0;
                foreach ($formatted as $key => $value) {
                    if ($value == 1) {
                        $countDipupuk++;
                    }
                }

                //jenis pupuk
                $sub = substr($item->jenis_pupuk, 1, -1);
                $formatted = explode(", ", $sub);
                $countJenisPupuk = 0;
                foreach ($formatted as $key => $value) {
                    if ($value == 1) {
                        $countJenisPupuk++;
                    }
                }

                //lokasi pupuk
                $sub = substr($item->lokasi_pupuk, 1, -1);
                $formatted = explode(", ", $sub);
                $countLokasiPupuk = 0;
                foreach ($formatted as $key => $value) {
                    if ($value == 1) {
                        $countLokasiPupuk++;
                    }
                }

                //sebaran pupuk
                $sub = substr($item->sebar_pupuk, 1, -1);
                $formatted = explode(", ", $sub);
                $countSebarPupuk = 0;
                foreach ($formatted as $key => $value) {
                    if ($value == 1) {
                        $countSebarPupuk++;
                    }
                }

                $item->terpupuk = $countDipupuk;
                $item->tersebar = $countSebarPupuk;
                $item->terlokasi = $countLokasiPupuk;
                $item->kesesuaian_jenis = $countJenisPupuk;
            }

            $query = json_decode($query, true);
            // dd($query);
            return DataTables::of($query)
                ->editColumn('terpupuk', function ($model) {
                    return $model['terpupuk'] . ' / ' . $model['jumlah_pokok'];
                })
                ->editColumn('kesesuaian_jenis', function ($model) {
                    return $model['kesesuaian_jenis'] . ' / ' . $model['jumlah_pokok'];
                })
                ->editColumn('terlokasi', function ($model) {
                    return $model['terlokasi'] . ' / ' . $model['jumlah_pokok'];
                })
                ->editColumn('tersebar', function ($model) {
                    return $model['tersebar'] . ' / ' . $model['jumlah_pokok'];
                })
                ->addColumn('action', function ($model) {
                    return '<a href="" class="" >  <i class="nav-icon fa fa-eye" style="color:#1E6E42"></i>    </a>';
                })
                ->make(true);
        }
        return view('mon_pemupukan.detail', ['est' => $estate, 'afd' => $afdeling]);
    }
}
