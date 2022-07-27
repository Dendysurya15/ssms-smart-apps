<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DateInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function ds_taksasi(Request $request)
    {

        $est_array = array();
        $log_tak_est = '';
        $log_keb_pemanen_est = '';
        $log_tak_afd = '';
        $log_keb_pemanen_afd = '';
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
        $estate_regional_1 = array(
            'KDE' => 'Kondang',
            'BKE' => 'Batu Kotam',
            'SGE' => 'Selangkun',
            'RGE' => 'Rungun',
            'RDE' => 'Rangda',
            'PLE' => 'Pulau',
            'NBE' => 'Natai Baru',
            'SLE' => 'Sulung',
            'KNE' => 'Kenambui',
            'SYE' => 'Suayap',
            'UPY' => 'Umpang',
            'BGE' => 'Bengaris',
            'LDE' => 'LADA',
            'SRE' => 'Sungai Rangit',
            'SKE' => 'Simpang Kadipi',
        );

        $afdeling = array('OA', 'OB', 'OC', 'OD', 'OF', 'OA');

        $query = DB::connection('mysql2')->table('taksasi')
            ->select('taksasi.*')
            ->whereBetween('taksasi.waktu_upload', [$hariIni, $besok])
            ->orderBy('taksasi.afdeling', 'asc')
            ->get();
        // dd($query);

        $sum_tak_est = 0;
        $sum_keb_pemanen_est = 0;
        // dd($query);

        if ($query->first() != null) {
            $query = json_decode($query);
            foreach ($estate_regional_1 as $key => $value) {
                foreach ($query as $data) {
                    if ($data->lokasi_kerja == $value) {
                        $sum_tak_est += $data->taksasi;
                        $sum_keb_pemanen_est += $data->pemanen;
                    } else {
                        $sum_tak_est = 0;
                        $sum_keb_pemanen_est = 0;
                    }
                }
                $est_array[$key]['est'] = $key;
                $est_array[$key]['taksasi'] = $sum_tak_est;
                $est_array[$key]['kebutuhan_pemanen'] = $sum_keb_pemanen_est;
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



        $estate_regional_2 = array('Pedongatan', 'Nangakiu', 'Sepondam', 'Merambang', 'Batu Tunggal', 'Nanua', 'Malata', 'Sungai Bulik', 'Sumber Cahaya');
        $estate_regional_3 = array('Kanamit', 'Badirih', 'Behaur', 'Maliku', 'Pangkoh', 'Basarang', 'Gedabung', 'Betawi');

        return view('dashboard.estate', [
            'estate_1' => $estate_regional_1,
            'est' => $est,

        ]);
    }


    public function ds_taksasi_afdeling(Request $request)
    {

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
        $estate_regional_1 = array(
            'KDE' => 'Kondang',
            'BKE' => 'Batu Kotam',
            'SGE' => 'Selangkun',
            'RGE' => 'Rungun',
            'RDE' => 'Rangda',
            'PLE' => 'Pulau',
            'NBE' => 'Natai Baru',
            'SLE' => 'Sulung',
            'KNE' => 'Kenambui',
            'SYE' => 'Suayap',
            'UPY' => 'Umpang',
            'BGE' => 'Bengaris',
            'LDE' => 'LADA',
            'SRE' => 'Sungai Rangit',
            'SKE' => 'Simpang Kadipi',
        );

        $afdeling = array('OA', 'OB', 'OC', 'OD', 'OF', 'OA');

        $query = DB::connection('mysql2')->table('taksasi')
            ->select('taksasi.*')
            ->whereBetween('taksasi.waktu_upload', [$hariIni, $besok])
            ->orderBy('taksasi.afdeling', 'asc')
            ->get();
        // dd($query);

        $sum_tak_est = 0;
        $sum_keb_pemanen_est = 0;
        // dd($query);

        $list_afd_array = array();
        if ($query->first() != null) {
            $query = json_decode($query);
            foreach ($estate_regional_1 as $key => $value) {
                foreach ($query as $data) {
                    if (!in_array($data->afdeling, $list_afd_array)) {
                        array_push($list_afd_array, $data->afdeling);
                    }
                }
            }

            foreach ($list_afd_array as $key => $value) {
                $sum_tak_afd = 0;
                $sum_keb_pemanen_afd = 0;
                foreach ($query as $key2 => $data) {
                    if ($data->afdeling == $value) {
                        $sum_tak_afd += $data->taksasi;
                        $sum_keb_pemanen_afd += $data->pemanen;
                    }
                }
                $afd_array[$key]['afd'] = $value;
                $afd_array[$key]['taksasi'] = $sum_tak_afd;
                $afd_array[$key]['taksasi'] = $sum_tak_afd;
                $afd_array[$key]['kebutuhan_pemanen'] = $sum_keb_pemanen_afd;
            }

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

        $afd = [
            'data_taksasi_afd'      => $log_tak_afd,
            'data_kebutuhan_pemanen_afd'      => $log_keb_pemanen_afd,
        ];


        $estate_regional_2 = array('Pedongatan', 'Nangakiu', 'Sepondam', 'Merambang', 'Batu Tunggal', 'Nanua', 'Malata', 'Sungai Bulik', 'Sumber Cahaya');
        $estate_regional_3 = array('Kanamit', 'Badirih', 'Behaur', 'Maliku', 'Pangkoh', 'Basarang', 'Gedabung', 'Betawi');

        return view('dashboard.afdeling', [
            'estate_1' => $estate_regional_1,
            'afd' => $afd,
        ]);
    }
}
