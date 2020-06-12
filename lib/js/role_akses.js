
getRole_akses(0);
function getRole_akses(start){
    $('#start').val(start);
    var search = $('#q').val();
    var limit = $('#limit').val();
    var active="class='btn btn-primary btn-sm'";
    var url=base_url + "role_akses/data?q=" + search + "&start=" +start+ "&limit=" +limit;
    $.ajax({
        url     : url,
        type    : "GET",
        dataType: "json",
        data    : {get_param : 'value'},
        success : function(data){
            //menghitung jumlah data
            console.clear();
            if(data["status"]==true){
                var role_akses    = data["data"];
                var jmlData=role_akses.length;
                var limit   = data["limit"]
                var tabel   = "";
                //Create Tabel
                for(var i=0; i<jmlData;i++){
                    start++;
                    tabel+="<tr>";
                    tabel+="<td>"+start+"</td>";
                    tabel+="<td>"+role_akses[i]["role_nama"]+"</td>";
                    tabel+="<td>"+role_akses[i]["nama_modul"]+"</td>";
                    tabel+="<td>"+role_akses[i]["nama_aksi"]+"</td>";
                    if(role_akses[i]["tampil_menu"]==1){
                        tabel+='<td style="width:100px;">';
                        tabel+='<label class="switch switch-small">';
                        tabel+="<input type='checkbox' id='tampil_menu"+role_akses[i]["id_akses"]+"' onclick='setTampil(\""+role_akses[i]["id_akses"]+"\")' checked>";
                        tabel+='<span></span>';
                        tabel+='</label>';
                        tabel+='</td>';
                    }else{
                        tabel+='<td style="width:100px;">';
                        tabel+='<label class="switch switch-small">';
                        tabel+="<input type='checkbox' id='tampil_menu"+role_akses[i]["id_akses"]+"' onclick='setTampil(\""+role_akses[i]["id_akses"]+"\")'>";
                        tabel+='<span></span>';
                        tabel+='</label>';
                        tabel+='</td>';
                    }
                    tabel+='<td class=\'text-right\' style="width:200px;">';
                    tabel+='<div class="btn-group btn-group-sm">';
                    tabel+='<button type=\'button\' class=\'btn btn-success \' onclick=\'edit("' +role_akses[i]["id_akses"] +'")\'><span class=\'glyphicon glyphicon-pencil\' ></span> Edit</button>';
                    tabel+='<button type=\'button\' class=\'btn btn-danger \' onclick=\'hapus("' +role_akses[i]["id_akses"] +'")\'><span class=\'glyphicon glyphicon-remove\' ></span> Hapus</td>';
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
                    var btnFirst="<button class='btn btn-default btn-sm' onclick='getRole_akses(0)'><span class='fa fa-angle-double-left'></span></button>";
                    if(curIdx>1){
                        var prevSt=((curIdx-1)*data["limit"])-jmlData;
                        btnFirst+="<button class='btn btn-default btn-sm' onclick='getRole_akses("+prevSt+")'><span class='fa fa-angle-left'></span></button>";
                    }

                    var btnLast="";
                    if(curIdx<jmlPage){
                        var nextSt=((curIdx+1)*data["limit"])-jmlData;
                        btnLast+="<button class='btn btn-default btn-sm' onclick='getRole_akses("+nextSt+")'><span class='fa fa-angle-right'></span></button>";
                    }
                    btnLast+="<button class='btn btn-default btn-sm' onclick='getRole_akses("+lastSt+")'><span class='fa fa-angle-double-right'></span></button>";
                    
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
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getRole_akses("+ st +")'>" + j +"</button>";
                        }
                    }else{
                        for (var j = 1; j<=jmlPage; j++) {
                            st=(j*data["limit"])-jmlData;
                            if(curSt==st)  btn="btn-success"; else btn= "btn-default";
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getRole_akses("+ st +")'>" + j +"</button>";
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
    $('.modal-title').text('Tambah Data Role_akses'); 
}
function save(){
    var url;
    url = base_url + "role_akses/save";
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
            $('#csrf').val(data["csrf"]);
            $('#modal_form').modal('hide');
            var start=$('#start').val();
            getRole_akses(start);
            swal({
             title: "Sukses",
             text: data["message"],
             type: "success",
             timer: 5000
            });
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
        url : base_url + "role_akses/edit/" + id,
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
                var role_akses = data["data"];
                
                $('#id_akses').val(role_akses.id_akses);
                $('#role_id').val(role_akses.role_id);
                $('#modul_id').val(role_akses.modul_id);
                $('#id_aksi').val(role_akses.id_aksi);
            if(role_akses.tampil_menu==1) $('#tampil_menu').prop( "checked", true );
                $('#modal_form').modal('show'); 
                $('.modal-title').text('Edit Data Role_akses'); 
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
            url : base_url + "role_akses/delete/" +id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                var start=$('#start').val();
                getRole_akses(start);
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

function setTampil(id_group){
    if ($('#tampil_menu'+id_group).is(':checked')) {
        var url=base_url+"role_akses/tampil/"+id_group+"/1";
    }else{
        var url=base_url+"role_akses/tampil/"+id_group+"/0";
    }
    console.log(url);
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