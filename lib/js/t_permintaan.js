getT_permintaan(0);
function getT_permintaan(start){
    $('#start').val(start);
    var search = $('#q').val();
    var active="class='btn btn-primary btn-sm'";
    var url=base_url + "t_permintaan/data?q=" + search + "&start=" +start;
    $.ajax({
        url     : url,
        type    : "GET",
        dataType: "json",
        data    : {get_param : 'value'},
        success : function(data){
            //menghitung jumlah data
            console.clear();
            if(data["status"]==true){
                var t_permintaan    = data["data"];
                var jmlData=t_permintaan.length;
                var limit   = data["limit"]
                var tabel   = "";
                //Create Tabel
                for(var i=0; i<jmlData;i++){
                    start++;
                    tabel+="<tr>";
                    tabel+="<td>"+start+"</td>";
                    
            tabel+="<td>"+t_permintaan[i]["no_permintaan"]+"</td>";
            tabel+="<td>"+t_permintaan[i]["tgl_permintaan"]+"</td>";
            tabel+="<td>"+t_permintaan[i]["id_pemohon"]+"</td>";
            tabel+="<td>"+t_permintaan[i]["id_izin"]+"</td>";
            tabel+="<td>"+t_permintaan[i]["status_permintaan"]+"</td>";
            tabel+="<td>"+t_permintaan[i]["userinput"]+"</td>";
                    tabel+='<td class=\'text-right\'><button type=\'button\' class=\'btn btn-success btn-xs\' onclick=\'edit("' +t_permintaan[i]["id_permintaan"] +'")\'><span class=\'fa fa-pencil\' ></span></button>|';
                    tabel+='<button type=\'button\' class=\'btn btn-danger btn-xs\' onclick=\'hapus("' +t_permintaan[i]["id_permintaan"] +'")\'><span class=\'fa fa-remove\' ></span></td>';
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
                    var btnFirst="<button class='btn btn-default btn-sm' onclick='getT_permintaan(0)'><span class='fa fa-angle-double-left'></span></button>";
                    if(curIdx>1){
                        var prevSt=((curIdx-1)*data["limit"])-jmlData;
                        btnFirst+="<button class='btn btn-default btn-sm' onclick='getT_permintaan("+prevSt+")'><span class='fa fa-angle-left'></span></button>";
                    }

                    var btnLast="";
                    if(curIdx<jmlPage){
                        var nextSt=((curIdx+1)*data["limit"])-jmlData;
                        btnLast+="<button class='btn btn-default btn-sm' onclick='getT_permintaan("+nextSt+")'><span class='fa fa-angle-right'></span></button>";
                    }
                    btnLast+="<button class='btn btn-default btn-sm' onclick='getT_permintaan("+lastSt+")'><span class='fa fa-angle-double-right'></span></button>";
                    
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
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getT_permintaan("+ st +")'>" + j +"</button>";
                        }
                    }else{
                        for (var j = 1; j<=jmlPage; j++) {
                            st=(j*data["limit"])-jmlData;
                            if(curSt==st)  btn="btn-success"; else btn= "btn-default";
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getT_permintaan("+ st +")'>" + j +"</button>";
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
    
                $('#err_id_permintaan').html("");
                $('#err_no_permintaan').html("");
                $('#err_tgl_permintaan').html("");
                $('#err_id_pemohon').html("");
                $('#err_id_izin').html("");
                $('#err_status_permintaan').html("");
                $('#err_userinput').html("");
    $('.modal-title').text('Tambah Data T_permintaan'); 
}
function save(){
    var url;
    url = base_url + "t_permintaan/save";
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
                    
                if(data["err_id_permintaan"]!="") $('#err_id_permintaan').html(data["err_id_permintaan"]); else $('#err_id_permintaan').html("");
                
                if(data["err_no_permintaan"]!="") $('#err_no_permintaan').html(data["err_no_permintaan"]); else $('#err_no_permintaan').html("");
                
                if(data["err_tgl_permintaan"]!="") $('#err_tgl_permintaan').html(data["err_tgl_permintaan"]); else $('#err_tgl_permintaan').html("");
                
                if(data["err_id_pemohon"]!="") $('#err_id_pemohon').html(data["err_id_pemohon"]); else $('#err_id_pemohon').html("");
                
                if(data["err_id_izin"]!="") $('#err_id_izin').html(data["err_id_izin"]); else $('#err_id_izin').html("");
                
                if(data["err_status_permintaan"]!="") $('#err_status_permintaan').html(data["err_status_permintaan"]); else $('#err_status_permintaan').html("");
                
                if(data["err_userinput"]!="") $('#err_userinput').html(data["err_userinput"]); else $('#err_userinput').html("");
                
                }else{
                    $('#modal_form').modal('hide');
                    var start=$('#start').val();
                    $('#csrf').val(data["csrf"]);
                    getT_permintaan(start);
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
        url : base_url + "t_permintaan/edit/" + id,
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
                $('#csrf').val(data["csrf"]);
                //alert(data["message"]);
            }else{
                var t_permintaan = data["data"];
                
                $('#id_permintaan').val(t_permintaan.id_permintaan);
                $('#no_permintaan').val(t_permintaan.no_permintaan);
                $('#tgl_permintaan').val(t_permintaan.tgl_permintaan);
                $('#id_pemohon').val(t_permintaan.id_pemohon);
                $('#id_izin').val(t_permintaan.id_izin);
            if(t_permintaan.status_permintaan==1) $('#status_permintaan').prop( "checked", true );
                $('#userinput').val(t_permintaan.userinput);
                
                $('#err_id_permintaan').html("");
                $('#err_no_permintaan').html("");
                $('#err_tgl_permintaan').html("");
                $('#err_id_pemohon').html("");
                $('#err_id_izin').html("");
                $('#err_userinput').html("");
                $('#csrf').val(data["csrf"]),
                $('#modal_form').modal('show'); 
                $('.modal-title').text('Edit Data T_permintaan'); 
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
            url : base_url + "t_permintaan/delete/" +id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                var start=$('#start').val();
                getT_permintaan(start);
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