getAdmin(0);
function getAdmin(start){
    $('#start').val(start);
    var search = $('#q').val();
    var limit = $('#limit').val();
    var active="class='btn btn-primary btn-sm'";
    var url=base_url + "admin/data?q=" + search + "&start=" +start+ "&limit=" +limit;
    console.log(url);
    $.ajax({
        url     : url,
        type    : "GET",
        dataType: "json",
        data    : {get_param : 'value'},
        success : function(data){
            //menghitung jumlah data
            //console.clear();
            if(data["status"]==true){
                var admin    = data["data"];
                var jmlData=admin.length;
                var limit   = data["limit"]
                var tabel   = "";
                //Create Tabel
                for(var i=0; i<jmlData;i++){
                    start++;
                    tabel+="<tr>";
                    tabel+="<td>"+start+"</td>";
                    tabel+="<td>"+admin[i]["nama_lengkap"]+"</td>";
                    tabel+="<td>"+admin[i]["email"]+"</td>";
                    tabel+="<td>"+admin[i]["alamat"]+"</td>";
                    tabel+="<td>"+admin[i]["nohp"]+"</td>";
                    tabel+="<td>"+admin[i]["role_nama"]+"</td>"; 
                    tabel+='<td class=\'text-right\' style="width:200px;">';
                    tabel+='<div class="btn-group btn-group-sm">';
                    tabel+='<button type=\'button\' class=\'btn btn-success \' onclick=\'edit("' +admin[i]["admin_id"] +'")\'><span class=\'glyphicon glyphicon-pencil\' ></span> Edit</button>';
                    tabel+='<button type=\'button\' class=\'btn btn-danger \' onclick=\'hapus("' +admin[i]["admin_id"] +'")\'><span class=\'glyphicon glyphicon-remove\' ></span> Hapus</td>';
                    tabel+='</div>';
                    tabel+='</td>';
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
                    
                    var curSt=(curIdx*data["limit"])-data["limit"];
                    var st=start;
                    var btn="btn-default";
                    var lastSt=(jmlPage*data["limit"])-data["limit"]
                    var btnFirst="<button class='btn btn-default btn-sm' onclick='getAdmin(0)'><span class='glyphicon glyphicon-angle-double-left'></span></button>";
                    if(curIdx>1){
                        var prevSt=((curIdx-1)*data["limit"])-jmlData;
                        btnFirst+="<button class='btn btn-default btn-sm' onclick='getAdmin("+prevSt+")'><span class='glyphicon glyphicon-angle-left'></span></button>";
                    }

                    var btnLast="";
                    if(curIdx<jmlPage){
                        var nextSt=((curIdx+1)*data["limit"])-data["limit"];
                        btnLast+="<button class='btn btn-default btn-sm' onclick='getAdmin("+nextSt+")'><span class='glyphicon glyphicon-angle-right'></span></button>";
                    }
                    btnLast+="<button class='btn btn-default btn-sm' onclick='getAdmin("+lastSt+")'><span class='glyphicon glyphicon-angle-double-right'></span></button>";
                    
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
                            st=(j*data["limit"])-data["limit"];
                            if(curSt==st)  btn="btn-success"; else btn= "btn-default";
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getAdmin("+ st +")'>" + j +"</button>";
                        }
                    }else{
                        for (var j = 1; j<=jmlPage; j++) {
                            st=(j*data["limit"])-data["limit"];
                            if(curSt==st)  btn="btn-success"; else btn= "btn-default";
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getAdmin("+ st +")'>" + j +"</button>";
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
    $('#err_id_admin').html("");
    $('#err_nama_lengkap').html("");
    $('#err_email').html("");
    $('#err_alamat').html("");
    $('#err_nohp').html("");
    $('#err_username').html("");
    $('#err_password').html("");
    $('#err_role').html("");
    $('#username').prop('readonly', false);
    $('#password').prop('readonly', false);
    $('#id_admin').val("");
    $('.modal-title').text('Tambah Data Admin'); 
}
function save(){
    var url;
    url = base_url + "admin/save";
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
            //console.log(data);
            if(data["status"]==true){
                if(data["error"]==true){
                    $('#csrf').val(data["csrf"]);
                    if(data["err_id_admin"]!="") $('#err_id_admin').html(data["err_id_admin"]); else $('#err_id_admin').html("");
                    if(data["err_nama_lengkap"]!="") $('#err_nama_lengkap').html(data["err_nama_lengkap"]); else $('#err_nama_lengkap').html("");
                    if(data["err_email"]!="") $('#err_email').html(data["err_email"]); else $('#err_email').html("");
                    if(data["err_alamat"]!="") $('#err_alamat').html(data["err_alamat"]); else $('#err_alamat').html("");
                    if(data["err_nohp"]!="") $('#err_nohp').html(data["err_nohp"]); else $('#err_nohp').html("");
                    if(data["err_username"]!="") $('#err_username').html(data["err_username"]); else $('#err_username').html("");
                    if(data["err_password"]!="") $('#err_password').html(data["err_password"]); else $('#err_password').html("");
                }else{
                    $('#csrf').val(data["csrf"]);
                    $('#modal_form').modal('hide');
                    var start=$('#start').val();
                    getAdmin(start);
                    
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
        url : base_url + "admin/edit/" + id,
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
                var admin = data["data"];
                
                $('#id_admin').val(admin.id_admin);
                $('#nama_lengkap').val(admin.nama_lengkap);
                $('#email').val(admin.email);
                $('#alamat').val(admin.alamat);
                $('#nohp').val(admin.nohp);
                $('#username').val(admin.username);
                $('#password').val(admin.password);
                $('#role').val(admin.role);
                $('#username').prop('readonly', true);
                $('#password').prop('readonly', true);
                $('#err_id_admin').html("");
                $('#err_nama_lengkap').html("");
                $('#err_email').html("");
                $('#err_alamat').html("");
                $('#err_nohp').html("");
                $('#err_username').html("");
                $('#err_password').html("");
                $('#err_role').html("");
                $('#csrf').val(data["csrf"]),
                $('#modal_form').modal('show'); 
                $('.modal-title').text('Edit Data Admin'); 
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
            url : base_url + "admin/delete/" +id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                var start=$('#start').val();
                getAdmin(start);
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