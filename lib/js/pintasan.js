getpintasan(0);
function getpintasan(start){
    $('#start').val(start);
    var search = $('#q').val();
    var active="class='btn btn-primary btn-sm'";
    var url=base_url + "admin/pintasan/data?q=" + search + "&start=" +start;
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
                var pintasan    = data["data"];
                var jmlData=pintasan.length;
                var limit   = data["limit"]
                var tabel   = "";
                //Create Tabel
                for(var i=0; i<jmlData;i++){
                    start++;
                    tabel+="<tr>";
                    tabel+="<td>"+start+"</td>";
                    tabel+="<td><img class='img img-responsive' src='"+base_url+"uploads/media/thumb/88X88/_88X88_"+pintasan[i]["pintasan_img"]+"'></td>";
                    tabel+="<td>"+pintasan[i]["pintasan_nama"]+"</td>";
                    tabel+="<td>"+pintasan[i]["pintasan_link"]+"</td>";
                    
                    if(pintasan[i]["pintasan_status"]==1){
                        tabel+='<td style="width:100px;">';
                        tabel+='<label class="switch switch-small">';
                        tabel+='<input type="checkbox" checked value="1" onclick="nonAktifkan(\''+pintasan[i]["pintasan_id"]+'\')"/>';
                        tabel+='<span></span>';
                        tabel+='</label>';
                        tabel+='</td>'
                        //tabel+="<td style='width:100px;'><button class='btn btn-success btn-sm'>Aktif</button></td>";
                    }else{
                        tabel+='<td style="width:100px;">';
                        tabel+='<label class="switch switch-small">';
                        tabel+='<input type="checkbox" value="0" onclick="aktifkan(\''+pintasan[i]["pintasan_id"]+'\')" />';
                        tabel+='<span></span>';
                        tabel+='</label>';
                        tabel+='</td>'
                        //tabel+="<td style='width:100px;'><button class='btn btn-danger btn-sm'>Non Aktif</button></td>";
                    }
                    tabel+='<td class=\'text-right\' style="width:200px;">';
                    tabel+='<div class="btn-group btn-group-sm">';
                    tabel+='<button type=\'button\' class=\'btn btn-success \' onclick=\'edit("' +pintasan[i]["pintasan_id"] +'")\'><span class=\'glyphicon glyphicon-pencil\' ></span> Edit</button>';
                    tabel+='<button type=\'button\' class=\'btn btn-danger \' onclick=\'hapus("' +pintasan[i]["pintasan_id"] +'")\'><span class=\'glyphicon glyphicon-remove\' ></span> Hapus</td>';
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
                    
                    var curSt=(curIdx*data["limit"])-jmlData;
                    var st=start;
                    var btn="btn-deglyphiconult";
                    var lastSt=(jmlPage*data["limit"])-jmlData
                    var btnFirst="<button class='btn btn-deglyphiconult btn-sm' onclick='getpintasan(0)'><span class='glyphicon glyphicon-angle-double-left'></span></button>";
                    if(curIdx>1){
                        var prevSt=((curIdx-1)*data["limit"])-jmlData;
                        btnFirst+="<button class='btn btn-deglyphiconult btn-sm' onclick='getpintasan("+prevSt+")'><span class='glyphicon glyphicon-angle-left'></span></button>";
                    }

                    var btnLast="";
                    if(curIdx<jmlPage){
                        var nextSt=((curIdx+1)*data["limit"])-jmlData;
                        btnLast+="<button class='btn btn-deglyphiconult btn-sm' onclick='getpintasan("+nextSt+")'><span class='glyphicon glyphicon-angle-right'></span></button>";
                    }
                    btnLast+="<button class='btn btn-deglyphiconult btn-sm' onclick='getpintasan("+lastSt+")'><span class='glyphicon glyphicon-angle-double-right'></span></button>";
                    
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
                            if(curSt==st)  btn="btn-success"; else btn= "btn-deglyphiconult";
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getpintasan("+ st +")'>" + j +"</button>";
                        }
                    }else{
                        for (var j = 1; j<=jmlPage; j++) {
                            st=(j*data["limit"])-jmlData;
                            if(curSt==st)  btn="btn-success"; else btn= "btn-deglyphiconult";
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getpintasan("+ st +")'>" + j +"</button>";
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
    $('#pintasan_id').val("");
    $('#err_pintasan_id').html("");
    $('#err_pintasan_nama').html("");
    $('#err_pintasan_link').html("");
    $('#err_pintasan_img').html("");
    $('#err_pintasan_status').html("");
    $('.modal-title').text('Tambah Data pintasan'); 
}
function save(){
    var url;
    url = base_url + "admin/pintasan/save";
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
            console.clear();
            console.log(data);
            if(data["status"]==true){
                if(data["error"]==true){
                    $('#csrf').val(data["csrf"]);
                    
                    if(data["err_pintasan_id"]!="") $('#err_pintasan_id').html(data["err_pintasan_id"]); else $('#err_pintasan_id').html("");
                    
                    if(data["err_pintasan_nama"]!="") $('#err_pintasan_nama').html(data["err_pintasan_nama"]); else $('#err_pintasan_nama').html("");
                    
                    if(data["err_pintasan_link"]!="") $('#err_pintasan_link').html(data["err_pintasan_link"]); else $('#err_pintasan_link').html("");
                    
                    if(data["err_pintasan_img"]!="") $('#err_pintasan_img').html(data["err_pintasan_img"]); else $('#err_pintasan_img').html("");
                    
                    if(data["err_pintasan_status"]!="") $('#err_pintasan_status').html(data["err_pintasan_status"]); else $('#err_pintasan_status').html("");
                
                }else{
                    $('#modal_form').modal('hide');
                    $('#csrf').val(data["csrf"]);
                    var start=$('#start').val();
                    getpintasan(start);
                    swal({
                     title: "Sukses",
                     text: data["message"],
                     type: "success",
                     timer: 5000
                    });
                }
            }
            else{
                $('#csrf').val(data["csrf"]);
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
    var url =base_url + "admin/pintasan/edit/" + id;
    //alert(url);
    save_method = 'update';
    $('#form')[0].reset(); 
    $.ajax({
        url : base_url + "admin/pintasan/edit/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            if(data["status"]==false){
                $('#csrf').val(data["csrf"]);
                swal({
                 title: "Peringatan",
                 text: data["message"],
                 type: "error",
                 timer: 5000
                });

                //alert(data["message"]);
            }else{
                var pintasan = data["data"];
                
                $('#pintasan_id').val(pintasan.pintasan_id);
                $('#pintasan_nama').val(pintasan.pintasan_nama);
                $('#pintasan_link').val(pintasan.pintasan_link);
                //if(pintasan.pintasan_status==1) $('#pintasan_status').prop( "checked", true );
                if(pintasan.pintasan_status==1) {
                    $('#pintasan_status').prop( "checked", true );
                    $('.icheckbox_minimal-grey').addClass("checked");
                }else{
                    $('.icheckbox_minimal-grey').removeClass("checked");
                }
                $('#err_pintasan_id').html("");
                $('#err_pintasan_nama').html("");
                $('#err_pintasan_link').html("");
                $('#csrf').val(data["csrf"]),
                $('#modal_form').modal('show'); 
                $('.modal-title').text('Edit Data pintasan'); 
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
            url : base_url + "admin/pintasan/delete/" +id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                var start=$('#start').val();
                getpintasan(start);
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
        url : base_url + "admin/pintasan/aktifkan/" +id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            var start=$('#start').val();
            getpintasan(start);
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
    
    $.ajax({
        url : base_url + "admin/pintasan/nonaktifkan/" +id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            var start=$('#start').val();
            getpintasan(start);
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