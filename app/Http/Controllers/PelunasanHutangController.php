<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Model\invoicehutang;
use App\Model\invoicehutangdetail;
use App\Model\lokasi;
use App\Model\pelunasanhutang;
use App\Model\kasbank;
use App\Model\matauang;
use App\Model\supplier;

class PelunasanHutangController extends Controller
{
    public function index()
    {
        $suppliers = DB::select('SELECT DISTINCT s.NamaSupplier, s.KodeSupplier FROM invoicehutangs i inner join suppliers s on s.KodeSupplier = i.KodeSupplier');
        return view('hutang.pelunasan.index', compact('suppliers'));
    }

    public function invoice($id)
    {
        $invoice = DB::select("SELECT i.KodeInvoiceHutangShow, i.KodeInvoiceHutang, p.NamaSupplier, i.Tanggal, i.Term, d.KodeLPB, d.Subtotal, d.TotalReturn, COALESCE(sum(pp.Jumlah),0) as bayar 
            FROM invoicehutangs i 
            inner join invoicehutangdetails d on i.KodeInvoiceHutang = d.KodeInvoiceHutang
            inner join suppliers p on p.KodeSupplier = i.KodeSupplier
            left join pelunasanhutangs pp on pp.KodeInvoice = i.KodeInvoiceHutang
            where p.KodeSupplier ='" . $id . "'
            GROUP by i.KodeInvoiceHutangShow, i.KodeInvoiceHutang, p.NamaSupplier, i.Tanggal, d.Subtotal
            order by i.KodeInvoiceHutang desc
        ");

        return view('hutang.pelunasan.invoice', compact('invoice'));
    }

    public function payment($id)
    {
        $invoice = invoicehutang::where('KodeInvoiceHutang', $id)->first();
        $supplier = supplier::where('KodeSupplier', $invoice->KodeSupplier)->first();
        $payments = pelunasanhutang::where('KodeInvoice', $id)->get();
        $detail = invoicehutangdetail::where('KodeInvoiceHutang', $id)->first();

        $tot = 0;
        foreach ($payments as $bill) {
            $tot += $bill->Jumlah;
        }

        $sub = $detail->Subtotal;
        $return = $detail->TotalReturn;
        $sisa = $sub - $tot - $return;
        return view('hutang.pelunasan.paymentlist', compact('invoice', 'payments', 'sisa', 'supplier'));
    }

    public function addpayment($id)
    {
        $invoice = invoicehutang::where('KodeInvoiceHutang', $id)->first();
        $payments = pelunasanhutang::where('KodeInvoice', $id)->get();
        $detail = invoicehutangdetail::where('KodeInvoiceHutang', $id)->first();
        $matauang = matauang::all();

        $tot = 0;
        foreach ($payments as $bill) {
            $tot += $bill->Jumlah;
        }

        $sub = $detail->Subtotal;
        $return = $detail->TotalReturn;
        $sisa = $sub - $tot - $return;

        return view('hutang.pelunasan.paymentadd', compact('invoice', 'payments', 'matauang', 'sub', 'sisa'));
    }

    public function addpaymentpost($id, Request $request)
    {
        $jml = $request->jml;
        $keterangan = $request->keterangan;
        $metode = $request->metode;
        $matauang = $request->matauang;
        $status = $request->status;
        $invoice = invoicehutang::where('KodeInvoiceHutang', $id)->first();
        $payments = pelunasanhutang::where('KodeInvoice', $id)->get();
        $detail = invoicehutangdetail::where('KodeInvoiceHutang', $id)->first();

        $tot = 0;
        foreach ($payments as $pay) {
            $tot += $pay->Jumlah;
        }

        $sub = $detail->Subtotal;
        $return = $detail->TotalReturn;
        $sisa = $sub - $tot - $return;

        if ($sisa - $request->jml < -0.1) {
            return redirect('/pelunasanhutang/payment/' . $id);
        } else {
            $last_id = DB::select('SELECT * FROM kasbanks ORDER BY KodeKasBankID DESC LIMIT 1');

            $year_now = date('y');
            $month_now = date('m');
            $date_now = date('d');
            $pref = "KK";
            if ($last_id == null) {
                $newID = $pref . "-" . $year_now . $month_now . "0001";
            } else {
                $string = $last_id[0]->KodeKasBank;
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

                $newID = $pref . "-" . $year_now . $month_now . $newID;
            }

            $kas = new kasbank();
            $kas->KodeKasBank = $newID;
            $kas->Tanggal = $request->Tanggal;
            $kas->Status = 'CFM';
            $kas->TanggalCheque = $request->Tanggal;
            $kas->KodeBayar = $metode;
            $kas->TipeBayar = '';
            $kas->NoLink = '';
            $kas->BayarDari = '';
            $kas->Untuk = 'SUP';
            $kas->KodeInvoice = $invoice->KodeInvoiceHutangShow;
            $kas->Keterangan = $keterangan;
            $kas->KodeUser = \Auth::user()->name;
            $kas->Tipe = $status;
            $kas->created_at = \Carbon\Carbon::now();
            $kas->updated_at = \Carbon\Carbon::now();
            $kas->Total = $request->jml;
            $kas->save();

            $last_id = DB::select('SELECT * FROM pelunasanhutangs ORDER BY KodePelunasanHutangID DESC LIMIT 1');

            $year_now = date('y');
            $month_now = date('m');
            $date_now = date('d');
            $pref = "PL";
            if ($last_id == null) {
                $newID = $pref . "-" . $year_now . $month_now . "0001";
            } else {
                $string = $last_id[0]->KodePelunasanHutang;
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

                $newID = $pref . "-" . $year_now . $month_now . $newID;
            }

            $pp = new pelunasanhutang();
            $pp->KodePelunasanHutang = $newID;
            $pp->Tanggal = $request->Tanggal;
            $pp->Status = 'CFM';
            $pp->KodeHutang = '';
            $pp->KodeInvoice = $invoice->KodeInvoiceHutang;
            $pp->KodeBayar = $metode;
            $pp->TipeBayar = $metode;
            $pp->Jumlah = $request->jml;
            $pp->Keterangan = $keterangan;
            $pp->KodeMataUang = $matauang;
            $pp->KodeUser = \Auth::user()->name;
            $pp->KodeSupplier = 'SUP';
            $pp->KodeKasBank = $kas->KodeKasBank;
            $pp->created_at = \Carbon\Carbon::now();
            $pp->updated_at = \Carbon\Carbon::now();
            $pp->save();

            //update status jika sudah lunas
            $payments = pelunasanhutang::where('KodeInvoice', $id)->get();
            $hutang = invoicehutangdetail::where('KodeInvoiceHutang', $id)->first();

            $tot = 0;
            foreach ($payments as $bill) {
                $tot += $bill->Jumlah;
            }

            $sisa = $hutang->Subtotal - $tot - $hutang->TotalReturn;
            if ($sisa <= 0) {
                DB::table('invoicehutangs')->where('KodeInvoiceHutang', $id)->update([
                    'Status' => 'CLS'
                ]);
            }

            DB::table('eventlogs')->insert([
                'KodeUser' => \Auth::user()->name,
                'Tanggal' => \Carbon\Carbon::now(),
                'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
                'Keterangan' => 'Tambah pelunasan hutang ' . $newID . ' pada invoice ' . $invoice->KodeInvoiceHutangShow,
                'Tipe' => 'OPN',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);

            return redirect('/pelunasanhutang/payment/' . $id);
        }
    }

    public function edit($id)
    {
        $pelunasan = pelunasanhutang::where('KodePelunasanHutangID', $id)->first();
        $invoice = invoicehutang::where('KodeInvoiceHutang', $pelunasan->KodeInvoice)->first();
        $payments = pelunasanhutang::where('KodeInvoice', $pelunasan->KodeInvoice)->get();
        $detail = invoicehutangdetail::where('KodeInvoiceHutang', $pelunasan->KodeInvoice)->first();
        $matauang = matauang::all();

        $tot = 0;
        foreach ($payments as $bill) {
            $tot += $bill->Jumlah;
        }

        $sub = $detail->Subtotal;
        $return = $detail->TotalReturn;
        $sisa = $sub - $tot - $return + $pelunasan->Jumlah;

        return view('hutang.pelunasan.edit', compact('pelunasan', 'invoice', 'payments', 'matauang', 'sub', 'sisa'));
    }

    public function update($id, Request $request)
    {
        $invoice = invoicehutang::where('KodeInvoiceHutang', $id)->first();
        $pelunasan = pelunasanhutang::where('KodePelunasanHutangID', $request->KodePelunasan)->first();

        DB::table('kasbanks')
            ->where('KodeKasBank', $pelunasan->KodeKasBank)
            ->update([
                'Tanggal' => $request->Tanggal,
                'TanggalCheque' => $request->Tanggal,
                'KodeBayar' => $request->metode,
                'Keterangan' => $request->keterangan,
                'Tipe' => $request->status,
                'Total' => $request->jml,
                'KodeUser' =>  \Auth::user()->name,
                'updated_at' => \Carbon\Carbon::now(),
            ]);

        DB::table('pelunasanhutangs')
            ->where('KodePelunasanHutangID', $request->KodePelunasan)
            ->update([
                'Tanggal' => $request->Tanggal,
                'KodeBayar' => $request->metode,
                'TipeBayar' => $request->metode,
                'Keterangan' => $request->keterangan,
                'KodeMataUang' => $request->matauang,
                'Jumlah' => $request->jml,
                'KodeUser' =>  \Auth::user()->name,
                'updated_at' => \Carbon\Carbon::now(),
            ]);

        //update status jika sudah lunas
        $payments = pelunasanhutang::where('KodeInvoice', $id)->get();
        $hutang = invoicehutangdetail::where('KodeInvoiceHutang', $id)->first();

        $tot = 0;
        foreach ($payments as $bill) {
            $tot += $bill->Jumlah;
        }

        $sisa = $hutang->Subtotal - $tot - $hutang->TotalReturn;
        if ($sisa <= 0) {
            DB::table('invoicehutangs')->where('KodeInvoiceHutang', $id)->update([
                'Status' => 'CLS'
            ]);
        }

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Update pelunasan hutang ' . $pelunasan->KodePelunasanHutang . ' pada invoice ' . $invoice->KodeInvoiceHutangShow,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        return redirect('/pelunasanhutang/payment/' . $id);
    }
}
