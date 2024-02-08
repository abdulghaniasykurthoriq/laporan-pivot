<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venturo - Test</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="container" style="margin-top: 2rem;margin-bottom:1rem">
        <div class="card" style="margin-bottom: 2rem;">
            <div class="card-header">
                Venturo - Laporan siswa per sekolah
            </div>
            <div class="card-body">
                <form method="get" action="{{route('advanced')}}">

                    <div class="row">
                        <div class="col-3">
                            <select class="form-control" name="sekolah">
                                <option selected disabled value="">Pilih Sekolah</option>
                                <option {{ $tingkat == 'SMP' ? 'selected' : '' }}  value="SMP">SMP</option>
                                <option {{ $tingkat == 'SMA' ? 'selected' : '' }}  value="SMA">SMA</option>
                                <option {{ $tingkat == 'SMK' ? 'selected' : '' }}  value="SMK">SMK</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary" type="submit">Tampilan</button>
                            <a href="http://tes-web.landa.id/sekolah.json" class="btn btn-secondary"
                                target="_blank">Json Sekolah</a>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        @foreach ($data as $key => $sekolah)
        {{-- @dd($sekolah) --}}
        {{-- @php
            echo $sekolah
        @endphp --}}
        <div class="card" style="margin-bottom: 2rem;">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group row">
                            <div class="col-6">
                                <label><b>NAMA SEKOLAH</b></label>
                            </div>
                            <div class="col-6">
                                <label>: {{strtoupper($key)}}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-6">
                                <label><b>TELEPON</b></label>
                            </div>
                            <div class="col-6">
                                <label>: {{$sekolah['tlp']}}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-6">
                                <label><b>ALAMAT</b></label>
                            </div>
                            <div class="col-6">
                                <label>: {{$sekolah['alamat']}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <br>
                        <table class="table table-bordered" style="margin-bottom: 0;">
                            <tbody>
                                <tr class="table-dark">
                                    <th>NIS</th>
                                    <th>NAMA</th>
                                    <th>TANGGAL LAHIR</th>
                                </tr>
                                @if (!empty($sekolah) && !empty($sekolah['siswa']))
                                @foreach ($sekolah['siswa'] as $item)
                                    {{-- @dd($item) --}}
                                    <tr>
                                        <td>{{ $item['nis'] }}</td>
                                        <td>{{ $item['nama'] }}</td>
                                        <td>{{ $item['tgl_lahir'] }}</td>
                                    </tr>
                                @endforeach
                                
                                    
                                @else
                                    <td colspan="3" align="center">tidak ada siswa</td>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
 
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>


</body>

</html>
