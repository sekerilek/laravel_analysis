<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Datatables;

class MasterResepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.resep.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /*$resep_terakhir = DB::select("select * from `prod_resepheader` where `Status` = 'OPN' order by `IDResep` desc limit 1");

        if ($resep_terakhir == null) {
            $newkoderesep = 'RCP-001';
        } else {
            $id = (int)substr($resep_terakhir[0]->KodeResep, -3);
            $id = $id + 1;
            if ($id >= 100) {
                $newkoderesep = 'RCP-' . $id;
            } else if ($id >= 10) {
                $newkoderesep = 'RCP-0' . $id;
            } else {
                $newkoderesep = 'RCP-00' . $id;
            }
        }*/

        /*ambil daftar nama bahan jadi*/
        $bahanjadi = DB::table('items')
            ->select('items.KodeItem', 'items.NamaItem')
            ->where('items.Status', 'OPN')
            ->where('items.jenisitem', 'bahanjadi')
            ->get();

        $bahanbaku = DB::table('items')
            ->select('KodeItem', 'NamaItem')
            ->where('items.Status', 'OPN')
            ->where('items.jenisitem', 'bahanbaku')
            ->get();

        return view('master.resep.create', compact('bahanjadi', 'bahanbaku'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $koderesep      = $request->KodeResep;
        $namaresep      = $request->NamaResep;
        $keteranganresep = $request->KeteranganResep;
        $satuanresep    = $request->SatuanResep;
        $qtyresep       = $request->JumlahResep;
        $baku           = $request->BahanBaku;
        $satuanbaku     = $request->SatuanBahanBaku;
        $jumlahbaku     = $request->JumlahBahanBaku;
        $keteranganbaku = $request->KeteranganBahanBaku;

        DB::table('prod_resepheader')->insert([
            'KodeResep'         => $koderesep,
            'KodeItem'          => $namaresep,
            'Keterangan'        => $keteranganresep,
            'Status'            => 'OPN',
            'KodeUser'          => \Auth::user()->name,
            'created_at'        => \Carbon\Carbon::now(),
            'updated_at'        => \Carbon\Carbon::now(),
            'Qty'               => $qtyresep,
            'KodeSatuan'        => $satuanresep,
        ]);

        $x = 0;
        foreach ($baku as $key => $value) {
            $x++;
            DB::table('prod_resepdetail')->insert([
                'KodeResep'     => $koderesep,
                'KodeItem'      => $baku[$key],
                'KodeSatuan'    => $satuanbaku[$key],
                'Qty'           => $jumlahbaku[$key],
                'Keterangan'    => $keteranganbaku[$key],
                'NoUrut'        => $x,
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now(),
            ]);
        }

        try {
            DB::transaction(function () use ($request) {
                $cek = DB::table('resep')->count() + 1;
                $kode = 'RCP-'.str_pad($cek, 3, '0', STR_PAD_LEFT);

                DB::table('resep')->insert(array(
                    'kode' => $kode,
                    'item' => $request->NamaResep,

                ));
            });
        } catch (Exception $e) {
            
        }

        return redirect('/masterresep')->with(['created' => 'Resep untuk kode barang ' . $namaresep . ' berhasil dibuat']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $resepdetail = DB::table('prod_resepdetail')
            ->join('items', 'prod_resepdetail.KodeItem', '=', 'items.KodeItem')
            ->join('satuans', 'prod_resepdetail.KodeSatuan', '=', 'satuans.KodeSatuan')
            ->select(
                'items.NamaItem',
                'prod_resepdetail.Keterangan',
                'prod_resepdetail.Qty',
                'satuans.NamaSatuan'
            )
            ->where('prod_resepdetail.KodeResep', $request->kode)
            ->get();

        return Datatables::of($resepdetail)->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bahanbaku = DB::table('items')
            ->select('KodeItem', 'NamaItem')
            ->where('items.Status', 'OPN')
            ->where('items.jenisitem', 'bahanbaku')
            ->get();

        $bahanbakuresep = DB::table('prod_resepdetail')
            ->join('items', 'prod_resepdetail.KodeItem', '=', 'items.KodeItem')
            ->where('prod_resepdetail.KodeResep', $id)
            ->get();

        $bahanjadi  = DB::table('items')
            ->leftJoin('prod_resepheader', 'prod_resepheader.KodeItem', '=', 'items.KodeItem')
            ->where('prod_resepheader.KodeResep', $id)
            ->where('prod_resepheader.Status', 'OPN')
            ->select('prod_resepheader.*', 'items.NamaItem')
            ->get();

        return view('master.resep.edit', [
            'bahanbaku'     => $bahanbaku,
            'bahanbakuresep' => $bahanbakuresep,
            'resep'         => $bahanjadi,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $koderesep      = $request->KodeResep;
        $namaresep      = $request->NamaResep;
        $keteranganresep = $request->KeteranganResep;
        $satuanresep    = $request->SatuanResep;
        $qtyresep       = $request->JumlahResep;
        $baku           = $request->BahanBaku;
        $satuanbaku     = $request->SatuanBahanBaku;
        $jumlahbaku     = $request->JumlahBahanBaku;
        $keteranganbaku = $request->KeteranganBahanBaku;

        DB::table('prod_resepheader')->where('IDResep', $id)->update([
            'Keterangan'        => $keteranganresep,
            'KodeUser'          => Auth::id(),
            'created_at'        => \Carbon\Carbon::now(),
            'updated_at'        => \Carbon\Carbon::now(),
            'Qty'               => $qtyresep,
            'KodeSatuan'        => $satuanresep,
        ]);

        foreach ($baku as $key => $value) {
            DB::table('prod_resepdetail')->where('KodeResep', $koderesep)->update([
                'KodeItem'      => $baku[$key],
                'KodeSatuan'    => $satuanbaku[$key],
                'Qty'           => $jumlahbaku[$key],
                'Keterangan'    => $keteranganbaku[$key],
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now(),
            ]);
        }

        return redirect('/masterresep')->with(['created' => 'Resep untuk kode barang ' . $namaresep . ' berhasil dibuat']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('prod_resepheader')
            ->where('KodeResep', $id)
            ->update([
                'Status'    => 'DEL'
            ]);

        return redirect('/masterresep')->with(['deleted' => 'Resep untuk kode barang ' . $id . ' telah dihapus']);
    }

    public function apiDetail(Request $request)
    {
        /*$resepdetail = DB::table('prod_resepdetail')
            ->join('items', 'prod_resepdetail.KodeItem', '=', 'items.KodeItem')
            ->join('satuans', 'prod_resepdetail.KodeSatuan', '=', 'satuans.KodeSatuan')
            ->select(
                'items.NamaItem',
                'prod_resepdetail.Keterangan',
                'prod_resepdetail.Qty',
                'satuans.NamaSatuan'
            )
            ->where('prod_resepdetail.KodeResep', $request->kode)
            ->get();*/

        $data = DB::table('resepdetail')
            ->leftJoin('items','resepdetail.item','=','items.KodeItem')
            ->leftJoin('satuans','resepdetail.satuan','=','satuans.KodeSatuan')
            ->where('resepdetail.resep', $request->kode)
            ->select(
                'resepdetail.jumlah',
                'items.NamaItem',
                'satuans.KodeSatuan'
            )
            ->get();

        return Datatables::of($data)->make(true);
    }

    public function apiOPN()
    {
        /*$resep = DB::table('prod_resepheader')
            ->join('items', 'prod_resepheader.KodeItem', '=', 'items.KodeItem')
            ->join('satuans', 'prod_resepheader.KodeSatuan', '=', 'satuans.KodeSatuan')
            ->select(
                'prod_resepheader.KodeResep',
                'items.NamaItem',
                'prod_resepheader.Keterangan',
                'prod_resepheader.Qty',
                'satuans.NamaSatuan'
            )
            ->where('prod_resepheader.Status', 'OPN')
            ->get();*/

        $data = DB::table('resep')
            ->leftJoin('items','resep.item','=','items.KodeItem')
            ->where('status','OPN')->get();

        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                return
                    '<form style="display:inline-block;">' .
                    '<button type="button" class="btn btn-primary btn-xs" onclick="detailResep(\'' . $data->kode . '\')"><i class="fa fa-eye"></i>&nbsp;Lihat Bahan</button></form>' .

                    '<form style="display:inline-block;" type="submit" action="/masterresep/' . $data->kode . '/edit" method="get">' .
                    '<button class="btn btn-success btn-xs" data-function="ubah"><i class="fa fa-pencil"></i>&nbsp;Ubah</button></form>' .

                    '<form style="display:inline-block;" action="/masterresep/delete/' . $data->kode . '" method="get" onsubmit="return showConfirm()">' .
                    '<button class="btn btn-danger btn-xs" data-function="hapus"><i class="fa fa-trash"></i>&nbsp;Hapus</button></form>';
            })
            ->make(true);
    }

    public function apiSatuanOPN(Request $request)
    {
        $barang = $request->kode;

        $satuan = DB::table('satuans')
            ->select('satuans.KodeSatuan', 'satuans.NamaSatuan')
            ->leftJoin('itemkonversis', 'satuans.KodeSatuan', '=', 'itemkonversis.KodeSatuan')
            ->where('itemkonversis.KodeItem', $barang)
            ->where('satuans.Status', 'OPN')
            ->get();

        $option = '';
        foreach ($satuan as $key => $value) {
            $option = $option . '<option value="' . $value->KodeSatuan . '">' . $value->NamaSatuan . '</option>';
        }

        return $option;
    }
}
