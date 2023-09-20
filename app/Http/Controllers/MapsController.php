<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class MapsController extends Controller
{
    public function dashboard()
    {
        $tahun = DB::connection('mysql2')
            ->table('dt_pokok_kuning')
            ->select('tahun_tanam')
            ->distinct()
            ->pluck('tahun_tanam')
            ->toArray();

        $estate = DB::connection('mysql2')
            ->table('dt_pokok_kuning')
            ->select('est')
            ->distinct()
            ->pluck('est')
            ->toArray();

        // Pass the data as an associative array
        return view('maps.index', [
            'tahun' => $tahun,
            'estate' => $estate
        ]);
    }



    public function getPlotBlok(Request $request)
    {

        $est = $request->get('estData');
        $tahun = $request->get('tahunData');
        $afd_s = $request->get('afd');
        // dd($afd);
        $estateQuery = DB::connection('mysql2')->Table('estate')
            ->join('afdeling', 'afdeling.estate', 'estate.id')
            ->where('est', $est)
            ->get();

        $listIdAfd = array();
        foreach ($estateQuery as $key => $value) {
            $listIdAfd[] = $value->id;
        }
        $blokEstate =  DB::connection('mysql2')->Table('blok')->whereIn('afdeling', $listIdAfd)->groupBy('nama')->pluck('nama', 'id');
        $blokEstateFix[$est] = json_decode($blokEstate, true);

        // dd($blokEstateFix);
        $blokLatLn = array();
        foreach ($blokEstateFix as $key => $value) {
            $inc = 0;
            foreach ($value as $key2 => $data) {
                $nilai = 0;
                $kategori = 'x';



                $query = DB::connection('mysql2')->table('blok')
                    ->select('blok.*')
                    ->whereIn('blok.afdeling', $listIdAfd)
                    ->get();

                $latln = '';
                $queryAfd  = '';
                foreach ($query as $key3 => $val) {
                    if ($val->nama == $data) {
                        $latln .= '[' . $val->lon . ',' . $val->lat . '],';
                        $afd =  $val->afdeling;
                        $queryAfd = DB::connection('mysql2')->table('afdeling')
                            ->select('afdeling.*')
                            ->where('id', $afd)
                            ->first();

                        // $queryEst = DB::connection('mysql2')->table('afdeling')
                        // ->select('afdeling.*')
                        // ->whereIn('afdeling.id', $afd)
                        // ->pluck('nama');


                    }
                }

                $blokLatLn[$inc]['blok'] = $data;
                $blokLatLn[$inc]['estate'] = $est;
                $blokLatLn[$inc]['latln'] = rtrim($latln, ',');
                $blokLatLn[$inc]['nilai'] = $nilai;
                $blokLatLn[$inc]['afdeling'] = $queryAfd->nama;
                $blokLatLn[$inc]['kategori'] = $kategori;

                $inc++;
            }
        }
        // dd($blokLatLn);

        $queryAfd = DB::connection('mysql2')->table('afdeling')
            ->select(
                'afdeling.id',
                'afdeling.nama',
                'estate.est'
            ) //buat mengambil data di estate db dan willayah db
            ->join('estate', 'estate.id', '=', 'afdeling.estate') //kemudian di join untuk mengambil est perwilayah
            ->where('est', '=', $est)
            ->get();
        $queryAfd = json_decode($queryAfd, true);


        $id = [];
        foreach ($queryAfd as $key => $value) {
            $id[] = $value['id'];
        }


        // dd($id);


        $querryBlok = DB::connection('mysql2')->table('blok')
            ->select('blok.*') // Use 'blok.*' to select all columns from the 'blok' table
            // ->whereIn('afdeling', $id)
            ->where('afdeling', '=', 51)

            ->get()
            ->groupBy(['afdeling', 'nama']);
        $querryBlok = json_decode($querryBlok, true);

        // dd($querryBlok);
        // Now $jsonResult contains the JSON-encoded data
        // dd($querryBlok);
        $plot_estate = array();
        foreach ($querryBlok as $key => $value) {
            foreach ($value as $key1 => $value1) {
                foreach ($value1 as $key2 => $value2) {


                    $plot_estate[$key][$key1][$key2]['lat'] = $value2['lat'];
                    $plot_estate[$key][$key1][$key2]['lon'] = $value2['lon'];
                } # code...
            }  # code...
        }
        $latLonArray = [];

        foreach ($querryBlok as $afdeling => $namaGroup) {
            foreach ($namaGroup as $nama => $items) {
                foreach ($items as $item) {
                    // Extract lat and lon from each item and add them to the $latLonArray
                    $latLonArray[] = ['lat' => $item['lat'], 'lon' => $item['lon']];
                }
            }
        }
        $queryPlotEst = DB::connection('mysql2')->table('estate_plot')
            ->select("estate_plot.*")
            ->where('est', $est)
            ->get();
        // $queryPlotEst = $queryPlotEst->groupBy(['estate', 'afdeling']);
        $queryPlotEst = json_decode($queryPlotEst, true);

        // dd($queryPlotEst, $latLonArray);
        $convertedCoords = [];
        foreach ($latLonArray as $coord) {
            $convertedCoords[] = [$coord['lat'], $coord['lon']];
        }


        // dd($afd);
        $queryTrans = DB::connection('mysql2')->table("dt_pokok_kuning")
            ->select("dt_pokok_kuning.*", "estate.wil")
            ->join('estate', 'estate.est', '=', 'dt_pokok_kuning.est')
            ->where('dt_pokok_kuning.est', $est)
            ->where('dt_pokok_kuning.afd', $afd_s)
            ->where('tahun_tanam', 'like', '%' . $tahun . '%')
            ->get();
        $queryTrans = json_decode($queryTrans, true);

        $groupedTrans = array_reduce($queryTrans, function ($carry, $item) {
            $carry[$item['blok']][] = $item;
            return $carry;
        }, []);

        // dd($groupedTrans);


        $trans_plot = [];
        foreach ($groupedTrans as $blok => $coords) {
            foreach ($coords as $coord) {
                $afd = ($coord['est'] == 'MRE' && $coord['afd'] == 'OC') ? 'OD' : $coord['afd'];

                $trans_plot[$blok][] = [
                    'blok' => $blok,
                    'lat' => $coord['lat'],
                    'lon' => $coord['lon'],
                    'tahun_tanam' => $coord['tahun_tanam'],
                    'keterangan' => $coord['keterangan'],
                    'est' => $coord['est'],
                    'afd' => $afd
                ];
            }
        }

        // dd($trans_plot);







        $plot['blok'] = $blokLatLn;
        $plot['coords'] = $convertedCoords;
        $plot['pokok_data'] = $trans_plot;


        // dd($plotBlokAll);
        echo json_encode($plot);
    }

    public function mapsTest(Request $request)
    {


        $queryEstate = DB::connection('mysql2')->table('estate')
            ->select('estate.*')
            ->join('wil', 'wil.id', '=', 'estate.wil')
            ->where('wil.regional', 2)
            ->whereNotIn('estate.est', ['CWS1', 'CWS2', 'CWS3'])
            ->where('estate.est', '!=', 'PLASMA')
            ->pluck('est');

        // dd($queryEstate);

        $queryEstate = json_decode($queryEstate, true);
        return view('maps.testingestate', [
            // 'tahun' => $tahun,
            'estate' => $queryEstate
        ]);
    }

    public function mapsestatePlot(Request $request)
    {
        $estDate = $request->get('estData');

        // dd($estDate);

        $plotEst = DB::connection('mysql2')
            ->table('estate_plot')
            ->select('estate_plot.*')
            ->where('est', '=', $estDate)
            // ->whereNotIn('id', [353])
            ->orderBy('id', 'desc') // Sort by 'id' column in descending order
            ->get();

        $plotEst = json_decode($plotEst, true);


        $estate = [];
        $no = 1;
        foreach ($plotEst as $key => $value) {
            $estate[] = [
                'Plot' => $value['est'],
                'lat' => $value['lat'],
                'lon' => $value['lon'],
                'number' => $no++,
                'id' => $value['id']
            ];
        }

        $newkey = []; // Initialize the new array

        foreach ($estate as $key => $value) {
            if ($value['Plot'] == 'BGE' && ($value['number'] >= 80 && $value['number'] <= 95)) {
                $newkey[] = $value; // Add the key to the new array
            }

            if ($value['Plot'] == 'UPE' && ($value['number'] >= 2 && $value['number'] <= 6)) {
                $newkey[] = $value; // Add the key to the new array
            }

            if ($value['Plot'] == 'MRE' && ($value['number'] >= 76 && $value['number'] <= 82)) {
                $newkey[] = $value; // Add the key to the new array
            }
        }
        $newkey2 = []; // Initialize the new array

        foreach ($estate as $key => $value) {

            if ($value['Plot'] == 'MRE' && ($value['number'] >= 65 && $value['number'] <= 75)) {
                $newkey2[] = $value; // Add the key to the new array
            }
        }
        // foreach ($estate as $key => $value) {
        //     if ($value['Plot'] == 'BGE' && ($value['number'] >= 80 && $value['number'] <= 95)) {
        //         unset($estate[$key]);
        //     }

        //     if ($value['Plot'] == 'UPE' && ($value['number'] >= 2 && $value['number'] <= 6)) {
        //         unset($estate[$key]);
        //     }

        //     if ($value['Plot'] == 'MRE' && ($value['number'] >= 76 && $value['number'] <= 82)) {
        //         unset($estate[$key]);
        //     }

        //     if ($value['Plot'] == 'MRE' && ($value['number'] >= 65 && $value['number'] <= 75)) {
        //         unset($estate[$key]);
        //     }
        // }

        // dd($newkey);
        // Now, $newkey contains the keys you want


        $plot['blok'] = $estate;
        $plot['blok_Pulau'] = $newkey;
        $plot['blok_Pulau2'] = $newkey2;


        // dd($plotBlokAll);
        echo json_encode($plot);
    }
}
