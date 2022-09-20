<?php

namespace App\Http\Controllers;

use App\Models\Afdeling;
use App\Models\Estate;
use App\Models\Regional;
use App\Models\Wilayah;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

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

        $est_array = array();
        $log_tak_est = '';
        $log_keb_pemanen_est = '';
        $est = '';
        $dateToday = Carbon::now()->format('Y-m-d');
        $tglData = $request->has('tgl') ? $request->input('tgl') : $defaultHari = $dateToday;

        $hariIni =  $tglData . ' 00:00:00';

        // dd($hariIni);
        $newConvert = new Carbon($hariIni);

        $besok = $newConvert->addDays();
        $besok = $besok->format('Y-m-d') . ' 00:00:00';

        $color_chart = array(
            '#001E3C', '#AB221D', '#5CAF50', '#7CAF50', '#8CAF50', '#AB221D', '#AB221D',
            '#AB221D', '#AB221D', '#AB221D', '#AB221D', '#AB221D', '#AB221D', '#AB221D', '#282C34'
        );

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
                $est_array[$key]['est'] = $key;
                $est_array[$key]['estate'] = $value;
                $est_array[$key]['taksasi'] = number_format($sum_tak_est, 0, ".", ".");
                $est_array[$key]['kebutuhan_pemanen'] = $sum_keb_pemanen_est;
                $inc++;
            }
        }

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

        // dd($list_afd_est);
        $afd_array = array();
        $keb_pem_array = array();



        $query = DB::connection('mysql2')->table('taksasi')
            ->select('taksasi.*')
            ->whereBetween('taksasi.waktu_upload', [$hariIni, $besok])
            ->where('lokasi_kerja', $queryEst->nama)
            ->orderBy('taksasi.afdeling', 'asc')
            ->get();


        foreach ($list_afd_est as $key => $value) {
            $afd_array[$key]['afd'] = $value;
            $afd_array[$key]['taksasi'] = 0;
            $afd_array[$key]['kebutuhan_pemanen'] = 0;
        }

        // dd($afd_array);
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
                $afd_array[$key]['afd'] = $value;
                $afd_array[$key]['taksasi'] = number_format($sum_tak_afd, 0, ".", ".");;
                $afd_array[$key]['kebutuhan_pemanen'] = $sum_keb_pemanen_afd;
            }
        }

        return view('homepage', [
            'date' => $getDate->format('l, j F Y'),
            'hour' =>  Carbon::now()->format('H:i:s'),
            'dataEstate' => $est_array ? $est_array['RDE'] : '', // default RDE 
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

    public function ds_pemupukan()
    {
        $query = DB::connection('mysql2')->table('monitoring_pemupukan')
            ->select('monitoring_pemupukan.*', 'pupuk.nama as nama_pupuk')
            ->join('pupuk', 'monitoring_pemupukan.jenis_pupuk_id', '=', 'pupuk.id')
            ->orderBy('monitoring_pemupukan.waktu_upload', 'DESC')
            ->get();

        // dd($query);
        foreach ($query as $item) {
            $hari = Carbon::parse($item->waktu_upload)->locale('id');
            $hari->settings(['formatFunction' => 'translatedFormat']);
            $item->tanggal = $hari->format('j F Y');
            $item->tanggal = $hari->format('j F Y');
        }
        return view('mon_pemupukan.dashboard', ['collection' => $query]);
    }
}
