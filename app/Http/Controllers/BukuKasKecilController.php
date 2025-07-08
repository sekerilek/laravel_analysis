<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Model\kasbank;
use PDF;

class BukuKasKecilController extends Controller
{
    public function index()
    {
        $year_now = date('Y');
        $filter = false;
        return view('laporan.bukukaskecil.index', compact('filter', 'year_now'));
    }

    public function show(Request $request)
    {
        $year_now = date('Y');
        $filter = true;
        $no = 1;
        $kas = DB::select("SELECT k.*, pt.Nama, pt.Karyawan, pt.Transaksi, s.SaldoCash, s.SaldoRekening
            from kasbanks k
            inner join pengeluarantambahans pt on pt.KodePengeluaran = k.KodeInvoice
            left join saldos s on s.KodeTransaksi = pt.KodePengeluaran
            WHERE YEAR(k.Tanggal) = '" . $year_now . "'
            AND k.Status = 'CFM'
            AND (k.Tipe LIKE 'BO%' or k.Tipe = 'KS')
            order by k.Tanggal, k.KodeKasBankID ");

        $total_pengeluaran = DB::table('kasbanks')->where('Tipe', 'BOK')->where('Status', 'CFM')->whereYear('Tanggal', $year_now)->select(DB::raw('SUM(Total) as total_biaya'))->first()->total_biaya;
        $total_pemasukan = DB::table('kasbanks')->where('Tipe', 'BOM')->where('Status', 'CFM')->whereYear('Tanggal', $year_now)->select(DB::raw('SUM(Total) as total_biaya'))->first()->total_biaya;
        $saldoawal_cash = DB::table('saldos')->whereYear('Tanggal', $year_now - 1)->select('SaldoCash')->orderBy('id', 'desc')->first();
        $saldoakhir_cash = DB::table('saldos')->whereYear('Tanggal', $year_now)->select('SaldoCash')->orderBy('id', 'desc')->first();
        $saldoawal_rekening = DB::table('saldos')->whereYear('Tanggal', $year_now - 1)->select('SaldoRekening')->orderBy('id', 'desc')->first();
        $saldoakhir_rekening = DB::table('saldos')->whereYear('Tanggal', $year_now)->select('SaldoRekening')->orderBy('id', 'desc')->first();

        if ($saldoawal_cash != null) $saldoawal_cash = $saldoawal_cash->SaldoCash;
        if ($saldoakhir_cash != null) $saldoakhir_cash = $saldoakhir_cash->SaldoCash;
        if ($saldoawal_rekening != null) $saldoawal_rekening = $saldoawal_rekening->SaldoRekening;
        if ($saldoakhir_rekening != null) $saldoakhir_rekening = $saldoakhir_rekening->SaldoRekening;

        return view('laporan.bukukaskecil.index', compact('kas', 'filter', 'year_now', 'no', 'total_pengeluaran', 'total_pemasukan', 'saldoawal_cash', 'saldoakhir_cash', 'saldoawal_rekening', 'saldoakhir_rekening'));
    }

    public function filter(Request $request)
    {
        $year_now = date('Y');
        $filter = true;
        $no = 1;
        $kas = DB::select("SELECT k.*, pt.Nama, pt.Karyawan, pt.Transaksi, s.SaldoCash, s.SaldoRekening
            from kasbanks k
            inner join pengeluarantambahans pt on pt.KodePengeluaran = k.KodeInvoice
            left join saldos s on s.KodeTransaksi = pt.KodePengeluaran
            WHERE MONTH(k.Tanggal) = '" . $request->month . "' AND YEAR(k.Tanggal) = '" . $request->year . "'
            AND k.Status = 'CFM'
            AND (k.Tipe LIKE 'BO%' or k.Tipe = 'KS')
            order by k.Tanggal, k.KodeKasBankID ");

        $total_pengeluaran = DB::table('kasbanks')->where('Tipe', 'BOK')->where('Status', 'CFM')->whereMonth('Tanggal', $request->month)->whereYear('Tanggal', $request->year)->select(DB::raw('SUM(Total) as total_biaya'))->first()->total_biaya;
        $total_pemasukan = DB::table('kasbanks')->where('Tipe', 'BOM')->where('Status', 'CFM')->whereMonth('Tanggal', $request->month)->whereYear('Tanggal', $request->year)->select(DB::raw('SUM(Total) as total_biaya'))->first()->total_biaya;
        if ($request->month == 1) {
            $saldoawal_cash = DB::table('saldos')->whereMonth('Tanggal', 12)->whereYear('Tanggal', $request->year - 1)->select('SaldoCash')->orderBy('id', 'desc')->first();
            $saldoakhir_cash = DB::table('saldos')->whereMonth('Tanggal', $request->month)->whereYear('Tanggal', $request->year)->select('SaldoCash')->orderBy('id', 'desc')->first();
            $saldoawal_rekening = DB::table('saldos')->whereMonth('Tanggal', 12)->whereYear('Tanggal', $request->year - 1)->select('SaldoRekening')->orderBy('id', 'desc')->first();
            $saldoakhir_rekening = DB::table('saldos')->whereMonth('Tanggal', $request->month)->whereYear('Tanggal', $request->year)->select('SaldoRekening')->orderBy('id', 'desc')->first();
        } else {
            $saldoawal_cash = DB::table('saldos')->whereMonth('Tanggal', $request->month - 1)->whereYear('Tanggal', $request->year)->select('SaldoCash')->orderBy('id', 'desc')->first();
            $saldoakhir_cash = DB::table('saldos')->whereMonth('Tanggal', $request->month)->whereYear('Tanggal', $request->year)->select('SaldoCash')->orderBy('id', 'desc')->first();
            $saldoawal_rekening = DB::table('saldos')->whereMonth('Tanggal', $request->month - 1)->whereYear('Tanggal', $request->year)->select('SaldoRekening')->orderBy('id', 'desc')->first();
            $saldoakhir_rekening = DB::table('saldos')->whereMonth('Tanggal', $request->month)->whereYear('Tanggal', $request->year)->select('SaldoRekening')->orderBy('id', 'desc')->first();
        }

        if ($saldoawal_cash != null) $saldoawal_cash = $saldoawal_cash->SaldoCash;
        if ($saldoakhir_cash != null) $saldoakhir_cash = $saldoakhir_cash->SaldoCash;
        if ($saldoawal_rekening != null) $saldoawal_rekening = $saldoawal_rekening->SaldoRekening;
        if ($saldoakhir_rekening != null) $saldoakhir_rekening = $saldoakhir_rekening->SaldoRekening;

        return view('laporan.bukukaskecil.index', compact('kas', 'filter', 'year_now', 'no', 'total_pengeluaran', 'total_pemasukan', 'saldoawal_cash', 'saldoakhir_cash', 'saldoawal_rekening', 'saldoakhir_rekening'));
    }
}
