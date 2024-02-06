<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
        td,
        th {
            font-size: 11px;
        }
    </style>


    <title>TES - Venturo Camp Tahap 2</title>
</head>

<body>
    <div class="container-fluid">
        <div class="card" style="margin: 2rem 0rem;">
            <div class="card-header">
                Venturo - Laporan penjualan tahunan per menu
            </div>
            <div class="card-body">
                <form action="" method="get">
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <select id="my-select" class="form-control" name="tahun">
                                    <option value="">Pilih Tahun</option>
                                    <option value="2021" selected="">2021</option>
                                    <option value="2022">2022</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary">
                                Tampilkan
                            </button>
                            <a href="http://tes-web.landa.id/intermediate/menu" target="_blank" rel="Array Menu"
                                class="btn btn-secondary">
                                Json Menu
                            </a>
                            <a href="http://tes-web.landa.id/intermediate/transaksi?tahun=2021" target="_blank"
                                rel="Array Transaksi" class="btn btn-secondary">
                                Json Transaksi
                            </a>
                            <a href="https://tes-web.landa.id/intermediate/download?path=example.php" class="btn btn-secondary">Download Example</a>

                        </div>
                    </div>
                </form>
                <hr>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" style="margin: 0;">
                        <thead>
                            <tr class="table-dark">
                                <th rowspan="2" style="text-align:center;vertical-align: middle;width: 250px;">Menu
                                </th>
                                <th colspan="12" style="text-align: center;">Periode Pada 2021
                                </th>
                                <th rowspan="2" style="text-align:center;vertical-align: middle;width:75px">Total
                                </th>
                            </tr>
                            <tr class="table-dark">
                                <th style="text-align: center;width: 75px;">Jan</th>
                                <th style="text-align: center;width: 75px;">Feb</th>
                                <th style="text-align: center;width: 75px;">Mar</th>
                                <th style="text-align: center;width: 75px;">Apr</th>
                                <th style="text-align: center;width: 75px;">Mei</th>
                                <th style="text-align: center;width: 75px;">Jun</th>
                                <th style="text-align: center;width: 75px;">Jul</th>
                                <th style="text-align: center;width: 75px;">Ags</th>
                                <th style="text-align: center;width: 75px;">Sep</th>
                                <th style="text-align: center;width: 75px;">Okt</th>
                                <th style="text-align: center;width: 75px;">Nov</th>
                                <th style="text-align: center;width: 75px;">Des</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="table-secondary" colspan="14"><b>Makanan</b></td>
                            </tr>


                            @foreach ($groupedCategories['makanan'] as $item)
                                <tr>
                                    <td>{{ $item['menu'] }}</td>
                                    @php
                                        $monthsArray = $item['months']->toArray();
                                    @endphp
                                    @if ($monthsArray)
                                        @foreach ($monthsArray as $total)
                                            {{-- // perbaiki td disini ada tidak ada pokokny ada 12 --}}
                                            @if ($total)
                                            <td style="text-align: right;">{{ number_format($total) }} </td>
                                                
                                            @else
                                            <td style="text-align: right;"> </td>
                                                
                                            @endif
                                        @endforeach
                                    @else
                                        @for ($i = 0; $i < 12; $i++)
                                            <td style="text-align: right;"> </td>
                                        @endfor
                                    @endif


                                    <td style="text-align: right;"><b>{{ number_format(array_sum($monthsArray)) }}</b>
                                    </td>
                                </tr>
                            @endforeach

                            <tr>
                                <td class="table-secondary" colspan="14"><b>Minuman</b></td>
                            </tr>
                            @foreach ($groupedCategories['minuman'] as $item)
                                <tr>
                                    <td>{{ $item['menu'] }}</td>
                                    @php
                                        $monthsArray = $item['months']->toArray();
                                    @endphp
                                    @if ($monthsArray)
                                        @foreach ($monthsArray as $total)
                                            {{-- // perbaiki td disini ada tidak ada pokokny ada 12 --}}
                                            @if ($total)
                                            <td style="text-align: right;">{{ number_format($total) }} </td>
                                                
                                            @else
                                            <td style="text-align: right;"> </td>
                                                
                                            @endif
                                        @endforeach
                                    @else
                                        @for ($i = 0; $i < 12; $i++)
                                            <td style="text-align: right;"> </td>
                                        @endfor
                                    @endif


                                    <td style="text-align: right;"><b>{{ number_format(array_sum($monthsArray)) }}</b>
                                    </td>
                                </tr>
                            @endforeach

                            <tr class="table-dark">
                                <td><b>Total</b></td>
                            @foreach ($transaksiPerBulan as $item)
                                @if ($item)
                                <td style="text-align: right;">
                                    <b> {{number_format($item)}} </b>
                                </td>
                                @else
                                    <td></td>
                                @endif
                                
                                
                            @endforeach

                                <td style="text-align: right;"><b>{{number_format($totalTransaksiTahunan)}}</b></td>
                            </tr>

                            
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- view json menu hidden --}}

        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>


</body>

</html>
