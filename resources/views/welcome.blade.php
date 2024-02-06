<?php
if (isset($_GET['tahun'])) {
    $menu = json_decode(file_get_contents('http://tes-web.landa.id/intermediate/menu'));
    $transaksi = json_decode(file_get_contents('http://tes-web.landa.id/intermediate/transaksi?tahun=' . $_GET['tahun']));
}
?>
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
                <form id="tahunForm" action="{{ route('transaksi') }}" method="get">
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <select id="my-select" class="form-control" name="tahun">
                                    <option disabled value="">Pilih Tahun</option>
                                    <option {{ $tahun == 2021 ? 'selected' : ''}} value="2021" >2021</option>
                                    <option {{ $tahun == 2022 ? 'selected' : ''}} value="2022">2022</option>
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
                        </div>
                    </div>
                </form>
                <script>
                    // Mendapatkan elemen select
                    var selectElement = document.getElementById('my-select');
                
                    // Menambahkan event listener untuk menangani perubahan pada opsi
                    selectElement.addEventListener('change', function() {
                        var selectedValue = this.value; // Mendapatkan nilai tahun yang dipilih
                
                        // Membuat URL dengan parameter tahun yang dipilih
                        var url = "{{ route('transaksi') }}?tahun=" + selectedValue;
                
                        // Mengarahkan ke URL yang baru
                        window.location.href = url;
                    });
                </script>
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
                            @foreach ($makanan as $item)
                                @foreach ($transaksiPerMenuBulan as $key => $menu)
                                    @if ($item == $key)
                                        <tr>
                                            <td>{{ $key }} </td>
                                            <td style="text-align: right;">
                                                {{ isset($menu['January']) ? $menu['January'] : '' }}
                                            </td>
                                            <td style="text-align: right;">
                                                {{ isset($menu['February']) ? $menu['February'] : '' }}
                                            </td>
                                            <td style="text-align: right;">
                                                {{ isset($menu['March']) ? $menu['March'] : '' }}
                                            </td>
                                            <td style="text-align: right;">
                                                {{ isset($menu['April']) ? $menu['April'] : '' }}
                                            </td>
                                            <td style="text-align: right;">
                                                {{ isset($menu['May']) ? $menu['May'] : '' }}
                                            </td>
                                            <td style="text-align: right;">
                                                {{ isset($menu['June']) ? $menu['June'] : '' }}

                                            </td>
                                            <td style="text-align: right;">
                                                {{ isset($menu['July']) ? $menu['July'] : '' }}

                                            </td>
                                            <td style="text-align: right;">
                                                {{ isset($menu['August']) ? $menu['August'] : '' }}

                                            </td>
                                            <td style="text-align: right;">
                                                {{ isset($menu['September']) ? $menu['September'] : '' }}

                                            </td>
                                            <td style="text-align: right;">
                                                {{ isset($menu['October']) ? $menu['October'] : '' }}

                                            </td>
                                            <td style="text-align: right;">
                                                {{ isset($menu['November']) ? $menu['November'] : '' }}

                                            </td>
                                            <td style="text-align: right;">
                                                {{ isset($menu['December']) ? $menu['December'] : '' }}

                                            </td>
                                            <td style="text-align: right;"><b>{{ array_sum(array_values($menu)) }}</b>
                                            </td></b></td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach

                            <tr>
                                <td class="table-secondary" colspan="14"><b>Minuman</b></td>
                            </tr>
                            @foreach ($minuman as $item)
                                @foreach ($transaksiPerMenuBulan as $key => $menu)
                                    @if ($item == $key)
                                        <tr>
                                            <td>{{ $key }} </td>
                                            <td style="text-align: right;">
                                                {{ isset($menu['January']) ? $menu['January'] : '' }}
                                            </td>
                                            <td style="text-align: right;">
                                                {{ isset($menu['February']) ? $menu['February'] : '' }}
                                            </td>
                                            <td style="text-align: right;">
                                                {{ isset($menu['March']) ? $menu['March'] : '' }}
                                            </td>
                                            <td style="text-align: right;">
                                                {{ isset($menu['April']) ? $menu['April'] : '' }}
                                            </td>
                                            <td style="text-align: right;">
                                                {{ isset($menu['May']) ? $menu['May'] : '' }}
                                            </td>
                                            <td style="text-align: right;">
                                                {{ isset($menu['June']) ? $menu['June'] : '' }}

                                            </td>
                                            <td style="text-align: right;">
                                                {{ isset($menu['July']) ? $menu['July'] : '' }}

                                            </td>
                                            <td style="text-align: right;">
                                                {{ isset($menu['August']) ? $menu['August'] : '' }}

                                            </td>
                                            <td style="text-align: right;">
                                                {{ isset($menu['September']) ? $menu['September'] : '' }}

                                            </td>
                                            <td style="text-align: right;">
                                                {{ isset($menu['October']) ? $menu['October'] : '' }}

                                            </td>
                                            <td style="text-align: right;">
                                                {{ isset($menu['November']) ? $menu['November'] : '' }}

                                            </td>
                                            <td style="text-align: right;">
                                                {{ isset($menu['December']) ? $menu['December'] : '' }}

                                            </td>
                                            <td style="text-align: right;"><b>{{ array_sum(array_values($menu)) }}</b>
                                            </td></b></td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach
                            {{-- @foreach ($transaksiPerBulan as $bulan => $total)
                                <tr class="table-dark">
                                    <td><b>Total</b></td>
                                    <td style="text-align: right;">
                                        <b>{{ $total }}</b>
                                    </td>

                                    <td style="text-align: right;"><b>3,965,000</b></td>
                                </tr>
                            @endforeach --}}
                            <tr class="table-dark">
                                <td><b>Total</b></td>
                                @foreach ($transaksiPerBulan as $bulan => $total)
                                    {{-- <td>{{ $bulan }}</td> --}}
                                    <td style="text-align: right;">{{ $total }}</td>
                                @endforeach
                                <td style="text-align: right;">{{ $transaksiPerTahun }}</td>
                            </tr>



                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>


</body>

</html>
