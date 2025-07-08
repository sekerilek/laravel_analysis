<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Datatables;

class RekamMedisController extends Controller
{
	public function index()
	{
		// $rekammedis = DB::table('rekammedis')
		// 			->join('pelanggans', 'pelanggans.KodePelanggan', 'rekammedis.KodePelanggan')
		// 			->where('rekammedis.Status', 'OPN')
		// 			->select('rekammedis.id', 'rekammedis.KodeRekamMedis', 'rekammedis.KodePelanggan', 'pelanggans.NamaPelanggan', 'rekammedis.CatatanMedis', 'rekammedis.created_at')
		// 			->get();

        $pelanggans = DB::table('pelanggans')->where('Status', 'OPN')->get();

		return view('rekammedis.index', compact('pelanggans'));
	}

    public function detail($id)
    {
        $rekammedis = DB::table('rekammedis')
                    ->join('pelanggans', 'pelanggans.KodePelanggan', 'rekammedis.KodePelanggan')
                    ->where('rekammedis.KodePelanggan', $id)
                    ->where('rekammedis.Status', 'OPN')
                    ->select('rekammedis.id', 'rekammedis.KodeRekamMedis', 'rekammedis.KodePelanggan', 'pelanggans.NamaPelanggan', 'rekammedis.CatatanMedis', 'rekammedis.Tanggal')
                    ->get();

        $riwayatpembelians = DB::table('kasirdetails')
                            ->join('kasirs', 'kasirs.KodeKasir', '=', 'kasirdetails.KodeKasir')
                            ->join('items', 'items.KodeItem', '=', 'kasirdetails.KodeItem')
                            ->join('satuans', 'satuans.KodeSatuan', '=', 'kasirdetails.KodeSatuan')
                            ->where('kasirs.KodePelanggan', $id)
                            ->select('kasirs.KodeKasir', 'kasirs.Tanggal', 'kasirdetails.Subtotal', 'items.NamaItem', 'satuans.NamaSatuan', 'kasirdetails.Qty')
                            ->get();

        $pelanggans = DB::table('pelanggans')
                    ->where('KodePelanggan', $id)
                    ->get();

        return view('rekammedis.detail', compact('rekammedis', 'pelanggans', 'riwayatpembelians'));
    }

    public function filterData(Request $request, $id)
    {
        $search = $request->get('name');
        $start = $request->get('mulai');
        $end = $request->get('sampai');
        $mulai = $request->get('mulai');
        $sampai = $request->get('sampai');

        $rekammedis = DB::table('rekammedis')
                    ->join('pelanggans', 'pelanggans.KodePelanggan', '=', 'rekammedis.KodePelanggan')
                    ->where('rekammedis.Status', 'OPN')
                    ->where('pelanggans.KodePelanggan', $id)
                    ->where(function ($query) use ($search) {
                $query->Where('rekammedis.KodePelanggan', 'LIKE', "%$search%");
            })->get();
        if ($start && $end) {
            $rekammedis = $rekammedis->whereBetween('Tanggal', [$start . ' 00:00:00', $end . ' 23:59:59']);
        } else {
            $rekammedis->all();
        }

        $riwayatpembelians = DB::table('kasirdetails')
                            ->join('kasirs', 'kasirs.KodeKasir', '=', 'kasirdetails.KodeKasir')
                            ->join('items', 'items.KodeItem', '=', 'kasirdetails.KodeItem')
                            ->join('satuans', 'satuans.KodeSatuan', '=', 'kasirdetails.KodeSatuan')
                            ->where('kasirs.KodePelanggan', $id)
                            ->where('kasirs.Status', 'CFM')
            ->where(function ($query) use ($search) {
                $query->Where('kasirdetails.KodeKasir', 'LIKE', "%$search%");
            })->get();
        if ($start && $end) {
            $riwayatpembelians = $riwayatpembelians->whereBetween('Tanggal', [$start . ' 00:00:00', $end . ' 23:59:59']);
        } else {
            $riwayatpembelians->all();
        }

        $pelanggans = DB::table('pelanggans')
                    ->where('KodePelanggan', $id)
                    ->get();

        return view('rekammedis.detail', compact('rekammedis', 'riwayatpembelians', 'pelanggans', 'mulai', 'sampai'));
    }

