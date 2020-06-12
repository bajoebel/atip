getSlider(0);
function getSlider(start){
    $('#start').val(start);
    var search = $('#q').val();
    var limit = $('#limit').val();
    var active="class='btn btn-primary btn-sm'";
    var url=base_url + "admin/slider/data?q=" + search + "&start=" +start+ "&limit=" +limit;
    $.ajax({
        url     : url,
        type    : "GET",
        dataType: "json",
        data    : {get_param : 'value'},
        success : function(data){
            //menghitung jumlah data
            console.clear();
            if(data["status"]==true){
                var slider    = data["data"];
                var jmlData=slider.length;
                var limit   = data["limit"]
                var tabel   = "";
                //Create Tabel
                for(var i=0; i<jmlData;i++){
                    start++;
                    tabel+="<tr>";
                    tabel+="<td>"+start+"</td>";
                    
                    tabel+="<td><img src='"+base_url+"uploads/media/icon/"+slider[i]["gambar_slider"]+"'>"+"</td>";
                    tabel+="<td>"+slider[i]["keterangan_slider"]+"</td>";
                    tabel+="<td>"+slider[i]["judul_posting"]+"</td>";
                    
                    if(slider[i]["status_slider"]==1){
                        tabel+='<td style="width:100px;">';
                        tabel+='<label class="switch switch-small">';
                        tabel+="<input type='checkbox' id='status_slider"+slider[i]["id_slider"]+"' onclick='setStatus(\""+slider[i]["id_slider"]+"\")' checked>";
                        tabel+='<span></span>';
                        tabel+='</label>';
                        tabel+='</td>';
                    }else{
                        tabel+='<td style="width:100px;">';
                        tabel+='<label class="switch switch-small">';
                        tabel+="<input type='checkbox' id='status_slider"+slider[i]["id_slider"]+"' onclick='setStatus(\""+slider[i]["id_slider"]+"\")'>";
                        tabel+='<span></span>';
                        tabel+='</label>';
                        tabel+='</td>';
                    }

                    tabel+='<td class=\'text-right\' style="width:200px;">';
                    tabel+='<div class="btn-group btn-group-sm">';
                    tabel+='<button type=\'button\' class=\'btn btn-success \' onclick=\'edit("' +slider[i]["id_slider"] +'")\'><span class=\'glyphicon glyphicon-pencil\' ></span> Edit</button>';
                    tabel+='<button type=\'button\' class=\'btn btn-danger \' onclick=\'hapus("' +slider[i]["id_slider"] +'")\'><span class=\'glyphicon glyphicon-remove\' ></span> Hapus</td>';
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
                    var btnFirst="<button class='btn btn-default btn-sm' onclick='getSlider(0)'><span class='fa fa-angle-double-left'></span></button>";
                    if(curIdx>1){
                        var prevSt=((curIdx-1)*data["limit"])-jmlData;
                        btnFirst+="<button class='btn btn-default btn-sm' onclick='getSlider("+prevSt+")'><span class='fa fa-angle-left'></span></button>";
                    }

                    var btnLast="";
                    if(curIdx<jmlPage){
                        var nextSt=((curIdx+1)*data["limit"])-jmlData;
                        btnLast+="<button class='btn btn-default btn-sm' onclick='getSlider("+nextSt+")'><span class='fa fa-angle-right'></span></button>";
                    }
                    btnLast+="<button class='btn btn-default btn-sm' onclick='getSlider("+lastSt+")'><span class='fa fa-angle-double-right'></span></button>";
                    
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
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getSlider("+ st +")'>" + j +"</button>";
                        }
                    }else{
                        for (var j = 1; j<=jmlPage; j++) {
                            st=(j*data["limit"])-jmlData;
                            if(curSt==st)  btn="btn-success"; else btn= "btn-default";
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getSlider("+ st +")'>" + j +"</button>";
                        }
                    }
                    pagination+=btnFirst + btnIdx + btnLast;
                    $('#pagination').html(pagination);
                }
            }
        }
    });
}
function getPosting(start){
    $('#start-posting').val(start);
    var search = $('#q-posting').val();
    var active="class='btn btn-primary btn-sm'";
    var url=base_url + "admin/slider/dataposting?q=" + search + "&start=" +start;
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
                    tabel+='<tr onclick=\'setPosting("' +posting[i]["id_posting"] +'","'+posting[i]["judul_posting"]+'")\'>';
                    tabel+="<td>"+start+"</td>";
                    tabel+="<td>"+posting[i]["judul_posting"]+"</td>";
                    tabel+='<td class=\'text-right\'>';
                    tabel+='<button type=\'button\' class=\'btn btn-success btn-xs\' onclick=\'setPosting("' +posting[i]["id_posting"] +'","'+posting[i]["judul_posting"]+'")\'><span class=\'fa fa-check\' ></span></td>';
                    tabel+="</tr>";
                }
                $('#data-posting').html(tabel);
                //Create Pagination
                if(data["row_count"]<=limit){
                    $('#pagination-posting').html("");
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
                    var btnFirst="<button type=\'button\' class='btn btn-default btn-sm' onclick='getPosting(0)'><span class='fa fa-angle-double-left'></span></button>";
                    if(curIdx>1){
                        var prevSt=((curIdx-1)*data["limit"])-jmlData;
                        btnFirst+="<button type=\'button\' class='btn btn-default btn-sm' onclick='getPosting("+prevSt+")'><span class='fa fa-angle-left'></span></button>";
                    }

                    var btnLast="";
                    if(curIdx<jmlPage){
                        var nextSt=((curIdx+1)*data["limit"])-jmlData;
                        btnLast+="<button type=\'button\' class='btn btn-default btn-sm' onclick='getPosting("+nextSt+")'><span class='fa fa-angle-right'></span></button>";
                    }
                    btnLast+="<button type=\'button\' class='btn btn-default btn-sm' onclick='getPosting("+lastSt+")'><span class='fa fa-angle-double-right'></span></button>";
                    
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
                            btnIdx+="<button type=\'button\' class='btn " +btn +" btn-sm' onclick='getPosting("+ st +")'>" + j +"</button>";
                        }
                    }else{
                        for (var j = 1; j<=jmlPage; j++) {
                            st=(j*data["limit"])-jmlData;
                            if(curSt==st)  btn="btn-success"; else btn= "btn-default";
                            btnIdx+="<button type=\'button\' class='btn " +btn +" btn-sm' onclick='getPosting("+ st +")'>" + j +"</button>";
                        }
                    }
                    pagination+=btnFirst + btnIdx + btnLast;
                    $('#pagination-posting').html(pagination);
                }
            }
        }
    });
}
function setPosting(id_posting,judul_posting){
    $('#id_posting').val(id_posting);
    $('#judul_posting').val(judul_posting);
    $('#show').val("0");
    $('#cari-artikel').hide();
}
function cariArtikel(start){
    var show=$('#show').val();

    if(show==0){
        $('#show').val("1");
        $('#cari-artikel').show();
        getPosting(start);
    }else{
        $('#show').val("0");
        $('#cari-artikel').hide();
    }
    
}
function add(){
    save_method = 'add';
    $('#form')[0].reset(); 
    $('#modal_form').modal('show'); 
    $('#err_id_slider').html("");
    $('#err_gambar_slider').html("");
    $('#err_keterangan_slider').html("");
    $('#err_status_slider').html("");
    $('#id_posting').val("");
    $('#judul_posting').val("");
    $('.modal-title').text('Tambah Data Slider'); 
}
function save(){
    var url;
    url = base_url + "admin/slider/save";
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
                    
                if(data["err_id_slider"]!="") $('#err_id_slider').html(data["err_id_slider"]); else $('#err_id_slider').html("");
                
                if(data["err_gambar_slider"]!="") $('#err_gambar_slider').html(data["err_gambar_slider"]); else $('#err_gambar_slider').html("");
                
                if(data["err_keterangan_slider"]!="") $('#err_keterangan_slider').html(data["err_keterangan_slider"]); else $('#err_keterangan_slider').html("");
                
                if(data["err_status_slider"]!="") $('#err_status_slider').html(data["err_status_slider"]); else $('#err_status_slider').html("");
                
                }else{
                    $('#csrf').val(data["csrf"]);
                    $('#modal_form').modal('hide');
                    var start=$('#start').val();
                    
                    getSlider(start);
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
        url : base_url + "admin/slider/edit/" + id,
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
                var slider = data["data"];
                console.log(slider);
                $('#id_slider').val(slider.id_slider);
                //$('#gambar_slider').val(slider.gambar_slider);
                $('#keterangan_slider').val(slider.keterangan_slider);
                $('#id_posting').val(slider.id_posting);
                //alert(slider.judul_posting);
                $('#judul_posting').val(slider.judul_posting);
                if(slider.status_slider==1) $('#status_slider').prop( "checked", true );
                
                $('#err_id_slider').html("");
                $('#err_gambar_slider').html("");
                $('#err_keterangan_slider').html("");
                
                $('#csrf').val(data["csrf"]),
                $('#modal_form').modal('show'); 
                $('.modal-title').text('Edit Data Slider'); 
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
            url : base_url + "admin/slider/delete/" +id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                var start=$('#start').val();
                getSlider(start);
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

function setStatus(id_group){
    if ($('#status_slider'+id_group).is(':checked')) {
        var url=base_url+"admin/slider/status/"+id_group+"/1";
    }else{
        var url=base_url+"admin/slider/status/"+id_group+"/0";
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