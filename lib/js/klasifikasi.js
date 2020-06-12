
getKlasifikasi(0);
function getKlasifikasi(start){
    $('#start').val(start);
    var search = $('#q').val();
    var active="class='btn btn-primary btn-sm'";
    var url=base_url + "klasifikasi/data?q=" + search + "&start=" +start;
    $.ajax({
        url     : url,
        type    : "GET",
        dataType: "json",
        data    : {get_param : 'value'},
        success : function(data){
            //menghitung jumlah data
            console.clear();
            if(data["status"]==true){
                var klasifikasi    = data["data"];
                var jmlData=klasifikasi.length;
                var limit   = data["limit"]
                var tabel   = "";
                //Create Tabel
                for(var i=0; i<jmlData;i++){
                    start++;
                    tabel+="<tr>";
                    tabel+="<td>"+start+"</td>";
                    
                    tabel+="<td>"+klasifikasi[i]["nama_klasifikasi"]+"</td>";
                    if(klasifikasi[i]["status_klasifikasi"]==1){
                        tabel+="<td style='width:100px;'><button class='btn btn-success btn-xs'>Aktif</button></td>";
                    }else{
                        tabel+="<td style='width:100px;'><button class='btn btn-danger btn-xs'>Non Aktif</button></td>";
                    }
                    tabel+='<td class=\'text-right\'><button type=\'button\' class=\'btn btn-success btn-xs\' onclick=\'edit("' +klasifikasi[i]["id_klasifikasi"] +'")\'><span class=\'fa fa-pencil\' ></span></button>|';
                    tabel+='<button type=\'button\' class=\'btn btn-danger btn-xs\' onclick=\'hapus("' +klasifikasi[i]["id_klasifikasi"] +'")\'><span class=\'fa fa-remove\' ></span></td>';
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
                    var btnFirst="<button class='btn btn-default btn-sm' onclick='getKlasifikasi(0)'><span class='fa fa-angle-double-left'></span></button>";
                    if(curIdx>1){
                        var prevSt=((curIdx-1)*data["limit"])-jmlData;
                        btnFirst+="<button class='btn btn-default btn-sm' onclick='getKlasifikasi("+prevSt+")'><span class='fa fa-angle-left'></span></button>";
                    }

                    var btnLast="";
                    if(curIdx<jmlPage){
                        var nextSt=((curIdx+1)*data["limit"])-jmlData;
                        btnLast+="<button class='btn btn-default btn-sm' onclick='getKlasifikasi("+nextSt+")'><span class='fa fa-angle-right'></span></button>";
                    }
                    btnLast+="<button class='btn btn-default btn-sm' onclick='getKlasifikasi("+lastSt+")'><span class='fa fa-angle-double-right'></span></button>";
                    
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
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getKlasifikasi("+ st +")'>" + j +"</button>";
                        }
                    }else{
                        for (var j = 1; j<=jmlPage; j++) {
                            st=(j*data["limit"])-jmlData;
                            if(curSt==st)  btn="btn-success"; else btn= "btn-default";
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getKlasifikasi("+ st +")'>" + j +"</button>";
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
    
                $('#err_id_klasifikasi').html("");
                $('#err_nama_klasifikasi').html("");
                $('#err_status_klasifikasi').html("");
    $('.modal-title').text('Tambah Data Klasifikasi'); 
}
function save(){
    var url;
    url = base_url + "klasifikasi/save";
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
                    
                if(data["err_id_klasifikasi"]!="") $('#err_id_klasifikasi').html(data["err_id_klasifikasi"]); else $('#err_id_klasifikasi').html("");
                
                if(data["err_nama_klasifikasi"]!="") $('#err_nama_klasifikasi').html(data["err_nama_klasifikasi"]); else $('#err_nama_klasifikasi').html("");
                
                if(data["err_status_klasifikasi"]!="") $('#err_status_klasifikasi').html(data["err_status_klasifikasi"]); else $('#err_status_klasifikasi').html("");
                
                }else{
                    $('#csrf').val(data["csrf"]);
                    $('#modal_form').modal('hide');
                    var start=$('#start').val();
                    
                    getKlasifikasi(start);
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
        url : base_url + "klasifikasi/edit/" + id,
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
                var klasifikasi = data["data"];
                
                $('#id_klasifikasi').val(klasifikasi.id_klasifikasi);
                $('#nama_klasifikasi').val(klasifikasi.nama_klasifikasi);
            if(klasifikasi.status_klasifikasi==1) $('#status_klasifikasi').prop( "checked", true );
                
                $('#err_id_klasifikasi').html("");
                $('#err_nama_klasifikasi').html("");
                $('#csrf').val(data["csrf"]),
                $('#modal_form').modal('show'); 
                $('.modal-title').text('Edit Data Klasifikasi'); 
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
            url : base_url + "klasifikasi/delete/" +id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                var start=$('#start').val();
                getKlasifikasi(start);
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