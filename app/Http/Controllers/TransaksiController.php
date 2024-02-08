<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan data transaksi dari API
        $tahun = $request->input('tahun');
        $response = Http::get("https://tes-web.landa.id/intermediate/transaksi?tahun=$tahun");
        $data = $response->json() ?? [];
        // dd($data);

        // Mendapatkan data menu dari API
        $responseMenu = Http::get('https://tes-web.landa.id/intermediate/menu');
        $dataMenu = $responseMenu->json();

        // Inisialisasi data siap
        $dataReady = [];
        $transaksiPerTahun = array_fill_keys(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'], 0);

        // Iterasi melalui data transaksi untuk menghitung total transaksi per bulan dalam setiap tahun
        foreach ($data as $transaction) {
            $bulan = date('F', strtotime($transaction['tanggal']));
            $transaksiPerTahun[$bulan] += $transaction['total'];
        }

        // Iterasi melalui data menu untuk mengelompokkan data transaksi
        foreach ($dataMenu as $menu) {
            // Inisialisasi total transaksi per bulan
            $transaksiPerBulan = array_fill_keys(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'], 0);

            // Mendapatkan transaksi yang terkait dengan menu
            $transaksiMenu = array_filter($data, function ($transaction) use ($menu) {
                return $transaction['menu'] === $menu['menu'];
            });

            // Iterasi melalui transaksi menu untuk menghitung total per bulan
            foreach ($transaksiMenu as $detail) {
                // Ambil bulan dari tanggal transaksi
                $bulan = date('F', strtotime($detail['tanggal']));
                // Tambahkan total transaksi ke bulan yang sesuai
                $transaksiPerBulan[$bulan] += $detail['total'];
            }

            // Simpan data siap dengan kategori sebagai kunci
            $dataReady[$menu['kategori']][$menu['menu']] = $transaksiPerBulan;
        }
        // dd($transaksiPerTahun);

        return view('intermediate', compact('dataReady', 'transaksiPerTahun', 'tahun'));
    }
}
