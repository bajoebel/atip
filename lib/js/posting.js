function getPosting(start){
    $('#start').val(start);
    var search = $('#q').val();
    var active="class='btn btn-primary btn-sm'";
    var limit = $('#limit').val();
    var url=base_url + "admin/posting/data?q=" + search + "&start=" +start+ "&limit=" +limit;
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
                var posting    = data["data"];
                var jmlData=posting.length;
                var limit   = data["limit"]
                var tabel   = "";
                //Create Tabel
                for(var i=0; i<jmlData;i++){
                    start++;
                    tgl=posting[i]["tgl_publish"];
                    arr=tgl.split("-");

                    tabel+="<tr>";
                    tabel+="<td>"+start+"</td>";
                    
                    tabel+="<td>"+posting[i]["nama_kategori"]+"</td>";
                    tabel+="<td>"+posting[i]["judul_posting"]+"</td>";
                    tabel+="<td>"+posting[i]["tgl_posting"]+"</td>";
                    tabel+="<td>"+posting[i]["tgl_publish"]+"</td>";
                    tabel+="<td>"+posting[i]["tgl_exp"]+"</td>";
                    tabel+="<td>"+posting[i]["group_posting"]+"</td>";
                    if(posting[i]["group_posting"]=="Artikel"){
                        tabel+="<td>"+base_url + arr[2] +"/"+arr[1]+"/"+arr[0]+"/"+posting[i]["link_posting"] +"</td>";
                    }else{
                        tabel+="<td>"+base_url + "halaman/"+posting[i]["link_posting"] +"</td>";
                    }
                    
                    // id='sebagai_galery"+media[i]["id_group"]+"' onclick='setGalery(\""+media[i]["id_group"]+"\")'
                    if(posting[i]["status_komentar"]==1){
                        tabel+='<td style="width:100px;">';
                        tabel+='<label class="switch switch-small">';
                        tabel+='<input type="checkbox" checked value="1" id="status_komentar'+posting[i]["id_posting"]+'"  onclick="setKomentar(\''+posting[i]["id_posting"]+'\')"/>';
                        tabel+='<span></span>';
                        tabel+='</label>';
                        tabel+='</td>'
                        //tabel+="<td style='width:100px;'><button class='btn btn-success btn-sm'>Aktif</button></td>";
                    }else{
                        tabel+='<td style="width:100px;">';
                        tabel+='<label class="switch switch-small">';
                        tabel+='<input type="checkbox" value="1" id="status_komentar'+posting[i]["id_posting"]+'"  c/>';
                        tabel+='<span></span>';
                        tabel+='</label>';
                        tabel+='</td>'
                        //tabel+="<td style='width:100px;'><button class='btn btn-danger btn-sm'>Non Aktif</button></td>";
                    }
                    
                    tabel+="<td>";
                    if(posting[i]["status_posting"]=="Publish"){
                        var style='success';
                    }else if(posting[i]["status_posting"]=="Draft"){
                        var style='warning';
                    }else{
                        var style='danger';
                    }
                    tabel+='<button type="button" class="btn btn-'+style+' btn-sm dropdown-toggle" data-toggle="dropdown">'+posting[i]["status_posting"]+' <span class="caret"></span></button>';
                    tabel+='<ul class="dropdown-menu" role="menu">';
                    if(posting[i]["status_posting"]=="Unpublish") tabel+='<li role="presentation" class="dropdown-header">Unpublish</li>'; else tabel+='<li><a href="#"  onclick="setStatus(\''+posting[i]["id_posting"]+'\',\'Unpublish\')">Unpublish</a></li>';
                    if(posting[i]["status_posting"]=="Draft") tabel+='<li role="presentation" class="dropdown-header">Draft</li>'; else tabel+='<li><a href="#" onclick="setStatus(\''+posting[i]["id_posting"]+'\',\'Draft\')">Draft</a></li>';
                    if(posting[i]["status_posting"]=="Publish") tabel+='<li role="presentation" class="dropdown-header">Publish</li>'; else tabel+=' <li><a href="#" onclick="setStatus(\''+posting[i]["id_posting"]+'\',\'Publish\')">Publish</a></li>';
                    tabel+="</td>"; 
                    tabel+="<td>"+posting[i]["jml_hits"]+"</td>";
                    tabel+="<td>"+posting[i]["userinput"]+"</td>";

                    tabel+='<td class=\'text-right\' style="width:200px;">';
                    tabel+='<div class="btn-group btn-group-sm">';
                    tabel+='<a href=\''+base_url+'admin/posting/form/'+posting[i]["id_posting"]+'\' class=\'btn btn-success\'><span class=\'glyphicon glyphicon-pencil\' ></span> Edit</a>';
                    tabel+='<button type=\'button\' class=\'btn btn-danger \' onclick=\'hapus("' +posting[i]["id_posting"] +'")\'><span class=\'glyphicon glyphicon-remove\' ></span> Hapus</td>';
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
                    var btnFirst="<button class='btn btn-default btn-sm' onclick='getPosting(0)'><span class='fa fa-angle-double-left'></span></button>";
                    if(curIdx>1){
                        var prevSt=((curIdx-1)*data["limit"])-data["limit"];
                        btnFirst+="<button class='btn btn-default btn-sm' onclick='getPosting("+prevSt+")'><span class='fa fa-angle-left'></span></button>";
                    }

                    var btnLast="";
                    if(curIdx<jmlPage){
                        var nextSt=((curIdx+1)*data["limit"])-data["limit"];
                        btnLast+="<button class='btn btn-default btn-sm' onclick='getPosting("+nextSt+")'><span class='fa fa-angle-right'></span></button>";
                    }
                    btnLast+="<button class='btn btn-default btn-sm' onclick='getPosting("+lastSt+")'><span class='fa fa-angle-double-right'></span></button>";
                    
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
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getPosting("+ st +")'>" + j +"</button>";
                        }
                    }else{
                        for (var j = 1; j<=jmlPage; j++) {
                            st=(j*data["limit"])-data["limit"];
                            if(curSt==st)  btn="btn-success"; else btn= "btn-default";
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getPosting("+ st +")'>" + j +"</button>";
                        }
                    }
                    pagination+=btnFirst + btnIdx + btnLast;
                    $('#pagination').html(pagination);
                }
            }
        }
    });
}
function getMedia(start){
    $('#start').val(start);
    var search = $('#q').val();
    var active="class='btn btn-primary btn-sm'";
    var url=base_url + "admin/posting/datamedia?q=" + search + "&start=" +start;
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
                    
                    tabel+="</tr>";
                    tabel+="<tr class='view-media' id='view-media"+media[i]["id_group"]+"' style='display:none;'><td colspan='5'  ><input type='hidden' class='open' id='open"+media[i]["id_group"]+"' value='0'><div class='col-md-12' id='data-media"+media[i]["id_group"]+"'></div></td></tr>";
                }
                $('#data-media').html(tabel);
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
                    var btnFirst="<button class='btn btn-default btn-sm' onclick='getMedia(0)'><span class='fa fa-angle-double-left'></span></button>";
                    if(curIdx>1){
                        var prevSt=((curIdx-1)*data["limit"])-data["limit"];
                        btnFirst+="<button class='btn btn-default btn-sm' onclick='getMedia("+prevSt+")'><span class='fa fa-angle-left'></span></button>";
                    }

                    var btnLast="";
                    if(curIdx<jmlPage){
                        var nextSt=((curIdx+1)*data["limit"])-data["limit"];
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
                            st=(j*data["limit"])-data["limit"];
                            if(curSt==st)  btn="btn-success"; else btn= "btn-default";
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getMedia("+ st +")'>" + j +"</button>";
                        }
                    }else{
                        for (var j = 1; j<=jmlPage; j++) {
                            st=(j*data["limit"])-data["limit"];
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
function getDatamedia(id_group){
    //$('#start').val(start);
    //var search = $('#q').val();
    //var active="class='btn btn-primary btn-sm'";
    var url=base_url + "admin/posting/detailmedia/" + id_group;
    $.ajax({
        url     : url,
        type    : "GET",
        dataType: "json",
        data    : {get_param : 'value'},
        success : function(data){
            //menghitung jumlah data
            console.clear();
            console.log(url);
            if(data["status"]==true){
                var media    = data["data"];
                var jmlData=media.length;
                var limit   = data["limit"]
                var tabel   = "";
                //Create Tabel
                for(var i=0; i<jmlData;i++){
                    start++;
                    tabel+="<div class='col-md-4'>";
                    tabel+="<a href='#' onclick='viewMedia(\""+media[i]["id_media"]+"\")'>";
                    file=media[i]["namafile"];
                    arr=file.split(".");
                    jml_split=arr.length;
                    ext=arr[jml_split-1];
                    //console.log(ext);
                    //console.log("jml SPLIT : " + jml_split);
                    if(ext=="jpg"||ext=="png"||ext=="gif"||ext=="jpeg"){
                        tabel+="<img src='"+base_url+"uploads/media/thumb/"+media[i]["namafile"]+"' class='img img-responsive'>";
                    }else{
                        tabel+="<img src='"+base_url+"uploads/media/"+ext+".png' class='img img-responsive'>";
                    }
                    //tabel+="<img src='"+base_url+"uploads/media/"+media[i]["namafile"]+"' class='img img-responsive'>";
                    tabel+="<div>"+media[i]["keterangan"]+"</div></div>";
                }
                $('#data-media'+id_group).html(tabel);
                
            }
        }
    });
}

function viewMedia(idmedia){
    var url=base_url+"admin/posting/viewmedia/"+idmedia;
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
function add(){
    save_method = 'add';
    $('#form')[0].reset(); 
    $('#modal_form').modal('show'); 
    
                $('#err_id_posting').html("");
                $('#err_id_kategori').html("");
                $('#err_judul_posting').html("");
                $('#err_isi_posting').html("");
                $('#err_tgl_posting').html("");
                $('#err_tgl_publish').html("");
                $('#err_tgl_exp').html("");
                $('#err_lampiran_gambar').html("");
                $('#err_link_posting').html("");
                $('#err_group_posting').html("");
                $('#err_status_komentar').html("");
                $('#err_status_posting').html("");
                $('#err_jml_hits').html("");
                $('#err_userinput').html("");
    $('.modal-title').text('Tambah Data Posting'); 
}
function save(){
    var url;
    url = base_url + "admin/posting/save";
    //alert("user");
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
            //alert(data["message"]);
            //console.log(data);
            if(data["status"]==true){
                if(data["error"]==true){
                    $('#csrf').val(data["csrf"]);
                    
                if(data["err_id_posting"]!="") $('#err_id_posting').html(data["err_id_posting"]); else $('#err_id_posting').html("");
                
                if(data["err_id_kategori"]!="") $('#err_id_kategori').html(data["err_id_kategori"]); else $('#err_id_kategori').html("");
                
                if(data["err_judul_posting"]!="") $('#err_judul_posting').html(data["err_judul_posting"]); else $('#err_judul_posting').html("");
                
                if(data["err_isi_posting"]!="") $('#err_isi_posting').html(data["err_isi_posting"]); else $('#err_isi_posting').html("");
                
                if(data["err_tgl_posting"]!="") $('#err_tgl_posting').html(data["err_tgl_posting"]); else $('#err_tgl_posting').html("");
                
                if(data["err_tgl_publish"]!="") $('#err_tgl_publish').html(data["err_tgl_publish"]); else $('#err_tgl_publish').html("");
                
                if(data["err_tgl_exp"]!="") $('#err_tgl_exp').html(data["err_tgl_exp"]); else $('#err_tgl_exp').html("");
                
                if(data["err_lampiran_gambar"]!="") $('#err_lampiran_gambar').html(data["err_lampiran_gambar"]); else $('#err_lampiran_gambar').html("");
                
                if(data["err_link_posting"]!="") $('#err_link_posting').html(data["err_link_posting"]); else $('#err_link_posting').html("");
                
                if(data["err_group_posting"]!="") $('#err_group_posting').html(data["err_group_posting"]); else $('#err_group_posting').html("");
                
                if(data["err_status_komentar"]!="") $('#err_status_komentar').html(data["err_status_komentar"]); else $('#err_status_komentar').html("");
                
                if(data["err_status_posting"]!="") $('#err_status_posting').html(data["err_status_posting"]); else $('#err_status_posting').html("");
                
                if(data["err_jml_hits"]!="") $('#err_jml_hits').html(data["err_jml_hits"]); else $('#err_jml_hits').html("");
                
                if(data["err_userinput"]!="") $('#err_userinput').html(data["err_userinput"]); else $('#err_userinput').html("");
                
                }else{
                    $('#csrf').val(data["csrf"]);
                    $('#modal_form').modal('hide');
                    var start=$('#start').val();
                    
                    getPosting(start);
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
        url : base_url + "admin/posting/edit/" + id,
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
                var posting = data["data"];
                
                $('#id_posting').val(posting.id_posting);
                $('#id_kategori').val(posting.id_kategori);
                $('#judul_posting').val(posting.judul_posting);
                $('#isi_posting').val(posting.isi_posting);
                $('#tgl_posting').val(posting.tgl_posting);
                $('#tgl_publish').val(posting.tgl_publish);
                $('#tgl_exp').val(posting.tgl_exp);
                $('#lampiran_gambar').val(posting.lampiran_gambar);
                $('#link_posting').val(posting.link_posting);
                $('#group_posting').val(posting.group_posting);
            if(posting.status_komentar==1) $('#status_komentar').prop( "checked", true );
                $('#status_posting').val(posting.status_posting);
                $('#jml_hits').val(posting.jml_hits);
                $('#userinput').val(posting.userinput);
                
                $('#err_id_posting').html("");
                $('#err_id_kategori').html("");
                $('#err_judul_posting').html("");
                $('#err_isi_posting').html("");
                $('#err_tgl_posting').html("");
                $('#err_tgl_publish').html("");
                $('#err_tgl_exp').html("");
                $('#err_lampiran_gambar').html("");
                $('#err_link_posting').html("");
                $('#err_group_posting').html("");
                $('#err_status_posting').html("");
                $('#err_jml_hits').html("");
                $('#err_userinput').html("");
                $('#csrf').val(data["csrf"]),
                $('#modal_form').modal('show'); 
                $('.modal-title').text('Edit Data Posting'); 
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
            url : base_url + "admin/posting/delete/" +id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                var start=$('#start').val();
                getPosting(start);
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

function insertThumb(){
    var thumb=$('#thumb_gambar').val();
    var file=$('#namafile').val();
    $('#lampiran_gambar').val(file);
    $('#priv-img').html(thumb);
    $('#userfile').val("");
    $('#filecontrol').hide();
    $('#modal_view').modal('hide'); 
}



function InsertPostOri(){
    /**
     * Get Summernote value
     */
    var isi= $('.note-editable').html();
    isi+=$('#original_gambar').val();
    $('.note-editable').html(isi);
    $('#modal_view').modal('hide'); 
}
function InsertPostThumb(){
    /**
     * Get Summernote value
     */
    var isi= $('.note-editable').html();
    isi+=$('#thumb_gambar').val();
    $('.note-editable').html(isi);
    $('#modal_view').modal('hide'); 
}

function setKomentar(id_group){
    if ($('#status_komentar'+id_group).is(':checked')) {
        var url=base_url+"admin/posting/komentar/"+id_group+"/1";
    }else{
        var url=base_url+"admin/posting/komentar/"+id_group+"/0";
    }
    console.log(url);
    $.ajax({
        url : url,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            getPosting(0);
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

function setStatus(id_group,status){
    var url=base_url+"admin/posting/status/"+id_group+"/"+status;
    console.log(url);
    $.ajax({
        url : url,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            getPosting(0);
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