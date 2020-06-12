function getPermintaan(start){
    $('#start').val(start);
    var search = $('#q').val();
    var active="class='btn btn-primary btn-sm'";
    var url=base_url + "permintaan/data?q=" + search + "&start=" +start;
    $.ajax({
        url     : url,
        type    : "GET",
        dataType: "json",
        data    : {get_param : 'value'},
        success : function(data){
            //menghitung jumlah data
            console.clear();
            if(data["status"]==true){
                var permintaan    = data["data"];
                var jmlData=permintaan.length;
                var limit   = data["limit"]
                var tabel   = "";
                //Create Tabel
                for(var i=0; i<jmlData;i++){
                    start++;
                    tabel+="<tr>";
                    tabel+="<td>"+start+"</td>";
                    tabel+="<td>"+permintaan[i]["no_permintaan"]+"</td>";
                    tabel+="<td>"+permintaan[i]["tgl_permintaan"]+"</td>";
                    tabel+="<td>"+permintaan[i]["nama_pemohon"]+"</td>";
                    tabel+="<td>"+permintaan[i]["nama_bidang"]+"</td>";
                    tabel+="<td>"+permintaan[i]["nama_perizinan"]+"</td>";
                    if(permintaan[i]["status_permintaan"]==1) tabel+="<td><span class='btn btn-success btn-xs'>Aktif</span></td>";
                    else tabel+="<td><span class='btn btn-danger btn-xs'>No Aktif</span></td>";
                    tabel+="<td>"+permintaan[i]["userinput"]+"</td>";
                    tabel+='<td class=\'text-right\'>';
                    tabel+='<button type=\'button\' class=\'btn btn-warning btn-xs\' onclick=\'detail("' +permintaan[i]["id_permintaan"] +'")\'><span class=\'fa fa-bars\' ></span></button>|';
                    //tabel+='<button type=\'button\' class=\'btn btn-success btn-xs\' onclick=\'edit("' +permintaan[i]["id_permintaan"] +'")\'><span class=\'fa fa-pencil\' ></span></button>|';
                    tabel+='<button type=\'button\' class=\'btn btn-danger btn-xs\' onclick=\'hapus("' +permintaan[i]["id_permintaan"] +'")\'><span class=\'fa fa-remove\' ></span></td>';
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
                    var btnFirst="<button class='btn btn-default btn-sm' onclick='getPermintaan(0)'><span class='fa fa-angle-double-left'></span></button>";
                    if(curIdx>1){
                        var prevSt=((curIdx-1)*data["limit"])-jmlData;
                        btnFirst+="<button class='btn btn-default btn-sm' onclick='getPermintaan("+prevSt+")'><span class='fa fa-angle-left'></span></button>";
                    }

                    var btnLast="";
                    if(curIdx<jmlPage){
                        var nextSt=((curIdx+1)*data["limit"])-jmlData;
                        btnLast+="<button class='btn btn-default btn-sm' onclick='getPermintaan("+nextSt+")'><span class='fa fa-angle-right'></span></button>";
                    }
                    btnLast+="<button class='btn btn-default btn-sm' onclick='getPermintaan("+lastSt+")'><span class='fa fa-angle-double-right'></span></button>";
                    
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
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getPermintaan("+ st +")'>" + j +"</button>";
                        }
                    }else{
                        for (var j = 1; j<=jmlPage; j++) {
                            st=(j*data["limit"])-jmlData;
                            if(curSt==st)  btn="btn-success"; else btn= "btn-default";
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getPermintaan("+ st +")'>" + j +"</button>";
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
    window.location.href=base_url + "permintaan/tambah";
    
}
function save(){
    var url;
    url = base_url + "permintaan/save";
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
                    if(data["err_jenis_identitas"]!="") $('#err_jenis_identitas').html(data["err_jenis_identitas"]); else $('#err_jenis_identitas').html("");
                    if(data["err_no_identitas"]!="") $('#err_no_identitas').html(data["err_no_identitas"]); else $('#err_no_identitas').html("");
                    if(data["err_nama_pemohon"]!="") $('#err_nama_pemohon').html(data["err_nama_pemohon"]); else $('#err_nama_pemohon').html("");
                    if(data["err_no_hp"]!="") $('#err_no_hp').html(data["err_no_hp"]); else $('#err_no_hp').html("");
                    if(data["err_alamat_pemohon"]!="") $('#err_alamat_pemohon').html(data["err_alamat_pemohon"]); else $('#err_alamat_pemohon').html("");
                    if(data["err_provinsi"]!="") $('#err_provinsi').html(data["err_provinsi"]); else $('#err_provinsi').html("");
                    if(data["err_kabupaten"]!="") $('#err_kabupaten').html(data["err_kabupaten"]); else $('#err_kabupaten').html("");
                    if(data["err_kecamatan"]!="") $('#err_kecamatan').html(data["err_kecamatan"]); else $('#err_kecamatan').html("");
                    if(data["err_kelurahan"]!="") $('#err_kelurahan').html(data["err_kelurahan"]); else $('#err_kelurahan').html("");
                    if(data["err_id_bidang"]!="") $('#err_id_bidang').html(data["err_id_bidang"]); else $('#err_id_bidang').html("");
                    if(data["err_id_izin"]!="") $('#err_id_izin').html(data["err_id_izin"]); else $('#err_id_izin').html("");
                    if(data["err_id_tujuan"]!="") $('#err_id_tujuan').html(data["err_id_tujuan"]); else $('#err_id_tujuan').html("");
                    if(data["err_catatan"]!="") $('#err_catatan').html(data["err_catatan"]); else $('#err_catatan').html("");
                }else{
                    window.location.href=base_url+"permintaan";
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
        url : base_url + "permintaan/edit/" + id,
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
                var permintaan = data["data"];
                
                $('#id_permintaan').val(permintaan.id_permintaan);
                $('#no_permintaan').val(permintaan.no_permintaan);
                $('#tgl_permintaan').val(permintaan.tgl_permintaan);
                $('#id_pemohon').val(permintaan.id_pemohon);
                $('#id_izin').val(permintaan.id_izin);
            if(permintaan.status_permintaan==1) $('#status_permintaan').prop( "checked", true );
                $('#userinput').val(permintaan.userinput);
                
                $('#err_id_permintaan').html("");
                $('#err_no_permintaan').html("");
                $('#err_tgl_permintaan').html("");
                $('#err_id_pemohon').html("");
                $('#err_id_izin').html("");
                $('#err_userinput').html("");
                $('#csrf').val(data["csrf"]),
                $('#modal_form').modal('show'); 
                $('.modal-title').text('Edit Data Permintaan'); 
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
            url : base_url + "permintaan/delete/" +id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                if(data["status"]==true){
                    var start=$('#start').val();
                    getPermintaan(start);
                }else{
                    swal({
                     title: "Peringatan..!",
                     text: data["message"],
                     type: "warning",
                     timer: 5000
                    });
                }
                    
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

function getIzin(){
    var bidang=$('#id_bidang').val();
    var url=base_url + "permintaan/dataizin/" + bidang ;
    console.log(url);
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
                var bidang    = data["data"];
                var jmlData=bidang.length;
                var tabel   = "<option value=''>Pilih Layanan</option>";
                //Create Tabel
                for(var i=0; i<jmlData;i++){
                    tabel+="<option value='"+bidang[i]["id_izin"]+"'>"+bidang[i]["nama_perizinan"]+"</option>";
                }
                $('#id_izin').html(tabel);
                
            }else{
                swal({
                 title: "Opps...",
                 text: data["message"],
                 type: "warning",
                 timer: 5000
                });
                var tabel   = "<option value=''>Pilih Layanan</option>";
                $('#id_izin').html(tabel);
            }
        }
    });
}

function getPersyaratan(){
    var izin=$('#id_izin').val();
    var url=base_url + "permintaan/datasyarat/" + izin ;
    console.log(url);
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
                var syarat    = data["data"];
                var jmlData=syarat.length;
                var tabel   = "";
                //Create Tabel
                for(var i=0; i<jmlData;i++){
                    tabel+="<input type='checkbox' name='persyaratan"+syarat[i]["id_syarat"]+"' id='persyaratan"+i+"' value='1' required> " + syarat[i]["nama_persyaratan"] +"<hr>";
                    tabel+="<input type='hidden' name='id_syarat[]' value='"+syarat[i]["id_syarat"]+"'>";
                }
                $('#syarat').html(tabel);
                
            }else{
                swal({
                 title: "Opps...",
                 text: data["message"],
                 type: "warning",
                 timer: 5000
                });
                
            }
        }
    });
}

