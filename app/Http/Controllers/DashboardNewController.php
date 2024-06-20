<?php

namespace App\Http\Controllers;

use App\Imports\RealisasiTaksasiImport;
use App\Models\Afdeling;
use App\Models\Estate;
use App\Models\Regional;
use App\Models\Wilayah;
use App\Services\DataServiceImportRealisasi;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;

class DashboardNewController extends Controller
{


    protected $dataService;

    public function __construct(DataServiceImportRealisasi $dataService)
    {
        $this->dataService = $dataService;
    }

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
            ->where('reg.nama', $reg_all[$idReg]['nama'])
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
            $processedBlokYgSama = [];
            foreach ($value as $key2 => $value2) {
                // if (!in_array($value2->blok, $processedBlokYgSama)) {
                $luasTotal += $value2->luas;
                //     $processedBlokYgSama[] = $value2->blok;
                // }
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



    public function getDataRealisasiTaksasi(Request $request)
    {

        $bulan = $request->get('bulan_request');


        $startDate = (new DateTime($bulan . '-01'));
        $endDate = (new DateTime($bulan . '-01'));
        $endDate->modify('last day of this month');

        $startDateString = $startDate->format('Y-m-d');
        $endDateString = $endDate->format('Y-m-d');

        // dd($data);
        $id_reg = $request->get('id_reg');

        $reg_all = Regional::where('nama', '!=', 'Regional V')->get()->toArray();

        $id_reg = $reg_all[$id_reg]['id'];

        $wil_id = Wilayah::where('regional', $id_reg)->pluck('id')->toArray();

        $query = Afdeling::select('afdeling.nama as nama_afdeling', 'estate.est as nama_est', 'wil.id as nama_wil')
            ->join('estate', 'afdeling.estate', 'estate.id')
            ->join('wil', 'estate.wil', 'wil.id')->where(function ($query) {
                $query->where(DB::raw('LOWER(estate.nama)'), 'NOT LIKE', '%mill%')
                    ->where(DB::raw('LOWER(estate.est)'), 'NOT LIKE', '%plasma%')
                    ->where(DB::raw('LOWER(estate.est)'), 'NOT LIKE', '%cws1%')
                    ->where(DB::raw('LOWER(estate.est)'), 'NOT LIKE', '%cws2%')
                    ->where(DB::raw('LOWER(estate.est)'), 'NOT LIKE', '%cws3%')
                    ->where(DB::raw('LOWER(estate.est)'), 'NOT LIKE', '%reg%')
                    ->where(DB::raw('LOWER(estate.est)'), 'NOT LIKE', '%srs%')
                    ->where(DB::raw('LOWER(estate.est)'), 'NOT LIKE', '%sr%')
                    ->where(DB::raw('LOWER(estate.est)'), 'NOT LIKE', '%tc%');
            })
            ->whereIn('estate.wil', $wil_id)->get()
            ->groupBy('nama_est')
            ->toArray();

        $result = [];

        $listEstate = [];
        foreach ($query as $nama_est => $afdelingArray) {
            foreach ($afdelingArray as $index => $afdeling) {
                $result[$nama_est][$index] = $afdeling['nama_afdeling'];
            }

            $listEstate[] = $nama_est;
        }


        $queryDataRealisasi = DB::connection('mysql2')->table('realisasi_taksasi')
            ->select('*')
            ->whereBetween('tanggal_realisasi', [$startDateString, $endDateString])
            ->whereIn('est', $listEstate)
            ->get()
            ->toArray();

        $realisasiMap = [];
        foreach ($queryDataRealisasi as $item) {
            $key = $item->est . '-' . $item->afd . '-' . $item->tanggal_realisasi;
            $realisasiMap[$key] = $item;
        }

        $queryDataTaksasi = DB::connection('mysql2')->table('taksasi')
            ->select('*')
            ->whereBetween('waktu_upload', [$startDateString, $endDateString])
            ->whereIn('lokasi_kerja', $listEstate)
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->waktu_upload)->format('Y-m-d');
            })
            ->map(function ($dayGroup) {
                return $dayGroup->groupBy('lokasi_kerja')
                    ->map(function ($lokasiGroup) {
                        // Sort afdeling keys alphabetically
                        $sortedAfdelingGroups = $lokasiGroup->groupBy('afdeling')
                            ->sortBy(function ($items, $key) {
                                return $key; // Sort alphabetically by afdeling key
                            });

                        return $sortedAfdelingGroups->map(function ($afdelingGroup) {
                            return $afdelingGroup->groupBy('blok');
                        });
                    });
            })
            ->toArray();

        $dataRawTaksasi = [];
        foreach ($queryDataTaksasi as $key => $value) {



            foreach ($value as $key2 => $value2) {
                foreach ($value2 as $key3 => $blokArr) {
                    $sum_luas = 0;
                    $sum_sph = 0;
                    $sum_bjr = 0;
                    $sum_janjang = 0;
                    $sum_pokok = 0;
                    $keb_pemanen = 0;

                    $inc = 0;
                    foreach ($blokArr as $key4 => $value3) {
                        if (count($value3) > 1) {
                            $sum_luas += $value3[0]->luas;
                            $sum_bjr += $value3[0]->bjr;
                            $sum_sph += $value3[0]->sph;
                            $inc++;
                        } else {
                            $sum_luas += $value3[0]->luas;
                            $sum_bjr += $value3[0]->bjr;
                            $sum_sph += $value3[0]->sph;
                            $inc++;
                        }

                        foreach ($value3 as $key5 => $value4) {
                            $sum_janjang += $value4->jumlah_janjang;
                            $sum_pokok += $value4->jumlah_pokok;
                            $keb_pemanen += $value4->pemanen;
                        }
                    }



                    $final_sph = round($sum_sph / $inc);
                    $final_bjr = round($sum_bjr / $inc);
                    $akp = round($sum_janjang / $sum_pokok, 2) * 100;
                    $tak = round(($akp * $sum_luas * $final_sph * $final_bjr) / 100, 2);
                    $formatted_tak = number_format($tak, 2, ',', '.');

                    $dataRawTaksasi[$key][$key2][$key3]['ha_panen_taksasi'] = $sum_luas;
                    $dataRawTaksasi[$key][$key2][$key3]['luas'] = $sum_luas;
                    $dataRawTaksasi[$key][$key2][$key3]['bjr'] = $final_bjr;
                    $dataRawTaksasi[$key][$key2][$key3]['sph'] = $final_sph;
                    $dataRawTaksasi[$key][$key2][$key3]['akp_taksasi'] = $akp;
                    $dataRawTaksasi[$key][$key2][$key3]['tonase_taksasi'] = $tak;
                    $dataRawTaksasi[$key][$key2][$key3]['keb_hk_taksasi'] = $keb_pemanen;
                }
            }
        }


        // dd($dataRawTaksasi);
        $dataRaw = [];

        while ($startDate <= $endDate) {
            $dateString = $startDate->format('Y-m-d');
            foreach ($result as $nama_est => $afdelings) {

                $inc = 0;
                foreach ($afdelings as $afdeling) {
                    $key = $nama_est . '-' . $afdeling . '-' . $dateString . ' 00:00:00';


                    $ha_panen_taksasi = isset($dataRawTaksasi[$dateString][$nama_est][$afdeling]['ha_panen_taksasi']) ? number_format($dataRawTaksasi[$dateString][$nama_est][$afdeling]['ha_panen_taksasi'], 2, '.', '') : '-';
                    $akp_taksasi = isset($dataRawTaksasi[$dateString][$nama_est][$afdeling]['akp_taksasi']) ? number_format($dataRawTaksasi[$dateString][$nama_est][$afdeling]['akp_taksasi'], 2, '.', '') : '-';
                    $tonase_taksasi_str = isset($dataRawTaksasi[$dateString][$nama_est][$afdeling]['tonase_taksasi']) ? $dataRawTaksasi[$dateString][$nama_est][$afdeling]['tonase_taksasi'] : '-';
                    $tonase_taksasi = $tonase_taksasi_str !== '-' ? number_format((float) str_replace(',', '', $tonase_taksasi_str), 2, '.', '') : '-';
                    $keb_hk_taksasi = isset($dataRawTaksasi[$dateString][$nama_est][$afdeling]['keb_hk_taksasi']) ? number_format($dataRawTaksasi[$dateString][$nama_est][$afdeling]['keb_hk_taksasi'], 2, '.', '') : '-';

                    if (isset($realisasiMap[$key])) {
                        $item = $realisasiMap[$key];
                        // Calculate varian for ha_panen
                        $ha_panen_taksasi_value = $ha_panen_taksasi !== '-' ? (float) str_replace(',', '', $ha_panen_taksasi) : 0;
                        $ha_panen_realisasi_value = isset($item->ha_panen) ? $item->ha_panen : 0;
                        $ha_panen_varian = $ha_panen_taksasi_value !== 0 ? number_format(($ha_panen_realisasi_value / $ha_panen_taksasi_value) * 100, 2) : '-';

                        $tonase_realisasi_value = isset($item->tonase) ? $item->tonase : 0;
                        $tonase_varian = $tonase_taksasi !== '-' && $tonase_taksasi !== 0 ? number_format(($tonase_realisasi_value / $tonase_taksasi) * 100, 2) : '-';

                        $akp_realisasi_value = isset($item->akp) ? $item->akp : 0;
                        $akp_varian = $akp_taksasi !== '-' && $akp_taksasi !== 0 ? number_format(($akp_realisasi_value / $akp_taksasi) * 100, 2) : '-';

                        $keb_hk_realisasi_value = isset($item->hk) ? $item->hk : 0;
                        $keb_hk_varian = $keb_hk_taksasi !== '-' && $keb_hk_taksasi !== 0 ? number_format(($keb_hk_realisasi_value / $keb_hk_taksasi) * 100, 2) : '-';

                        $dataRaw[$nama_est][] = [
                            'Tanggal' => $dateString,
                            'AFD' => $afdeling,
                            'ha_panen_taksasi' => $ha_panen_taksasi,
                            'ha_panen_realisasi' => isset($item->ha_panen) ? number_format($item->ha_panen, 2) : '-',
                            'ha_panen_varian' => $ha_panen_varian,
                            'akp_taksasi' => $akp_taksasi,
                            'akp_realisasi' => isset($item->akp) ? number_format($item->akp, 2) : '-',
                            'akp_varian' => $akp_varian, // Replace with actual calculation logic for akp_varian
                            'taksasi_tonase' => $tonase_taksasi,
                            'taksasi_realisasi' => isset($item->tonase) ? number_format($item->tonase, 2) : '-',
                            'taksasi_varian' => $tonase_varian,
                            'keb_hk_taksasi' => $keb_hk_taksasi,
                            'keb_hk_realisasi' => isset($item->hk) ? number_format($item->hk, 2) : '-',
                            'keb_hk_varian' => $keb_hk_varian, // Replace with actual calculation logic for keb_hk_varian
                        ];
                    } else {
                        $dataRaw[$nama_est][] = [
                            'Tanggal' => $dateString,
                            'AFD' => $afdeling,
                            'ha_panen_taksasi' => '-',
                            'ha_panen_realisasi' => '-',
                            'ha_panen_varian' => '-',
                            'akp_taksasi' => '-',
                            'akp_realisasi' => '-',
                            'akp_varian' => '',
                            'taksasi_tonase' => '-',
                            'taksasi_realisasi' => '-',
                            'taksasi_varian' => '',
                            'keb_hk_taksasi' => '-',
                            'keb_hk_realisasi' => '-',
                            'keb_hk_varian' => '-',
                        ];
                    }
                    $inc++;
                }

                if ($inc == count($afdelings)) {
                    $dataRaw[$nama_est][] = [
                        'Tanggal' => $dateString,
                        'AFD' => $nama_est,
                        'ha_panen_taksasi' => '-',
                        'ha_panen_realisasi' => '-',
                        'ha_panen_varian' => '-',
                        'akp_taksasi' => '-',
                        'akp_realisasi' => '-',
                        'akp_varian' => '',
                        'taksasi_tonase' => '-',
                        'taksasi_realisasi' => '-',
                        'taksasi_varian' => '',
                        'keb_hk_taksasi' => '-',
                        'keb_hk_realisasi' => '-',
                        'keb_hk_varian' => '-',
                    ];
                }
            }
            $startDate->modify('+1 day');
        }


        // dd($dataRaw);

        $finalData = [
            'data' => $dataRaw,
            'listEstate' => $listEstate
        ];


        echo json_encode($finalData);
    }

    public function importExcelRealisasiTaksasi(Request $request)
    {
        try {
            $validated = $request->validate([
                'file' => 'required|mimes:csv,xls,xlsx|max:20480', // max size in kilobytes (20MB)
            ]);

            $month = $request->input('month');
            $file = $request->file('file');

            // Process the Excel file
            $import = new RealisasiTaksasiImport($this->dataService, $month);
            FacadesExcel::import($import, $file); // Specify the sheet here

            // Flash success message
            Session::flash('success', 'Data Realisasi Excel Berhasil Diimport!');
            return redirect()->back();
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Flash error message
            $errorMessage = implode(' ', $e->validator->getMessageBag()->all());
            Session::flash('errors', $errorMessage);
            return redirect()->back()->withInput();
        } catch (\Exception $e) {
            // Flash general error message
            Session::flash('errors', 'An error occurred while processing the file. ' . $e);
            return redirect()->back()->withInput();
        }
    }
}
