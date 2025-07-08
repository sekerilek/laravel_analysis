<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class LaporanPenjualanController extends Controller
{
    public function index()
    {
        $pelanggans = DB::table('pelanggans')->where('Status', 'OPN')->get();
        return view('laporan.penjualan.index', compact('pelanggans'));
    }

    public function show($id)
    {
        $year_now = date('Y');
        $pelanggan = $id;
        $nama = DB::table('pelanggans')->where('Status', 'OPN')->where('KodePelanggan', $pelanggan)->first()->NamaPelanggan;
        $jenis = "kode";
        $penjualans = DB::select("SELECT sj.Tanggal, sj.KodeSuratJalan, sj.KodeSO, sum(sjd.Qty) as total, i.NamaItem, sjd.KodeSatuan 
            FROM suratjalandetails sjd
            INNER JOIN suratjalans sj
            INNER JOIN items i
            INNER JOIN pelanggans p on p.KodePelanggan = sj.KodePelanggan
            WHERE sj.KodeSuratJalan = sjd.KodeSuratJalan
            AND p.KodePelanggan ='" . $id . "'
            AND i.KodeItem = sjd.KodeItem
            GROUP BY sj.KodeSuratJalan, sj.KodeSO, sjd.KodeItem, sjd.KodeSatuan 
            ORDER BY sj.Tanggal DESC
        ");
        return view('laporan.penjualan.laporan', compact('penjualans', 'year_now', 'pelanggan', 'nama', 'jenis'));
    }

    public function filter(Request $request)
    {
        $year_now = date('Y');
        $pelanggan = $request->pelanggan;
        $nama = $request->nama;
        $filter = true;
        $jenis = $request->filter;
        if ($jenis == "kode") {
            $penjualans = DB::select("SELECT sj.Tanggal, sj.KodeSuratJalan, sj.KodeSO, sum(sjd.Qty) as total, i.NamaItem, sjd.KodeSatuan 
                FROM suratjalandetails sjd
                INNER JOIN suratjalans sj
                INNER JOIN items i
                INNER JOIN pelanggans p on p.KodePelanggan = sj.KodePelanggan
                WHERE MONTH(sj.Tanggal) = '" . $request->month . "' AND YEAR(sj.Tanggal) = '" . $request->year . "'
                AND sj.KodeSuratJalan = sjd.KodeSuratJalan
                AND p.KodePelanggan ='" . $request->pelanggan . "'
                AND i.KodeItem = sjd.KodeItem
                GROUP BY sj.KodeSuratJalan, sj.KodeSO, sjd.KodeItem, sjd.KodeSatuan  
                ORDER BY sj.Tanggal DESC
            ");
        } else if ($jenis == "item") {
            $penjualans = DB::select("SELECT sum(sjd.Qty) as total, i.NamaItem, sjd.KodeSatuan 
                FROM suratjalandetails sjd
                INNER JOIN suratjalans sj
                INNER JOIN items i
                INNER JOIN pelanggans p on p.KodePelanggan = sj.KodePelanggan
                WHERE MONTH(sj.Tanggal) = '" . $request->month . "' AND YEAR(sj.Tanggal) = '" . $request->year . "'
                AND sj.KodeSuratJalan = sjd.KodeSuratJalan
                AND p.KodePelanggan ='" . $request->pelanggan . "'
                AND i.KodeItem = sjd.KodeItem
                GROUP BY sjd.KodeItem, sjd.KodeSatuan  
                ORDER BY i.NamaItem ASC
            ");
        }
        return view('laporan.penjualan.laporan', compact('penjualans', 'year_now', 'filter', 'jenis', 'pelanggan', 'nama'));
    }

    public function filterdate(Request $request)
    {
        $year_now = date('Y');
        $pelanggan = $request->pelanggan;
        $nama = $request->nama;
        $filter = true;
        $jenis = $request->filter;
        $start = $request->get('mulai');
        $end = $request->get('sampai');
        $mulai = $request->get('mulai');
        $sampai = $request->get('sampai');
        if ($jenis == "kode") {
            $penjualans = DB::select("SELECT sj.Tanggal, sj.KodeSuratJalan, sj.KodeSO, sum(sjd.Qty) as total, i.NamaItem, sjd.KodeSatuan 
                FROM suratjalandetails sjd
                INNER JOIN suratjalans sj
                INNER JOIN items i
                INNER JOIN pelanggans p on p.KodePelanggan = sj.KodePelanggan
                WHERE sj.Tanggal BETWEEN '" . $request->start . "' AND '" . $request->end . "'
                AND sj.KodeSuratJalan = sjd.KodeSuratJalan
                AND p.KodePelanggan ='" . $request->pelanggan . "'
                AND i.KodeItem = sjd.KodeItem
                GROUP BY sj.KodeSuratJalan, sj.KodeSO, sjd.KodeItem, sjd.KodeSatuan  
                ORDER BY sj.Tanggal DESC
            ");
        } else if ($jenis == "item") {
            $penjualans = DB::select("SELECT sum(sjd.Qty) as total, i.NamaItem, sjd.KodeSatuan 
                FROM suratjalandetails sjd
                INNER JOIN suratjalans sj
                INNER JOIN items i
                INNER JOIN pelanggans p on p.KodePelanggan = sj.KodePelanggan
                WHERE sj.Tanggal BETWEEN '" . $request->start . "' AND '" . $request->end . "'
                AND sj.KodeSuratJalan = sjd.KodeSuratJalan
                AND p.KodePelanggan ='" . $request->pelanggan . "'
                AND i.KodeItem = sjd.KodeItem
                GROUP BY sjd.KodeItem, sjd.KodeSatuan  
                ORDER BY i.NamaItem ASC
            ");
        }
        return view('laporan.penjualan.laporan', compact('penjualans', 'year_now', 'mulai', 'sampai', 'filter', 'jenis', 'pelanggan', 'nama'));
    }
}
