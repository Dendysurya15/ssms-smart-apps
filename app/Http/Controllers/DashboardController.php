<?php

namespace App\Http\Controllers;

use App\Models\Afdeling;
use App\Models\Estate;
use App\Models\Regional;
use App\Models\Wilayah;
use Carbon\Carbon;
use DateInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class DashboardController extends Controller
{
    //
    public function ds_taksasi(Request $request)
    {
        // $reg_all = Regional::all()->pluck('nama');
        // $reg = Estate::with("afdeling")->find(3)->afdeling;
        // $reg_all = json_decode($reg_all);

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

        $hariIni = $tglData . ' 00:00:00';

        $newConvert = new Carbon($hariIni);

        $besok = $newConvert->addDays();
        $besok = ($besok->format('Y-m-d')) . ' 00:00:00';

        $color_chart = array(
            '#001E3C', '#AB221D', '#5CAF50', '#7CAF50', '#8CAF50', '#AB221D', '#AB221D',
            '#AB221D', '#AB221D', '#AB221D', '#AB221D', '#AB221D', '#AB221D', '#AB221D', '#282C34'
        );
        // $estate_regional_1 = array(
        //     'KDE' => 'Kondang',
        //     'BKE' => 'Batu Kotam',
        //     'SGE' => 'Selangkun',
        //     'RGE' => 'Rungun',
        //     'RDE' => 'Rangda',
        //     'PLE' => 'Pulau',
        //     'NBE' => 'Natai Baru',
        //     'SLE' => 'Sulung',
        //     'KNE' => 'Kenambui',
        //     'SYE' => 'Suayap',
        //     'UPY' => 'Umpang',
        //     'BGE' => 'Bengaris',
        //     'LDE' => 'LADA',
        //     'SRE' => 'Sungai Rangit',
        //     'SKE' => 'Simpang Kadipi',
        // );

        $afdeling = array('OA', 'OB', 'OC', 'OD', 'OF', 'OA');

        $query = DB::connection('mysql2')->table('taksasi')
            ->select('taksasi.*')
            ->whereBetween('taksasi.waktu_upload', [$hariIni, $besok])
            ->orderBy('taksasi.afdeling', 'asc')
            ->get();




        // dd($est_wil_reg[$pil_reg]);d

        if ($query->first() != null) {
            $query = json_decode($query);
            $inc = 0;

            // DD($query[1]->taksasi);
            foreach ($est_wil_reg[$pil_reg] as $key => $value) {
                $sum_tak_est = 0;
                $sum_keb_pemanen_est = 0;
                foreach ($query as $data) {
                    if ($data->lokasi_kerja == $value) {
                        $sum_tak_est += $data->taksasi;
                        $sum_keb_pemanen_est += $data->pemanen;
                    }
                }
                $est_array[$key]['est'] = $key;
                $est_array[$key]['taksasi'] = $sum_tak_est;
                $est_array[$key]['kebutuhan_pemanen'] = $sum_keb_pemanen_est;
                $inc++;
            }

            foreach ($est_array as $key => $value) {
                $est        = $value['est'];
                $log_tak_est .=
                    "[{v:'" . $est . "'}, {v:" . $value['taksasi'] . ", f:'" .  number_format($value['taksasi'], 0, ".", ".")  . " Kg'},                             
            ],";
                $log_keb_pemanen_est .=
                    "[{v:'" . $est . "'}, {v:" . $value['kebutuhan_pemanen'] . ", f:'" .  $value['kebutuhan_pemanen']  . " Orang'},                             
        ],";
            }
        }

        $est = [
            'data_taksasi_est'      => $log_tak_est,
            'data_kebutuhan_pemanen_est'      => $log_keb_pemanen_est,
        ];

        return view('dashboard.estate', [
            'est' => $est,
            'reg' => $reg_all,
        ]);
    }


    public function ds_taksasi_afdeling(Request $request)
    {
        $pil_est = $request;

        $reg_all = Regional::all()->pluck('nama');
        // $reg = Estate::with("afdeling")->find(3)->afdeling;
        $reg_all = json_decode($reg_all);
        // dd($reg[0]);
        $wil_reg = array();
        $wil_reg1 = null;


        // $reg
        // // dd($wil_reg1);
        $reg = Regional::with("wilayah")->get();
        // dd($reg[0]->wilayah);
        $reg_arr = array();
        // dd($reg);

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
        // dd($est_wil_reg);
        // dd($wil_reg);
        // dd($reg_arr);
        // $est_reg1[] =

        //estate default id 3 yaitu RDE 
        $afd_req = 3;
        $queryEst = Estate::with("afdeling")->find($afd_req);
        $list_afd_est = $queryEst->afdeling->pluck('nama');

        // dd($test);
        $afd_array = array();
        $log_tak_est = '';
        $log_keb_pemanen_est = '';
        $log_tak_afd = '';
        $log_keb_pemanen_afd = '';
        $afd = '';
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
            ->where('lokasi_kerja', $queryEst->nama)
            ->orderBy('taksasi.afdeling', 'asc')
            ->get();

        $sum_tak_est = 0;
        $sum_keb_pemanen_est = 0;
        $list_afd_est = json_decode($list_afd_est);

        if ($query->first() != null) {
            $query = json_decode($query);
            // dd($list_afd_array);
            foreach ($list_afd_est as $key => $value) {
                $sum_tak_afd = 0;
                $sum_keb_pemanen_afd = 0;
                // dd($value);
                foreach ($query as $key2 => $data) {
                    if ($data->afdeling == $value) {
                        $sum_tak_afd += $data->taksasi;
                        $sum_keb_pemanen_afd += $data->pemanen;
                    } else {
                        $sum_tak_afd = 0;
                        $sum_keb_pemanen_afd = 0;
                    }
                }
                $afd_array[$key]['afd'] = $value;
                $afd_array[$key]['taksasi'] = $sum_tak_afd;
                $afd_array[$key]['taksasi'] = $sum_tak_afd;
                $afd_array[$key]['kebutuhan_pemanen'] = $sum_keb_pemanen_afd;
            }

            // dd($afd_array);
            foreach ($afd_array as $key => $value) {
                $afd        = $value['afd'];
                $log_tak_afd .=
                    "[{v:'" . $afd . "'}, {v:" . $value['taksasi'] . ", f:'" .  number_format($value['taksasi'], 0, ".", ".")  . " Kg'},                             
            ],";
                $log_keb_pemanen_afd .=
                    "[{v:'" . $afd . "'}, {v:" . $value['kebutuhan_pemanen'] . ", f:'" .  $value['kebutuhan_pemanen']  . " Orang'},                             
        ],";
            }
        }

        // dd($list_afd_est);
        $afd = [
            'data_taksasi_afd'      => $log_tak_afd,
            'data_kebutuhan_pemanen_afd'      => $log_keb_pemanen_afd,
        ];


        $estate_regional_2 = array('Pedongatan', 'Nangakiu', 'Sepondam', 'Merambang', 'Batu Tunggal', 'Nanua', 'Malata', 'Sungai Bulik', 'Sumber Cahaya');
        $estate_regional_3 = array('Kanamit', 'Badirih', 'Behaur', 'Maliku', 'Pangkoh', 'Basarang', 'Gedabung', 'Betawi');

        return view('dashboard.afdeling', [
            // 'estate_1' => $estate_regional_1,
            'afd' => $afd,
            'reg' => $reg_all,
        ]);
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
                    if ($data->lokasi_kerja == $value) {
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

        // dd($list_afd_est);
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
            ->where('lokasi_kerja', $queryEst->nama)
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
                $afd_array[$value] = $sum_tak_afd;
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
}
