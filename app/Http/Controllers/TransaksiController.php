<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TransaksiController extends Controller
{
    public function venturo(Request $request)
    {
        $tahun = 2021;
        if ($request->input('tahun')) {
            $tahun = $request->input('tahun');
        }
        $response = Http::get('https://tes-web.landa.id/intermediate/transaksi?tahun=' . $tahun);
        $data = $response->json();

        $responseMenu = Http::get('https://tes-web.landa.id/intermediate/menu');
        $dataMenu = $responseMenu->json();

        // Kelompokkan data berdasarkan menu
        $groupedData = collect($data)->groupBy('menu');

        // Inisialisasi array untuk kategori makanan dan minuman
        $groupedCategories = ['makanan' => [], 'minuman' => []];

        // Inisialisasi array untuk menyimpan total transaksi per bulan
        $transaksiPerBulan = [
            'January' => 0,
            'February' => 0,
            'March' => 0,
            'April' => 0,
            'May' => 0,
            'June' => 0,
            'July' => 0,
            'August' => 0,
            'September' => 0,
            'October' => 0,
            'November' => 0,
            'December' => 0,
        ];

        // Loop melalui semua data transaksi untuk mengakumulasikan total transaksi per bulan
        foreach ($data as $transaction) {
            $bulan = date('F', strtotime($transaction['tanggal']));
            $transaksiPerBulan[$bulan] += $transaction['total'];
        }

        // Hitung total transaksi dalam satu tahun
        $totalTransaksiTahunan = array_sum($transaksiPerBulan);

        // Loop melalui semua data menu dan tambahkan ke dalam groupedCategories
        foreach ($dataMenu as $menuItem) {
            $menu = $menuItem['menu'];
            $kategori = $menuItem['kategori'];

            if (!isset($groupedCategories[$kategori][$menu])) {
                $groupedCategories[$kategori][$menu] = [
                    'menu' => $menu,
                    'kategori' => $kategori,
                    'months' => collect([]), // Buat koleksi kosong untuk bulan-bulan
                ];
            }
        }

        // Lakukan groupBy berdasarkan bulan di dalam setiap menu
        $groupedData->transform(function ($menuData, $menu) use ($dataMenu, &$groupedCategories) {
            // Filter data menu berdasarkan menu yang sesuai
            $kategori = collect($dataMenu)
                ->where('menu', $menu)
                ->pluck('kategori')
                ->first();

            // Kelompokkan berdasarkan bulan
            $groupedByMonth = $menuData->groupBy(function ($item) {
                return date('F', strtotime($item['tanggal']));
            });

            // Tambahkan bulan yang hilang dengan nilai total 0
            $allMonths = collect(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);

            $groupedByMonth = $groupedByMonth->mapWithKeys(function ($monthData, $month) {
                return [$month => $monthData->sum('total')];
            });

            // Tambahkan data ke dalam kategori yang sesuai
            $groupedCategories[$kategori][$menu]['months'] = $allMonths->map(function ($month) use ($groupedByMonth) {
                return $groupedByMonth->has($month) ? $groupedByMonth[$month] : 0;
            });

            return $groupedByMonth; // Tidak ada pengaruh pada transformasi utama
        });
        // dd($totalTransaksiTahunan);

        // Outputkan hasil grouping bersama total transaksi per bulan
        return view('venturo', compact('groupedCategories', 'tahun', 'transaksiPerBulan', 'totalTransaksiTahunan'));
    }








    
    public function index(Request $request)
    {
        $tahun = 2021;
        if ($request->input('tahun')) {
            $tahun = $request->input('tahun');
        }
        $menu = json_decode(file_get_contents('http://tes-web.landa.id/intermediate/menu'));
        $transaksi = json_decode(file_get_contents('http://tes-web.landa.id/intermediate/transaksi?tahun=' . $tahun));

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
        // dd($transaksiPerMenuBulan);
        $minuman = ['teh_hijau', 'teh_lemon', 'teh', 'kopi_hitam', 'kopi_susu'];

        // Inisialisasi $transaksipermenubulan dengan semua menu yang terdaftar dalam $minuman dan nilai awal 0 untuk setiap bulan
        $transaksipermenubulan = [];
        foreach ($minuman as $menu) {
            $transaksipermenubulan[$menu] = array_fill_keys(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'], 0);
        }

        // Mengisi nilai transaksi berdasarkan data yang Anda berikan
        foreach ($transaksipermenubulan as $menu => &$bulanData) {
            foreach ($bulanData as $bulan => &$total) {
                // Jika ada transaksi yang terdaftar untuk menu dan bulan tertentu, kita mengambil nilainya
                if (isset($transaksipermenubulan[$menu][$bulan])) {
                    $total = $transaksipermenubulan[$menu][$bulan];
                }
            }
        }

        dd($transaksiPerBulan);
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

    public function groupByMenuAndMonth()
    {
        $response = Http::get('https://tes-web.landa.id/intermediate/transaksi?tahun=2021');
        $data = $response->json();

        $responseMenu = Http::get('https://tes-web.landa.id/intermediate/menu');
        $dataMenu = $responseMenu->json();

        // Kelompokkan data berdasarkan menu
        $groupedData = collect($data)->groupBy('menu');

        // Inisialisasi array untuk kategori makanan dan minuman
        $groupedCategories = ['makanan' => [], 'minuman' => []];
        $bulananData = [];

        // Lakukan groupBy berdasarkan bulan di dalam setiap menu
        $groupedData->transform(function ($menuData, $menu) use ($dataMenu, &$groupedCategories) {
            // Filter data menu berdasarkan menu yang sesuai
            $kategori = collect($dataMenu)
                ->where('menu', $menu)
                ->pluck('kategori')
                ->first();

            // Kelompokkan berdasarkan bulan
            $groupedByMonth = $menuData->groupBy(function ($item) {
                return date('F', strtotime($item['tanggal']));
            });

            // Tambahkan bulan yang hilang dengan nilai total 0
            $allMonths = collect(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);

            $groupedByMonth = $groupedByMonth->mapWithKeys(function ($monthData, $month) {
                return [$month => $monthData->sum('total')];
            });

            // Tambahkan data ke dalam kategori yang sesuai
            $groupedCategories[$kategori][] = [
                'menu' => $menu,
                'kategori' => $kategori,
                'months' => $allMonths->map(function ($month) use ($groupedByMonth) {
                    return $groupedByMonth->has($month) ? $groupedByMonth[$month] : 0;
                }),
            ];

            return $groupedByMonth; // Tidak ada pengaruh pada transformasi utama
        });

        // Outputkan hasil grouping
        return $groupedCategories;
    }

    
}
