@include('layout.header')
<style>
    .content {
        font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        font-size: 15px;
    }

    th,
    td {
        white-space: nowrap;
    }

    div.dataTables_wrapper {
        /* width: 800px; */
        margin: 0 auto;
    }

    table.dataTable thead tr th {
        border: 1px solid black;
    }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>

    <section class="content">
        <div class="container-fluid">
            <h3>Dashboard Pemupukan</h3>
            {{-- <div class="row">
                <div class="col-2">
                    Pilih Tanggal
                </div>
                <div class="col-2">
                    Pilih Estate
                </div>
                <div class="col-2">
                    Pilih Afdeling
                </div>

            </div> --}}
            <div class="row mb-3">

                <div class="col-2">
                    <input class="form-control" type="month" name="tgl" id="inputDate">
                </div>

                <div class="col-2">
                    {{csrf_field()}}
                    <select id="estateList" class="form-control">
                        <option selected disabled>Pilih Estate</option>
                    </select>
                </div>

                <div class="col-2">
                    <select id="afdelingList" class="form-control" style="width:180px">
                        {{-- <option>Pilih Afdeling</option> --}}
                    </select>
                </div>

            </div>
            <div class="card">
                <div class="card-body">

                    <table id="example" class="table table-bordered" cellspacing="0" width="100%">
                        <thead class="text-center">
                            <tr>
                                <th rowspan="3">Tanggal</th>
                                <th rowspan="3">Estate</th>
                                <th rowspan="3">Divisi</th>
                                {{-- <th rowspan="3">Luas (Ha)</th> --}}
                                {{-- <th rowspan="3">Jumlah Pokok</th> --}}
                                <th rowspan="3">Jenis Pupuk</th>
                                <th colspan="4">Rekomendasi</th>
                                {{-- <th>Estate</th> --}}
                                {{-- <th>Divisi</th> --}}
                                {{-- <th>Luas (Ha)</th> --}}
                                <th colspan="4">Aplikasi</th>
                                {{-- <th>Jenis Pupuk</th> --}}
                                {{-- <th>Rekomendasi</th> --}}
                                {{-- <th>Aplikasi</th> --}}
                                <th rowspan="3">Achievement</th>
                                <th rowspan="3">Varian</th>
                                <th rowspan="3">Annual Achievement (%)</th>
                                <th rowspan="3">Kg/pokok</th>
                                {{-- <th rowspan="3">Aksi</th> --}}
                            </tr>
                            <tr>
                                {{-- <th>Jenis Pupuk</th> --}}
                                <th colspan="2">SM1</th>
                                {{-- <th>Estate</th> --}}
                                <th colspan="2">SM2</th>
                                {{-- <th>Luas (Ha)</th> --}}
                                <th colspan="2">SM1</th>
                                {{-- <th>Jenis Pupuk</th> --}}
                                <th colspan="2">SM2</th>
                                {{-- <th>Aplikasi</th> --}}
                                {{-- <th>Achievement</th> --}}
                                {{-- <th>Varian</th> --}}
                                {{-- <th>Annual Achievement (%)</th> --}}
                                {{-- <th>Kg/pokok</th> --}}
                            </tr>
                            <tr>

                                {{-- <th>Jenis Pupuk</th> --}}

                                <th>BI</th>
                                <th>SBI</th>
                                <th>BI</th>
                                <th>SBI</th>
                                <th>BI</th>
                                <th>SBI</th>
                                <th>BI</th>
                                <th>SBI</th>

                                {{-- <th>Achievement</th> --}}
                                {{-- <th>Varian</th> --}}
                                {{-- <th>Annual Achievement (%)</th> --}}
                                {{-- <th>Kg/pokok</th> --}}
                            </tr>
                        </thead>
                        <tbody>



                            {{-- <tr>
                                <td>Tiger Nixon</td>
                                <td>System Architect</td>
                                <td>Edinburgh</td>
                                <td>61</td>
                                <td>2011-04-25</td>
                                <td>$320,800</td>
                                <td>2011-04-25</td>
                                <td>$320,800</td>
                                <td>2011-04-25</td>
                                <td>$320,800</td>
                                <td>2011-04-25</td>
                                <td>$320,800</td>
                                <td>2011-04-25</td>
                                <td>$320,800</td>
                                <td>2011-04-25</td>
                                <td>$320,800</td>
                            </tr> --}}
                        </tbody>
                    </table>


                </div>
            </div>


        </div>
    </section>

</div>
@include('layout.footer')

