<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Model\keluarmasukbarang;
use App\Model\lokasi;
use App\Model\item;
use App\Model\satuan;
use PDF;

class KartuStokController extends Controller
{
    public function index()
    {
        /*$stok = DB::select("SELECT a.Tanggal, a.KodeItem, a.KodeLokasi, a.JenisTransaksi, a.KodeTransaksi, round((a.Qty/c.Konversi),4) as Qty, a.KodeUser, round(SUM(b.Qty)/c.Konversi,4) as saldo, l.NamaLokasi, i.NamaItem, s.NamaSatuan, s.KodeSatuan
            from keluarmasukbarangs a 
            inner join lokasis l on a.KodeLokasi = l.KodeLokasi 
            inner join items i on a.KodeItem = i.KodeItem
            left JOIN keluarmasukbarangs b on a.KodeItem = b.KodeItem and b.created_at <= a.created_at 
            left join itemkonversis c on a.KodeItem = c.KodeItem 
            left join satuans s on c.KodeSatuan = s.KodeSatuan
            group by a.Tanggal, a.KodeItem, a.KodeLokasi, a.JenisTransaksi, a.KodeTransaksi, a.Qty, a.HargaRata, a.KodeUser, a.idx, a.indexmov, l.NamaLokasi, i.NamaItem
            order by a.created_at desc ");*/
        /*$item = DB::select("SELECT s.KodeItem, s.NamaItem, s.Keterangan 
            FROM items s
            WHERE s.Status = 'OPN'
            ORDER BY s.NamaItem
        ")*/;
        // $store = lokasi::where('Status', 'OPN')->get();
        // $satuan = satuan::where('Status', 'OPN')->get();
        $item = item::where('Status','OPN')
            ->select('KodeItem','NamaItem','Keterangan')
            ->orderBy('NamaItem','asc')
            ->get();
        $filter = false;
        session()->put('date_start', \Carbon\Carbon::now()->format('Y-m-d'));
        session()->put('date_finish', \Carbon\Carbon::now()->format('Y-m-d'));
        session()->put('item', 'all');
        session()->put('item_list', $item);
        return view('stok.kartustok.index', compact('filter'));
    }

