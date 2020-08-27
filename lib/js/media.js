getMedia(0);
function getMedia(start){
    $('#start').val(start);
    var search = $('#q').val();
    var limit = $('#limit').val();
    var active="class='btn btn-primary btn-sm'";
    var url=base_url + "admin/media/data?q=" + search + "&start=" +start+ "&limit=" +limit;
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
                var media    = data["data"];
                var jmlData=media.length;
                var limit   = data["limit"]
                var tabel   = "";
                //Create Tabel
                for(var i=0; i<jmlData;i++){
                    start++;
                    tabel+="<tr>";
                    tabel+="<td><button class='btn btn-success btn-xs' onclick='openMedia(\""+media[i]["id_group"]+"\")'><span class='fa fa-plus icon-group' id='icon-group"+media[i]["id_group"]+"'></span></button></td>";
                    
                    tabel+="<td>"+media[i]["nama_group"]+"</td>";
                    
                    if(media[i]["status_group"]==1){
                        tabel+='<td style="width:100px;">';
                        tabel+='<label class="switch switch-small">';
                        tabel+='<input type="checkbox" checked value="1" onclick="nonAktifkan(\''+media[i]["id_group"]+'\')"/>';
                        tabel+='<span></span>';
                        tabel+='</label>';
                        tabel+='</td>'
                        //tabel+="<td style='width:100px;'><button class='btn btn-success btn-sm'>Aktif</button></td>";
                    }else{
                        tabel+='<td style="width:100px;">';
                        tabel+='<label class="switch switch-small">';
                        tabel+='<input type="checkbox" value="0" onclick="aktifkan(\''+media[i]["id_group"]+'\')" />';
                        tabel+='<span></span>';
                        tabel+='</label>';
                        tabel+='</td>'
                        //tabel+="<td style='width:100px;'><button class='btn btn-danger btn-sm'>Non Aktif</button></td>";
                    }

                    /*if(media[i]["sebagai_galery"]==1){
                        tabel+='<td style="width:100px;">';
                        tabel+='<label class="switch switch-small">';
                        tabel+="<input type='checkbox' id='sebagai_galery"+media[i]["id_group"]+"' onclick='setGalery(\""+media[i]["id_group"]+"\")' checked>";
                        tabel+='<span></span>';
                        tabel+='</label>';
                        tabel+='</td>';
                    }else{
                        tabel+='<td style="width:100px;">';
                        tabel+='<label class="switch switch-small">';
                        tabel+="<input type='checkbox' id='sebagai_galery"+media[i]["id_group"]+"' onclick='setGalery(\""+media[i]["id_group"]+"\")'>";
                        tabel+='<span></span>';
                        tabel+='</label>';
                        tabel+='</td>';
                    }
                    if(media[i]["sebagai_ppid"]==1){
                        tabel+='<td style="width:100px;">';
                        tabel+='<label class="switch switch-small">';
                        tabel+="<input type='checkbox' id='sebagai_ppid"+media[i]["id_group"]+"' onclick='setPpid(\""+media[i]["id_group"]+"\")' checked>";
                        tabel+='<span></span>';
                        tabel+='</label>';
                        tabel+='</td>';
                    }else{
                        tabel+='<td style="width:100px;">';
                        tabel+='<label class="switch switch-small">';
                        tabel+="<input type='checkbox' id='sebagai_ppid"+media[i]["id_group"]+"' onclick='setPpid(\""+media[i]["id_group"]+"\")' >";
                        tabel+='<span></span>';
                        tabel+='</label>';
                        tabel+='</td>';
                    }
                    if(media[i]["sebagai_download"]==1){
                        tabel+='<td style="width:100px;">';
                        tabel+='<label class="switch switch-small">';
                        tabel+="<input type='checkbox' id='sebagai_download"+media[i]["id_group"]+"' onclick='setDownload(\""+media[i]["id_group"]+"\")' checked>";
                        tabel+='<span></span>';
                        tabel+='</label>';
                        tabel+='</td>';
                    }else{
                        tabel+='<td style="width:100px;">';
                        tabel+='<label class="switch switch-small">';
                        tabel+="<input type='checkbox' id='sebagai_download"+media[i]["id_group"]+"' onclick='setDownload(\""+media[i]["id_group"]+"\")'>";
                        tabel+='<span></span>';
                        tabel+='</label>';
                        tabel+='</td>';
                    }*/

                    tabel+='<td class=\'text-right\' style="width:200px;">';
                    tabel+='<div class="btn-group btn-group-sm">';
                    tabel+='<button type=\'button\' class=\'btn btn-success \' onclick=\'edit("' +media[i]["id_group"] +'")\'><span class=\'glyphicon glyphicon-pencil\' ></span> Edit</button>';
                    tabel+='<button type=\'button\' class=\'btn btn-danger \' onclick=\'hapus("' +media[i]["id_group"] +'")\'><span class=\'glyphicon glyphicon-remove\' ></span> Hapus</td>';
                    tabel+='</div></td>';

                    
                    tabel+="<tr class='view-media' id='view-media"+media[i]["id_group"]+"' style='display:none;'><td colspan='7'  ><input type='hidden' class='open' id='open"+media[i]["id_group"]+"' value='0'><div class='col-md-12'><a href='#' class='btn btn-sm' onclick='addMedia(\""+media[i]["id_group"]+"\")'>Add</a></div><div class='col-md-12' id='data-media"+media[i]["id_group"]+"'></div></td></tr>";
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
                    var btnFirst="<button class='btn btn-default btn-sm' onclick='getMedia(0)'><span class='fa fa-angle-double-left'></span></button>";
                    if(curIdx>1){
                        var prevSt=((curIdx-1)*data["limit"])-jmlData;
                        btnFirst+="<button class='btn btn-default btn-sm' onclick='getMedia("+prevSt+")'><span class='fa fa-angle-left'></span></button>";
                    }

                    var btnLast="";
                    if(curIdx<jmlPage){
                        var nextSt=((curIdx+1)*data["limit"])-jmlData;
                        btnLast+="<button class='btn btn-default btn-sm' onclick='getMedia("+nextSt+")'><span class='fa fa-angle-right'></span></button>";
                    }
                    btnLast+="<button class='btn btn-default btn-sm' onclick='getMedia("+lastSt+")'><span class='fa fa-angle-double-right'></span></button>";
                    
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
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getMedia("+ st +")'>" + j +"</button>";
                        }
                    }else{
                        for (var j = 1; j<=jmlPage; j++) {
                            st=(j*data["limit"])-jmlData;
                            if(curSt==st)  btn="btn-success"; else btn= "btn-default";
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getMedia("+ st +")'>" + j +"</button>";
                        }
                    }
                    pagination+=btnFirst + btnIdx + btnLast;
                    $('#pagination').html(pagination);
                }
            }
        }
    });
}
function openMedia(id_group){
    var status=$('#open'+id_group).val();
    if(status==0){
        $('.open').val("0");
        $('#open'+id_group).val("1");
        $('.view-media').hide();
        $('#view-media'+id_group).show();
        $('.icon-group').removeClass('fa-minus');
        $('.icon-group').addClass('fa-plus');
        $('#icon-group'+id_group).removeClass('fa-plus');
        $('#icon-group'+id_group).addClass('fa-minus');
        getDatamedia(id_group);
    }else{
        $('#open'+id_group).val("0");
        $('#view-media'+id_group).hide();
        $('#icon-group'+id_group).removeClass('fa-minus');
        $('#icon-group'+id_group).addClass('fa-plus');
    }
    
}