function enter_noidentitas(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode;
    //console.log(charCode);
    if (charCode > 31 && (charCode < 48 || charCode > 57)){
        return false;
    }else{
        if(evt.keyCode==13){
            cariPemohon();
            
        }
    }
    return true;
}

function enter_nama(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode;
    //console.log(charCode);
    if (charCode > 31 && (charCode < 48 || charCode > 57)){
        return false;
    }else{
        if(evt.keyCode==13){
            $('#no_hp').focus();
            
        }
    }
    return true;
}

function enter_nohp(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode;
    //console.log(charCode);
    if (charCode > 31 && (charCode < 48 || charCode > 57)){
        return false;
    }else{
        if(evt.keyCode==13){
            $('#alamat_pemohon').focus();
            
        }
    }
    return true;
}

function enter_alamat(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode;
    //console.log(charCode);
    if (charCode > 31 && (charCode < 48 || charCode > 57)){
        return false;
    }else{
        if(evt.keyCode==13){
            $('#btn_cariwilayah').focus();
            
        }
    }
    return true;
}

function enter_bidang(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode;
    //console.log(charCode);
    if (charCode > 31 && (charCode < 48 || charCode > 57)){
        return false;
    }else{
        if(evt.keyCode==13){
            $('#id_izin').focus();
            
        }
    }
    return true;
}
function detail($id){
    var url = base_url+"permintaan/detail/"+$id;
    location.href=url;
}

