<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\karyawan;
use Datatables;
use DB;

class ProduksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('produksi.hasil.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $produksi_terakhir = DB::table('prod_hasilproduksiheader')->orderBy('id', 'desc')->first();
        $kode_produksi = '';
        $year_now = date('y');
        $month_now = date('m');
        $date_now = date('d');
        $pref = "PRD-";

        if ($produksi_terakhir == null) {
            $kode_produksi = $pref . $year_now . $month_now . "0001";
        } else {
            $string = $produksi_terakhir->KodeProduksi;
            $ids = substr($string, -4, 4);
            $month = substr($string, -6, 2);
            $year = substr($string, -8, 2);

            if ((int) $year_now > (int) $year) {
                $newID = "0001";
            } else if ((int) $month_now > (int) $month) {
                $newID = "0001";
            } else {
                $newID = $ids + 1;
                $newID = str_pad($newID, 4, '0', STR_PAD_LEFT);
            }
            $kode_produksi = $pref . $year_now . $month_now . $newID;
        }

        $resep = DB::table('prod_resepheader')
            ->join('items', 'prod_resepheader.KodeItem', '=', 'items.KodeItem')
            ->join('satuans', 'prod_resepheader.KodeSatuan', '=', 'satuans.KodeSatuan')
            ->where('prod_resepheader.Status', 'OPN')
            ->get();

        $karyawan = karyawan::where('Status', 'OPN')
            ->select('KodeKaryawan', 'Nama')
            ->orderBy('Nama', 'asc')
            ->get();

        $satuan = DB::table('prod_resepheader')
            ->join('satuans', 'prod_resepheader.KodeSatuan', '=', 'satuans.KodeSatuan')
            ->where('prod_resepheader.Status', 'OPN')
            ->first();

        return view('produksi.hasil.create', compact('kode_produksi', 'resep', 'karyawan', 'satuan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::table('prod_hasilproduksiheader')
            ->insert([
                'KodeProduksi' => $request->KodeProduksi,
                'KodeResep' => $request->ResepProduksi,
                'TanggalProduksi' => $request->TanggalProduksi,
                'Status' => 'OPN',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);

        $karyawan = $request->KaryawanProduksi;
        $jumlah = $request->JumlahProduksi;
        $satuan = $request->SatuanProduksi;
        foreach ($karyawan as $key => $value) {
            DB::table('prod_hasilproduksidetail')
                ->insert([
                    'KodeResep' => $request->ResepProduksi,
                    'KodeProduksi' => $request->KodeProduksi,
                    'KodeKaryawan' => $karyawan[$key],
                    'QtyHasil' => $jumlah[$key],
                    'KodeSatuan' => $satuan[$key],
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ]);
        }

        return redirect('/produksi')->with(['created' => 'Data produksi ' . $request->NamaResepProduksi . ' dengan kode ' . $request->KodeProduksi . ' berhasil dibuat']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $produksi = DB::table('prod_hasilproduksiheader')
            ->join('prod_resepheader', 'prod_hasilproduksiheader.KodeResep', '=', 'prod_resepheader.KodeResep')
            ->join('items', 'prod_resepheader.KodeItem', '=', 'items.KodeItem')
            ->where('prod_hasilproduksiheader.KodeProduksi', $id)
            ->first();

        $produksi_detail = DB::table('prod_hasilproduksidetail')
            ->join('karyawans', 'prod_hasilproduksidetail.KodeKaryawan', '=', 'karyawans.KodeKaryawan')
            ->join('satuans', 'prod_hasilproduksidetail.KodeSatuan', '=', 'satuans.KodeSatuan')
            ->where('prod_hasilproduksidetail.KodeProduksi', $id)
            ->get();

        $karyawan = DB::table('karyawans')->where('Status', 'OPN')->get();
        return view('produksi.hasil.edit', compact('produksi', 'produksi_detail', 'karyawan'));
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
        $karyawan = $request->KaryawanProduksi;
        $jumlah = $request->JumlahProduksi;
        $old_karyawan = $request->OldKaryawanProduksi;

        foreach ($karyawan as $key => $value) {
            DB::table('prod_hasilproduksidetail')
                ->updateOrInsert(
                    [
                        'KodeProduksi' => $id,
                        'KodeKaryawan' => $old_karyawan[$key]
                    ],
                    [
                        'KodeKaryawan' => $karyawan[$key],
                        'QtyHasil' => $jumlah[$key],
                        'updated_at' => \Carbon\Carbon::now()
                    ]
                );
        }

        return redirect('/produksi')->with(['edited' => 'Data produksi ' . $request->NamaResepProduksi . ' dengan kode ' . $id . ' telah diperbarui']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produksi = DB::table('prod_hasilproduksiheader')
            ->join('prod_resepheader', 'prod_hasilproduksiheader.KodeResep', '=', 'prod_resepheader.KodeResep')
            ->join('items', 'prod_resepheader.KodeResep', '=', 'items.KodeItem')
            ->where('prod_hasilproduksiheader.id', $id)
            ->select('items.NamaItem')
            ->first();

        DB::table('prod_hasilproduksiheader')->where('id', $id)
            ->update(
                [
                    'Status' => 'DEL',
                    'updated_at' => \Carbon\Carbon::now()
                ]
            );

        return redirect('/produksi')->with(['deleted' => 'Data produksi ' . $produksi->NamaItem . ' telah dihapus']);
    }

    public function dataProduksi()
    {
        $produksi = DB::table('prod_hasilproduksiheader')
            ->join('prod_resepheader', 'prod_hasilproduksiheader.KodeResep', '=', 'prod_resepheader.KodeResep')
            ->join('items', 'prod_resepheader.KodeItem', '=', 'items.KodeItem')
            ->where('prod_hasilproduksiheader.Status', 'OPN')
            ->orderBy('prod_hasilproduksiheader.created_at', 'desc')
            ->select(
                'prod_hasilproduksiheader.id',
                'prod_hasilproduksiheader.KodeProduksi',
                'items.NamaItem',
                'prod_hasilproduksiheader.TanggalProduksi'
            )
            ->get();

        return Datatables::of($produksi)
            ->addColumn('action', function ($produksi) {
                return
                    '<form style="display:inline-block;">' .
                    '<button type="button" class="btn btn-primary btn-xs" onclick="detailProduksi(\'' . $produksi->KodeProduksi . '\')"><i class="fa fa-eye"></i>&nbsp;Lihat Rincian</button></form>' .

                    '<form style="display:inline-block;" type="submit" action="/produksi/' . $produksi->id . '/edit" method="get">' .
                    '<button data-function="ubah" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i>&nbsp;Ubah</button></form>' .

                    '<form style="display:inline-block;" action="/produksi/' . $produksi->id . '" method="post" onsubmit="return showConfirm()">' .
                    '<input type="hidden" name="_method" value="delete">' .
                    '<button class="btn btn-danger btn-xs" data-function="hapus"><i class="fa fa-trash"></i>&nbsp;Hapus</button></form>';
            })
            ->make(true);
    }

    public function dataProduksiDetail(Request $request)
    {
        $kode_produksi = $request->kode;

        $produksi = DB::table('prod_hasilproduksiheader')
            ->join('prod_hasilproduksidetail', 'prod_hasilproduksiheader.KodeProduksi', '=', 'prod_hasilproduksidetail.KodeProduksi')
            ->join('karyawans', 'prod_hasilproduksidetail.KodeKaryawan', '=', 'karyawans.KodeKaryawan')
            ->join('satuans', 'prod_hasilproduksidetail.KodeSatuan', '=', 'satuans.KodeSatuan')
            ->where('prod_hasilproduksiheader.KodeProduksi', $kode_produksi)
            ->orderBy('prod_hasilproduksiheader.TanggalProduksi', 'desc')
            ->select('karyawans.Nama', 'prod_hasilproduksidetail.QtyHasil', 'satuans.NamaSatuan')
            ->get();

        return Datatables::of($produksi)->make(true);
    }

    public function resep()
    {
        $item = DB::table('items')->where('Status','OPN')->get();
        return view('produksi.resep', compact('item'));
    }

    public function resepData($param)
    {
        if ($param == 'all') {
            $data = DB::table('rak')->where('status','OPN')->get();
        } else {
            $data = DB::table('rak')->where('status','OPN')->where('kode', $param)->get();
        }
        
        return Datatables::of($data)
            ->addColumn('tools', function ($data) {
                return '<button type="button" class="btn btn-info btnShow" data-id="'.$data->kode.'">Lihat</button>' .
                '<button type="button" class="btn btn-danger btnDelete" data-id="'.$data->kode.'">Hapus</button>';
            })
            ->make(true);
    }

    public function resepUpload(Request $request)
    {
        $data = $request;
        try {
            DB::transaction(function () use ($data) {
                $cek = DB::table('rak')->count();
                $kode = 'RAK'.str_pad($cek+1, 3, '0', STR_PAD_LEFT);

                $rak = array(
                    'kode' => $kode,
                    'harga' => $data->hargautama, 
                    'nama' => $data->namautama, 
                    'created_at' => date('Y-m-d H:i:s'),
                );

                $rakdetail = array();

                foreach ($data->itemutama as $key => $value) {
                    array_push($rakdetail, array(
                        'rak' => $kode,
                        'item' => $data->itemutama[$key],
                        'qty' => $data->qtyutama[$key]
                    ));
                }

                $cektambahan = DB::table('raktambahan')->count();
                $kodetambahan = 'RAKTB'.str_pad($cektambahan+1, 3, '0', STR_PAD_LEFT);

                $raktambahan = array(
                    'kode' => $kodetambahan,
                    'harga' => $data->hargatambahan, 
                    'rak' => $kode, 
                    'created_at' => date('Y-m-d H:i:s'),
                );

                $raktambahandetail = array();

                foreach ($data->itemtambahan as $key => $value) {
                    array_push($raktambahandetail, array(
                        'rak' => $kodetambahan,
                        'item' => $data->itemtambahan[$key],
                        'qty' => $data->qtytambahan[$key]
                    ));
                }

                DB::table('rak')->insert($rak);
                DB::table('rakdetail')->insert($rakdetail);
                DB::table('raktambahan')->insert($raktambahan);
                DB::table('raktambahandetail')->insert($raktambahandetail);
            });

            return redirect('/resep')->with(['created' => 'Data rak baru telah ditambahkan']);
        } catch (Exception $e) {
            return redirect('/resep')->with(['deleted' => $e->getMessage()]);
        }
    }
}
