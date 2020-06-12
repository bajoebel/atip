
getPengguna(0);
function getPengguna(start){
    $('#start').val(start);
    var search = $('#q').val();
    var active="class='btn btn-primary btn-sm'";
    var url=base_url + "pengguna/data?q=" + search + "&start=" +start;
    $.ajax({
        url     : url,
        type    : "GET",
        dataType: "json",
        data    : {get_param : 'value'},
        success : function(data){
            //menghitung jumlah data
            console.clear();
            if(data["status"]==true){
                var pengguna    = data["data"];
                var jmlData=pengguna.length;
                var limit   = data["limit"]
                var tabel   = "";
                //Create Tabel
                for(var i=0; i<jmlData;i++){
                    start++;
                    tabel+="<tr>";
                    tabel+="<td>"+start+"</td>";
                    tabel+="<td>"+pengguna[i]["username"]+"</td>";
                    tabel+="<td>"+pengguna[i]["role_nama"]+"</td>";
                    tabel+="<td>"+pengguna[i]["nama_lengkap"]+"</td>";
                    if(pengguna[i]["status_user"]==1){
                        tabel+="<td style='width:100px;'><button class='btn btn-success btn-xs'>Aktif</button></td>";
                    }else{
                        tabel+="<td style='width:100px;'><button class='btn btn-danger btn-xs'>Non Aktif</button></td>";
                    }
                    tabel+='<td class=\'text-right\'><button type=\'button\' class=\'btn btn-success btn-xs\' onclick=\'edit("' +pengguna[i]["username"] +'")\'><span class=\'fa fa-pencil\' ></span></button>|';
                    tabel+='<button type=\'button\' class=\'btn btn-danger btn-xs\' onclick=\'hapus("' +pengguna[i]["username"] +'")\'><span class=\'fa fa-remove\' ></span></td>';
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
                    var btnFirst="<button class='btn btn-default btn-sm' onclick='getPengguna(0)'><span class='fa fa-angle-double-left'></span></button>";
                    if(curIdx>1){
                        var prevSt=((curIdx-1)*data["limit"])-jmlData;
                        btnFirst+="<button class='btn btn-default btn-sm' onclick='getPengguna("+prevSt+")'><span class='fa fa-angle-left'></span></button>";
                    }

                    var btnLast="";
                    if(curIdx<jmlPage){
                        var nextSt=((curIdx+1)*data["limit"])-jmlData;
                        btnLast+="<button class='btn btn-default btn-sm' onclick='getPengguna("+nextSt+")'><span class='fa fa-angle-right'></span></button>";
                    }
                    btnLast+="<button class='btn btn-default btn-sm' onclick='getPengguna("+lastSt+")'><span class='fa fa-angle-double-right'></span></button>";
                    
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
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getPengguna("+ st +")'>" + j +"</button>";
                        }
                    }else{
                        for (var j = 1; j<=jmlPage; j++) {
                            st=(j*data["limit"])-jmlData;
                            if(curSt==st)  btn="btn-success"; else btn= "btn-default";
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getPengguna("+ st +")'>" + j +"</button>";
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
    
                $('#err_username').html("");
                $('#err_password').html("");
                $('#err_ref_id').html("");
                $('#err_group_user').html("");
                $('#err_role').html("");
                $('#err_status_user').html("");
    $('.modal-title').text('Tambah Data Pengguna'); 
}
function save(){
    var url;
    url = base_url + "pengguna/save";
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
                    
                if(data["err_username"]!="") $('#err_username').html(data["err_username"]); else $('#err_username').html("");
                
                if(data["err_password"]!="") $('#err_password').html(data["err_password"]); else $('#err_password').html("");
                
                if(data["err_ref_id"]!="") $('#err_ref_id').html(data["err_ref_id"]); else $('#err_ref_id').html("");
                
                if(data["err_group_user"]!="") $('#err_group_user').html(data["err_group_user"]); else $('#err_group_user').html("");
                
                if(data["err_role"]!="") $('#err_role').html(data["err_role"]); else $('#err_role').html("");
                
                if(data["err_status_user"]!="") $('#err_status_user').html(data["err_status_user"]); else $('#err_status_user').html("");
                
                }else{
                    $('#csrf').val(data["csrf"]);
                    $('#modal_form').modal('hide');
                    var start=$('#start').val();
                    
                    getPengguna(start);
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
        url : base_url + "pengguna/edit/" + id,
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
                var pengguna = data["data"];
                
                $('#username').val(pengguna.username);
                $('#password').val(pengguna.password);
                $('#ref_id').val(pengguna.ref_id);
                $('#group_user').val(pengguna.group_user);
                $('#role').val(pengguna.role);
            if(pengguna.status_user==1) $('#status_user').prop( "checked", true );
                
                $('#err_username').html("");
                $('#err_password').html("");
                $('#err_ref_id').html("");
                $('#err_group_user').html("");
                $('#err_role').html("");
                $('#csrf').val(data["csrf"]),
                $('#modal_form').modal('show'); 
                $('.modal-title').text('Edit Data Pengguna'); 
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
            url : base_url + "pengguna/delete/" +id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                var start=$('#start').val();
                getPengguna(start);
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