function cariPemohon(){
    var no_identitas=$('#no_identitas').val();
    var url=base_url + "permintaan/caripemohon/" + no_identitas ;
    console.log(url);
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
                var pemohon = data["data"];
                //alert(pemohon["nama_pemohon"]);
                $('#id_pemohon').val(pemohon["id_pemohon"]);
                $('#nama_pemohon').val(pemohon["nama_pemohon"]);
                $('#no_hp').val(pemohon["no_hp"]);
                $('#alamat_pemohon').val(pemohon["alamat_pemohon"]);
                $('#provinsi').val(pemohon["provinsi"]);
                $('#kabupaten').val(pemohon["kabupaten"]);
                $('#kecamatan').val(pemohon["kecamatan"]);
                $('#kelurahan').val(pemohon["kelurahan"]);

                $('#nama_pemohon').prop('readonly', true);
                    $('#no_hp').prop('readonly', true);
                    $('#alamat_pemohon').prop('readonly', true);
                    $('#provinsi').prop('readonly', true);
                    $('#kabupaten').prop('readonly', true);
                    $('#kecamatan').prop('readonly', true);
                    $('#kelurahan').prop('readonly', true);
                    $('#id_bidang').focus();
            }else{

                if(data['error']==true){
                                swal({
                                 title: "Opps...",
                                 text: data["message"],
                                 type: "warning",
                                 timer: 5000
                                });
                }else{
                    $('#nama_pemohon').prop('readonly', false);
                    $('#no_hp').prop('readonly', false);
                    $('#alamat_pemohon').prop('readonly', false);
                    /*$('#provinsi').prop('readonly', false);
                    $('#kabupaten').prop('readonly', false);
                    $('#kecamatan').prop('readonly', false);
                    $('#kelurahan').prop('readonly', false);*/
                    $('#id_pemohon').val("");
                    $('#nama_pemohon').val("");
                    $('#no_hp').val("");
                    $('#alamat_pemohon').val("");
                    $('#provinsi').val("");
                    $('#kabupaten').val("");
                    $('#kecamatan').val("");
                    $('#kelurahan').val("");

                    $('#nama_pemohon').focus();
                }
                
            }
        }
    });
}

function cariWilayah(){
    var s=$("#show_wilayah").val();
    
    //alert(s);

    if(s=="1"){
        $('#wilayah').hide();
        $("#show_wilayah").val("0");
    }else{
        $('#wilayah').show();
        getWilayah(0);
        $("#show_wilayah").val("1");
    }
    //$('#wilayah').show();
}
function setWilayah(provinsi, kabkota, kecamatan, kelurahan){
    $('#provinsi').val(provinsi);
    $('#kabupaten').val(kabkota);
    $('#kecamatan').val(kecamatan);
    $('#kelurahan').val(kelurahan);
    $('#data-wilayah').html("");
    $('#wilayah').hide();
    $('#id_bidang').focus();
}