	public function create($id)
	{	

		$pelanggans = DB::table('pelanggans')
                    ->where('KodePelanggan', $id)
					->where('Status', 'OPN')
					->get();

		$last_id = DB::select("SELECT * FROM rekammedis WHERE KodeRekamMedis LIKE '%RM-0%' ORDER BY id DESC LIMIT 1");
		$year_now = date('y');
        $month_now = date('m');
        $date_now = date('d');
		if ($last_id == null) {
            $newID = "RM-0" . $year_now . $month_now . "0001";
        } else {
            $string = $last_id[0]->KodeRekamMedis;
            $id = substr($string, -4, 4);
            $month = substr($string, -6, 2);
            $year = substr($string, -8, 2);

            if ((int) $year_now > (int) $year) {
                $newID = "0001";
            } else if ((int) $month_now > (int) $month) {
                $newID = "0001";
            } else {
                $newID = $id + 1;
                $newID = str_pad($newID, 4, '0', STR_PAD_LEFT);
            }
            $newID = "RM-0" . $year_now . $month_now . $newID;
        }

        return view('rekammedis.create', compact('newID', 'pelanggans'));

	}

	public function store(Request $request)
	{
		$last_id = DB::select("SELECT * FROM rekammedis WHERE KodeRekamMedis LIKE '%RM-0%' ORDER BY id DESC LIMIT 1");
		$year_now = date('y');
        $month_now = date('m');
        $date_now = date('d');
		if ($last_id == null) {
            $newID = "RM-0" . $year_now . $month_now . "0001";
        } else {
            $string = $last_id[0]->KodeRekamMedis;
            $id = substr($string, -4, 4);
            $month = substr($string, -6, 2);
            $year = substr($string, -8, 2);

            if ((int) $year_now > (int) $year) {
                $newID = "0001";
            } else if ((int) $month_now > (int) $month) {
                $newID = "0001";
            } else {
                $newID = $id + 1;
                $newID = str_pad($newID, 4, '0', STR_PAD_LEFT);
            }
            $newID = "RM-0" . $year_now . $month_now . $newID;
        }

        DB::table('rekammedis')->insert([
        	'KodeRekamMedis' => $newID,
        	'KodePelanggan' => $request->KodePelanggan,
        	'CatatanMedis' => $request->CatatanMedis,
            'Tanggal' => $request->Tanggal,
        	'Status' => 'OPN',
        	'KodeUser' => \Auth::user()->id,
        	'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Tambah rekam medis ' . $newID,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Rekam Medis ' . $newID . ' berhasil ditambahkan';
        return redirect('/rekammedis/detail/'. $request->KodePelanggan)->with(['created' => $pesan]);
	}

	public function edit($id, $idp)
	{
		$rekammedis = DB::table('rekammedis')
					->join('pelanggans', 'pelanggans.KodePelanggan', 'rekammedis.KodePelanggan')
					->where('rekammedis.KodeRekamMedis', $idp)
					->get();

		$pelanggans = DB::table('pelanggans')
                    ->where('KodePelanggan', $id)
					->where('Status', 'OPN')
					->get();

		return view('rekammedis.edit', compact('rekammedis', 'pelanggans'));
	}

	public function update(Request $request)
	{

        DB::table('rekammedis')->where('KodeRekamMedis', $request->KodeRekamMedis)->update([
        	'KodePelanggan' => $request->KodePelanggan,
        	'CatatanMedis' => $request->CatatanMedis,
            'Tanggal' => $request->Tanggal,
        	'KodeUser' => \Auth::user()->id,
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'ubah rekam medis ' . $request->KodeRekamMedis,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Rekam Medis ' . $request->KodeRekamMedis . ' berhasil diubah';
        return redirect('/rekammedis/detail/'. $request->KodePelanggan)->with(['edited' => $pesan]);
	}

	public function destroy($id)
	{
		DB::table('rekammedis')->where('KodeRekamMedis', $id)->update([
			'Status' => 'DEL',
			'updated_at' => \Carbon\Carbon::now(),
		]);

		DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'hapus rekam medis ' . $id,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Rekam Medis ' . $id . ' berhasil dihapus';
        return redirect('/rekammedis/detail/'. $id)->with(['deleted' => $pesan]);
	}

}