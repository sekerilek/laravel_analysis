@extends('index')
@section('content')
<div class="container">
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 id="header">Ubah Akses</h3>
            </div>

            <div class="x_content">
                <div class="form-row">
                <form action="{{url('/user/access/'.$user)}}" method="post">
                    @csrf
                    @method('POST')

                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <table class="col-lg-4 col-md-4 col-sm-4 table table-bordered table-striped table-condensed" id="tabel_menu">
                            <tr>
                                <th width="10%" class="text-center">
                                    <input type="checkbox" class="menu-all" onclick="pilihMenu(this)"> Semua
                                </th>
                                <th width="30%" class="text-center">Menu</th>
                                <th width="60%" class="text-center">Fungsi</th>
                            </tr>
                            
                        </table>
                    </div>
                    

                    <button type="submit" class="btn btn-success" id="buttonSimpan" style="width:120px;" onclick="return confirm('Simpan data ini?')">Simpan</button>
                    <a href="/user" class="btn btn-danger" style="width:120px;">Batal</a>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
function getAllMenu(menu, submenu, functionmenu) {
    var x = 1;
    var htmlTable = '';
    $.each(submenu, function(i, val) {
        htmlTable = htmlTable
                    +'<tr>'
                    +'<td style="text-align: center;">'
                    +'<input type="checkbox" name="menu_status['+val.replace(/ /g, '_')+']" class="menu" value="0" data-menu="'+val+'" onclick="pilihMenu(this)">&nbsp;'+x
                    +'<input type="hidden" name="user_menu['+val.replace(/ /g, '_')+']" value="'+val+'">'
                    +'</td>'
                    +'<td style="text-align: left;">'+val+'</td>'
                    +'<td>';
        $.each(functionmenu, function(i, fn) {
            var function_name = fn;
            htmlTable = htmlTable
                    +'<input type="checkbox" name="function_status['+val.replace(/ /g, '_')+']['+function_name+']" class="funcmenu" value="0" data-function="'+val+'" data-function-name="'+val+'-'+function_name+'" onclick="pilihMenu(this)" readonly>&nbsp;'+function_name+'&nbsp;&nbsp;&nbsp;'
                    +'<input type="hidden" name="user_function['+val.replace(/ /g, '_')+']['+function_name+']" value="'+function_name+'">';
        });
        htmlTable = htmlTable
                    +'</td>'
                    +'</tr>';
        x++;
    });

    $('#tabel_menu').append(htmlTable);
}

$(function() {
    $('input:checkbox').prop('checked', false);
    $('input:checkbox').attr('value', '0');
    $('input:checkbox').prop('readonly', true);
    $('#buttonSimpan').prop('readonly', true);

    initPage('{{Auth::user()->name}}');
});

function pilihMenu(e) {
    var cl = $(e).attr('class');
    if (cl == 'menu-all') {
        if ($(e).is(':checked')) {
            $('.'+cl+':checkbox').prop('checked', true);
            $('.'+cl).attr('value', '1');
            $('.menu:checkbox').prop('checked', true);
            $('.menu').attr('value', '1');
            $('.funcmenu:checkbox').prop('readonly', false);
            $('.funcmenu:checkbox').prop('checked', true);
            $('.funcmenu').attr('value', '1');
        } else {
            $('.'+cl+':checkbox').prop('checked', false);
            $('.'+cl).attr('value', '0');
            $('.menu:checkbox').prop('checked', false);
            $('.menu').attr('value', '0');
            $('.funcmenu:checkbox').prop('readonly', true);
            $('.funcmenu:checkbox').prop('checked', false);
            $('.funcmenu').attr('value', '0');
        }
    } else if (cl == 'menu') {
        var id  = $(e).attr('data-menu');
        if ($(e).is(':checked')) {
            $('[data-menu="'+id+'"]:checkbox').prop('checked', true);
            $('[data-menu="'+id+'"]').attr('value', '1');
            $('[data-function="'+id+'"]:checkbox').prop('readonly', false);
            $('[data-function="'+id+'"]:checkbox').prop('checked', true);
            $('[data-function="'+id+'"]').attr('value', '1');
        }
        else {
            $('[data-menu="'+id+'"]:checkbox').prop('checked', false);
            $('[data-menu="'+id+'"]').attr('value', '0');
            $('[data-function="'+id+'"]:checkbox').prop('readonly', true);
            $('[data-function="'+id+'"]:checkbox').prop('checked', false);
            $('[data-function="'+id+'"]').attr('value', '0');
        }

        if ($('.'+cl+':checked').length == $('.'+cl+':checkbox').length) {
            $('.menu-all:checkbox').prop('checked', true);
            $('.menu-all').attr('value', '1');
        }
        else {
            $('.menu-all:checkbox').prop('checked', false);
            $('.menu-all').attr('value', '0');
        }
    } else if (cl == 'funcmenu') {
        var id  = $(e).attr('data-function-name');
        if ($(e).is(':checked')) {
            $('[data-function-name="'+id+'"]:checkbox').prop('checked', true);
            $('[data-function-name="'+id+'"]').attr('value', '1');
        }
        else {
            $('[data-function-name="'+id+'"]:checkbox').prop('checked', false);
            $('[data-function-name="'+id+'"]').attr('value', '0');
        }
    }
}
</script>
@endpush