function getWilayah(start){
    var prov=$('#prov').val();
    var kab=$('#kab').val();
    var kec=$('#kec').val();
    var kel=$('#kel').val();
    var kwn=$('#kewarganegaraan').val();
    //alert(kwn);
    //alert(this);
    $('#wilayah').show();
        $('.groupKewarganegaraan').hide();
        $('.groupWNI').show();
        //+"&kec="kec+"&kel="+kel
        var url = base_url + "/permintaan/getWilayah?start="+start+"&prov="+prov+"&kab="+kab+"&kec="+kec+"&kel="+kel;
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
                    var wilayah    = data["data"];
                    var jmlData=wilayah.length;
                    var limit   = data["limit"]
                    var tabel   = "";
                    //Create Tabel
                    for(var i=0; i<jmlData;i++){
                        start++;
                        tabel+="<tr>";
                        tabel+="<td>"+wilayah[i]["provinsi"]+"</td>";
                        tabel+="<td>"+wilayah[i]["kabkota"]+" "+wilayah[i]["nama_kabkota"]+"</td>";
                        tabel+="<td>"+wilayah[i]["kecamatan"]+"</td>";
                        tabel+="<td>"+wilayah[i]["desa"]+"</td>";
                        tabel+='<td class=\'text-right\'>';
                        tabel+='<button type=\'button\' class=\'btn btn-success btn-xs\' id="pilih'+i+'" onclick=\'setWilayah("' +wilayah[i]["provinsi"] +'","' +wilayah[i]["kabkota"] +' ' +wilayah[i]["nama_kabkota"] +'","' +wilayah[i]["kecamatan"] +'","' +wilayah[i]["desa"] +'")\'><span class=\'fa fa-check\' ></span></button>';
                        tabel+='</td>';
                        tabel+="</tr>";
                    }
                    $('#data-wilayah').html(tabel);
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
                        var btnFirst="<button class='btn btn-default btn-sm' type='button' onclick='getWilayah(0)'><span class='fa fa-angle-double-left'></span></button>";
                        if(curIdx>1){
                            var prevSt=((curIdx-1)*data["limit"])-jmlData;
                            btnFirst+="<button class='btn btn-default btn-sm' type='button' onclick='getWilayah("+prevSt+")'><span class='fa fa-angle-left'></span></button>";
                        }

                        var btnLast="";
                        if(curIdx<jmlPage){
                            var nextSt=((curIdx+1)*data["limit"])-jmlData;
                            btnLast+="<button class='btn btn-default btn-sm' type='button' onclick='getWilayah("+nextSt+")'><span class='fa fa-angle-right'></span></button>";
                        }
                        btnLast+="<button class='btn btn-default btn-sm' type='button' onclick='getWilayah("+lastSt+")'><span class='fa fa-angle-double-right'></span></button>";
                        
                        if(jmlPage>=5){
                            if(curIdx>=2){
                                var idx_start=curIdx - 1;
                                var idx_end=idx_start+ 4;
                                if(idx_end>=jmlPage) idx_end=jmlPage;
                            }else{
                                var idx_start=1;
                                var idx_end=5;
                            }
                            for (var j = idx_start; j<=idx_end; j++) {
                                st=(j*data["limit"])-jmlData;
                                if(curSt==st)  btn="btn-success"; else btn= "btn-default";
                                btnIdx+="<button class='btn " +btn +" btn-sm' type='button' onclick='getWilayah("+ st +")'>" + j +"</button>";
                            }
                        }else{
                            for (var j = 1; j<=jmlPage; j++) {
                                st=(j*data["limit"])-jmlData;
                                if(curSt==st)  btn="btn-success"; else btn= "btn-default";
                                btnIdx+="<button class='btn " +btn +" btn-sm' type='button' onclick='getWilayah("+ st +")'>" + j +"</button>";
                            }
                        }
                        pagination+=btnFirst + btnIdx + btnLast;
                        $('#pagination').html("Showing 11 to 20 of 1234 " +pagination );
                    }
                }
            }
        });
}

function enter_prov(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if(evt.keyCode==13){
        console.log(evt.keyCode);
        $('#kab').focus();
    }
    return true;
}
function enter_kab(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if(evt.keyCode==13){
        console.log(evt.keyCode);
        $('#kec').focus();
    }
    return true;
}

function enter_kec(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if(evt.keyCode==13){
        console.log(evt.keyCode);
        $('#kel').focus();
    }
    return true;
}

function enter_kel(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if(evt.keyCode==13){
        console.log(evt.keyCode);
        $('#pilih0').focus();
    }
    return true;
}
