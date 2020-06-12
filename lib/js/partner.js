
getpartner(0);
function getpartner(start){
    $('#start').val(start);
    var search = $('#q').val();
    var limit = $('#limit').val();
    var active="class='btn btn-primary btn-sm'";
    var url=base_url + "admin/partner/data?q=" + search + "&start=" +start+ "&limit=" +limit;
    $.ajax({
        url     : url,
        type    : "GET",
        dataType: "json",
        data    : {get_param : 'value'},
        success : function(data){
            //menghitung jumlah data
            console.clear();
            if(data["status"]==true){
                var partner    = data["data"];
                var jmlData=partner.length;
                var limit   = data["limit"]
                var tabel   = "";
                //Create Tabel
                for(var i=0; i<jmlData;i++){
                    start++;
                    tabel+="<tr>";
                    tabel+="<td>"+start+"</td>";
                    tabel+="<td><image src='"+base_url+"uploads/media/icon/"+partner[i]["partner_img"]+"'></td>";
                    tabel+="<td>"+partner[i]["partner_nama"]+"</td>";
                    tabel+="<td>"+partner[i]["partner_link"]+"</td>";
                    
                    //if(partner[i]["partner_status"]==1) tabel+="<td><span class='btn btn-success btn-xs'>Aktif</span></td>";
                    //else tabel+="<td><span class='btn btn-danger btn-xs'>Non Aktif</span></td>";
                    
                    if(partner[i]["partner_status"]==1){
                        tabel+='<td>';
                        tabel+='<label class="switch switch-small">';
                        tabel+="<input type='checkbox' id='partner_status"+partner[i]["partner_id"]+"' onclick='setStatus(\""+partner[i]["partner_id"]+"\")' checked>";
                        tabel+='<span></span>';
                        tabel+='</label>';
                        tabel+='</td>';
                    }else{
                        tabel+='<td>';
                        tabel+='<label class="switch switch-small">';
                        tabel+="<input type='checkbox' id='partner_status"+partner[i]["partner_id"]+"' onclick='setStatus(\""+partner[i]["partner_id"]+"\")' >";
                        tabel+='<span></span>';
                        tabel+='</label>';
                        tabel+='</td>';
                    }

                    tabel+='<td class=\'text-right\' style="width:200px;">';
                    tabel+='<div class="btn-group btn-group-sm">';
                    tabel+='<button type=\'button\' class=\'btn btn-success \' onclick=\'edit("' +partner[i]["partner_id"] +'")\'><span class=\'glyphicon glyphicon-pencil\' ></span> Edit</button>';
                    tabel+='<button type=\'button\' class=\'btn btn-danger \' onclick=\'hapus("' +partner[i]["partner_id"] +'")\'><span class=\'glyphicon glyphicon-remove\' ></span> Hapus</td>';
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
                    var btnFirst="<button class='btn btn-default btn-sm' onclick='getpartner(0)'><span class='fa fa-angle-double-left'></span></button>";
                    if(curIdx>1){
                        var prevSt=((curIdx-1)*data["limit"])-jmlData;
                        btnFirst+="<button class='btn btn-default btn-sm' onclick='getpartner("+prevSt+")'><span class='fa fa-angle-left'></span></button>";
                    }

                    var btnLast="";
                    if(curIdx<jmlPage){
                        var nextSt=((curIdx+1)*data["limit"])-jmlData;
                        btnLast+="<button class='btn btn-default btn-sm' onclick='getpartner("+nextSt+")'><span class='fa fa-angle-right'></span></button>";
                    }
                    btnLast+="<button class='btn btn-default btn-sm' onclick='getpartner("+lastSt+")'><span class='fa fa-angle-double-right'></span></button>";
                    
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
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getpartner("+ st +")'>" + j +"</button>";
                        }
                    }else{
                        for (var j = 1; j<=jmlPage; j++) {
                            st=(j*data["limit"])-jmlData;
                            if(curSt==st)  btn="btn-success"; else btn= "btn-default";
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getpartner("+ st +")'>" + j +"</button>";
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
    $('#partner_id').val("");
    $('#err_partner_id').html("");
    $('#err_partner_nama').html("");
    $('#err_partner_link').html("");
    $('#err_partner_img').html("");
    $('#err_partner_status').html("");
    $('.modal-title').text('Tambah Data partner'); 
}
function save(){
    var url;
    url = base_url + "admin/partner/save";
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
                    
                    if(data["err_partner_id"]!="") $('#err_partner_id').html(data["err_partner_id"]); else $('#err_partner_id').html("");
                    
                    if(data["err_partner_nama"]!="") $('#err_partner_nama').html(data["err_partner_nama"]); else $('#err_partner_nama').html("");
                    
                    if(data["err_partner_link"]!="") $('#err_partner_link').html(data["err_partner_link"]); else $('#err_partner_link').html("");
                    
                    if(data["err_partner_img"]!="") $('#err_partner_img').html(data["err_partner_img"]); else $('#err_partner_img').html("");
                    
                    if(data["err_partner_status"]!="") $('#err_partner_status').html(data["err_partner_status"]); else $('#err_partner_status').html("");
                
                }else{
                    $('#modal_form').modal('hide');
                    $('#csrf').val(data["csrf"]);
                    var start=$('#start').val();
                    getpartner(start);
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
    var url =base_url + "admin/partner/edit/" + id;
    //alert(url);
    save_method = 'update';
    $('#form')[0].reset(); 
    $.ajax({
        url : base_url + "admin/partner/edit/" + id,
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
                var partner = data["data"];
                
                $('#partner_id').val(partner.partner_id);
                $('#partner_nama').val(partner.partner_nama);
                $('#partner_link').val(partner.partner_link);
                if(partner.partner_status==1) $('#partner_status').prop( "checked", true );
                
                $('#err_partner_id').html("");
                $('#err_partner_nama').html("");
                $('#err_partner_link').html("");
                $('#csrf').val(data["csrf"]),
                $('#modal_form').modal('show'); 
                $('.modal-title').text('Edit Data partner'); 
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
            url : base_url + "admin/partner/delete/" +id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                var start=$('#start').val();
                getpartner(start);
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
    if ($('#partner_status'+id_group).is(':checked')) {
        var url=base_url+"admin/partner/status/"+id_group+"/1";
    }else{
        var url=base_url+"admin/partner/status/"+id_group+"/0";
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