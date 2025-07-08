<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\penjualanlangsung;

class ReturnPenjualanLangsungController extends Controller
{
    public function index($id){
    	$sj =DB::select("select KodePenjualanLangsung, KodePenjualanLangsungID from penjualanlangsungs");
        if ($id=="0"){
            if(count($sj) <=0 ){
                return redirect('/penjualanLangsung');
            }
            $id = $sj[0]->KodePenjualanLangsungID;
        }
        $items = DB::select("sELECT a.KodeItem,i.NamaItem, COALESCE(SUM(a.qty),0)/coalesce(NULLIF(COUNT(sjr.KodePenjualanLangsungReturnID), 0),1)-COALESCE(SUM(sjrd.Qty),0) as jml, i.Keterangan, s.NamaSatuan, k.HargaJual 
FROM penjualanlangsungdetails a inner join items i on a.KodeItem = i.KodeItem inner join itemkonversis k on i.KodeItem = k.KodeItem inner join satuans s on s.KodeSatuan = k.KodeSatuan 
            left join penjualanlangsungs sj on sj.KodePenjualanLangsung = a.KodePenjualanLangsung
            left join penjualanlangsungreturns sjr on sjr.KodePenjualanLangsungID = sj.KodePenjualanLangsungID
            left join penjualanlangsungreturndetails sjrd on sjrd.KodePenjualanLangsungReturn = sjr.KodePenjualanLangsungReturn
            where sj.KodePenjualanLangsungID='".$id."' group by a.KodeItem, i.Keterangan, s.NamaSatuan, k.HargaJual, i.NamaItem
            having jml >0");
        $sjDet = penjualanlangsung::where('KodePenjualanLangsungID',$id)->first();
        return view('returnPenjualanLangsung.add', compact('sj', 'id','items','sjDet'));
    }

    public function store(Request $request){
    	$last_id = DB::select('SELECT * FROM penjualanlangsungreturns ORDER BY KodePenjualanLangsungReturnID DESC LIMIT 1');

        $year_now = date('y');
        $month_now = date('m');
        $date_now = date('d');
        $pref = "RDJ";
        if($request->ppn=='ya'){
            $pref = "RDJT";
        }
        if ($last_id == null) {
            $newID = $pref."-" . $year_now . $month_now . "0001";
        } else {
            $string = $last_id[0]->KodePenjualanLangsungReturn;
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

            $newID = $pref."-" . $year_now . $month_now . $newID;
        }
        $pl = penjualanlangsung::find($request->KodeSJ);
    	 DB::table('penjualanlangsungreturns')->insert([
            'KodePenjualanLangsungReturn' => $newID,
            'Tanggal' => $request->Tanggal,
            'Status' => 'CLS',
            'KodePenjualanLangsungID' => $request->KodeSJ,
            'KodePenjualanLangsung'=>$pl->KodePenjualanLangsung,
            'KodeUser' => 'Admin',
            'Total' => $request->total,
            'NilaiPPN'=>$request->ppnval,
            'PPN' => $request->ppn,
            'Printed'=>0,
            'Diskon'=>$request->diskon,
            'NilaiDiskon'=>$request->diskonval,
            'Subtotal'=>$request->subtotal,
            'KodePelanggan'=>$request->KodePelangganId,
            'NoIndeks'=>'0',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
		
        $items = $request->item;
        $qtys = $request->qty;
        foreach ($items as $key => $value) {
            DB::table('penjualanlangsungreturndetails')->insert([
                'KodePenjualanLangsungReturn' => $newID,
                'KodeItem'=>$items[$key],
                'KodeSatuan'=>'',
                'Qty' => $qtys[$key],
                'Harga' => 0,
                'Keterangan'=>'',
                'NoUrut' => 0,
                'Subtotal' => 0,
                'Diskon' => 0,
                'NilaiDiskon' => 0,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
            
        }

        return redirect('/returnPenjualanLangsung/0');
    }
}
