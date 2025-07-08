<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterPaketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all = \DB::table('rak')->where('status', 'OPN')->get();
        return view('master.paket.index', compact('all'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bahanjadi = \DB::table('items')
            ->where('Status','OPN')
            ->where('jenisitem','bahanjadi')
            ->get();

        $satuan = \DB::table('satuans')->where('Status','OPN')->get();

        return view('master.paket.create', compact('bahanjadi', 'satuan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            \DB::transaction(function () use ($request) {
                $cek = \DB::table('rak')->count();
                $kode = 'R-'.str_pad($cek+1, 3, '0', STR_PAD_LEFT);

                $data = array(
                    'kode' => $kode,
                    'nama' => $request->nama,
                    'harga' => $request->harga,
                    'created_at' => date('Y-m-d H:i:s'),
                );

                \DB::table('rak')->insert($data);

                foreach ($request->komponen as $key => $value) {
                    $subdata = array(
                        'rak' => $kode,
                        'item' => $request->komponen[$key],
                        'jumlah' => $request->qty[$key],
                    );

                    \DB::table('rakdetail')->insert($subdata);
                }
            });

            return redirect()->route('masterpaket.index')->with(['created' => 'Rak baru telah ditambahkan']);
        } catch (Exception $e) {
            \DB::rollback();

            return redirect()->route('masterpaket.index')->with(['deleted' => $e->getMessage()]);
        }
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('rak')->where('kode', $id)->update([
            'status' => 'DEL',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('masterpaket.index')->with(['deleted' => 'Data paket dihapus']);
    }
}
