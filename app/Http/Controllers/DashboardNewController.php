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
        $idReg = $request->get('id_reg');
        $reg_all = Regional::all()->toArray();

        $queryListWil = Wilayah::select('nama')
            ->where('regional', $reg_all[$idReg]['id'])
            ->pluck('nama');

        $queryListWilId = Wilayah::select('id')
            ->where('regional', $reg_all[$idReg]['id'])
            ->pluck('id');


        $queryListEstate = Estate::whereIn('wil', $queryListWilId)
            ->where(function ($query) {
                $query->where(DB::raw('LOWER(nama)'), 'NOT LIKE', '%mill%')
                    ->where(DB::raw('LOWER(est)'), 'NOT LIKE', '%plasma%')
                    ->where(DB::raw('LOWER(est)'), 'NOT LIKE', '%cws1%')
                    ->where(DB::raw('LOWER(est)'), 'NOT LIKE', '%cws2%')
                    ->where(DB::raw('LOWER(est)'), 'NOT LIKE', '%cws3%')
                    ->where(DB::raw('LOWER(est)'), 'NOT LIKE', '%reg%')
                    ->where(DB::raw('LOWER(est)'), 'NOT LIKE', '%srs%')
                    ->where(DB::raw('LOWER(est)'), 'NOT LIKE', '%sr%')
                    ->where(DB::raw('LOWER(est)'), 'NOT LIKE', '%tc%');
            })
            ->pluck('est', 'nama')
            ->toArray();

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
            ->where('reg.nama', $reg_all[$idReg]['id'])
            ->get()
            ->groupBy('nama_regional');

        $queryByDateWilayah = DB::connection('mysql2')->table('taksasi')
            ->select('taksasi.*',  'wil.nama as nama_wilayah')
            ->join('estate', 'taksasi.lokasi_kerja', '=', 'estate.est')
            ->join('wil', 'estate.wil', '=', 'wil.id')
            ->whereBetween('taksasi.waktu_upload', [$firstData, $lastData])
            ->whereIn('wil.nama', $queryListWil)
            ->get()
            ->groupBy('nama_wilayah');



        $queryByDateEstate = DB::connection('mysql2')->table('taksasi')
            ->select('taksasi.*',  'wil.nama as nama_wilayah')
            ->join('estate', 'taksasi.lokasi_kerja', '=', 'estate.est')
            ->join('wil', 'estate.wil', '=', 'wil.id')
            ->whereBetween('taksasi.waktu_upload', [$firstData, $lastData])
            ->whereIn('taksasi.lokasi_kerja', $queryListEstate)
            ->get()
            ->groupBy('lokasi_kerja');


        $dataFinalRegional = [];
        $dataFinalRegional[$reg_all[$idReg]['nama']] = [
            'regional' => $reg_all[$idReg]['nama'],
            'luas' => "-",
            'jumlahBlok' => "-",
            'ritase' => "-",
            'akp' => "-",
            'taksasi' => "-",
            'keb_pemanen' => "-"
        ];

        $dataFinalWilayah = [];
        foreach ($queryListWil as $key => $value) {
            // Initialize with default values
            $dataFinalWilayah[$value] = [
                'wilayah' => $value,
                'luas' => "-",
                'jumlahBlok' => "-",
                'ritase' => "-",
                'akp' => "-",
                'taksasi' => "-",
                'keb_pemanen' => "-"
            ];
        }

        $dataFinalEstate = [];
        foreach ($queryListEstate as $key => $nama) {
            $dataFinalEstate[$nama] = [
                'estate' => $nama,
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

            $dataFinalRegional[$key]['luas'] = round($luasTotal, 2);
            $dataFinalRegional[$key]['jumlahBlok'] = $jumlahBlok;
            $dataFinalRegional[$key]['ritase'] = ceil($tak / 6500);
            $dataFinalRegional[$key]['akp'] = $akp;
            $dataFinalRegional[$key]['taksasi'] = $tak;
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

            $dataFinalWilayah[$key]['luas'] = round($luasTotal, 2);
            $dataFinalWilayah[$key]['jumlahBlok'] = $jumlahBlok;
            $dataFinalWilayah[$key]['ritase'] = ceil($tak / 6500);
            $dataFinalWilayah[$key]['akp'] = $akp;
            $dataFinalWilayah[$key]['taksasi'] = $tak;
            $dataFinalWilayah[$key]['keb_pemanen'] = $pemanen;
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

        $result['data_reg'] = $dataFinalRegional;
        $result['data_wil'] = $dataFinalWilayah;
        $result['data_est'] = $dataFinalEstate;

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
