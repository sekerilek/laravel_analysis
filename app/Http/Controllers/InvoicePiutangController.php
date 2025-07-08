<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\suratjalan;
use App\Model\karyawan;
use App\Model\invoicepiutangdetail;
use DB;
use PDF;

class InvoicePiutangController extends Controller
{
    public function piutang()
    {
        $year_now = date('Y');
        $invoice = DB::select('SELECT i.KodeInvoicePiutangShow, i.KodeInvoicePiutang, i.NoFaktur, i.Term, p.NamaPelanggan, i.Tanggal, d.KodeSuratJalan, d.Subtotal, d.TotalReturn, sj.PPN, COALESCE(sum(pp.Jumlah),0) as bayar
                    FROM invoicepiutangs i
                    inner join invoicepiutangdetails d on i.KodeInvoicePiutang = d.KodeInvoicePiutang
                    inner join pelanggans p on p.KodePelanggan = i.KodePelanggan
                    left join pelunasanpiutangs pp on pp.KodeInvoice = i.KodeInvoicePiutang
                    left join suratjalans sj on sj.KodeSuratJalan = d.KodeSuratJalan
                    GROUP by i.KodeInvoicePiutang');

        $returns = DB::select("SELECT SUM(d.TotalReturn) as total_return
            FROM invoicepiutangs i
            inner join invoicepiutangdetails d on i.KodeInvoicePiutang = d.KodeInvoicePiutang
            GROUP by i.KodeInvoicePiutang");
        $return = 0;
        foreach ($returns as $ret) {
            $return += $ret->total_return;
        }

        $bayars = DB::select("SELECT SUM(p.Jumlah) as total_bayar
            FROM invoicepiutangs i
            inner join pelunasanpiutangs p on i.KodeInvoicePiutang = p.KodeInvoice
            GROUP by i.KodeInvoicePiutang");
        $bayar = 0;
        foreach ($bayars as $ret) {
            $bayar += $ret->total_bayar;
        }

        $total = DB::table('invoicepiutangs')->select(DB::raw('SUM(Total) as subtotal'))->first()->subtotal;
        $no = 1;
        return view('piutang.invoice.index', compact('invoice', 'year_now', 'total', 'bayar', 'return', 'no'));
    }

    public function filter(Request $request)
    {
        $year_now = date('Y');
        $invoice = DB::select("SELECT i.KodeInvoicePiutangShow, i.KodeInvoicePiutang, i.NoFaktur, i.Term, p.NamaPelanggan, i.Tanggal, d.KodeSuratJalan, d.Subtotal, d.TotalReturn, sj.PPN, COALESCE(sum(pp.Jumlah),0) as bayar
                    FROM invoicepiutangs i
                    inner join invoicepiutangdetails d on i.KodeInvoicePiutang = d.KodeInvoicePiutang
                    inner join pelanggans p on p.KodePelanggan = i.KodePelanggan
                    left join pelunasanpiutangs pp on pp.KodeInvoice = i.KodeInvoicePiutang
                    left join suratjalans sj on sj.KodeSuratJalan = d.KodeSuratJalan
                    WHERE MONTH(i.Tanggal) = '" . $request->month . "' AND YEAR(i.Tanggal) = '" . $request->year . "'
                    GROUP by i.KodeInvoicePiutang");

        $returns = DB::select("SELECT SUM(d.TotalReturn) as total_return
                    FROM invoicepiutangs i
                    inner join invoicepiutangdetails d on i.KodeInvoicePiutang = d.KodeInvoicePiutang
                    WHERE MONTH(i.Tanggal) = '" . $request->month . "' AND YEAR(i.Tanggal) = '" . $request->year . "'
                    GROUP by i.KodeInvoicePiutang");
        $return = 0;
        foreach ($returns as $ret) {
            $return += $ret->total_return;
        }

        $bayars = DB::select("SELECT SUM(p.Jumlah) as total_bayar
                    FROM invoicepiutangs i
                    inner join pelunasanpiutangs p on i.KodeInvoicePiutang = p.KodeInvoice
                    WHERE MONTH(i.Tanggal) = '" . $request->month . "' AND YEAR(i.Tanggal) = '" . $request->year . "'
                    GROUP by i.KodeInvoicePiutang");
        $bayar = 0;
        foreach ($bayars as $ret) {
            $bayar += $ret->total_bayar;
        }

        $total = DB::table('invoicepiutangs')->whereMonth('Tanggal', $request->month)->whereYear('Tanggal', $request->year)->select(DB::raw('SUM(Total) as subtotal'))->first()->subtotal;
        $no = 1;
        return view('piutang.invoice.index', compact('invoice', 'year_now', 'total', 'bayar', 'return', 'no'));
    }

    public function edit($id)
    {
        $invoice = DB::select("SELECT i.KodeInvoicePiutangShow, i.KodeInvoicePiutang, i.NoFaktur, i.Term, p.NamaPelanggan, i.Tanggal, d.KodeSuratJalan, d.Subtotal, COALESCE(sum(pp.Jumlah),0) as bayar
                    FROM invoicepiutangs i
                    inner join invoicepiutangdetails d on i.KodeInvoicePiutang = d.KodeInvoicePiutang
                    inner join pelanggans p on p.KodePelanggan = i.KodePelanggan
                    left join pelunasanpiutangs pp on pp.KodeInvoice = i.KodeInvoicePiutang
                    where i.KodeInvoicePiutangShow = '" . $id . "'
                    group by i.KodeInvoicePiutangShow, i.KodeInvoicePiutang, p.NamaPelanggan, i.Tanggal, d.Subtotal, i.Term");
        return view('piutang.invoice.edit', compact('invoice'));
    }

    public function update(Request $request)
    {
        DB::table('invoicepiutangs')->where('KodeInvoicePiutangShow', $request->KodeInvoice)
            ->update([
                'NoFaktur' => $request->NoFaktur,
                'KodeUser' => \Auth::user()->name,
                'updated_at' => \Carbon\Carbon::now()
            ]);

        $detail = DB::table('invoicepiutangdetails')->where('KodePiutang', $request->KodeInvoice)->first();
        DB::table('suratjalans')->where('KodeSuratJalan', $detail->KodeSuratJalan)
            ->update([
                'NoFaktur' => $request->NoFaktur,
                'KodeUser' => \Auth::user()->name,
                'updated_at' => \Carbon\Carbon::now()
            ]);

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Update invoice piutang ' . $request->KodeInvoice,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        return redirect('/invoicepiutang');
    }

    public function print($id)
    {
        $invoice = DB::select("SELECT i.KodeInvoicePiutangShow, i.KodeInvoicePiutang, i.Term, p.NamaPelanggan, i.Tanggal, d.Subtotal
        FROM invoicepiutangs i
        left join pelunasanpiutangs pp on pp.KodeInvoice = i.KodeInvoicePiutang
        inner join invoicepiutangdetails d on i.KodeInvoicePiutang = d.KodeInvoicePiutang
        inner join pelanggans p on p.KodePelanggan = i.KodePelanggan
        where i.KodeInvoicePiutangShow = '" . $id . "'
        group by i.KodeInvoicePiutangShow, i.KodeInvoicePiutang, p.NamaPelanggan, i.Tanggal, d.Subtotal, i.Term")[0];
        $inv = invoicepiutangdetail::where('KodePiutang', $id)->first();
        $suratjalan = suratjalan::where('KodeSuratJalan', $inv->KodeSuratJalan)->first();
        $driver = karyawan::where('KodeKaryawan', $suratjalan->KodeSopir)->first();
        $items = DB::select(
            "SELECT a.KodeItem,i.NamaItem, a.Qty, i.Keterangan, s.NamaSatuan, s.KodeSatuan, a.Harga as HargaJual
            FROM suratjalandetails a 
            inner join items i on a.KodeItem = i.KodeItem 
            inner join itemkonversis k on i.KodeItem = k.KodeItem and a.KodeSatuan = k.KodeSatuan 
            inner join satuans s on s.KodeSatuan = k.KodeSatuan
            where a.KodeSuratJalan='" . $inv->KodeSuratJalan . "' group by a.KodeItem, s.NamaSatuan"
        );

        $jml = 0;
        foreach ($items as $value) {
            $jml += $value->Qty;
        }
        $invoice->TanggalFormat = \Carbon\Carbon::parse($invoice->Tanggal)->format('d-m-Y');

        $pdf = PDF::loadview('piutang.invoice.print', compact('invoice', 'id', 'items', 'jml', 'suratjalan', 'driver'));

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Print invoice piutang ' . $id,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        return $pdf->download('InvoicePiutang_' . $id . '.pdf');
    }
}
