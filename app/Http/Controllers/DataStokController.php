<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class DataStokController extends Controller
{
    public function index()
    {   
        $filter = false;

        session()->put('month', '');
        session()->put('year', date('Y'));
        session()->put('date_start', date('Y-m-d'));
        session()->put('date_finish', date('Y-m-d'));
        
        return view('stok.datastok.index', compact('filter'));
    }

    public function show(Request $request)
    {
        /*$year_now = date('Y');
        $filter = true;
        $filterdate = false;
        $satuanfil = $request->satuan;
        if ($satuanfil == "kg") {
            $stok = DB::select("SELECT i.NamaItem, s.NamaSatuan, s.KodeSatuan,
                SUM(CASE WHEN a.JenisTransaksi = 'RJB' THEN round((a.Qty/c.Konversi),4) ELSE 0 END) AS 'RJB',
                SUM(CASE WHEN a.JenisTransaksi = 'SJB' THEN round((a.Qty/c.Konversi),4) ELSE 0 END) AS 'SJB',
                SUM(CASE WHEN a.JenisTransaksi = 'SLM' THEN round((a.Qty/c.Konversi),4) ELSE 0 END) AS 'SLM',
                SUM(CASE WHEN a.JenisTransaksi = 'SLK' THEN round((a.Qty/c.Konversi),4) ELSE 0 END) AS 'SLK'
                from keluarmasukbarangs a
                inner join items i on a.KodeItem = i.KodeItem
                inner join itemkonversis c on a.KodeItem = c.KodeItem and c.KodeSatuan = 'kg'
                inner join satuans s on s.KodeSatuan = c.KodeSatuan
                WHERE i.jenisitem = 'bahanjadi'
                and YEAR(a.Tanggal) = '" . $year_now . "'
                group by a.KodeItem
                order by i.NamaItem
            ");

            $saldo_awal = DB::select("SELECT * from
                (SELECT i.NamaItem, i.KodeItem, s.NamaSatuan, s.KodeSatuan, round(((a.saldo-a.Qty)/c.Konversi),4) as saldo
                from keluarmasukbarangs a
                inner join items i on a.KodeItem = i.KodeItem
                inner join itemkonversis c on a.KodeItem = c.KodeItem and c.KodeSatuan = 'kg'
                inner join satuans s on s.KodeSatuan = c.KodeSatuan
                WHERE i.jenisitem = 'bahanjadi'
                and YEAR(a.Tanggal) = '" . $year_now . "'
                order by i.NamaItem, a.Tanggal, a.id) sort
                group by sort.KodeItem
                order by sort.NamaItem
            ");

            $saldo_akhir = DB::select("SELECT i.NamaItem, i.KodeItem, s.NamaSatuan, s.KodeSatuan, round((a.saldo/c.Konversi),4) as saldo
                FROM keluarmasukbarangs a
                inner join items i on a.KodeItem = i.KodeItem
                inner join itemkonversis c on a.KodeItem = c.KodeItem and c.KodeSatuan = 'kg'
                inner join satuans s on s.KodeSatuan = c.KodeSatuan
                WHERE a.id in 
                    (SELECT max(a.id)
                    from keluarmasukbarangs a
                    inner join items i on a.KodeItem = i.KodeItem
                    inner join itemkonversis c on a.KodeItem = c.KodeItem and c.KodeSatuan = 'kg'
                    inner join satuans s on s.KodeSatuan = c.KodeSatuan
                    WHERE i.jenisitem = 'bahanjadi'
                    and YEAR(a.Tanggal) = '" . $year_now . "'
                    group by i.KodeItem)
                and i.jenisitem = 'bahanjadi'
                and YEAR(a.Tanggal) = '" . $year_now . "'
                GROUP BY i.KodeItem
                ORDER BY i.NamaItem
            ");
        } else if ($satuanfil == "sak") {
            $stok = DB::select("SELECT i.NamaItem, s.NamaSatuan, s.KodeSatuan,
                SUM(CASE WHEN a.JenisTransaksi = 'RJB' THEN round((a.Qty/c.Konversi),4) ELSE 0 END) AS 'RJB',
                SUM(CASE WHEN a.JenisTransaksi = 'SJB' THEN round((a.Qty/c.Konversi),4) ELSE 0 END) AS 'SJB',
                SUM(CASE WHEN a.JenisTransaksi = 'SLM' THEN round((a.Qty/c.Konversi),4) ELSE 0 END) AS 'SLM',
                SUM(CASE WHEN a.JenisTransaksi = 'SLK' THEN round((a.Qty/c.Konversi),4) ELSE 0 END) AS 'SLK'
                from keluarmasukbarangs a
                inner join items i on a.KodeItem = i.KodeItem
                inner join itemkonversis c on a.KodeItem = c.KodeItem and c.KodeSatuan = 'sak'
                inner join satuans s on s.KodeSatuan = c.KodeSatuan
                WHERE i.jenisitem = 'bahanjadi'
                and YEAR(a.Tanggal) = '" . $year_now . "'
                group by a.KodeItem
                order by i.NamaItem
            ");

            $saldo_awal = DB::select("SELECT * from
                (SELECT i.NamaItem, i.KodeItem, s.NamaSatuan, s.KodeSatuan, round(((a.saldo-a.Qty)/c.Konversi),4) as saldo
                from keluarmasukbarangs a
                inner join items i on a.KodeItem = i.KodeItem
                inner join itemkonversis c on a.KodeItem = c.KodeItem and c.KodeSatuan = 'sak'
                inner join satuans s on s.KodeSatuan = c.KodeSatuan
                WHERE i.jenisitem = 'bahanjadi'
                and YEAR(a.Tanggal) = '" . $year_now . "'
                order by i.NamaItem, a.Tanggal, a.id) sort
                group by sort.KodeItem
                order by sort.NamaItem
            ");

            $saldo_akhir = DB::select("SELECT i.NamaItem, i.KodeItem, s.NamaSatuan, s.KodeSatuan, round((a.saldo/c.Konversi),4) as saldo
                FROM keluarmasukbarangs a
                inner join items i on a.KodeItem = i.KodeItem
                inner join itemkonversis c on a.KodeItem = c.KodeItem and c.KodeSatuan = 'sak'
                inner join satuans s on s.KodeSatuan = c.KodeSatuan
                WHERE a.id in 
                    (SELECT max(a.id)
                    from keluarmasukbarangs a
                    inner join items i on a.KodeItem = i.KodeItem
                    inner join itemkonversis c on a.KodeItem = c.KodeItem and c.KodeSatuan = 'sak'
                    inner join satuans s on s.KodeSatuan = c.KodeSatuan
                    WHERE i.jenisitem = 'bahanjadi'
                    and YEAR(a.Tanggal) = '" . $year_now . "'
                    group by i.KodeItem)
                and i.jenisitem = 'bahanjadi'
                and YEAR(a.Tanggal) = '" . $year_now . "'
                GROUP BY i.KodeItem
                ORDER BY i.NamaItem
            ");
        } else if ($satuanfil == "semua") {
            $stok = DB::select("SELECT i.NamaItem, s.NamaSatuan, s.KodeSatuan,
                SUM(CASE WHEN a.JenisTransaksi = 'RJB' THEN round((a.Qty/c.Konversi),4) ELSE 0 END) AS 'RJB',
                SUM(CASE WHEN a.JenisTransaksi = 'SJB' THEN round((a.Qty/c.Konversi),4) ELSE 0 END) AS 'SJB',
                SUM(CASE WHEN a.JenisTransaksi = 'SLM' THEN round((a.Qty/c.Konversi),4) ELSE 0 END) AS 'SLM',
                SUM(CASE WHEN a.JenisTransaksi = 'SLK' THEN round((a.Qty/c.Konversi),4) ELSE 0 END) AS 'SLK'
                from keluarmasukbarangs a
                inner join items i on a.KodeItem = i.KodeItem
                inner join itemkonversis c on a.KodeItem = c.KodeItem and c.Konversi = 1
                inner join satuans s on s.KodeSatuan = c.KodeSatuan
                WHERE i.jenisitem = 'bahanjadi'
                and YEAR(a.Tanggal) = '" . $year_now . "'
                group by a.KodeItem
                order by i.NamaItem
            ");

            $saldo_awal = DB::select("SELECT * from
                (SELECT i.NamaItem, i.KodeItem, s.NamaSatuan, s.KodeSatuan, round(((a.saldo-a.Qty)/c.Konversi),4) as saldo
                from keluarmasukbarangs a
                inner join items i on a.KodeItem = i.KodeItem
                inner join itemkonversis c on a.KodeItem = c.KodeItem and c.Konversi = 1
                inner join satuans s on s.KodeSatuan = c.KodeSatuan
                WHERE i.jenisitem = 'bahanjadi'
                and YEAR(a.Tanggal) = '" . $year_now . "'
                order by i.NamaItem, a.Tanggal, a.id) sort
                group by sort.KodeItem
                order by sort.NamaItem
            ");

            $saldo_akhir = DB::select("SELECT i.NamaItem, i.KodeItem, s.NamaSatuan, s.KodeSatuan, round((a.saldo/c.Konversi),4) as saldo
                FROM keluarmasukbarangs a
                inner join items i on a.KodeItem = i.KodeItem
                inner join itemkonversis c on a.KodeItem = c.KodeItem and c.Konversi = 1
                inner join satuans s on s.KodeSatuan = c.KodeSatuan
                WHERE a.id in 
                    (SELECT max(a.id)
                    from keluarmasukbarangs a
                    inner join items i on a.KodeItem = i.KodeItem
                    inner join itemkonversis c on a.KodeItem = c.KodeItem and c.Konversi = 1
                    inner join satuans s on s.KodeSatuan = c.KodeSatuan
                    WHERE i.jenisitem = 'bahanjadi'
                    and YEAR(a.Tanggal) = '" . $year_now . "'
                    group by i.KodeItem)
                and i.jenisitem = 'bahanjadi'
                and YEAR(a.Tanggal) = '" . $year_now . "'
                GROUP BY i.KodeItem
                ORDER BY i.NamaItem
            ");
        }

        foreach ($stok as $key => $value) {
            $stok[$key]->SaldoAwal = $saldo_awal[$key]->saldo;
            $stok[$key]->SaldoAkhir = $saldo_akhir[$key]->saldo;
        }*/

        $filter = true;

        $stok_awal = DB::select("
            SELECT
                #i.NamaItem,
                #s.NamaSatuan,
                km.saldo
            FROM items i
            LEFT JOIN itemkonversis ik ON i.Kodeitem = ik.KodeItem
            LEFT JOIN satuans s ON ik.KodeSatuan = s.KodeSatuan
            LEFT JOIN keluarmasukbarangs km ON i.Kodeitem = km.KodeItem
            WHERE 
                km.Tanggal <= NOW()
                AND km.id IN (
                    SELECT MIN(k.id)
                    FROM keluarmasukbarangs k
                    GROUP BY k.KodeItem
                )
            ORDER BY i.NamaItem ASC
        ");

        $stok_akhir = DB::select("
            SELECT
                #i.NamaItem,
                #s.NamaSatuan,
                km.saldo
            FROM items i
            LEFT JOIN itemkonversis ik ON i.Kodeitem = ik.KodeItem
            LEFT JOIN satuans s ON ik.KodeSatuan = s.KodeSatuan
            LEFT JOIN keluarmasukbarangs km ON i.Kodeitem = km.KodeItem
            WHERE 
                km.Tanggal <= NOW()
                AND km.id IN (
                    SELECT MAX(k.id)
                    FROM keluarmasukbarangs k
                    GROUP BY k.KodeItem
                )
            ORDER BY i.NamaItem ASC
        ");

        $stok = DB::select("
            SELECT
                i.NamaItem,
                s.NamaSatuan,
                SUM(CASE WHEN km.Qty > 0 AND i.KodeItem = km.KodeItem THEN km.Qty ELSE 0 END) AS `StokMasuk`,
                SUM(CASE WHEN km.Qty < 0 AND i.Kodeitem = km.KodeItem THEN km.Qty ELSE 0 END) AS `StokKeluar`
            FROM items i
            LEFT JOIN keluarmasukbarangs km ON i.Kodeitem = km.KodeItem
            LEFT JOIN itemkonversis ik ON i.Kodeitem = ik.KodeItem
            LEFT JOIN satuans s ON ik.KodeSatuan = s.KodeSatuan
            WHERE km.Tanggal <= NOW()
            GROUP BY i.KodeItem
            ORDER BY i.NamaItem ASC
        ");

        foreach ($stok as $key => $value) {
            $stok[$key]->StokAwal = $stok_awal[$key]->saldo;
            $stok[$key]->StokAkhir = $stok_akhir[$key]->saldo;
        }

        return view('stok.datastok.index', compact('stok', 'filter'));
    }

    public function filter(Request $request)
    {
        $year_now = date('Y');
        $filter = true;
        $filterdate = false;
        $satuanfil = $request->satuan;
        if ($satuanfil == "kg") {
            $stok = DB::select("SELECT i.NamaItem, s.NamaSatuan, s.KodeSatuan,
                SUM(CASE WHEN a.JenisTransaksi = 'RJB' THEN round((a.Qty/c.Konversi),4) ELSE 0 END) AS 'RJB',
                SUM(CASE WHEN a.JenisTransaksi = 'SJB' THEN round((a.Qty/c.Konversi),4) ELSE 0 END) AS 'SJB',
                SUM(CASE WHEN a.JenisTransaksi = 'SLM' THEN round((a.Qty/c.Konversi),4) ELSE 0 END) AS 'SLM',
                SUM(CASE WHEN a.JenisTransaksi = 'SLK' THEN round((a.Qty/c.Konversi),4) ELSE 0 END) AS 'SLK'
                from keluarmasukbarangs a
                inner join items i on a.KodeItem = i.KodeItem
                inner join itemkonversis c on a.KodeItem = c.KodeItem and c.KodeSatuan = 'kg'
                inner join satuans s on s.KodeSatuan = c.KodeSatuan
                WHERE i.jenisitem = 'bahanjadi'
                and MONTH(a.Tanggal) = '" . $request->month . "' and YEAR(a.Tanggal) = '" . $request->year . "'
                group by a.KodeItem
                order by i.NamaItem
            ");

            $saldo_awal = DB::select("SELECT * from
                (SELECT i.NamaItem, i.KodeItem, s.NamaSatuan, s.KodeSatuan, round(((a.saldo-a.Qty)/c.Konversi),4) as saldo
                from keluarmasukbarangs a
                inner join items i on a.KodeItem = i.KodeItem
                inner join itemkonversis c on a.KodeItem = c.KodeItem and c.KodeSatuan = 'kg'
                inner join satuans s on s.KodeSatuan = c.KodeSatuan
                WHERE i.jenisitem = 'bahanjadi'
                and MONTH(a.Tanggal) = '" . $request->month . "' and YEAR(a.Tanggal) = '" . $request->year . "'
                order by i.NamaItem, a.Tanggal, a.id) sort
                group by sort.KodeItem
                order by sort.NamaItem
            ");

            $saldo_akhir = DB::select("SELECT i.NamaItem, i.KodeItem, s.NamaSatuan, s.KodeSatuan, round((a.saldo/c.Konversi),4) as saldo
                FROM keluarmasukbarangs a
                inner join items i on a.KodeItem = i.KodeItem
                inner join itemkonversis c on a.KodeItem = c.KodeItem and c.KodeSatuan = 'kg'
                inner join satuans s on s.KodeSatuan = c.KodeSatuan
                WHERE a.id in 
                    (SELECT max(a.id)
                    from keluarmasukbarangs a
                    inner join items i on a.KodeItem = i.KodeItem
                    inner join itemkonversis c on a.KodeItem = c.KodeItem and c.KodeSatuan = 'kg'
                    inner join satuans s on s.KodeSatuan = c.KodeSatuan
                    WHERE i.jenisitem = 'bahanjadi'
                    and MONTH(a.Tanggal) = '" . $request->month . "' and YEAR(a.Tanggal) = '" . $request->year . "'
                    group by i.KodeItem)
                and i.jenisitem = 'bahanjadi'
                and MONTH(a.Tanggal) = '" . $request->month . "' and YEAR(a.Tanggal) = '" . $request->year . "'
                GROUP BY i.KodeItem
                ORDER BY i.NamaItem
            ");
        } else if ($satuanfil == "sak") {
            $stok = DB::select("SELECT i.NamaItem, s.NamaSatuan, s.KodeSatuan,
                SUM(CASE WHEN a.JenisTransaksi = 'RJB' THEN round((a.Qty/c.Konversi),4) ELSE 0 END) AS 'RJB',
                SUM(CASE WHEN a.JenisTransaksi = 'SJB' THEN round((a.Qty/c.Konversi),4) ELSE 0 END) AS 'SJB',
                SUM(CASE WHEN a.JenisTransaksi = 'SLM' THEN round((a.Qty/c.Konversi),4) ELSE 0 END) AS 'SLM',
                SUM(CASE WHEN a.JenisTransaksi = 'SLK' THEN round((a.Qty/c.Konversi),4) ELSE 0 END) AS 'SLK'
                from keluarmasukbarangs a
                inner join items i on a.KodeItem = i.KodeItem
                inner join itemkonversis c on a.KodeItem = c.KodeItem and c.KodeSatuan = 'sak'
                inner join satuans s on s.KodeSatuan = c.KodeSatuan
                WHERE i.jenisitem = 'bahanjadi'
                and MONTH(a.Tanggal) = '" . $request->month . "' and YEAR(a.Tanggal) = '" . $request->year . "'
                group by a.KodeItem
                order by i.NamaItem
            ");

            $saldo_awal = DB::select("SELECT * from
                (SELECT i.NamaItem, i.KodeItem, s.NamaSatuan, s.KodeSatuan, round(((a.saldo-a.Qty)/c.Konversi),4) as saldo
                from keluarmasukbarangs a
                inner join items i on a.KodeItem = i.KodeItem
                inner join itemkonversis c on a.KodeItem = c.KodeItem and c.KodeSatuan = 'sak'
                inner join satuans s on s.KodeSatuan = c.KodeSatuan
                WHERE i.jenisitem = 'bahanjadi'
                and MONTH(a.Tanggal) = '" . $request->month . "' and YEAR(a.Tanggal) = '" . $request->year . "'
                order by i.NamaItem, a.Tanggal, a.id) sort
                group by sort.KodeItem
                order by sort.NamaItem
            ");

            $saldo_akhir = DB::select("SELECT i.NamaItem, i.KodeItem, s.NamaSatuan, s.KodeSatuan, round((a.saldo/c.Konversi),4) as saldo
                FROM keluarmasukbarangs a
                inner join items i on a.KodeItem = i.KodeItem
                inner join itemkonversis c on a.KodeItem = c.KodeItem and c.KodeSatuan = 'sak'
                inner join satuans s on s.KodeSatuan = c.KodeSatuan
                WHERE a.id in 
                    (SELECT max(a.id)
                    from keluarmasukbarangs a
                    inner join items i on a.KodeItem = i.KodeItem
                    inner join itemkonversis c on a.KodeItem = c.KodeItem and c.KodeSatuan = 'sak'
                    inner join satuans s on s.KodeSatuan = c.KodeSatuan
                    WHERE i.jenisitem = 'bahanjadi'
                    and MONTH(a.Tanggal) = '" . $request->month . "' and YEAR(a.Tanggal) = '" . $request->year . "'
                    group by i.KodeItem)
                and i.jenisitem = 'bahanjadi'
                and MONTH(a.Tanggal) = '" . $request->month . "' and YEAR(a.Tanggal) = '" . $request->year . "'
                GROUP BY i.KodeItem
                ORDER BY i.NamaItem
            ");
        } else if ($satuanfil == "semua") {
            $stok = DB::select("SELECT i.NamaItem, s.NamaSatuan, s.KodeSatuan,
                SUM(CASE WHEN a.JenisTransaksi = 'RJB' THEN round((a.Qty/c.Konversi),4) ELSE 0 END) AS 'RJB',
                SUM(CASE WHEN a.JenisTransaksi = 'SJB' THEN round((a.Qty/c.Konversi),4) ELSE 0 END) AS 'SJB',
                SUM(CASE WHEN a.JenisTransaksi = 'SLM' THEN round((a.Qty/c.Konversi),4) ELSE 0 END) AS 'SLM',
                SUM(CASE WHEN a.JenisTransaksi = 'SLK' THEN round((a.Qty/c.Konversi),4) ELSE 0 END) AS 'SLK'
                from keluarmasukbarangs a
                inner join items i on a.KodeItem = i.KodeItem
                inner join itemkonversis c on a.KodeItem = c.KodeItem and c.Konversi = 1
                inner join satuans s on s.KodeSatuan = c.KodeSatuan
                WHERE i.jenisitem = 'bahanjadi'
                and MONTH(a.Tanggal) = '" . $request->month . "' and YEAR(a.Tanggal) = '" . $request->year . "'
                group by a.KodeItem
                order by i.NamaItem
            ");

            $saldo_awal = DB::select("SELECT * from
                (SELECT i.NamaItem, i.KodeItem, s.NamaSatuan, s.KodeSatuan, round(((a.saldo-a.Qty)/c.Konversi),4) as saldo
                from keluarmasukbarangs a
                inner join items i on a.KodeItem = i.KodeItem
                inner join itemkonversis c on a.KodeItem = c.KodeItem and c.Konversi = 1
                inner join satuans s on s.KodeSatuan = c.KodeSatuan
                WHERE i.jenisitem = 'bahanjadi'
                and MONTH(a.Tanggal) = '" . $request->month . "' and YEAR(a.Tanggal) = '" . $request->year . "'
                order by i.NamaItem, a.Tanggal, a.id) sort
                group by sort.KodeItem
                order by sort.NamaItem
            ");

            $saldo_akhir = DB::select("SELECT i.NamaItem, i.KodeItem, s.NamaSatuan, s.KodeSatuan, round((a.saldo/c.Konversi),4) as saldo
                FROM keluarmasukbarangs a
                inner join items i on a.KodeItem = i.KodeItem
                inner join itemkonversis c on a.KodeItem = c.KodeItem and c.Konversi = 1
                inner join satuans s on s.KodeSatuan = c.KodeSatuan
                WHERE a.id in 
                    (SELECT max(a.id)
                    from keluarmasukbarangs a
                    inner join items i on a.KodeItem = i.KodeItem
                    inner join itemkonversis c on a.KodeItem = c.KodeItem and c.Konversi = 1
                    inner join satuans s on s.KodeSatuan = c.KodeSatuan
                    WHERE i.jenisitem = 'bahanjadi'
                    and MONTH(a.Tanggal) = '" . $request->month . "' and YEAR(a.Tanggal) = '" . $request->year . "'
                    group by i.KodeItem)
                and i.jenisitem = 'bahanjadi'
                and MONTH(a.Tanggal) = '" . $request->month . "' and YEAR(a.Tanggal) = '" . $request->year . "'
                GROUP BY i.KodeItem
                ORDER BY i.NamaItem
            ");
        }

        foreach ($stok as $key => $value) {
            $stok[$key]->SaldoAwal = $saldo_awal[$key]->saldo;
            $stok[$key]->SaldoAkhir = $saldo_akhir[$key]->saldo;
        }

        return view('stok.datastok.index', compact('year_now', 'stok', 'saldo_awal', 'filter', 'filterdate', 'satuanfil'));
    }

    public function filterdate(Request $request)
    {
        $year_now = date('Y');
        $filter = true;
        $filterdate = true;
        $satuanfil = $request->satuan;
        if ($satuanfil == "kg") {
            $stok = DB::select("SELECT i.NamaItem, s.NamaSatuan, s.KodeSatuan,
                SUM(CASE WHEN a.JenisTransaksi = 'RJB' THEN round((a.Qty/c.Konversi),4) ELSE 0 END) AS 'RJB',
                SUM(CASE WHEN a.JenisTransaksi = 'SJB' THEN round((a.Qty/c.Konversi),4) ELSE 0 END) AS 'SJB',
                SUM(CASE WHEN a.JenisTransaksi = 'SLM' THEN round((a.Qty/c.Konversi),4) ELSE 0 END) AS 'SLM',
                SUM(CASE WHEN a.JenisTransaksi = 'SLK' THEN round((a.Qty/c.Konversi),4) ELSE 0 END) AS 'SLK'
                from keluarmasukbarangs a
                inner join items i on a.KodeItem = i.KodeItem
                inner join itemkonversis c on a.KodeItem = c.KodeItem and c.KodeSatuan = 'kg'
                inner join satuans s on s.KodeSatuan = c.KodeSatuan
                WHERE i.jenisitem = 'bahanjadi'
                and a.Tanggal BETWEEN '" . $request->start . "' AND '" . $request->finish . "'
                group by a.KodeItem
                order by i.NamaItem
            ");

            $saldo_awal = DB::select("SELECT * from
                (SELECT i.NamaItem, i.KodeItem, s.NamaSatuan, s.KodeSatuan, round(((a.saldo-a.Qty)/c.Konversi),4) as saldo
                from keluarmasukbarangs a
                inner join items i on a.KodeItem = i.KodeItem
                inner join itemkonversis c on a.KodeItem = c.KodeItem and c.KodeSatuan = 'kg'
                inner join satuans s on s.KodeSatuan = c.KodeSatuan
                WHERE i.jenisitem = 'bahanjadi'
                and a.Tanggal BETWEEN '" . $request->start . "' AND '" . $request->finish . "'
                order by i.NamaItem, a.Tanggal, a.id) sort
                group by sort.KodeItem
                order by sort.NamaItem
            ");

            $saldo_akhir = DB::select("SELECT i.NamaItem, i.KodeItem, s.NamaSatuan, s.KodeSatuan, round((a.saldo/c.Konversi),4) as saldo
                FROM keluarmasukbarangs a
                inner join items i on a.KodeItem = i.KodeItem
                inner join itemkonversis c on a.KodeItem = c.KodeItem and c.KodeSatuan = 'kg'
                inner join satuans s on s.KodeSatuan = c.KodeSatuan
                WHERE a.id in 
                    (SELECT max(a.id)
                    from keluarmasukbarangs a
                    inner join items i on a.KodeItem = i.KodeItem
                    inner join itemkonversis c on a.KodeItem = c.KodeItem and c.KodeSatuan = 'kg'
                    inner join satuans s on s.KodeSatuan = c.KodeSatuan
                    WHERE i.jenisitem = 'bahanjadi'
                    and a.Tanggal BETWEEN '" . $request->start . "' AND '" . $request->finish . "'
                    group by i.KodeItem)
                and i.jenisitem = 'bahanjadi'
                and a.Tanggal BETWEEN '" . $request->start . "' AND '" . $request->finish . "'
                GROUP BY i.KodeItem
                ORDER BY i.NamaItem
            ");
        } else if ($satuanfil == "sak") {
            $stok = DB::select("SELECT i.NamaItem, s.NamaSatuan, s.KodeSatuan,
                SUM(CASE WHEN a.JenisTransaksi = 'RJB' THEN round((a.Qty/c.Konversi),4) ELSE 0 END) AS 'RJB',
                SUM(CASE WHEN a.JenisTransaksi = 'SJB' THEN round((a.Qty/c.Konversi),4) ELSE 0 END) AS 'SJB',
                SUM(CASE WHEN a.JenisTransaksi = 'SLM' THEN round((a.Qty/c.Konversi),4) ELSE 0 END) AS 'SLM',
                SUM(CASE WHEN a.JenisTransaksi = 'SLK' THEN round((a.Qty/c.Konversi),4) ELSE 0 END) AS 'SLK'
                from keluarmasukbarangs a
                inner join items i on a.KodeItem = i.KodeItem
                inner join itemkonversis c on a.KodeItem = c.KodeItem and c.KodeSatuan = 'sak'
                inner join satuans s on s.KodeSatuan = c.KodeSatuan
                WHERE i.jenisitem = 'bahanjadi'
                and a.Tanggal BETWEEN '" . $request->start . "' AND '" . $request->finish . "'
                group by a.KodeItem
                order by i.NamaItem
            ");

            $saldo_awal = DB::select("SELECT * from
                (SELECT i.NamaItem, i.KodeItem, s.NamaSatuan, s.KodeSatuan, round(((a.saldo-a.Qty)/c.Konversi),4) as saldo
                from keluarmasukbarangs a
                inner join items i on a.KodeItem = i.KodeItem
                inner join itemkonversis c on a.KodeItem = c.KodeItem and c.KodeSatuan = 'sak'
                inner join satuans s on s.KodeSatuan = c.KodeSatuan
                WHERE i.jenisitem = 'bahanjadi'
                and a.Tanggal BETWEEN '" . $request->start . "' AND '" . $request->finish . "'
                order by i.NamaItem, a.Tanggal, a.id) sort
                group by sort.KodeItem
                order by sort.NamaItem
            ");

            $saldo_akhir = DB::select("SELECT i.NamaItem, i.KodeItem, s.NamaSatuan, s.KodeSatuan, round((a.saldo/c.Konversi),4) as saldo
                FROM keluarmasukbarangs a
                inner join items i on a.KodeItem = i.KodeItem
                inner join itemkonversis c on a.KodeItem = c.KodeItem and c.KodeSatuan = 'sak'
                inner join satuans s on s.KodeSatuan = c.KodeSatuan
                WHERE a.id in 
                    (SELECT max(a.id)
                    from keluarmasukbarangs a
                    inner join items i on a.KodeItem = i.KodeItem
                    inner join itemkonversis c on a.KodeItem = c.KodeItem and c.KodeSatuan = 'sak'
                    inner join satuans s on s.KodeSatuan = c.KodeSatuan
                    WHERE i.jenisitem = 'bahanjadi'
                    and a.Tanggal BETWEEN '" . $request->start . "' AND '" . $request->finish . "'
                    group by i.KodeItem)
                and i.jenisitem = 'bahanjadi'
                and a.Tanggal BETWEEN '" . $request->start . "' AND '" . $request->finish . "'
                GROUP BY i.KodeItem
                ORDER BY i.NamaItem
            ");
        } else if ($satuanfil == "semua") {
            $stok = DB::select("SELECT i.NamaItem, s.NamaSatuan, s.KodeSatuan,
                SUM(CASE WHEN a.JenisTransaksi = 'RJB' THEN round((a.Qty/c.Konversi),4) ELSE 0 END) AS 'RJB',
                SUM(CASE WHEN a.JenisTransaksi = 'SJB' THEN round((a.Qty/c.Konversi),4) ELSE 0 END) AS 'SJB',
                SUM(CASE WHEN a.JenisTransaksi = 'SLM' THEN round((a.Qty/c.Konversi),4) ELSE 0 END) AS 'SLM',
                SUM(CASE WHEN a.JenisTransaksi = 'SLK' THEN round((a.Qty/c.Konversi),4) ELSE 0 END) AS 'SLK'
                from keluarmasukbarangs a
                inner join items i on a.KodeItem = i.KodeItem
                inner join itemkonversis c on a.KodeItem = c.KodeItem and c.Konversi = 1
                inner join satuans s on s.KodeSatuan = c.KodeSatuan
                WHERE i.jenisitem = 'bahanjadi'
                and a.Tanggal BETWEEN '" . $request->start . "' AND '" . $request->finish . "'
                group by a.KodeItem
                order by i.NamaItem
            ");

            $saldo_awal = DB::select("SELECT * from
                (SELECT i.NamaItem, i.KodeItem, s.NamaSatuan, s.KodeSatuan, round(((a.saldo-a.Qty)/c.Konversi),4) as saldo
                from keluarmasukbarangs a
                inner join items i on a.KodeItem = i.KodeItem
                inner join itemkonversis c on a.KodeItem = c.KodeItem and c.Konversi = 1
                inner join satuans s on s.KodeSatuan = c.KodeSatuan
                WHERE i.jenisitem = 'bahanjadi'
                and a.Tanggal BETWEEN '" . $request->start . "' AND '" . $request->finish . "'
                order by i.NamaItem, a.Tanggal, a.id) sort
                group by sort.KodeItem
                order by sort.NamaItem
            ");

            $saldo_akhir = DB::select("SELECT i.NamaItem, i.KodeItem, s.NamaSatuan, s.KodeSatuan, round((a.saldo/c.Konversi),4) as saldo
            FROM keluarmasukbarangs a
            inner join items i on a.KodeItem = i.KodeItem
            inner join itemkonversis c on a.KodeItem = c.KodeItem and c.Konversi = 1
            inner join satuans s on s.KodeSatuan = c.KodeSatuan
            WHERE a.id in 
                (SELECT max(a.id)
                from keluarmasukbarangs a
                inner join items i on a.KodeItem = i.KodeItem
                inner join itemkonversis c on a.KodeItem = c.KodeItem and c.Konversi = 1
                inner join satuans s on s.KodeSatuan = c.KodeSatuan
                WHERE i.jenisitem = 'bahanjadi'
                and a.Tanggal BETWEEN '" . $request->start . "' AND '" . $request->finish . "'
                group by i.KodeItem)
            and i.jenisitem = 'bahanjadi'
            and a.Tanggal BETWEEN '" . $request->start . "' AND '" . $request->finish . "'
            GROUP BY i.KodeItem
            ORDER BY i.NamaItem
        ");
        }

        $start = $request->start;
        $finish = $request->finish;

        foreach ($stok as $key => $value) {
            $stok[$key]->SaldoAwal = $saldo_awal[$key]->saldo;
            $stok[$key]->SaldoAkhir = $saldo_akhir[$key]->saldo;
        }

        return view('stok.datastok.index', compact('year_now', 'stok', 'saldo_awal', 'filter', 'filterdate', 'start', 'finish', 'satuanfil'));
    }
}
