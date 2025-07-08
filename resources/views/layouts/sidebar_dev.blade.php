<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <ul class="nav side-menu">
            <li>
                <a><i class="fa fa-database"></i> Master <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ url('/mastergudang') }}">Data Gudang </a></li>
                    <li><a href="{{ url('/masterklasifikasi') }}">Data Klasifikasi</a></li>
                    <li><a href="{{ url('/mastersatuan') }}">Data Satuan</a></li>
                    <li><a href="{{ url('/masteritem') }}">Data Item</a></li>
                    <li><a href="{{ url('/mastermatauang')}}">Data Mata Uang</a></li>
                    <li><a href="{{ url('/masterpelanggan') }}">Data Pelanggan</a></li>
                    <li><a href="{{ url('/mastersupplier') }}">Data Supplier</a></li>
                    <li><a href="{{ url('/masterkaryawan')}}">Data Karyawan</a></li>
                    <li><a href="{{ url('/mastergolongan')}}">Data Golongan</a></li>
                    <li><a href="{{ url('/masterjabatan')}}">Data Jabatan</a></li>
                </ul>
            </li>

            <li>
                <a><i class="fa fa-dollar"> </i> Penjualan <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ url('/sopenjualan')}}">Pemesanan Penjualan</a></li>
                    <li><a href="{{ url('/suratJalan') }}">Surat Jalan</a></li>
                    <li><a href="{{ url('/returnSuratJalan') }}">Return Surat Jalan</a></li>
                    <li><a href="{{ url('/kasir') }}">Kasir</a></li>
                    <li><a href="{{ url('/returnKasir') }}">Return Kasir</a></li>
                    <li><a href="{{ url('/invoicepiutang') }}">Invoice Piutang</a></li>
                    <li><a href="{{ url('/pelunasanpiutang') }}">Pelunasan Piutang</a></li>
                </ul>
            </li>

            <li>
                <a><i class="fa fa-shopping-cart"></i> Pembelian<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ url('/popembelian') }}">Pemesanan Pembelian</a></li>
                    <li><a href="{{ url('/penerimaanBarang') }}">Penerimaan Barang</a></li>
                    <li><a href="{{ url('/returnPenerimaanBarang') }}">Return Penerimaan Barang</a></li>
                    <li><a href="{{ url('/invoicehutang') }}">Invoice Hutang</a></li>
                    <li><a href="{{ url('/pelunasanhutang') }}">Pelunasan Hutang</a></li>
                </ul>
            </li>

            <li>
                <a><i class="fa fa-cart-plus"></i> Operasional <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ url('/pengeluarantambahan') }}">Biaya Operasional</a></li>
                    <li><a href="{{ url('/saldo') }}">Saldo</a></li>
                    <li><a href="{{ url('/laci') }}">Kas Laci</a></li>
                </ul>
            </li>

            <li>
                <a><i class="fa fa-cube"></i> Stok <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ url('/sisastok') }}">Sisa Stok</a></li>
                    <li><a href="{{ url('/stokmasuk') }}">Stok Masuk</a></li>
                    <li><a href="{{ url('/stokkeluar') }}">Stok Keluar</a></li>
                </ul>
            </li>

            <li>
                <a><i class="fa fa-book"></i> Laporan <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ url('/kartustok') }}">Kartu Stok</a></li>
                    <li><a href="{{ url('/datastok') }}">Data Stok</a></li>
                    <li><a href="{{ url('/bukukasbesar') }}">Kas Besar</a></li>
                    <li><a href="{{ url('/bukukaskecil') }}">Kas Kecil</a></li>
                    <li><a href="{{ url('/laporanpenjualan') }}">Penjualan</a></li>
                    <li><a href="{{ url('/laporanrugilaba') }}">Rugi Laba</a></li>
                </ul>
            </li>

            <li>
                <a href="/penggajian"><i class="fa fa-money"></i> Penggajian </a>
            </li>
            
            <li>
                <a href="/rekammedis"><i class="fa fa-medkit"></i> Rekam Medis </a>
            </li>

            @if (Auth::user() && Auth::user()->name == 'admin')
            <li>
                <a href="{{ url('/user')}}"><i class="fa fa-users"></i>Manajemen user</a>
            </li>
            @endif

            @if (Auth::user() && Auth::user()->name == 'admin')
            <li><a href="/eventlog"><i class="fa fa-edit"></i> Eventlog </a>
            </li>
            @endif
        </ul>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
var current_url;
current_url = $(location).attr('pathname');
current_url = current_url.split('/');

$(function() {
    if (current_url[1] == 'home') {
        initPage('{{Auth::user()->name}}');
    }
});

function initPage(params) {
    var menulist = {};
    var submenulist = {};
    var functionlist = ["tambah", "ubah", "hapus", "konfirmasi", "cetak", "return"];
    var user = arguments[0] || 'admin';
    var fn = arguments[1] || '';

    $('ul.side-menu > li').each(function() {
        var name = $.trim($(this).children('a').text());
        $(this).attr('data-menu', name);
        menulist[name] = name;
    });

    $('ul.child_menu > li').each(function() {
        $(this).css({"display":""});
        var subname = $.trim($(this).children('a').text());
        $(this).attr('data-submenu', subname);
        submenulist[subname] = subname;
    });

    if (user == 'admin') {
        current_url.pop();
        current_url = current_url.join('/');

        /* memanggil fungsi getAllMenu() pada view /usercontroller/user/changeAccess.blade.php */
        if (current_url == '/user/access') {
            getAllMenu(menulist, submenulist, functionlist);
        }
    }

    if (user != 'admin') {
        let auth_menu = [];
        let auth_function = {};
        $.get('/user/check/'+user, function(data, status) {
            if ($.isEmptyObject(data)) {}
            else {
                $.each(data, function(i, value) {
                    auth_menu.push(value.menu);
                    auth_function[value.menu] = value.func.split(',');
                });

                $.each(submenulist, function(x, val) {
                    if (!auth_menu.includes(val)) { $('li[data-submenu="'+val+'"]').css({"display":"none"}); }
                    else { 
                        $('li[data-submenu="'+val+'"]').css({"display":""});
                        let current_menu = val.toLowerCase().replace(/ /g, '');
                        $('li[data-submenu="'+val+'"]').attr('data-'+current_menu, auth_function[val]);
                    }
                });

                $('li[data-menu]').each(function() {
                    let count_elem = $(this).find('li[data-submenu]:not([style="display: none;"])').length;
                    if (count_elem > 0) { $(this).css({"display":""}); }
                    else { $(this).css({"display":"none"}); }
                });

                if (current_url[1] != 'home') {
                    if ($('body').has('li.current-page')) {
                        let current_menu = $('li.current-page').data('submenu');
                        current_menu = current_menu.toLowerCase().replace(/ /g, '');
                        let current_function = $('li.current-page').data(current_menu).split(',');

                        if (current_function.includes(fn)) { $('[data-function="'+fn+'"]').css({"display":""}); }
                        else { $('[data-function="'+fn+'"]').css({"display":"none"}); }
                    }
                }
            }
        });
    }
}
</script>
@endpush