getMenu(0);
function getMenu(start){
    $('#start').val(start);
    var search = $('#q').val();
    var limit = $('#limit').val();
    var active="class='btn btn-primary btn-sm'";
    var url=base_url + "menu/data?q=" + search + "&start=" +start+ "&limit=" +limit;
    console.log(url);
    $.ajax({
        url     : url,
        type    : "GET",
        dataType: "json",
        data    : {get_param : 'value'},
        success : function(data){
            //menghitung jumlah data
            console.clear();
            if(data["status"]==true){
                var menu    = data["data"];
                var jmlData=menu.length;
                var limit   = data["limit"]
                var tabel   = "";
                //Create Tabel
                for(var i=0; i<jmlData;i++){
                    start++;
                    tabel+="<tr>";
                    tabel+="<td>"+start+"</td>";
                    
                    tabel+="<td>"+menu[i]["menu_judul"]+"</td>";
                    if(menu[i]["menu_baseurl"]==1) tabel+="<td>"+base_url+menu[i]["menu_link"]+"</td>";
                    else tabel+="<td>"+menu[i]["menu_link"]+"</td>";
                    tabel+="<td>"+menu[i]["menu_idxutama"]+"</td>";
                    tabel+="<td>"+menu[i]["menu_idxanak"]+"</td>";
                    //tabel+="<td>"+menu[i]["menu_top"]+"</td>";
                    if (menu[i]["menu_top"] == 1) {
                        tabel += '<td >';
                        tabel += '<label class="switch switch-small">';
                        tabel += '<input type="checkbox" id="menu_top' + menu[i]["menu_id"] + '" checked value="1" onclick="newTop(\'' + menu[i]["menu_id"] + '\')"/>';
                        tabel += '<span></span>';
                        tabel += '</label>';
                        tabel += '</td>'
                        //tabel+="<td style='width:100px;'><button class='btn btn-success btn-sm'>Aktif</button></td>";
                    } else {
                        tabel += '<td>';
                        tabel += '<label class="switch switch-small">';
                        tabel += '<input type="checkbox" value="1" onclick="newTab(\'' + menu[i]["menu_id"] + '\')" />';
                        tabel += '<span></span>';
                        tabel += '</label>';
                        tabel += '</td>'
                        //tabel+="<td style='width:100px;'><button class='btn btn-danger btn-sm'>Non Aktif</button></td>";
                    }
                    if(menu[i]["menu_newtab"]==1){
                        tabel+='<td >';
                        tabel+='<label class="switch switch-small">';
                        tabel+='<input type="checkbox" id="menu_newtab'+menu[i]["menu_id"]+'" checked value="1" onclick="newTab(\''+menu[i]["menu_id"]+'\')"/>';
                        tabel+='<span></span>';
                        tabel+='</label>';
                        tabel+='</td>'
                        //tabel+="<td style='width:100px;'><button class='btn btn-success btn-sm'>Aktif</button></td>";
                    }else{
                        tabel+='<td>';
                        tabel+='<label class="switch switch-small">';
                        tabel+='<input type="checkbox" value="1" onclick="newTab(\''+menu[i]["menu_id"]+'\')" />';
                        tabel+='<span></span>';
                        tabel+='</label>';
                        tabel+='</td>'
                        //tabel+="<td style='width:100px;'><button class='btn btn-danger btn-sm'>Non Aktif</button></td>";
                    }
                    if(menu[i]["menu_status"]==1){
                        tabel+='<td>';
                        tabel+='<label class="switch switch-small">';
                        tabel+='<input type="checkbox" checked value="1" id="menu_status'+menu[i]["menu_id"]+'" onclick="setStatus(\''+menu[i]["menu_id"]+'\')"/>';
                        tabel+='<span></span>';
                        tabel+='</label>';
                        tabel+='</td>'
                        //tabel+="<td style='width:100px;'><button class='btn btn-success btn-sm'>Aktif</button></td>";
                    }else{
                        tabel+='<td>';
                        tabel+='<label class="switch switch-small">';
                        tabel+='<input type="checkbox" value="1" id="menu_status'+menu[i]["menu_id"]+'" onclick="setStatus(\''+menu[i]["menu_id"]+'\')" />';
                        tabel+='<span></span>';
                        tabel+='</label>';
                        tabel+='</td>'
                        //tabel+="<td style='width:100px;'><button class='btn btn-danger btn-sm'>Non Aktif</button></td>";
                    }
                    tabel+='<td class=\'text-right\' style="width:180px;">';
                    tabel+='<div class="btn-group btn-group-sm">';
                    tabel+='<button type=\'button\' class=\'btn btn-success \' onclick=\'edit("' +menu[i]["menu_id"] +'")\'><span class=\'glyphicon glyphicon-pencil\' ></span> Edit</button>';
                    tabel+='<button type=\'button\' class=\'btn btn-danger \' onclick=\'hapus("' +menu[i]["menu_id"] +'")\'><span class=\'glyphicon glyphicon-remove\' ></span> Hapus</td>';
                    tabel+='</div></td>';
                    tabel+="</tr>";
                }
                $('#data').html(tabel);
                //Create Pagination
                if(data["row_count"]<=limit){
                    $('#pagination').html("");
                }else{
                    var pagination="";
                    var btnIdx="";
                    jmlPage=Math.ceil(data["row_count"]/limit);
                    offset  = data["start"] % limit;
                    curIdx  = Math.ceil((data["start"]/data["limit"])+1);
                    prev    = (curIdx-2) * data["limit"];
                    next    = (curIdx) * data["limit"];
                    
                    var curSt=(curIdx*data["limit"])-jmlData;
                    var st=start;
                    var btn="btn-default";
                    var lastSt=(jmlPage*data["limit"])-jmlData
                    var btnFirst="<button class='btn btn-default btn-sm' onclick='getMenu(0)'><span class='fa fa-angle-double-left'></span></button>";
                    if(curIdx>1){
                        var prevSt=((curIdx-1)*data["limit"])-jmlData;
                        btnFirst+="<button class='btn btn-default btn-sm' onclick='getMenu("+prevSt+")'><span class='fa fa-angle-left'></span></button>";
                    }

                    var btnLast="";
                    if(curIdx<jmlPage){
                        var nextSt=((curIdx+1)*data["limit"])-jmlData;
                        btnLast+="<button class='btn btn-default btn-sm' onclick='getMenu("+nextSt+")'><span class='fa fa-angle-right'></span></button>";
                    }
                    btnLast+="<button class='btn btn-default btn-sm' onclick='getMenu("+lastSt+")'><span class='fa fa-angle-double-right'></span></button>";
                    
                    if(jmlPage>=25){
                        if(curIdx>=20){
                            var idx_start=curIdx - 20;
                            var idx_end=idx_start+ 25;
                            if(idx_end>=jmlPage) idx_end=jmlPage;
                        }else{
                            var idx_start=1;
                            var idx_end=25;
                        }
                        for (var j = idx_start; j<=idx_end; j++) {
                            st=(j*data["limit"])-jmlData;
                            if(curSt==st)  btn="btn-success"; else btn= "btn-default";
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getMenu("+ st +")'>" + j +"</button>";
                        }
                    }else{
                        for (var j = 1; j<=jmlPage; j++) {
                            st=(j*data["limit"])-jmlData;
                            if(curSt==st)  btn="btn-success"; else btn= "btn-default";
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getMenu("+ st +")'>" + j +"</button>";
                        }
                    }
                    pagination+=btnFirst + btnIdx + btnLast;
                    $('#pagination').html(pagination);
                }
            }
        }
    });
}
function add(){
    save_method = 'add';
    $('#form')[0].reset(); 
    $('#modal_form').modal('show'); 
    
                $('#err_menu_id').html("");
                $('#err_menu_judul').html("");
                $('#err_menu_link').html("");
                $('#err_menu_baseurl').html("");
                $('#err_menu_idxutama').html("");
                $('#err_menu_idxanak').html("");
                $('#err_menu_top').html("");
                $('#err_menu_status').html("");
    $('.modal-title').text('Tambah Data Menu'); 
}
function save(){
    var url;
    url = base_url + "menu/save";
    var formData = new FormData($('#form')[0]);
    $.ajax({
        url : url,
        type: "POST",
        data : formData,
        processData: false,
        contentType: false,
        dataType: 'JSON',
        success: function(data)
        {
            if(data["status"]==true){
                if(data["error"]==true){
                    $('#csrf').val(data["csrf"]);
                    
                if(data["err_menu_id"]!="") $('#err_menu_id').html(data["err_menu_id"]); else $('#err_menu_id').html("");
                
                if(data["err_menu_judul"]!="") $('#err_menu_judul').html(data["err_menu_judul"]); else $('#err_menu_judul').html("");
                
                if(data["err_menu_link"]!="") $('#err_menu_link').html(data["err_menu_link"]); else $('#err_menu_link').html("");
                
                if(data["err_menu_baseurl"]!="") $('#err_menu_baseurl').html(data["err_menu_baseurl"]); else $('#err_menu_baseurl').html("");
                
                if(data["err_menu_idxutama"]!="") $('#err_menu_idxutama').html(data["err_menu_idxutama"]); else $('#err_menu_idxutama').html("");
                
                if(data["err_menu_idxanak"]!="") $('#err_menu_idxanak').html(data["err_menu_idxanak"]); else $('#err_menu_idxanak').html("");
                
                if(data["err_menu_top"]!="") $('#err_menu_top').html(data["err_menu_top"]); else $('#err_menu_top').html("");
                
                if(data["err_menu_status"]!="") $('#err_menu_status').html(data["err_menu_status"]); else $('#err_menu_status').html("");
                
                }else{
                    $('#csrf').val(data["csrf"]);
                    $('#modal_form').modal('hide');
                    var start=$('#start').val();
                    getMenu(start);
                    swal({
                     title: "Sukses",
                     text: data["message"],
                     type: "success",
                     timer: 5000
                    });
                }
            }
            else{
                swal({
                    title: "Peringatan",
                    text: data["message"],
                    type: "warning",
                    timer: 5000
                });
            }
            
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            swal({
             title: "Terjadi Kesalahan ",
             text: "Gagal Menyimpan Data",
             type: "error",
             timer: 5000
            });
        }
    });
}
function edit(id)
{
    var url;
    save_method = 'update';
    $('#form')[0].reset(); 
    $.ajax({
        url : base_url + "menu/edit/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            if(data["status"]==false){
                swal({
                 title: "Peringatan",
                 text: data["message"],
                 type: "error",
                 timer: 5000
                });
                //alert(data["message"]);
            }else{
                var menu = data["data"];
                
                $('#menu_id').val(menu.menu_id);
                $('#menu_judul').val(menu.menu_judul);
                $('#menu_link').val(menu.menu_link);
                if(menu.menu_baseurl==1) $('#menu_baseurl').prop( "checked", true );
                if(menu.menu_newtab==1) $('#menu_newtab').prop( "checked", true );
                $('#menu_idxutama').val(menu.menu_idxutama);
                $('#menu_idxanak').val(menu.menu_idxanak);
                $('#menu_top').val(menu.menu_top);
                if(menu.menu_status==1) $('#menu_status').prop( "checked", true );
                
                $('#err_menu_id').html("");
                $('#err_menu_judul').html("");
                $('#err_menu_link').html("");
                $('#err_menu_idxutama').html("");
                $('#err_menu_idxanak').html("");
                $('#err_menu_top').html("");
                $('#csrf').val(data["csrf"]),
                $('#modal_form').modal('show'); 
                $('.modal-title').text('Edit Data Menu'); 
            }
            
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            swal({
             title: "Terjadi Kesalahan..!",
             text: "Gagal Saat Pengambilan data",
             type: "error",
             timer: 5000
            });
        }
    });
}
function hapus(id){
    swal({
      title: "Apakah Anda Yakin?",
      text: "Data ini akan dihapus dari database",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: "Ya, Saya Yakin!",
      cancelButtonText: "Tidak, Tolong Batalkan!",
      closeOnConfirm: true,
      closeOnCancel: true
    },
    function(isConfirm){
      if (isConfirm) {
        $.ajax({
            url : base_url + "menu/delete/" +id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                var start=$('#start').val();
                getMenu(start);
            },
            error: function (jqXHR, textStatus, errorThrown){
                swal({
                 title: "Terjadi Kesalahan..!",
                 text: "Gagal Saat Pengapusan data",
                 type: "error",
                 timer: 5000
                });
            }
        });
      } else {
        swal("Batal", "Data Tidak jadi dihapus :)", "error");
      }
    });
}

