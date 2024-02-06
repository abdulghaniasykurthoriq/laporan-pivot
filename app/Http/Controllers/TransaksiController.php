<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $tahun = 2021;
        if($request->input('tahun')){
            $tahun = $request->input('tahun');
        }
        $menu = json_decode(file_get_contents('http://tes-web.landa.id/intermediate/menu'));
        $transaksi = json_decode(file_get_contents('http://tes-web.landa.id/intermediate/transaksi?tahun='.$tahun));

        $menus = json_decode(file_get_contents('http://tes-web.landa.id/intermediate/menu'));
        $transaksiPerBulan = [];
        $transaksiPerTahun = 0;
        // Inisialisasi array dengan semua nama bulan
        $allMonths = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        foreach ($allMonths as $bulan) {
            $transaksiPerBulan[$bulan] = 0;
        }

        foreach ($transaksi as $data) {
            $bulan = date('F', strtotime($data->tanggal));
            $transaksiPerBulan[$bulan] += $data->total;
            $transaksiPerTahun += $data->total;
        }

        // dd($transaksiPerBulan);

        $transaksiPerMenuBulan = [];

        foreach ($transaksi as $data) {
            $bulan = date('F', strtotime($data->tanggal));
            $menu = (object) [
                'nama' => strtolower(str_replace(' ', '_', $data->menu)), // Mengubah teks menjadi huruf kecil dan mengganti spasi dengan garis bawah
                'bulan' => (object) [
                    $bulan => $data->total,
                ],
            ];

            // Menambahkan menu ke dalam array $transaksiPerMenuBulan
            if (!isset($transaksiPerMenuBulan[$menu->nama])) {
                $transaksiPerMenuBulan[$menu->nama] = [];
            }

            // Menggabungkan total transaksi berdasarkan bulan
            if (!isset($transaksiPerMenuBulan[$menu->nama][$bulan])) {
                $transaksiPerMenuBulan[$menu->nama][$bulan] = 0;
            }

            $transaksiPerMenuBulan[$menu->nama][$bulan] += $data->total;
        }

        //  dd($transaksiPerMenuBulan);
        // dd($menus);
        $makanan = [];
        $minuman = [];
        foreach ($menus as $item) {
            // Mengonversi objek ke dalam array dengan konversi JSON (json_decode)
            $itemArray = json_decode(json_encode($item), true);
            if ($itemArray['kategori'] == 'makanan') {
                // Perbaikan dilakukan di sini
                $makanan[] = strtolower(str_replace(' ', '_', $itemArray['menu']));
            } else {
                $minuman[] = strtolower(str_replace(' ', '_', $itemArray['menu']));
            }
        }
        // dd($transaksiPerBulan);

        return view('welcome', [
            'tahun' => $tahun,
            'menu' => $menus,
            'makanan' => $makanan,
            'minuman' => $minuman,
            'transaksiPerBulan' => $transaksiPerBulan,
            'transaksiPerTahun' => $transaksiPerTahun,
            'transaksiPerMenuBulan' => $transaksiPerMenuBulan,
        ]);
        // return view('welcome');
    }
}
