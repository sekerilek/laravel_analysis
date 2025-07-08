<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\supplier;
use DB;
use Datatables;

class MasterSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.supplier.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $last_id = DB::select('SELECT * FROM suppliers ORDER BY KodeSupplier DESC LIMIT 1');

        //Auto generate ID
        if ($last_id == null) {
            $newID = "SUP-001";
        } else {
            $string = $last_id[0]->KodeSupplier;
            $id = substr($string, -3, 3);
            $new = $id + 1;
            $new = str_pad($new, 3, '0', STR_PAD_LEFT);
            $newID = "SUP-" . $new;
        }

        return view('master.supplier.create', compact('newID'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'KodeSupplier' => 'required',
            'NamaSupplier' => 'required',
            'Kontak' => 'required',
            'Alamat' => 'required',
        ]);

        DB::table('suppliers')->insert([
            'KodeSupplier' => $request->KodeSupplier,
            'NamaSupplier' => $request->NamaSupplier,
            'Kontak' => $request->Kontak,
            'Alamat' => $request->Alamat,
            'Kota' => $request->Kota,
            'KodeUser' => \Auth::user()->name,
            'Status' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Tambah supplier ' . $request->KodeSupplier,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Supplier ' . $request->NamaSupplier . ' berhasil ditambahkan';
        return redirect('/mastersupplier')->with(['created' => $pesan]);
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
        $supplier = DB::table('suppliers')->get()->where('KodeSupplier', $id);
        return view('master.supplier.edit', compact('supplier'));
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
        $this->validate($request, [
            'KodeSupplier' => 'required',
            'NamaSupplier' => 'required',
            'Kontak' => 'required',
            'Alamat' => 'required',
        ]);

        DB::table('suppliers')->where('KodeSupplier', $request->KodeSupplier)->update([
            'KodeSupplier' => $request->KodeSupplier,
            'NamaSupplier' => $request->NamaSupplier,
            'Kontak' => $request->Kontak,
            'Alamat' => $request->Alamat,
            'Kota' => $request->Kota,
            'KodeUser' => \Auth::user()->name,
            'Status' => 'OPN',
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Update supplier ' . $request->KodeSupplier,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Supplier ' . $request->NamaSupplier . ' berhasil diubah';
        return redirect('/mastersupplier')->with(['edited' => $pesan]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = supplier::find($id);
        $supplier->Status = 'DEL';
        $supplier->save();

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Hapus supplier ' . $id,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $supplier = DB::table('suppliers')->get()->where('KodeSupplier', $id);
        foreach ($supplier as $pel) {
            $pesan = 'supplier ' . $pel->NamaSupplier . ' berhasil dihapus';
        }
        return redirect('/mastersupplier')->with(['deleted' => $pesan]);
    }

    public function apiOPN()
    {
        $supplier = DB::table('suppliers')
            ->where('Status', 'OPN')
            ->get();

        return Datatables::of($supplier)
            ->addColumn('action', function ($supplier) {
                return
                    '<form style="display:inline-block;" type="submit" action="/mastersupplier/' . $supplier->KodeSupplier . '/edit" method="get">' .
                    '<button class="btn btn-primary btn-xs" data-function="ubah"><i class="fa fa-pencil"></i>&nbsp;Ubah</button></form>' .

                    '<form style="display:inline-block;" action="/mastersupplier/delete/' . $supplier->KodeSupplier . '" method="get" onsubmit="return showConfirm()">' .
                    '<button class="btn btn-danger btn-xs" data-function="hapus"><i class="fa fa-trash"></i>&nbsp;Hapus</button></form>';
            })
            ->make(true);
    }
}
