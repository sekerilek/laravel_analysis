<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Model\kasbank;
use PDF;

class BukuKasBesarController extends Controller
{
    public function index()
    {
        $year_now = date('Y');
        $kas = DB::select("SELECT k.*
            from kasbanks k
            WHERE YEAR(k.Tanggal) = '" . $year_now . "'
            AND k.Status = 'CFM'
            AND (k.Tipe = 'AR' or k.Tipe = 'AP' or k.Tipe = 'KS' or k.Tipe = 'RKS') 
            order by k.Tanggal ");
        $filter = false;
        return view('laporan.bukukasbesar.index', compact('kas', 'filter', 'year_now'));
    }

    public function show(Request $request)
    {
        $year_now = date('Y');
        $kas = DB::select("SELECT k.*
            from kasbanks k
            WHERE YEAR(k.Tanggal) = '" . $year_now . "'
            AND k.Status = 'CFM'
            AND (k.Tipe = 'AR' or k.Tipe = 'AP' or k.Tipe = 'KS' or k.Tipe = 'RKS') 
            order by k.Tanggal, k.KodeKasBank ");
        $hutang = DB::table('kasbanks')->where('Tipe', 'AP')->whereYear('Tanggal', $year_now)->select(DB::raw('SUM(Total) as total_hutang'))->first()->total_hutang;
        $piutang = DB::table('kasbanks')->where('Tipe', 'AR')->whereYear('Tanggal', $year_now)->select(DB::raw('SUM(Total) as total_piutang'))->first()->total_piutang;
        $kasir = DB::table('kasbanks')->where('Tipe', 'KS')->whereYear('Tanggal', $year_now)->select(DB::raw('SUM(Total) as total_kasir'))->first()->total_kasir;
        $return = DB::table('kasbanks')->where('Tipe', 'RKS')->whereYear('Tanggal', $year_now)->select(DB::raw('SUM(Total) as total_return'))->first()->total_return;
        $filter = true;
        $no = 1;
        return view('laporan.bukukasbesar.index', compact('kas', 'filter', 'year_now', 'no', 'hutang', 'piutang', 'kasir', 'return'));
    }

    public function filter(Request $request)
    {
        $year_now = date('Y');
        $kas = DB::select("SELECT k.*
            from kasbanks k
            WHERE MONTH(k.Tanggal) = '" . $request->month . "' AND YEAR(k.Tanggal) = '" . $request->year . "'
            AND k.Status = 'CFM'
            AND (k.Tipe = 'AR' or k.Tipe = 'AP')
            order by k.Tanggal, k.KodeKasBank ");
        $hutang = DB::table('kasbanks')->where('Tipe', 'AP')->whereMonth('Tanggal', $request->month)->whereYear('Tanggal', $request->year)->select(DB::raw('SUM(Total) as total_hutang'))->first()->total_hutang;
        $piutang = DB::table('kasbanks')->where('Tipe', 'AR')->whereMonth('Tanggal', $request->month)->whereYear('Tanggal', $request->year)->select(DB::raw('SUM(Total) as total_piutang'))->first()->total_piutang;
        $kasir = DB::table('kasbanks')->where('Tipe', 'KS')->whereMonth('Tanggal', $request->month)->whereYear('Tanggal', $year_now)->select(DB::raw('SUM(Total) as total_kasir'))->first()->total_kasir;
        $return = DB::table('kasbanks')->where('Tipe', 'RKS')->whereMonth('Tanggal', $request->month)->whereYear('Tanggal', $year_now)->select(DB::raw('SUM(Total) as total_return'))->first()->total_return;
        $filter = true;
        $no = 1;
        return view('laporan.bukukasbesar.index', compact('kas', 'filter', 'year_now', 'no', 'hutang', 'piutang', 'kasir', 'return'));
    }
}
