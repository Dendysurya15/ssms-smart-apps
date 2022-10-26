@include('layout.header')
<style>
    @media only screen and (min-width: 992px) {
        .piechart_div {
            height: 590px;
        }

    }

    @media only screen and (min-width: 1366px) {

        .piechart_div {
            height: 800px;
        }
    }

    .selectCard:hover {
        transform: scale(1.01);
        box-shadow: 0 10px 20px rgba(0, 0, 0, .12), 0 4px 8px rgba(0, 0, 0, .06);
    }

    .selectCard {
        border-radius: 4px;
        background: #fff;
        box-shadow: 0 6px 10px rgba(0, 0, 0, .08), 0 0 6px rgba(0, 0, 0, .05);
        transition: .3s transform cubic-bezier(.155, 1.105, .295, 1.12), .3s box-shadow, .3s -webkit-transform cubic-bezier(.155, 1.105, .295, 1.12);
        cursor: pointer;
    }

    a,
    a:hover,
    a:focus,
    a:active {
        text-decoration: none;
        color: inherit;
    }
</style>

<div class="content-wrapper">

    <section class="content-header">
    </section>

    <section class="content">

        <div class="container-fluid pb-4">


            <div class="container-fluid pl-3 pr-3">
                <div class="row">
                    <div class="col-12 col-lg mb-1 dashboard_div">
                        <h2 style="color:#013C5E;font-weight: 550">Dashboard Taksasi
                        </h2>
                        <p style="color:#6C7C8B">Dashboard ini digunakan untuk mengamati hasil taksasi yang
                            dilakukan
                            disetiap estate secara otomatis update setiap hari.
                        </p>

                    </div>

                    <div class="col-12 col-lg-3 pb-3">
                        Pilih Tanggal
                        <form class="" action="{{ route('dashboard') }}" method="get">
                            <input class="form-control" type="date" name="tgl" onchange="this.form.submit()">
                        </form>
                    </div>
                </div>


                <div class="row">

                    <div class="pt-3 pb-3 font-italic col-12 col-lg mr-2 selectCard"
                        style="color:#013C5E;background-color:white;border-radius:5px;  display: table;width: 100%;">
                        <a href="{{ asset('/dashboard_taksasi') }}">

                            <div class="pl-3 pr-3 font-weight-bold">
                                {{-- <span class="font-weight-bold">Update data taksasi terakhir</span>
                                <hr> --}}
                                <span class="font-weight-bold">{{$date}} - {{$hour}} WIB</span>

                                <hr>
                            </div>
                            <div style="display: table-cell;vertical-align: middle;">

                                <span class="pl-3 " style="color: #6C7C8B">
                                    {{-- Taksasi @if ($dataEstate != '')
                                    {{$dataEstate['est']}}
                                    @else --}}
                                    Rangda
                                    {{-- @endif Estate --}}
                                </span>
                                <br>
                                <span class="pl-3" style="font-size: 40px;font-weight:500">
                                    @if ($estTak != '')
                                    {{$estTak}}
                                    @else
                                    0
                                    @endif
                                </span>
                                <span> kg</span>
                                {{-- <span class="pl-3"> <i class="fa fa-arrow-down" style="color: red"></i> (Turun
                                    3,56%)</span> --}}
                                <div style="margin-bottom: 10px"> </div>

                                <div style="margin-bottom: 10px"> </div>
                                <span class="pl-3" style="color: #6C7C8B">
                                    Kebutuhan Pemanen Rangda Estate
                                </span>
                                <br>
                                <span class="pl-3" style="font-size: 40px;font-weight:500">
                                    @if ($estPemanen != '')
                                    {{$estPemanen}}
                                    @else
                                    0
                                    @endif
                                </span>
                                <span> Orang</span>
                                {{-- <span class="pl-3"> <i class="fa fa-arrow-up" style="color: green"></i> (Naik
                                    7,56%)</span> --}}

                            </div>
                        </a>
                    </div>
                    <div class="pt-3 pb-3 font-italic col-12 col-lg mr-2  selectCard"
                        style="color:#013C5E;background-color:white;border-radius:5px;  display: table;width: 100%;height: 250px;">
                        <a href="{{ asset('/dashboard_taksasi') }}">
                            <div class="pl-3 pr-3 mb-3">
                                Persebaran taksasi
                                afdeling
                                <span class="font-weight-bold">
                                    {{-- @if ($dataEstate != '')
                                    {{$dataEstate['est']}}
                                    @else --}}
                                    Rangda
                                    {{-- @endif --}}
                                </span>

                            </div>

                            <div class="row pl-3 pr-3 ">
                                <div class="col-12">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">Afdeling</th>
                                                <th scope="col">Taksasi (kg)</th>
                                                <th scope="col">Kebutuhan Pemanen (orang)</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($dateAfdeling as $item)
                                            <tr>
                                                <th scope="row">{{$item['afd']}}</th>
                                                <td>{{$item['taksasi']}} </td>
                                                <td>{{$item['kebutuhan_pemanen']}}</td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>

                                </div>
                            </div>

                        </a>
                    </div>

                </div>




            </div>

        </div><!-- /.container-fluid -->
    </section>

</div>
@include('layout.footer')

{{-- <script src="{{ asset('lottie/93121-no-data-preview.json') }}" type="text/javascript"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.9.4/lottie.min.js"
    integrity="sha512-ilxj730331yM7NbrJAICVJcRmPFErDqQhXJcn+PLbkXdE031JJbcK87Wt4VbAK+YY6/67L+N8p7KdzGoaRjsTg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- jQuery -->
<script src="{{ asset('/public/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('/public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('/public/plugins/chart.js/Chart.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/public/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('/public/js/demo.js') }}"></script>

<script src="{{ asset('/public/js/loader.js') }}"></script>



<script>

</script>