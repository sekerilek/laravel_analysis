<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class MenuController extends Controller
{
   public function setMenu(Request $request) {
   		$menu = $request->menu;
   		$submenu = $request->submenu;
   		$function = ['tambah','ubah','hapus','konfirmasi','return','cetak'];

   		DB::table('app_menu')->truncate();
   		DB::table('app_submenu')->truncate();
   		DB::table('app_menu_function')->truncate();
   		foreach ($menu as $key => $value) {
   			DB::table('app_menu')->insert(['menu'=>$key]);
   		}
   		foreach ($submenu as $key => $value) {
   			DB::table('app_submenu')->insert(['submenu'=>$key]);
   		}
   		foreach ($function as $key => $value) {
   			DB::table('app_menu_function')->insert(['func'=>$value]);
   		}

   		return 'true';
   }

   public function getMenu() {

   }
}