function setStatus(menu_id){
    if ($('#menu_status'+menu_id).is(':checked')) {
        var url=base_url+"menu/status/"+menu_id+"/1";
    }else{
        var url=base_url+"menu/status/"+menu_id+"/0";
    }
    //alert(url);
    $.ajax({
        url : url,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            if(data["status"]==false){
                swal({
                 title: "Peringatan",
                 text: data["message"],
                 type: "error",
                 timer: 5000
                });
                //alert(data["message"]);
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            swal({
             title: "Terjadi Kesalahan..!",
             text: "Gagal Saat Pengambilan data",
             type: "error",
             timer: 5000
            });
        }
    });
}

function newTab(menu_id){
    if ($('#menu_status'+menu_id).is(':checked')) {
        var url=base_url+"menu/newtab/"+menu_id+"/1";
    }else{
        var url=base_url+"menu/newtab/"+menu_id+"/0";
    }
    //alert(url);
    $.ajax({
        url : url,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            if(data["status"]==false){
                swal({
                 title: "Peringatan",
                 text: data["message"],
                 type: "error",
                 timer: 5000
                });
                //alert(data["message"]);
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            swal({
             title: "Terjadi Kesalahan..!",
             text: "Gagal Saat Pengambilan data",
             type: "error",
             timer: 5000
            });
        }
    });
}

function newTop(menu_id) {
    if ($('#menu_status' + menu_id).is(':checked')) {
        var url = base_url + "menu/newtop/" + menu_id + "/1";
    } else {
        var url = base_url + "menu/newtop/" + menu_id + "/0";
    }
    //alert(url);
    $.ajax({
        url: url,
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            if (data["status"] == false) {
                swal({
                    title: "Peringatan",
                    text: data["message"],
                    type: "error",
                    timer: 5000
                });
                //alert(data["message"]);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            swal({
                title: "Terjadi Kesalahan..!",
                text: "Gagal Saat Pengambilan data",
                type: "error",
                timer: 5000
            });
        }
    });
}