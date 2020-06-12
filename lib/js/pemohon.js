getPemohon(0);
function getPemohon(start){
    $('#start').val(start);
    var search = $('#q').val();
    var active="class='btn btn-primary btn-sm'";
    var url=base_url + "pemohon/data?q=" + search + "&start=" +start;
    $.ajax({
        url     : url,
        type    : "GET",
        dataType: "json",
        data    : {get_param : 'value'},
        success : function(data){
            //menghitung jumlah data
            console.clear();
            if(data["status"]==true){
                var pemohon    = data["data"];
                var jmlData=pemohon.length;
                var limit   = data["limit"]
                var tabel   = "";
                //Create Tabel
                for(var i=0; i<jmlData;i++){
                    start++;
                    tabel+="<tr>";
                    tabel+="<td>"+start+"</td>";
                    
            tabel+="<td>"+pemohon[i]["jenis_identitas"]+"</td>";
            tabel+="<td>"+pemohon[i]["no_identitas"]+"</td>";
            tabel+="<td>"+pemohon[i]["nama_pemohon"]+"</td>";
            tabel+="<td>"+pemohon[i]["no_hp"]+"</td>";
            tabel+="<td>"+pemohon[i]["alamat_pemohon"]+"</td>";
            tabel+="<td>"+pemohon[i]["provinsi"]+"</td>";
            tabel+="<td>"+pemohon[i]["kabupaten"]+"</td>";
            tabel+="<td>"+pemohon[i]["kecamatan"]+"</td>";
            tabel+="<td>"+pemohon[i]["kelurahan"]+"</td>";
                    tabel+='<td class=\'text-right\'><button type=\'button\' class=\'btn btn-success btn-xs\' onclick=\'edit("' +pemohon[i]["id_pemohon"] +'")\'><span class=\'fa fa-pencil\' ></span></button>|';
                    tabel+='<button type=\'button\' class=\'btn btn-danger btn-xs\' onclick=\'hapus("' +pemohon[i]["id_pemohon"] +'")\'><span class=\'fa fa-remove\' ></span></td>';
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
                    var btnFirst="<button class='btn btn-default btn-sm' onclick='getPemohon(0)'><span class='fa fa-angle-double-left'></span></button>";
                    if(curIdx>1){
                        var prevSt=((curIdx-1)*data["limit"])-jmlData;
                        btnFirst+="<button class='btn btn-default btn-sm' onclick='getPemohon("+prevSt+")'><span class='fa fa-angle-left'></span></button>";
                    }

                    var btnLast="";
                    if(curIdx<jmlPage){
                        var nextSt=((curIdx+1)*data["limit"])-jmlData;
                        btnLast+="<button class='btn btn-default btn-sm' onclick='getPemohon("+nextSt+")'><span class='fa fa-angle-right'></span></button>";
                    }
                    btnLast+="<button class='btn btn-default btn-sm' onclick='getPemohon("+lastSt+")'><span class='fa fa-angle-double-right'></span></button>";
                    
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
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getPemohon("+ st +")'>" + j +"</button>";
                        }
                    }else{
                        for (var j = 1; j<=jmlPage; j++) {
                            st=(j*data["limit"])-jmlData;
                            if(curSt==st)  btn="btn-success"; else btn= "btn-default";
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getPemohon("+ st +")'>" + j +"</button>";
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
    
                $('#err_id_pemohon').html("");
                $('#err_jenis_identitas').html("");
                $('#err_no_identitas').html("");
                $('#err_nama_pemohon').html("");
                $('#err_no_hp').html("");
                $('#err_alamat_pemohon').html("");
                $('#err_provinsi').html("");
                $('#err_kabupaten').html("");
                $('#err_kecamatan').html("");
                $('#err_kelurahan').html("");
    $('.modal-title').text('Tambah Data Pemohon'); 
}
function save(){
    var url;
    url = base_url + "pemohon/save";
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
                    
                if(data["err_id_pemohon"]!="") $('#err_id_pemohon').html(data["err_id_pemohon"]); else $('#err_id_pemohon').html("");
                
                if(data["err_jenis_identitas"]!="") $('#err_jenis_identitas').html(data["err_jenis_identitas"]); else $('#err_jenis_identitas').html("");
                
                if(data["err_no_identitas"]!="") $('#err_no_identitas').html(data["err_no_identitas"]); else $('#err_no_identitas').html("");
                
                if(data["err_nama_pemohon"]!="") $('#err_nama_pemohon').html(data["err_nama_pemohon"]); else $('#err_nama_pemohon').html("");
                
                if(data["err_no_hp"]!="") $('#err_no_hp').html(data["err_no_hp"]); else $('#err_no_hp').html("");
                
                if(data["err_alamat_pemohon"]!="") $('#err_alamat_pemohon').html(data["err_alamat_pemohon"]); else $('#err_alamat_pemohon').html("");
                
                if(data["err_provinsi"]!="") $('#err_provinsi').html(data["err_provinsi"]); else $('#err_provinsi').html("");
                
                if(data["err_kabupaten"]!="") $('#err_kabupaten').html(data["err_kabupaten"]); else $('#err_kabupaten').html("");
                
                if(data["err_kecamatan"]!="") $('#err_kecamatan').html(data["err_kecamatan"]); else $('#err_kecamatan').html("");
                
                if(data["err_kelurahan"]!="") $('#err_kelurahan').html(data["err_kelurahan"]); else $('#err_kelurahan').html("");
                
                }else{
                    $('#modal_form').modal('hide');
                    var start=$('#start').val();
                    $('#csrf').val(data["csrf"]);
                    getPemohon(start);
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
        url : base_url + "pemohon/edit/" + id,
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
                var pemohon = data["data"];
                
                $('#id_pemohon').val(pemohon.id_pemohon);
                $('#jenis_identitas').val(pemohon.jenis_identitas);
                $('#no_identitas').val(pemohon.no_identitas);
                $('#nama_pemohon').val(pemohon.nama_pemohon);
                $('#no_hp').val(pemohon.no_hp);
                $('#alamat_pemohon').val(pemohon.alamat_pemohon);
                $('#provinsi').val(pemohon.provinsi);
                $('#kabupaten').val(pemohon.kabupaten);
                $('#kecamatan').val(pemohon.kecamatan);
                $('#kelurahan').val(pemohon.kelurahan);
                
                $('#err_id_pemohon').html("");
                $('#err_jenis_identitas').html("");
                $('#err_no_identitas').html("");
                $('#err_nama_pemohon').html("");
                $('#err_no_hp').html("");
                $('#err_alamat_pemohon').html("");
                $('#err_provinsi').html("");
                $('#err_kabupaten').html("");
                $('#err_kecamatan').html("");
                $('#err_kelurahan').html("");
                $('#csrf').val(data["csrf"]),
                $('#modal_form').modal('show'); 
                $('.modal-title').text('Edit Data Pemohon'); 
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
            url : base_url + "pemohon/delete/" +id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                var start=$('#start').val();
                getPemohon(start);
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