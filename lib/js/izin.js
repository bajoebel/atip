getIzin(0);
function getIzin(start){
    $('#start').val(start);
    var search = $('#q').val();
    var active="class='btn btn-primary btn-sm'";
    var url=base_url + "izin/data?q=" + search + "&start=" +start;
    $.ajax({
        url     : url,
        type    : "GET",
        dataType: "json",
        data    : {get_param : 'value'},
        success : function(data){
            //menghitung jumlah data
            console.clear();
            if(data["status"]==true){
                var izin    = data["data"];
                var jmlData=izin.length;
                var limit   = data["limit"]
                var tabel   = "";
                //Create Tabel
                for(var i=0; i<jmlData;i++){
                    start++;
                    tabel+="<tr>";
                    tabel+="<td>"+start+"</td>";
                    tabel+="<td>"+izin[i]["tipe_pemohon"]+"</td>";
                    tabel+="<td>"+izin[i]["nama_rumpun"]+"</td>";
                    tabel+="<td>"+izin[i]["nama_bidang"]+"</td>";
                    tabel+="<td>"+izin[i]["nama_perizinan"]+"</td>";
                    tabel+="<td>"+izin[i]["definisi"]+"</td>";
                    if(izin[i]["status_perizinan"]==1){
                        tabel+="<td style='width:100px;'><button class='btn btn-success btn-xs'>Aktif</button></td>";
                    }else{
                        tabel+="<td style='width:100px;'><button class='btn btn-danger btn-xs'>Non Aktif</button></td>";
                    }
                    tabel+='<td class=\'text-right\'><a href="'+base_url+'izin/form/'+izin[i]['id_izin']+'" class=\'btn btn-success btn-xs\' ><span class=\'fa fa-search\' ></span></a>|';
                    tabel+='<button type=\'button\' class=\'btn btn-danger btn-xs\' onclick=\'hapus("' +izin[i]["id_izin"] +'")\'><span class=\'fa fa-remove\' ></span></td>';
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
                    var lastSt=(jmlPage*data["limit"])-jmlData;
                    var btnFirst="<button class='btn btn-default btn-sm' onclick='getIzin(0)'><span class='fa fa-angle-double-left'></span></button>";
                    if(curIdx>1){
                        var prevSt=((curIdx-1)*data["limit"])-jmlData;
                        btnFirst+="<button class='btn btn-default btn-sm' onclick='getIzin("+prevSt+")'><span class='fa fa-angle-left'></span></button>";
                    }

                    var btnLast="";
                    if(curIdx<jmlPage){
                        var nextSt=((curIdx+1)*data["limit"])-jmlData;
                        btnLast+="<button class='btn btn-default btn-sm' onclick='getIzin("+nextSt+")'><span class='fa fa-angle-right'></span></button>";
                    }
                    btnLast+="<button class='btn btn-default btn-sm' onclick='getIzin("+lastSt+")'><span class='fa fa-angle-double-right'></span></button>";
                    
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
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getIzin("+ st +")'>" + j +"</button>";
                        }
                    }else{
                        for (var j = 1; j<=jmlPage; j++) {
                            st=(j*data["limit"])-jmlData;
                            if(curSt==st)  btn="btn-success"; else btn= "btn-default";
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getIzin("+ st +")'>" + j +"</button>";
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
    $('#err_id_tipe').html("");
    $('#err_id_rumpun').html("");
    $('#err_id_bidang').html("");
    $('#err_waktu_penyelesaian').html("");
    $('#err_biaya').html("");
    $('#err_nama_perizinan').html("");
    $('#err_definisi').html("");
    $('#err_status_perizinan').html("");
    var csrf=$('#csrf_baru').val();
    $('#csrf_mekanisme').val(csrf);
    $('.modal-title').text('Tambah Data Izin'); 
}
function save(){
    var url;
    url = base_url + "izin/save";
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
                    $('#csrf_baru').val(data["csrf"]);
                    if(data["err_id_tipe"]!="") $('#err_id_tipe').html(data["err_id_tipe"]); else $('#err_id_tipe').html("");
                    if(data["err_id_rumpun"]!="") $('#err_id_rumpun').html(data["err_id_rumpun"]); else $('#err_id_rumpun').html("");
                    if(data["err_id_bidang"]!="") $('#err_id_bidang').html(data["err_id_bidang"]); else $('#err_id_bidang').html("");
                    if(data["err_waktu_penyelesaian"]!="") $('#err_waktu_penyelesaian').html(data["err_waktu_penyelesaian"]); else $('#err_waktu_penyelesaian').html("");
                    if(data["err_biaya"]!="") $('#err_biaya').html(data["err_biaya"]); else $('#err_biaya').html("");
                    if(data["err_nama_perizinan"]!="") $('#err_nama_perizinan').html(data["err_nama_perizinan"]); else $('#err_nama_perizinan').html("");
                    if(data["err_definisi"]!="") $('#err_definisi').html(data["err_definisi"]); else $('#err_definisi').html("");
                    if(data["err_status_perizinan"]!="") $('#err_status_perizinan').html(data["err_status_perizinan"]); else $('#err_status_perizinan').html("");
                }else{
                    $('#csrf_baru').val(data["csrf"]);
                    $('#modal_form').modal('hide');
                    var start=$('#start').val();
                    
                    getIzin(start);
                    swal({
                     title: "Sukses",
                     text: data["message"],
                     type: "success",
                     timer: 5000
                    });
                    window.location.href=base_url+"izin/form/"+data["id_izin"]
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
        url : base_url + "izin/edit/" + id,
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
                var izin = data["data"];
                $('#id_izin').val(izin.id_izin);
                $('#id_tipe').val(izin.id_tipe);
                $('#id_rumpun').val(izin.id_rumpun);
                $('#id_bidang').val(izin.id_bidang);
                $('#waktu_penyelesaian').val(izin.waktu_penyelesaian);
                $('#biaya').val(izin.biaya);
                $('#nama_perizinan').val(izin.nama_perizinan);
                $('#definisi').val(izin.definisi);
                if(izin.status_perizinan==1) $('#status_perizinan').prop( "checked", true );
                $('#err_id_izin').html("");
                $('#err_id_rumpun').html("");
                $('#err_id_bidang').html("");
                $('#err_id_tipe').html("");
                $('#err_waktu_penyelesaian').html("");
                $('#err_biaya').html("");
                $('#err_nama_perizinan').html("");
                $('#err_definisi').html("");
                $('#csrf_baru').val(data["csrf"]),
                $('#csrf_baru').val(data["csrf"]),
                $('#modal_form').modal('show'); 
                $('.modal-title').text('Edit Data Izin'); 
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
            url : base_url + "izin/delete/" +id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                var start=$('#start').val();
                getIzin(start);
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
function getSubklasifikasi(){
    id=$('#id_klasifikasi').val();
    var url=base_url + "izin/subklasifikasi/" + id;
    console.log(url);
    $.ajax({
        url : base_url + "izin/subklasifikasi/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('#id_subklasifikasi').html(data);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            swal({
             title: "Terjadi Kesalahan..!",
             text: "Gagal Saat Pengambilan data ",
             type: "error",
             timer: 5000
            });
        }
    })
}
function mekanisme(id_izin){
    var active="class='btn btn-primary btn-sm'";
    var url=base_url + "izin/mekanisme/"+id_izin;
    $.ajax({
        url     : url,
        type    : "GET",
        dataType: "json",
        data    : {get_param : 'value'},
        success : function(data){
            //menghitung jumlah data
            console.clear();
            if(data["status"]==true){
                var izin    = data["data"];
                var jmlData=izin.length;
                var limit   = data["limit"]
                var tabel   = "";
                //Create Tabel
                for(var i=0; i<jmlData;i++){
                    start++;
                    tabel+="<tr>";
                    tabel+="<td>"+start+"</td>";
                    tabel+="<td>"+izin[i]["mekanisme_pelayanan"]+"</td>";
                    tabel+='<td class=\'text-right\'><a href="'+base_url+'izin/form/'+izin[i]['id_izin']+'" class=\'btn btn-success btn-xs\' ><span class=\'fa fa-search\' ></span></a>|';
                    tabel+='<button type=\'button\' class=\'btn btn-danger btn-xs\' onclick=\'hapus("' +izin[i]["id_izin"] +'")\'><span class=\'fa fa-remove\' ></span></td>';
                    tabel+="</tr>";
                }
                $('#d_mekanisme').html(tabel);
                
            }
        }
    });
}
function persyaratan(id_izin){
    var active="class='btn btn-primary btn-sm'";
    var url=base_url + "izin/persyaratan/" + id_izin;
    $.ajax({
        url     : url,
        type    : "GET",
        dataType: "json",
        data    : {get_param : 'value'},
        success : function(data){
            //menghitung jumlah data
            console.clear();
            if(data["status"]==true){
                var izin    = data["data"];
                var jmlData=izin.length;
                var limit   = data["limit"]
                var tabel   = "";
                //Create Tabel
                for(var i=0; i<jmlData;i++){
                    start++;
                    tabel+="<tr>";
                    tabel+="<td>"+start+"</td>";
                    tabel+="<td>"+izin[i]["nama_persyaratan"]+"</td>";
                    tabel+="<td>"+izin[i]["lampiran"]+"</td>";
                    tabel+='<td class=\'text-right\'><a href="'+base_url+'izin/form/'+izin[i]['id_syarat']+'" class=\'btn btn-success btn-xs\' ><span class=\'fa fa-search\' ></span></a>|';
                    tabel+='<button type=\'button\' class=\'btn btn-danger btn-xs\' onclick=\'hapus("' +izin[i]["id_syarat"] +'")\'><span class=\'fa fa-remove\' ></span></td>';
                    tabel+="</tr>";
                }
                $('#d_persyaratan').html(tabel);
                
            }
        }
    });
}

function addMekanisme(){
    $('#f_mekanisme')[0].reset(); 
    $('#form_mekanisme').modal('show'); 
    var csrf=$('#csrf_baru').val();
    $('#csrf_mekanisme').val(csrf);
    $('.modal-title').text('Tambah Mekanisme Pelayanan'); 
}
function addPersyaratan(){
    $('#form_syarat')[0].reset(); 
    $('#form_persyaratan').modal('show'); 
    var csrf=$('#csrf_baru').val();
    $('#csrf_persyaratan').val(csrf);
    $('.modal-title').text('Tambah Persyaratan'); 
}
function addDasarhukum(){
    $('#f_dasarhukum')[0].reset(); 
    $('#form_dasarhukum').modal('show'); 
    var csrf=$('#csrf_baru').val();
    $('#csrf_dasarhukum').val(csrf);
    $('.modal-title').text('Tambah Dasar Hukum'); 
}

//Persyaratan
function getPersyaratan(start){
    var active="class='btn btn-primary btn-sm'";
    var url=base_url + "izin/persyaratan/" + start;
    //alert(url);
    $.ajax({
        url     : url,
        type    : "GET",
        dataType: "json",
        data    : {get_param : 'value'},
        success : function(data){
            //menghitung jumlah data
            //console.clear();
            if(data["status"]==true){
                var persyaratan    = data["data"];
                var jmlData=persyaratan.length;
                var tabel   = "";
                //Create Tabel
                var no=0;
                for(var i=0; i<jmlData;i++){
                    no++;
                    tabel+="<tr>";
                    tabel+="<td>"+no+"</td>";
                    tabel+="<td>"+persyaratan[i]["nama_persyaratan"]+"</td>";
                    tabel+="<td>"+persyaratan[i]["lampiran"]+"</td>";
                    tabel+='<td class=\'text-right\'><button type=\'button\' class=\'btn btn-success btn-xs\' onclick=\'editPersyaratan("' +persyaratan[i]["id_syarat"] +'")\'><span class=\'fa fa-pencil\' ></span></button>|';
                    tabel+='<button type=\'button\' class=\'btn btn-danger btn-xs\' onclick=\'hapusPersyaratan("' +persyaratan[i]["id_syarat"] +'","'+persyaratan[i]["id_izin"]+'")\'><span class=\'fa fa-remove\' ></span></td>';
                    tabel+="</tr>";
                }
                $('#d_persyaratan').html(tabel);
                
            }
        }
    });
}

function savePersyaratan(){
    var url;
    url = base_url + "izin/save_persyaratan";
    var formData = new FormData($('#form_syarat')[0]);
    $.ajax({
        url : url,
        type: "POST",
        data : formData,
        processData: false,
        contentType: false,
        dataType: 'JSON',
        success: function(data)
        {
            //alert(url);
            console.log(data);
            if(data["status"]==true){
                if(data["error"]==true){
                    $('#csrf_baru').val(data["csrf"]);
                    if(data["err_id_syarat"]!="") $('#err_id_syarat').html(data["err_id_syarat"]); else $('#err_id_syarat').html("");
                    if(data["err_id_izin"]!="") $('#err_id_izin').html(data["err_id_izin"]); else $('#err_id_izin').html("");
                    if(data["err_nama_persyaratan"]!="") $('#err_nama_persyaratan').html(data["err_nama_persyaratan"]); else $('#err_nama_persyaratan').html("");
                    if(data["err_lampiran"]!="") $('#err_lampiran').html(data["err_lampiran"]); else $('#err_lampiran').html("");
                
                }else{
                    $('#form_persyaratan').modal('hide');
                    $('.csrf').val(data["csrf"]);
                    var start=$('#id_izin_persyaratan').val();
                    //alert(start);
                    getPersyaratan(start);
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
function editPersyaratan(id)
{
    var url;
    save_method = 'update';
    //alert("edit");
    $('#form_syarat')[0].reset(); 

    $.ajax({
        url : base_url + "izin/edit_persyaratan/" + id,
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
                var persyaratan = data["data"];
                $('#id_syarat').val(persyaratan.id_syarat);
                $('#id_izin').val(persyaratan.id_izin);
                $('#nama_persyaratan').val(persyaratan.nama_persyaratan);
                $('#lampiran').val(persyaratan.lampiran);
                $('#err_id_syarat').html("");
                $('#err_id_izin').html("");
                $('#err_nama_persyaratan').html("");
                $('#err_lampiran').html("");
                $('#csrf_persyaratan').val(data["csrf"]),
                $('#csrf_baru').val(data["csrf"]),
                $('#form_persyaratan').modal('show'); 
                $('.modal-title').text('Edit Data Persyaratan'); 
                
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
function hapusPersyaratan(id,id_izin){
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
            url : base_url + "izin/delete_persyaratan/" +id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                //alert(base_url + "izin/delete_persyaratan/" +id);
                getPersyaratan(id_izin);
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

//Mekanisme
function getMekanisme(start){
    var active="class='btn btn-primary btn-sm'";
    var url=base_url + "izin/Mekanisme/" + start;
    //alert(url);
    $.ajax({
        url     : url,
        type    : "GET",
        dataType: "json",
        data    : {get_param : 'value'},
        success : function(data){
            //menghitung jumlah data
            console.clear();
            if(data["status"]==true){
                var Mekanisme    = data["data"];
                var jmlData=Mekanisme.length;
                var tabel   = "";
                //Create Tabel
                var no=0;
                for(var i=0; i<jmlData;i++){
                    no++;
                    tabel+="<tr>";
                    tabel+="<td>"+no+"</td>";
                    tabel+="<td>"+Mekanisme[i]["mekanisme_pelayanan"]+"</td>";
                    tabel+='<td class=\'text-right\'><button type=\'button\' class=\'btn btn-success btn-xs\' onclick=\'editMekanisme("' +Mekanisme[i]["id_mekanisme"] +'")\'><span class=\'fa fa-pencil\' ></span></button>|';
                    tabel+='<button type=\'button\' class=\'btn btn-danger btn-xs\' onclick=\'hapusMekanisme("' +Mekanisme[i]["id_mekanisme"] +'","'+Mekanisme[i]["id_izin"]+'")\'><span class=\'fa fa-remove\' ></span></td>';
                    tabel+="</tr>";
                }
                $('#d_mekanisme').html(tabel);
                
            }
        }
    });
}

function saveMekanisme(){
    var url;
    url = base_url + "izin/save_mekanisme";
    var formData = new FormData($('#f_mekanisme')[0]);
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
            if(data["status"]==true){
                if(data["error"]==true){
                    $('#csrf_baru').val(data["csrf"]);
                    $('#csrf_mekanisme').val(data["csrf"]);
                    if(data["err_id_mekanisme"]!="") $('#err_id_mekanisme').html(data["err_id_mekanisme"]); else $('#err_id_mekanisme').html("");
                    if(data["err_id_izin"]!="") $('#err_id_izin').html(data["err_id_izin"]); else $('#err_id_izin').html("");
                    if(data["err_mekanisme_pelayanan"]!="") $('#err_mekanisme_pelayanan').html(data["err_mekanisme_pelayanan"]); else $('#err_mekanisme_pelayanan').html("");
                }else{
                    $('#form_mekanisme').modal('hide');
                    $('.csrf').val(data["csrf"]);
                    var start=$('#id_izin_mekanisme').val();
                    //alert(start);
                    getMekanisme(start);
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
function editMekanisme(id)
{
    var url;
    save_method = 'update';
    //alert("edit");
    $('#form_syarat')[0].reset(); 

    $.ajax({
        url : base_url + "izin/edit_mekanisme/" + id,
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
                var Mekanisme = data["data"];
                $('#id_mekanisme').val(Mekanisme.id_mekanisme);
                $('#id_izin').val(Mekanisme.id_izin);
                $('#mekanisme_pelayanan').val(Mekanisme.mekanisme_pelayanan);
                $('#err_id_mekanisme').html("");
                $('#err_id_izin').html("");
                $('#err_mekanisme_pelayanan').html("");
                $('#csrf_baru').val(data["csrf"]),
                $('#csrf_mekanisme').val(data["csrf"]),
                
                $('#form_mekanisme').modal('show'); 
                $('.modal-title').text('Edit Data Mekanisme'); 
                
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
function hapusMekanisme(id,id_izin){
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
            url : base_url + "izin/delete_mekanisme/" +id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                //alert(base_url + "izin/delete_mekanisme/" +id);
                getMekanisme(id_izin);
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

//Dasarhukum
function getDasarhukum(start){
    var active="class='btn btn-primary btn-sm'";
    var url=base_url + "izin/dasarhukum/" + start;
    //alert(url);
    $.ajax({
        url     : url,
        type    : "GET",
        dataType: "json",
        data    : {get_param : 'value'},
        success : function(data){
            //menghitung jumlah data
            console.clear();
            if(data["status"]==true){
                var Dasarhukum    = data["data"];
                var jmlData=Dasarhukum.length;
                var tabel   = "";
                //Create Tabel
                var no=0;
                for(var i=0; i<jmlData;i++){
                    no++;
                    tabel+="<tr>";
                    tabel+="<td>"+no+"</td>";
                    tabel+="<td>"+Dasarhukum[i]["dasar_hukum"]+"</td>";
                    tabel+='<td class=\'text-right\'><button type=\'button\' class=\'btn btn-success btn-xs\' onclick=\'editDasarhukum("' +Dasarhukum[i]["id_dasar"] +'")\'><span class=\'fa fa-pencil\' ></span></button>|';
                    tabel+='<button type=\'button\' class=\'btn btn-danger btn-xs\' onclick=\'hapusDasarhukum("' +Dasarhukum[i]["id_dasar"] +'","'+Dasarhukum[i]["id_izin"]+'")\'><span class=\'fa fa-remove\' ></span></td>';
                    tabel+="</tr>";
                }
                $('#d_dasarhukum').html(tabel);
                
            }
        }
    });
}

function saveDasarhukum(){
    var url;
    url = base_url + "izin/save_dasarhukum";
    var formData = new FormData($('#f_dasarhukum')[0]);
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
            if(data["status"]==true){
                if(data["error"]==true){
                    $('#csrf_baru').val(data["csrf"]);
                    $('#csrf_dasarhukum').val(data["csrf"]);
                    if(data["err_id_dasar"]!="") $('#err_id_dasar').html(data["err_id_dasar"]); else $('#err_id_dasar').html("");
                    if(data["err_id_izin"]!="") $('#err_id_izin').html(data["err_id_izin"]); else $('#err_id_izin').html("");
                    if(data["err_dasar_hukum"]!="") $('#err_dasar_hukum').html(data["err_dasar_hukum"]); else $('#err_dasar_hukum').html("");
                }else{
                    $('#form_dasarhukum').modal('hide');
                    var start=$('#id_izin_dasarhukum').val();
                    //alert(start);
                    $('.csrf').val(data["csrf"]);
                    getDasarhukum(start);
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
function editDasarhukum(id)
{
    var url;
    save_method = 'update';
    //alert("edit");
    $('#f_dasarhukum')[0].reset(); 

    $.ajax({
        url : base_url + "izin/edit_dasarhukum/" + id,
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
                var Dasarhukum = data["data"];
                $('#id_dasar').val(Dasarhukum.id_dasar);
                $('#id_izin').val(Dasarhukum.id_izin);
                $('#dasar_hukum').val(Dasarhukum.dasar_hukum);
                $('#err_id_dasar').html("");
                $('#err_id_izin').html("");
                $('#err_dasar_hukum').html("");
                $('#csrf_baru').val(data["csrf"]),
                $('#csrf_dasarhukum').val(data["csrf"]),
                
                $('#form_dasarhukum').modal('show'); 
                $('.modal-title').text('Edit Data Dasarhukum'); 
                
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
function hapusDasarhukum(id,id_izin){
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
            url : base_url + "izin/delete_dasarhukum/" +id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                //alert(base_url + "izin/delete_dasarhukum/" +id);
                getDasarhukum(id_izin);
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

function pilihProduk(id_izin,id_produk,id){
    if ($('#produklayanan'+id).is(':checked')) {
        var nilai=1;
    }else{
        var nilai=0;
    }
    var url=base_url + "izin/pilih_produk/" +id_izin+"/"+id_produk+"/"+nilai;
    //alert(url);
    $.ajax({
        url : base_url + "izin/pilih_produk/" +id_izin+"/"+id_produk+"/"+nilai,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            if(data["status"]==true){
                swal({
                        title: "Sukses",
                        text: data["message"],
                        type: "success",
                        timer: 5000
                    });
            }else{
                swal({
                        title: "Error",
                        text: data["message"],
                        type: "error",
                        timer: 5000
                    });
            }
            
        },
        error: function (jqXHR, textStatus, errorThrown){
            swal({
                title: "Terjadi Kesalahan..!",
                text: "Gagal Memilih data",
                type: "error",
                timer: 5000
            });
        }
    });
}