function setStatus(id_group){
    if ($('#status_group'+id_group).is(':checked')) {
        var url=base_url+"admin/media/status/"+id_group+"/1";
    }else{
        var url=base_url+"admin/media/status/"+id_group+"/0";
    }
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

function setGalery(id_group){
    if ($('#sebagai_galery'+id_group).is(':checked')) {
        var url=base_url+"admin/media/galery/"+id_group+"/1";
    }else{
        var url=base_url+"admin/media/galery/"+id_group+"/0";
    }
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
function setPpid(id_group){
    if ($('#sebagai_ppid'+id_group).is(':checked')) {
        var url=base_url+"admin/media/ppid/"+id_group+"/1";
    }else{
        var url=base_url+"admin/media/ppid/"+id_group+"/0";
    }
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

function setDownload(id_group){
    if ($('#sebagai_download'+id_group).is(':checked')) {
        var url=base_url+"admin/media/download/"+id_group+"/1";
    }else{
        var url=base_url+"admin/media/download/"+id_group+"/0";
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
function add(){
    save_method = 'add';
    $('#form')[0].reset(); 
    $('#modal_form').modal('show'); 
    
                $('#err_id_group').html("");
                $('#err_nama_group').html("");
                $('#err_status_group').html("");
                $('#err_sebagai_galery').html("");
                $('#err_sebagai_download').html("");
    $('.modal-title').text('Tambah Data Media'); 
}
function addMedia(id_group){
    save_method = 'add';
    $('#x-id_group').val(id_group);
    $('#form')[0].reset(); 
    $('#modal_media').modal('show'); 
    $('.media-title').text('Tambah Data Media'); 
}
function halamanBerkas(){
    var jmlhalaman=$('#jumlah_file').val();
    var form = "";
    var hal=0;
    for(var i=0; i<jmlhalaman; i++){
        hal++;
        form+='<div class="form-group">';
        form+='<label for="inputEmail3" class="col-sm-12">FILE '+hal+'</label>';
        form+='<div class="col-sm-6">';
        form+='<input type="file" id="file'+i+'" name="userfile[]" class="form-control" >';
        form+='</div>';
        form+='<div class="col-sm-6">';
        form+='<input type="keterangan" id="keterangan'+i+'" name="keterangan[]" class="form-control" placeholder="Keterangan" value="">';
        form+='</div>';
        form+='</div>';
    }
    $('#file_berkas').html(form);
}
function save(){
    var url;
    url = base_url + "admin/media/save";
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
                    $('.csrf').val(data["csrf"]);
                    if(data["err_id_group"]!="") $('#err_id_group').html(data["err_id_group"]); else $('#err_id_group').html("");
                    if(data["err_nama_group"]!="") $('#err_nama_group').html(data["err_nama_group"]); else $('#err_nama_group').html("");
                    if(data["err_status_group"]!="") $('#err_status_group').html(data["err_status_group"]); else $('#err_status_group').html("");
                    if(data["err_sebagai_galery"]!="") $('#err_sebagai_galery').html(data["err_sebagai_galery"]); else $('#err_sebagai_galery').html("");
                    if(data["err_sebagai_download"]!="") $('#err_sebagai_download').html(data["err_sebagai_download"]); else $('#err_sebagai_download').html("");
                }else{
                    $('.csrf').val(data["csrf"]);
                    $('#modal_form').modal('hide');
                    var start=$('#start').val();
                    getMedia(start);
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

function upload(){
    var url;
    url = base_url + "admin/media/upload";
    console.clear();
    console.log(url);
    var formData = new FormData($('#form-media')[0]);
    $.ajax({
        url : url,
        type: "POST",
        data : formData,
        processData: false,
        contentType: false,
        dataType: 'JSON',
        success: function(data)
        {
            console.log(data);
            var id_group=$('#x-id_group').val();
            if(data["status"]==true){
                if(data["error"]==true){
                    $('.csrf').val(data["csrf"]);
                    
                }else{
                    $('#modal_media').modal('hide');
                    var start=$('#start').val();
                    $('.csrf').val(data["csrf"]);
                    getDatamedia(id_group);
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


function getDatamedia(id_group){
    //$('#start').val(start);
    //var search = $('#q').val();
    //var active="class='btn btn-primary btn-sm'";
    var url=base_url + "admin/media/datamedia/" + id_group;
    $.ajax({
        url     : url,
        type    : "GET",
        dataType: "json",
        data    : {get_param : 'value'},
        success : function(data){
            //menghitung jumlah data
            //console.clear();
            console.log(url);
            if(data["status"]==true){
                var media    = data["data"];
                var jmlData=media.length;
                var limit   = data["limit"]
                var tabel   = "";
                var file = "";
                var ext = "";
                //Create Tabel
                for(var i=0; i<jmlData;i++){
                    start++;
                    tabel+="<div class='col-md-1'>";
                    tabel+="<a href='#' onclick='viewMedia(\""+media[i]["id_media"]+"\")'>";
                    file=media[i]["namafile"];
                    arr=file.split(".");
                    jml_split=arr.length;
                    ext=arr[jml_split-1];
                    //console.log(ext);
                    //console.log("jml SPLIT : " + jml_split);
                    if(ext=="jpg"||ext=="png"||ext=="gif"||ext=="jpeg"){
                        tabel+="<img src='"+base_url+"uploads/media/thumb/100X100/_100x100_"+media[i]["namafile"]+"' class='img img-responsive'>";
                    }else{
                        tabel+="<img src='"+base_url+"uploads/media/"+ext+".png' class='img img-responsive'>";
                    }
                    tabel+="<div>"+media[i]["keterangan"]+"</div></div>";
                }
                $('#data-media'+id_group).html(tabel);
                
            }
        }
    });
}
function viewMedia(idmedia){
    var url=base_url+"admin/media/viewmedia/"+idmedia;
    $.ajax({
        url : url,
        type: "GET",
        dataType: "HTML",
        success: function(data)
        {
            $('#modal_view').modal('show'); 
            $('#view-media').html(data);
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

function updateMedia(){
    var url;
    url = base_url + "admin/media/updatemedia";
    var formData = new FormData($('#view-form-media')[0]);
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
                    $('.csrf').val(data["csrf"]);
                
                }else{
                    
                    $('.csrf').val(data["csrf"]);
                    //var id_group=$('#x-id_group').val();
                    //alert(id_group);
                    getDatamedia(data["id_group"]);
                    $('#modal_view').modal('hide');
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
        url : base_url + "admin/media/edit/" + id,
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
                var media = data["data"];
                
                $('#id_group').val(media.id_group);
                $('#nama_group').val(media.nama_group);
                if(media.status_group==1) $('#status_group').prop( "checked", true );
            /*if(media.sebagai_galery==1) $('#sebagai_galery').prop( "checked", true );
            if(media.sebagai_download==1) $('#sebagai_download').prop( "checked", true );
                */
                $('#err_id_group').html("");
                $('#err_nama_group').html("");
                $('.csrf').val(data["csrf"]),
                $('#modal_form').modal('show'); 
                $('.modal-title').text('Edit Data Media'); 
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
            url : base_url + "admin/media/delete/" +id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                var start=$('#start').val();
                getMedia(start);
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

function deleteMedia(){
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
        var idmedia=$('#x-id_media').val();
        var idgroup=$('#x-idgroup').val();
        console.log("ID GROUP : "+idgroup);
        var url = base_url+"admin/media/deletemedia/"+idmedia+"/"+idgroup;
        console.log(url);
      if (isConfirm) {
        //var formData = new FormData($('#view-form-media')[0]);
        $.ajax({
            url : url,
            type: "GET",
            dataType: 'JSON',
            success: function(data)
            {
                console.log(data);
                var start=$('#start').val();
                $('.csrf').val(data["csrf"]);
                getDatamedia(data["id_group"]);
                $('#modal_view').modal('hide');
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
        url : base_url + "admin/media/aktifkan/" +id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            var start=$('#start').val();
            getMedia(start);
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
    url = base_url + "admin/media/nonaktifkan/" +id;
    console.log(url);
    $.ajax({
        url : base_url + "admin/media/nonaktifkan/" +id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            var start=$('#start').val();
            getMedia(start);
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