
getKomentar(0);
function getKomentar(start){
    $('#start').val(start);
    var search = $('#q').val();
    var limit = $('#limit').val();
    var active="class='btn btn-primary btn-sm'";
    var url=base_url + "komentar/data?q=" + search + "&start=" +start+ "&limit=" +limit;
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
                var komentar    = data["data"];
                var jmlData=komentar.length;
                var limit   = data["limit"]
                var tabel   = "";
                //Create Tabel
                for(var i=0; i<jmlData;i++){
                    start++;
                    tabel+="<tr>";
                    tabel+="<td>"+start+"</td>";
                    
                    tabel+="<td>"+komentar[i]["judul_posting"]+"</td>";
                    tabel+="<td>"+komentar[i]["email"]+"</td>";
                    tabel+="<td>"+komentar[i]["nama"]+"</td>";
                    tabel+="<td>"+komentar[i]["komentar"]+"</td>";
                    if(komentar[i]["status"]==1){
                        tabel+='<td style="width:100px;">';
                        tabel+='<label class="switch switch-small">';
                        tabel+='<input type="checkbox" checked value="1" onclick="nonAktifkan(\''+komentar[i]["id_komentar"]+'\')"/>';
                        tabel+='<span></span>';
                        tabel+='</label>';
                        tabel+='</td>'
                        //tabel+="<td style='width:100px;'><button class='btn btn-success btn-sm'>Aktif</button></td>";
                    }else{
                        tabel+='<td style="width:100px;">';
                        tabel+='<label class="switch switch-small">';
                        tabel+='<input type="checkbox" value="0" onclick="aktifkan(\''+komentar[i]["id_komentar"]+'\')" />';
                        tabel+='<span></span>';
                        tabel+='</label>';
                        tabel+='</td>'
                        //tabel+="<td style='width:100px;'><button class='btn btn-danger btn-sm'>Non Aktif</button></td>";
                    }
                    
                    tabel+='<td class=\'text-right\' style="width:200px;">';
                    tabel+='<div class="btn-group btn-group-sm">';
                    tabel+='<button type=\'button\' class=\'btn btn-success \' onclick=\'edit("' +komentar[i]["id_komentar"] +'")\'><span class=\'glyphicon glyphicon-pencil\' ></span> Edit</button>';
                    tabel+='<button type=\'button\' class=\'btn btn-danger \' onclick=\'hapus("' +komentar[i]["id_komentar"] +'")\'><span class=\'glyphicon glyphicon-remove\' ></span> Hapus</td>';
                    tabel+='</div>';

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
                    var btnFirst="<button class='btn btn-default btn-sm' onclick='getKomentar(0)'><span class='fa fa-angle-double-left'></span></button>";
                    if(curIdx>1){
                        var prevSt=((curIdx-1)*data["limit"])-jmlData;
                        btnFirst+="<button class='btn btn-default btn-sm' onclick='getKomentar("+prevSt+")'><span class='fa fa-angle-left'></span></button>";
                    }

                    var btnLast="";
                    if(curIdx<jmlPage){
                        var nextSt=((curIdx+1)*data["limit"])-jmlData;
                        btnLast+="<button class='btn btn-default btn-sm' onclick='getKomentar("+nextSt+")'><span class='fa fa-angle-right'></span></button>";
                    }
                    btnLast+="<button class='btn btn-default btn-sm' onclick='getKomentar("+lastSt+")'><span class='fa fa-angle-double-right'></span></button>";
                    
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
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getKomentar("+ st +")'>" + j +"</button>";
                        }
                    }else{
                        for (var j = 1; j<=jmlPage; j++) {
                            st=(j*data["limit"])-jmlData;
                            if(curSt==st)  btn="btn-success"; else btn= "btn-default";
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getKomentar("+ st +")'>" + j +"</button>";
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
    
                $('#err_id_komentar').html("");
                $('#err_id_post').html("");
                $('#err_email').html("");
                $('#err_nama').html("");
                $('#err_komentar').html("");
                $('#err_status').html("");
    $('.modal-title').text('Tambah Data Komentar'); 
}
function save(){
    var url;
    url = base_url + "komentar/save";
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
                    
                if(data["err_id_komentar"]!="") $('#err_id_komentar').html(data["err_id_komentar"]); else $('#err_id_komentar').html("");
                
                if(data["err_id_post"]!="") $('#err_id_post').html(data["err_id_post"]); else $('#err_id_post').html("");
                
                if(data["err_email"]!="") $('#err_email').html(data["err_email"]); else $('#err_email').html("");
                
                if(data["err_nama"]!="") $('#err_nama').html(data["err_nama"]); else $('#err_nama').html("");
                
                if(data["err_komentar"]!="") $('#err_komentar').html(data["err_komentar"]); else $('#err_komentar').html("");
                
                if(data["err_status"]!="") $('#err_status').html(data["err_status"]); else $('#err_status').html("");
                
                }else{
                    $('#csrf').val(data["csrf"]);
                    $('#modal_form').modal('hide');
                    var start=$('#start').val();
                    
                    getKomentar(start);
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
        url : base_url + "komentar/edit/" + id,
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
                var komentar = data["data"];
                
                $('#id_komentar').val(komentar.id_komentar);
                $('#id_post').val(komentar.id_post);
                $('#email').val(komentar.email);
                $('#nama').val(komentar.nama);
                $('#komentar').val(komentar.komentar);
            if(komentar.status==1) $('#status').prop( "checked", true );
                
                $('#err_id_komentar').html("");
                $('#err_id_post').html("");
                $('#err_email').html("");
                $('#err_nama').html("");
                $('#err_komentar').html("");
                $('#csrf').val(data["csrf"]),
                $('#modal_form').modal('show'); 
                $('.modal-title').text('Edit Data Komentar'); 
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
            url : base_url + "komentar/delete/" +id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                var start=$('#start').val();
                getKomentar(start);
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

function aktifkan(id){
    $.ajax({
        url : base_url + "komentar/aktifkan/" +id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            var start=$('#start').val();
            getKomentar(start);
        },
        error: function (jqXHR, textStatus, errorThrown){
            swal({
             title: "Terjadi Kesalahan..!",
             text: "Gagal Saat Mengaktifkan Status",
             type: "error",
             timer: 5000
            });
        }
    });
}
function nonAktifkan(id){
    url = base_url + "komentar/nonaktifkan/" +id;
    console.log(url);
    $.ajax({
        url : base_url + "komentar/nonaktifkan/" +id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            var start=$('#start').val();
            getKomentar(start);
        },
        error: function (jqXHR, textStatus, errorThrown){
            swal({
             title: "Terjadi Kesalahan..!",
             text: "Gagal Saat Menonaktifkan status",
             type: "error",
             timer: 5000
            });
        }
    });   
}