    public function show(Request $request)
    {
        // $stok = DB::select("SELECT a.Tanggal, a.KodeItem, a.KodeLokasi, a.JenisTransaksi, a.KodeTransaksi, round((a.Qty/min(c.Konversi)),4) as Qty, a.KodeUser, round(a.saldo/min(c.Konversi),4) as saldo, l.NamaLokasi, i.NamaItem, s.NamaSatuan, s.KodeSatuan
        //     from keluarmasukbarangs a 
        //     inner join lokasis l on a.KodeLokasi = l.KodeLokasi 
        //     inner join items i on a.KodeItem = i.KodeItem
        //     left join keluarmasukbarangs b on a.KodeItem = b.KodeItem and b.created_at <= a.created_at
        //     left join itemkonversis c on a.KodeItem = c.KodeItem
        //     left join satuans s on c.KodeSatuan = s.KodeSatuan
        //     group by a.KodeItem, a.KodeTransaksi, a.idx, a.indexmov
        //     order by convert(a.created_at, datetime) desc");
        
        /*$store = lokasi::where('Status', 'OPN')->get();
        $item = DB::select("SELECT s.KodeItem, s.NamaItem, s.Keterangan 
            FROM items s
            WHERE s.Status = 'OPN'
            ORDER BY s.NamaItem
        ");
        $satuan = satuan::where('Status', 'OPN')->get();*/

        $stok = DB::select("
            SELECT
                i.NamaItem,
                km.Tanggal,
                km.JenisTransaksi,
                km.KodeTransaksi,
                s.NamaSatuan,
                km.Qty,
                km.saldo
            FROM items i
            LEFT JOIN itemkonversis ik ON i.Kodeitem = ik.KodeItem
            LEFT JOIN satuans s ON ik.KodeSatuan = s.KodeSatuan
            LEFT JOIN keluarmasukbarangs km ON i.Kodeitem = km.KodeItem
            WHERE km.Tanggal <= NOW()
            ORDER BY i.NamaItem ASC, km.Tanggal ASC
        ");
        
        $filter = true;
        
        return view('stok.kartustok.index', compact('stok', 'filter'));
    }

    public function filter(Request $request)
    {
        /*$stok = DB::select("SELECT a.Tanggal, a.KodeItem, a.KodeLokasi, a.JenisTransaksi, a.KodeTransaksi, round((a.Qty/c.Konversi),4) as Qty, a.KodeUser, round(a.saldo/c.Konversi,4) as saldo, l.NamaLokasi, i.NamaItem, s.NamaSatuan, s.KodeSatuan
            from keluarmasukbarangs a 
            inner join lokasis l on a.KodeLokasi = l.KodeLokasi 
            inner join items i on a.KodeItem = i.KodeItem    
            left join keluarmasukbarangs b on a.KodeItem = b.KodeItem and b.created_at <= a.created_at
            left join itemkonversis c on a.KodeItem = c.KodeItem
            left join satuans s on c.KodeSatuan = '" . $request->satuan . "' and s.KodeSatuan = c.KodeSatuan
            where a.Tanggal >='" . $request->start . "' and a.Tanggal <='" . $request->finish . "'
            and a.KodeLokasi='" . $request->lokasi . "' and a.KodeItem='" . $request->item . "' and c.KodeSatuan='" . $request->satuan . "' 
            group by a.Tanggal, a.KodeItem, a.KodeLokasi, a.JenisTransaksi, a.KodeTransaksi, a.Qty, l.NamaLokasi, i.NamaItem
            order by convert(a.created_at, datetime) desc");
        $store = lokasi::where('Status', 'OPN')->get();
        $item = DB::select("SELECT s.KodeItem, s.NamaItem, s.Keterangan 
            FROM items s
            WHERE s.Status = 'OPN'
            ORDER BY s.NamaItem
        ");
        $satuan = satuan::where('Status', 'OPN')->get();
        $filter = true;
        $start = $request->start;
        $finish = $request->finish;
        $lokasifil = $request->lokasi;
        $itemfil = $request->item;
        $satuanfil = $request->satuan;*/

        $date_start = $request->start;
        $date_finish = $request->finish;
        $query_item = $request->item == 'all' ? "" : "AND i.KodeItem = '$request->item'";

        $stok = DB::select("
            SELECT
                i.NamaItem,
                km.Tanggal,
                km.JenisTransaksi,
                km.KodeTransaksi,
                s.NamaSatuan,
                km.Qty,
                km.saldo
            FROM items i
            LEFT JOIN itemkonversis ik ON i.Kodeitem = ik.KodeItem
            LEFT JOIN satuans s ON ik.KodeSatuan = s.KodeSatuan
            LEFT JOIN keluarmasukbarangs km ON i.Kodeitem = km.KodeItem
            WHERE 
                km.Tanggal >= '$date_start '
                AND km.Tanggal <= '$date_finish'
                $query_item
            ORDER BY i.NamaItem ASC, km.Tanggal ASC
        ");

        $filter = true;

        session()->put('date_start', $date_start);
        session()->put('date_finish', $date_finish);
        session()->put('item', $request->item);

        return view('stok.kartustok.index', compact('stok', 'filter'));
    }

    public function print(Request $request)
    {
        if ($request->start != null) {
            $stok = DB::select("SELECT a.Tanggal, a.KodeItem, a.KodeLokasi, a.JenisTransaksi, a.KodeTransaksi, a.Qty, a.HargaRata, a.KodeUser, a.idx, a.indexmov, SUM(b.Qty) as saldo from keluarmasukbarangs a left JOIN keluarmasukbarangs b on a.KodeItem = b.KodeItem and b.created_at <= a.created_at
            left join itemkonversis c on a.KodeItem = c.KodeItem
            where a.Tanggal >='" . $request->start . "' and a.Tanggal <='" . $request->finish . "'
            and a.KodeLokasi='" . $request->lokasi . "' and a.KodeItem='" . $request->item . "'and c.KodeSatuan='" . $request->satuan . "' 
            group by a.Tanggal, a.KodeItem, a.KodeLokasi, a.JenisTransaksi, a.KodeTransaksi, a.Qty, a.HargaRata, a.KodeUser, a.idx, a.indexmov
            order by a.created_at desc");
        } else {
            $stok = DB::select("select a.Tanggal, a.KodeItem, a.KodeLokasi, a.JenisTransaksi, a.KodeTransaksi, a.Qty, a.HargaRata, a.KodeUser, a.idx, a.indexmov, SUM(b.Qty) as saldo from keluarmasukbarangs a left JOIN keluarmasukbarangs b on a.KodeItem = b.KodeItem and b.created_at <= a.created_at group by a.Tanggal, a.KodeItem, a.KodeLokasi, a.JenisTransaksi,a.KodeTransaksi,a.Qty, a.HargaRata, a.KodeUser, a.idx, a.indexmov order by a.created_at desc ");
        }
        $in = 0;
        $out = 0;
        foreach ($stok as $s) {
            if ($s->Qty > 0) {
                $in += $s->Qty;
            } else {
                $out += $s->Qty * -1;
            }
        }
        $pdf = PDF::loadview('stok.kartustok.pdf', ['stok' => $stok, 'in' => $in, 'out' => $out]);
        return $pdf->download('stok.kartustok.pdf');
    }
}
