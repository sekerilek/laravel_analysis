<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Model\keluarmasukbarang;
use App\Model\satuan;
use App\Model\item;
use PDF;

class SisaStokController extends Controller
{
    public function index()
    {
        /*$items = DB::select("SELECT i.KodeItem, i.NamaItem, k.Konversi, k.Konversi as sisa, s.NamaSatuan, s.KodeSatuan 
            FROM items i
            left join itemkonversis k on k.KodeItem = i.KodeItem
            left join satuans s on s.KodeSatuan = k.KodeSatuan
            WHERE k.Konversi = 1 and s.Status = 'OPN'
            order by i.NamaItem
        ");
        $satuan = satuan::where('Status', 'OPN')->get();
        foreach ($items as $key => $value) {
            $last_saldo[$key] = DB::table('keluarmasukbarangs')->where('KodeItem', $value->KodeItem)->orderBy('id', 'desc')->limit(1)->pluck('saldo')->toArray();

            if (isset($last_saldo[$key][0])) {
                $saldo = (float) $last_saldo[$key][0] / (float) $value->Konversi;
                $value->sisa = $saldo;
            } else {
                $value->sisa = 0;
            }
        }*/

        $item = item::where('Status','OPN')->select('KodeItem','NamaItem')->orderBy('NamaItem','asc')->get();
        
        $filter = false;

        session()->put('item','');
        session()->put('item_list',$item);

        return view('stok.sisastok.index', compact('filter'));
    }

    public function show(Request $request)
    {
        /*$items = DB::select("SELECT i.KodeItem, i.NamaItem, k.Konversi, k.Konversi as sisa, s.NamaSatuan, s.KodeSatuan 
            FROM items i
            left join itemkonversis k on k.KodeItem = i.KodeItem
            left join satuans s on s.KodeSatuan = k.KodeSatuan
            WHERE i.Status = 'OPN'
            order by i.KodeItem
        ");
        $satuan = satuan::where('Status', 'OPN')->get();
        foreach ($items as $key => $value) {
            $last_saldo[$key] = DB::table('keluarmasukbarangs')->where('KodeItem', $value->KodeItem)->orderBy('id', 'desc')->limit(1)->pluck('saldo')->toArray();

            if (isset($last_saldo[$key][0])) {
                $saldo = (float) $last_saldo[$key][0] / (float) $value->Konversi;
                $value->sisa = $saldo;
            } else {
                $value->sisa = 0;
            }
        }
        $jenisfil = $request->jenis;
        $satuanfil = $request->satuan;*/

        $items = DB::select("
            SELECT
                i.KodeItem,
                i.NamaItem,
                s.NamaSatuan,
                km.saldo as `SisaStok`,
                ss.NamaSupplier
            FROM items i
            LEFT JOIN itemkonversis ik ON i.Kodeitem = ik.KodeItem
            LEFT JOIN satuans s ON ik.KodeSatuan = s.KodeSatuan
            LEFT JOIN keluarmasukbarangs km ON i.Kodeitem = km.KodeItem
            LEFT JOIN penerimaanbarangs pb ON pb.KodePenerimaanBarang = km.KodeTransaksi
            LEFT JOIN pemesananpembelians pp ON pp.KodePO = pb.KodePO
            LEFT JOIN suppliers ss ON pp.KodeSupplier = ss.KodeSupplier
            WHERE 
                km.Tanggal <= NOW()
                AND km.id IN (
                    SELECT MAX(k.id)
                    FROM keluarmasukbarangs k
                    GROUP BY k.KodeItem
                )
            ORDER BY i.NamaItem ASC
        ");
        dd($items);
        $filter = true;

        session()->put('item','');
        
        return view('stok.sisastok.index', compact('items', 'filter'));
    }

    public function filter(Request $request)
    {
        /*$items = DB::select("SELECT i.KodeItem, i.NamaItem, k.Konversi, k.Konversi as sisa, s.NamaSatuan, s.KodeSatuan 
            FROM items i
            left join itemkonversis k on k.KodeItem = i.KodeItem
            left join satuans s on s.KodeSatuan = k.KodeSatuan
            WHERE s.KodeSatuan = '" . $request->satuanfil . "' and i.jenisitem = '" . $request->jenisfil . "' and s.Status = 'OPN'
            order by i.NamaItem
        ");
        $satuan = satuan::where('Status', 'OPN')->get();
        $filter = true;
        foreach ($items as $key => $value) {
            $last_saldo[$key] = DB::table('keluarmasukbarangs')->where('KodeItem', $value->KodeItem)->orderBy('id', 'desc')->limit(1)->pluck('saldo')->toArray();

            if (isset($last_saldo[$key][0])) {
                $saldo = (float) $last_saldo[$key][0] / (float) $value->Konversi;
                $value->sisa = $saldo;
            } else {
                $value->sisa = 0;
            }
        }
        $jenisfil = $request->jenis;
        $satuanfil = $request->satuan;*/

        $item = $request->item;

        $items = DB::select("
            SELECT
                i.KodeItem,
                i.NamaItem,
                s.NamaSatuan,
                km.saldo as `SisaStok`
            FROM items i
            LEFT JOIN itemkonversis ik ON i.Kodeitem = ik.KodeItem
            LEFT JOIN satuans s ON ik.KodeSatuan = s.KodeSatuan
            LEFT JOIN keluarmasukbarangs km ON i.Kodeitem = km.KodeItem
            WHERE 
                i.KodeItem = '$item'
                AND km.Tanggal <= NOW()
                AND km.id IN (
                    SELECT MAX(k.id)
                    FROM keluarmasukbarangs k
                    GROUP BY k.KodeItem
                )
            ORDER BY i.NamaItem ASC
        ");

        $filter = true;

        session()->put('item', $item);

        return view('stok.sisastok.index', compact('items', 'filter'));
    }
}