{{-- <script src=" {{ asset('lottie/93121-no-data-preview.json') }}" type="text/javascript">
</script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.9.4/lottie.min.js" integrity="sha512-ilxj730331yM7NbrJAICVJcRmPFErDqQhXJcn+PLbkXdE031JJbcK87Wt4VbAK+YY6/67L+N8p7KdzGoaRjsTg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- jQuery -->
<script src="{{ asset('/public/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('/public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}">
</script>
<!-- ChartJS -->
<script src="{{ asset('/public/plugins/chart.js/Chart.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/public/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('/public/js/demo.js') }}"></script>

<script src="{{ asset('/public/js/loader.js') }}"></script>


<script>
    function dateFormat(inputDate, format) {
        //parse the input date
        const date = new Date(inputDate);

        //extract the parts of the date
        const day = date.getDate();
        const month = date.getMonth() + 1;
        const year = date.getFullYear();

        //replace the month
        format = format.replace("MM", month.toString().padStart(2, "0"));

        //replace the year
        if (format.indexOf("yyyy") > -1) {
            format = format.replace("yyyy", year.toString());
        } else if (format.indexOf("yy") > -1) {
            format = format.replace("yy", year.toString().substr(2, 2));
        }

        //replace the day
        format = format.replace("dd", day.toString().padStart(2, "0"));

        return format;
    }
    // $('#example').DataTable({
    //         "scrollX": true,
    // "searching": true,
    // "pageLength": 10,
    // processing: true,
    // serverSide: true,
    // ajax: "{{ route('data') }}",
    // columns: [
    // { data: 'tanggal', name: 'tanggal' },
    // { data: 'estate', name: 'estate' },
    // { data: 'afdeling', name: 'afdeling' },
    // // { data: 'estate', name: 'estate' },
    // // { data: 'jumlah_pokok', name: 'jumlah_pokok' },
    // { data: 'jenis_pupuk', name: 'jenis_pupuk' },
    // { data: 'biSm1Rekom', name: 'biSm1Rekom' },
    // { data: 'sbiSm1Rekom', name: 'sbiSm1Rekom' },
    // { data: 'biSm2Rekom', name: 'biSm2Rekom' },
    // { data: 'sbiSm2Rekom', name: 'sbiSm2Rekom' },
    // { data: 'biSm1Apl', name: 'biSm1Apl' },
    // { data: 'sbiSm1Apl', name: 'sbiSm1Apl' },
    // { data: 'biSm2Apl', name: 'biSm2Apl' },
    // { data: 'sbiSm2Apl', name: 'sbiSm2Apl' },
    // { data: 'achieve', name: 'achieve' },
    // { data: 'varian', name: 'varian' },
    // { data: 'annual', name: 'annual' },
    // { data: 'kgpokok', name: 'kgpokok' },
    // { data: 'action', name: 'action' },
    // ],

    // });
    date = ''

    const params = new URLSearchParams(window.location.search)
    var paramArr = [];
    for (const param of params) {
        paramArr = param
    }

    if (paramArr.length > 0) {
        date = paramArr[1]
    } else {
        date = new Date().toISOString().slice(0, 10)
    }

    $(document).ready(function() {

        $('#inputDate').change(function() {
            date = $(this).val();
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: "{{ route('getListEstateTerpupuk') }}",
                method: "POST",
                data: {
                    date: date,
                    _token: _token
                },
                success: function(result) {
                    if (result != '') {
                        document.getElementById("estateList").style.display = "block";
                        document.getElementById("afdelingList").style.display = "block";
                        $('#estateList').html(result)
                        var select = document.getElementById('estateList');
                        var firstIndexList = select.options[select.selectedIndex].value;

                        getListAfd(firstIndexList, date)

                        setTimeout(function() {
                            var select2 = document.getElementById('afdelingList');
                            var selectFirstIndex = $("#afdelingList").val($("#afdelingList option:first").val());
                            var defaultAfd = $("#afdelingList :selected").text()

                            getDataPemupukan(defaultAfd, firstIndexList, date)
                        }, 2000);


                    } else {
                        document.getElementById("estateList").style.display = "none";
                        document.getElementById("afdelingList").style.display = "none";
                    }

                }
            })
        });

        $('#estateList').change(function() {

            var value = $(this).val();
            var _token = $('input[name="_token"]').val();

            getListAfd(value, date)
            setTimeout(function() {
                var select2 = document.getElementById('afdelingList');
                var selectFirstIndex = $("#afdelingList").val($("#afdelingList option:first").val());
                var defaultAfd = $("#afdelingList :selected").text()

                getDataPemupukan(defaultAfd, value, date)
            }, 2000);
        });

        $('#afdelingList').change(function() {
            afd = $(this).val();
            id_est = document.getElementById("estateList").value

            getDataPemupukan(afd, id_est, date)
        });
    })


    function getListAfd(id_est, date) {

        var value = id_est;
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: "{{ route('getNameAfdeling') }}",
            method: "POST",
            data: {
                id_estate: value,
                _token: _token,
                date: date
            },
            success: function(result) {
                $('#afdelingList').html(result)
                // var defaultAfd = document.getElementById("afdelingList").selectedIndex = "OA";;

                // getDataPemupukan(defaultAfd,value,date)
            }
        })
    }

    function getDataPemupukan(afd, estate, date) {

        var value = afd;
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: "{{ route('getDataPemupukan') }}",
            method: "POST",
            data: {
                afd: value,
                _token: _token,
                date: date,
                id_est: estate
            },
            success: function(result) {

                var result = JSON.parse(result);
                $('#example').DataTable({
                    "scrollX": true,
                    "aaData": result,
                    "columns": [{
                            "data": "tanggal"
                        },
                        {
                            "data": "estate"
                        },
                        {
                            "data": "afdeling",
                            "render": function(data, type, row, meta) {
                                if (type === 'display') {
                                    var formattedDate = dateFormat(row.waktu_upload, 'dd-MM-yyyy')
                                    data = '<a href="detail_pemupukan/' + row.estate + '/' + row.afdeling + '/' + formattedDate + '">' + data + '</a>';
                                }

                                return data;
                            }
                        },
                        {
                            "data": "nama_pupuk"
                        },
                        {
                            "data": null,
                            "defaultContent": "-"
                        },
                        {
                            "data": null,
                            "defaultContent": "-"
                        },
                        {
                            "data": null,
                            "defaultContent": "-"
                        },
                        {
                            "data": null,
                            "defaultContent": "-"
                        },
                        {
                            "data": null,
                            "defaultContent": "-"
                        },
                        {
                            "data": null,
                            "defaultContent": "-"
                        },
                        {
                            "data": null,
                            "defaultContent": "-"
                        },
                        {
                            "data": null,
                            "defaultContent": "-"
                        },
                        {
                            "data": null,
                            "defaultContent": "-"
                        },
                        {
                            "data": null,
                            "defaultContent": "-"
                        },
                        {
                            "data": null,
                            "defaultContent": "-"
                        },
                        {
                            "data": null,
                            "defaultContent": "-"
                        },
                    ],
                    "bDestroy": true
                })
                // var wrapper = document.getElementById('example')
                // wrapper.innerHTML = "";
                // var result = JSON.parse(result);

                // // console.log(result)
                // for (let i = 0; i < result.length; i++) {
                //     let item = result[i]['waktu_upload']
                //     let item2 = result[i]['estate']
                //     let item3 = result[i]['estate']
                //     let item4 = result[i]['afdeling']
                //     let item5 = 'asdfa'
                //     let item6 = '-ads'
                //     let item7 = '-ddd'
                //     let item8 = '-dfdff'
                //     let item9 = '-dd'
                //     let item10 ='-dd'
                //     let item11 = '-a'
                //     let item12 = 'aad-'
                //     let item13 = '-ddf'
                //     let item14 = '-a'
                //     let item15 = '-df'
                //     let item16 = '-d'

                //     var tr = document.createElement('tr');
                //     let item_element = document.createElement('td')
                //     let item_element2 = document.createElement('td')
                //     let item_element3 = document.createElement('td')
                //     let item_element4 = document.createElement('td')
                //     let item_element5 = document.createElement('td')
                //     let item_element6 = document.createElement('td')
                //     let item_element7 = document.createElement('td')
                //     let item_element8 = document.createElement('td')
                //     let item_element9 = document.createElement('td')
                //     let item_element10 = document.createElement('td')
                //     let item_element11 = document.createElement('td')
                //     let item_element12 = document.createElement('td')
                //     let item_element13 = document.createElement('td')
                //     let item_element14 = document.createElement('td')
                //     let item_element15 = document.createElement('td')
                //     let item_element16 = document.createElement('td')

                //     item_element.innerText = item
                //     item_element2.innerText = item2
                //     item_element3.innerText = item3
                //     item_element4.innerText = item4
                //     item_element5.innerText = item5
                //     item_element6.innerText = item6
                //     item_element7.innerText = item7
                //     item_element7.innerText = item7
                //     item_element8.innerText = item8
                //     item_element9.innerText = item9
                //     item_element10.innerText = item10
                //     item_element11.innerText = item11
                //     item_element12.innerText = item12
                //     item_element13.innerText = item13
                //     item_element14.innerText = item14
                //     item_element15.innerText = item15
                //     item_element16.innerText = item16

                //     tr.appendChild(item_element);
                //     tr.appendChild(item_element2);
                //     tr.appendChild(item_element3);
                //     tr.appendChild(item_element4);
                //     tr.appendChild(item_element5);
                //     tr.appendChild(item_element6);
                //     tr.appendChild(item_element7);
                //     tr.appendChild(item_element8);
                //     tr.appendChild(item_element9);
                //     tr.appendChild(item_element10);
                //     tr.appendChild(item_element11);
                //     tr.appendChild(item_element12);
                //     tr.appendChild(item_element13);
                //     tr.appendChild(item_element14);
                //     tr.appendChild(item_element15);
                //     tr.appendChild(item_element16);
                //     wrapper.appendChild(tr)
                // }
                // console.log(result)
                // console.log(wrapper)
                // $('#example').html(result)

                //    $('#example').DataTable({
                //     "scrollX": true,
                //    })

            }
        })

    }
</script>