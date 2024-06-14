<?php

namespace App\Http\Controllers;

use App\Models\Estate;
use App\Models\Regional;
use App\Models\Wilayah;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardNewController extends Controller
{
    //

    public function getAllDataRegionalWilayah(Request $request)
    {
        $tglData = $request->get('tgl_request');

        $queryListReg = Regional::select('nama')
            ->where('nama', '!=', 'Regional V')
            ->pluck('nama');

        $queryListWil = Wilayah::select('nama')
            ->pluck('nama');

        $first = $tglData . ' 00:00:00';
        $last = $tglData . ' 23:59:59';
        $firstData = new Carbon($first);
        $lastData = new Carbon($last);

        $queryByDateRegional = DB::connection('mysql2')->table('taksasi')
            ->select('taksasi.*', 'estate.wil', 'wil.regional', "reg.nama as nama_regional")
            ->join('estate', 'taksasi.lokasi_kerja', '=', 'estate.est')
            ->join('wil', 'estate.wil', '=', 'wil.id')
            ->join('reg', 'wil.regional', '=', 'reg.id')
            ->whereBetween('taksasi.waktu_upload', [$firstData, $lastData])
            ->where('reg.nama', '!=', 'Regional V')
            ->get()
            ->groupBy('nama_regional');

        $queryByDateWilayah = DB::connection('mysql2')->table('taksasi')
            ->select('taksasi.*',  'wil.nama as nama_wilayah')
            ->join('estate', 'taksasi.lokasi_kerja', '=', 'estate.est')
            ->join('wil', 'estate.wil', '=', 'wil.id')
            ->whereBetween('taksasi.waktu_upload', [$firstData, $lastData])
            ->get()
            ->groupBy('nama_wilayah');


        $dataFinalRegional = [];

        foreach ($queryListReg as $reg => $regName) {
            // Initialize with default values
            $dataFinalRegional[$regName] = [
                'regional' => $regName,
                'luas' => "-",
                'jumlahBlok' => "-",
                'ritase' => "-",
                'akp' => "-",
                'taksasi' => "-",
                'keb_pemanen' => "-"
            ];
        }

        $dataFinalWilayah = [];
        foreach ($queryListWil as $key => $nama) {
            // Initialize with default values
            $dataFinalWilayah[$nama] = [
                'wilayah' => $nama,
                'luas' => "-",
                'jumlahBlok' => "-",
                'ritase' => "-",
                'akp' => "-",
                'taksasi' => "-",
                'keb_pemanen' => "-"
            ];
        }

        foreach ($queryByDateRegional as $key => $value) {
            $jumlahBlok = 0;
            $luasTotal = 0;
            $jum_pokok = 0;
            $jum_janjang = 0;
            $jum_sph = 0;
            $jum_bjr = 0;
            $pemanen = 0;

            foreach ($value as $key2 => $value2) {
                $luasTotal += $value2->luas;
                $jum_sph += $value2->sph;
                $jum_bjr += $value2->bjr;
                $jum_pokok += $value2->jumlah_pokok;
                $jum_janjang += $value2->jumlah_janjang;
                $pemanen += $value2->pemanen;
                $jumlahBlok += 1;
            }

            $rerata_sph = round($jum_sph / $jumlahBlok);
            $rerata_bjr = round($jum_bjr / $jumlahBlok);
            $akp = round(($jum_janjang / $jum_pokok) * 100, 2);
            $tak =  round(($akp * $luasTotal * $rerata_bjr * $rerata_sph) / 100, 1);

            $dataFinalRegional[$key]['luas'] = number_format(round($luasTotal, 2), 1, ',', '.');
            $dataFinalRegional[$key]['jumlahBlok'] = $jumlahBlok;
            $dataFinalRegional[$key]['ritase'] = ceil($tak / 6500);
            $dataFinalRegional[$key]['akp'] = $akp;
            $dataFinalRegional[$key]['taksasi'] = number_format($tak, 1, ',', '.');
            $dataFinalRegional[$key]['keb_pemanen'] = $pemanen;
        }


        foreach ($queryByDateWilayah as $key => $value) {
            $jumlahBlok = 0;
            $luasTotal = 0;
            $jum_pokok = 0;
            $jum_janjang = 0;
            $jum_sph = 0;
            $jum_bjr = 0;
            $pemanen = 0;

            foreach ($value as $key2 => $value2) {
                $luasTotal += $value2->luas;
                $jum_sph += $value2->sph;
                $jum_bjr += $value2->bjr;
                $jum_pokok += $value2->jumlah_pokok;
                $jum_janjang += $value2->jumlah_janjang;
                $pemanen += $value2->pemanen;
                $jumlahBlok += 1;
            }

            $rerata_sph = round($jum_sph / $jumlahBlok);
            $rerata_bjr = round($jum_bjr / $jumlahBlok);
            $akp = round(($jum_janjang / $jum_pokok) * 100, 2);
            $tak =  round(($akp * $luasTotal * $rerata_bjr * $rerata_sph) / 100, 1);

            $dataFinalWilayah[$key]['luas'] = number_format(round($luasTotal, 2), 1, ',', '.');
            $dataFinalWilayah[$key]['jumlahBlok'] = $jumlahBlok;
            $dataFinalWilayah[$key]['ritase'] = ceil($tak / 6500);
            $dataFinalWilayah[$key]['akp'] = $akp;
            $dataFinalWilayah[$key]['taksasi'] = number_format($tak, 1, ',', '.');
            $dataFinalWilayah[$key]['keb_pemanen'] = $pemanen;
        }


        $result['data_reg'] = $dataFinalRegional;
        $result['data_wil'] = $dataFinalWilayah;

        echo json_encode($result);
        exit;
    }


    public function getAllDataEstate(Request $request)
    {
        $tglData = $request->get('tgl_request');
        $estate = $request->get('estate_request');

        $first = $tglData . ' 00:00:00';
        $last = $tglData . ' 23:59:59';
        $firstData = new Carbon($first);
        $lastData = new Carbon($last);

        $queryListAfdeling = Estate::where('est', $estate)
            ->join('afdeling', 'estate.id', '=', 'afdeling.estate')
            ->pluck('afdeling.nama')->toArray();

        $queryByDateEstate = DB::connection('mysql2')->table('taksasi')
            ->select('taksasi.*', 'estate.wil')
            ->join('estate', 'taksasi.lokasi_kerja', '=', 'estate.est')
            ->whereBetween('taksasi.waktu_upload', [$firstData, $lastData])
            ->where('taksasi.lokasi_kerja', $estate)
            ->get()
            ->groupBy('afdeling');

        $dataFinalEstate = [];

        foreach ($queryListAfdeling as $key => $nama) {
            // Initialize with default values
            $dataFinalEstate[$nama] = [
                'afdeling' => $nama,
                'luas' => "-",
                'jumlahBlok' => "-",
                'ritase' => "-",
                'akp' => "-",
                'taksasi' => "-",
                'keb_pemanen' => "-"
            ];
        }

        foreach ($queryByDateEstate as $key => $value) {
            $jumlahBlok = 0;
            $luasTotal = 0;
            $jum_pokok = 0;
            $jum_janjang = 0;
            $jum_sph = 0;
            $jum_bjr = 0;
            $pemanen = 0;

            foreach ($value as $key2 => $value2) {
                $luasTotal += $value2->luas;
                $jum_sph += $value2->sph;
                $jum_bjr += $value2->bjr;
                $jum_pokok += $value2->jumlah_pokok;
                $jum_janjang += $value2->jumlah_janjang;
                $pemanen += $value2->pemanen;
                $jumlahBlok += 1;
            }

            $rerata_sph = round($jum_sph / $jumlahBlok);
            $rerata_bjr = round($jum_bjr / $jumlahBlok);
            $akp = round(($jum_janjang / $jum_pokok) * 100, 2);
            $tak =  round(($akp * $luasTotal * $rerata_bjr * $rerata_sph) / 100, 1);

            $dataFinalEstate[$key]['luas'] = round($luasTotal, 2);
            $dataFinalEstate[$key]['jumlahBlok'] = $jumlahBlok;
            $dataFinalEstate[$key]['ritase'] = ceil($tak / 6500);
            $dataFinalEstate[$key]['akp'] = $akp;
            $dataFinalEstate[$key]['taksasi'] = $tak;
            $dataFinalEstate[$key]['keb_pemanen'] = $pemanen;
        }

        $result['data_estate'] = $dataFinalEstate;

        echo json_encode($result);
        exit;
    }
}
