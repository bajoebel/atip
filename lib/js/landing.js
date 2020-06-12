function showDetail(id_bidang){
    
    var show=$('#show'+id_bidang).val();
    if(show==0){
        $('.show').val("0");
        $('.detail').hide();
        $('.expand').removeClass("icon-minus");
        $('.expand').addClass("icon-plus");
        $('#show'+id_bidang).val("1");
        $('#detail'+id_bidang).show();
        $('#expand'+id_bidang).removeClass("icon-plus");
        $('#expand'+id_bidang).addClass("icon-minus");
        //getIzinperbidang(id_bidang);
    }else{
        $('#show'+id_bidang).val("0");
        $('#detail'+id_bidang).hide();
        $('#expand'+id_bidang).removeClass("icon-minus");
        $('#expand'+id_bidang).addClass("icon-plus");
        $('#expand'+id_bidang).removeClass("icon-minus");
        $('#expand'+id_bidang).addClass("icon-plus");
    }
    
}
function showDetailfaq(id_bidang){
    
    var show=$('#showfaq'+id_bidang).val();
    if(show==0){
        $('.showfaq').val("0");
        $('.detailfaq').hide();
        $('.expandfaq').removeClass("icon-minus");
        $('.expandfaq').addClass("icon-plus");
        $('#showfaq'+id_bidang).val("1");
        $('#detailfaq'+id_bidang).show();
        $('#expandfaq'+id_bidang).removeClass("icon-plus");
        $('#expandfaq'+id_bidang).addClass("icon-minus");
        //getIzinperbidang(id_bidang);
    }else{
        $('#showfaq'+id_bidang).val("0");
        $('#detailfaq'+id_bidang).hide();
        $('#expandfaq'+id_bidang).removeClass("icon-minus");
        $('#expandfaq'+id_bidang).addClass("icon-plus");
        $('#expandfaq'+id_bidang).removeClass("icon-minus");
        $('#expandfaq'+id_bidang).addClass("icon-plus");
    }
    
}

function getIzinperbidang(id_bidang){
    var url=base_url+"landing/izin_bidang/"+id_bidang;
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
                var izin    = data["data"];
                var jmlData=izin.length;
                var limit   = data["limit"]
                var tabel   = "";
                //Create Tabel
                var start=0;
                if(jmlData<=0){
                    tabel="<tr><td></td><td>Data Belum Ada</td></tr>"
                }else{
                    for(var i=0; i<jmlData;i++){
                        start++;
                        tabel+="<tr>";
                        tabel+="<td></td>";
                        tabel+="<td><a href='"+base_url+"pelayanan/"+izin[i]["id_izin"]+"'>"+izin[i]["nama_perizinan"]+"</a></td>";
                        tabel+="</tr>";
                    }
                }
                
                $('#detail'+id_bidang).html(tabel);
                
            }
        }
    });
}

function getIzin(start){

    $('#start').val(start);
    if($('input:radio[name=rumpun]').is(':checked')){
        var rumpun = $('input[name=rumpun]:checked').val();
    }else{
        var rumpun = "";
    }

    if($('input:radio[name=tipe]').is(':checked')){
        var tipe = $('input[name=tipe]:checked').val();
    }else{
        var tipe = "";
    }
    
    var bdg=$('#bidang').val();
    var search = $('#q').val();
    var active="class='btn btn-primary btn-sm'";
    var url=base_url + "landing/izin?q=" + search + "&start=" +start + "&rumpun=" + rumpun+"&tipe="+tipe+"&bidang="+bdg;
    //alert(url);
    var pjg = search.length;

    $.ajax({
        url     : url,
        type    : "GET",
        dataType: "json",
        data    : {get_param : 'value'},
        success : function(data){
            //menghitung jumlah data
            console.clear();
            //alert(data["message"]);
            if(data["status"]==true){
                var izin    = data["data"];
                var jmlData=izin.length;
                var limit   = data["limit"]
                var tabel   = "";
                //Create Tabel
                var bidang="";
                for(var i=0; i<jmlData;i++){
                    start++;
                    if(bidang==""){
                        tabel+='<thead>';
                        tabel+='<tr style="background-color: #fcfcfc">';
                        tabel+='<th style="width: 10px;">';
                        if(pjg>3||bdg!=""){
                            tabel+='<a href="#" onclick="showDetail(\''+izin[i]["id_bidang"]+'\')"><span class="icon icon-minus expand" id="expand'+izin[i]["id_bidang"]+'"></span></a>';
                            tabel+='<input type="hidden" name="show" id="show'+izin[i]["id_bidang"]+'" class="show" value="1">';
                        }else{
                            tabel+='<a href="#" onclick="showDetail(\''+izin[i]["id_bidang"]+'\')"><span class="icon icon-plus expand" id="expand'+izin[i]["id_bidang"]+'"></span></a>';
                            tabel+='<input type="hidden" name="show" id="show'+izin[i]["id_bidang"]+'" class="show" value="0">';
                        }                        
                        tabel+='</th>'
                        tabel+='<th>'+izin[i]["nama_bidang"]+'</th>';
                        tabel+='</tr>';
                        tabel+='</thead>';
                        // /alert("panjang "+ pjg + " Bidang "+ bidang);
                        if(pjg>3||bdg!=""){
                            tabel+='<tbody class="detail" id="detail'+izin[i]["id_bidang"]+'">';
                        }else{
                            tabel+='<tbody style="display: none;" class="detail" id="detail'+izin[i]["id_bidang"]+'">';
                        }
                        tabel+='<tr>';
                        tabel+='<td></td>';
                        tabel+='<td><a href="'+base_url+"layanan/"+izin[i]["id_izin"]+'">'+izin[i]["nama_perizinan"]+'</a></td>';
                        tabel+='</tr>';
                        
                    }else{
                        if(bidang==izin[i]["id_bidang"]){
                            tabel+='<tr>';
                            tabel+='<td></td>';
                            tabel+='<td><a href="'+base_url+"layanan/"+izin[i]["id_izin"]+'">'+izin[i]["nama_perizinan"]+'</a></td>';
                            tabel+='</tr>';
                            //alert(tabel);
                        }else{
                            tabel+='</tbody>';
                            tabel+='<thead>';
                            tabel+='<tr style="background-color: #fcfcfc">';
                            tabel+='<th style="width: 10px;">';
                            if(pjg>3||bdg!=""){
                                tabel+='<a href="#" onclick="showDetail(\''+izin[i]["id_bidang"]+'\')"><span class="icon icon-minus expand" id="expand'+izin[i]["id_bidang"]+'"></span></a>';
                                tabel+='<input type="hidden" name="show" id="show'+izin[i]["id_bidang"]+'" class="show" value="1">';
                            }else{
                                tabel+='<a href="#" onclick="showDetail(\''+izin[i]["id_bidang"]+'\')"><span class="icon icon-plus expand" id="expand'+izin[i]["id_bidang"]+'"></span></a>';
                                tabel+='<input type="hidden" name="show" id="show'+izin[i]["id_bidang"]+'" class="show" value="0">';
                            }  
                            tabel+='</th>'
                            tabel+='<th>'+izin[i]["nama_bidang"]+'</th>';
                            tabel+='</tr>';
                            tabel+='</thead>';
                            if(pjg>3||bdg!=""){
                                tabel+='<tbody class="detail" id="detail'+izin[i]["id_bidang"]+'">';
                            }else{
                                tabel+='<tbody style="display: none;" class="detail" id="detail'+izin[i]["id_bidang"]+'">';
                            }
                            tabel+='<tr>';
                            tabel+='<td></td>';
                            tabel+='<td><a href="'+base_url+"layanan/"+izin[i]["id_izin"]+'">'+izin[i]["nama_perizinan"]+'</a></td>';
                            tabel+='</tr>';
                        }
                    }
                    //tabel+="</tbody>";
                    bidang=izin[i]["id_bidang"];
                        
                }
                //alert(tabel);
                $('#data-layanan').html(tabel);
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
                    $('#csrf').val(data["csrf"]);
                    if(data["err_id_tipe"]!="") $('#err_id_tipe').html(data["err_id_tipe"]); else $('#err_id_tipe').html("");
                    if(data["err_id_rumpun"]!="") $('#err_id_rumpun').html(data["err_id_rumpun"]); else $('#err_id_rumpun').html("");
                    if(data["err_id_bidang"]!="") $('#err_id_bidang').html(data["err_id_bidang"]); else $('#err_id_bidang').html("");
                    if(data["err_waktu_penyelesaian"]!="") $('#err_waktu_penyelesaian').html(data["err_waktu_penyelesaian"]); else $('#err_waktu_penyelesaian').html("");
                    if(data["err_biaya"]!="") $('#err_biaya').html(data["err_biaya"]); else $('#err_biaya').html("");
                    if(data["err_nama_perizinan"]!="") $('#err_nama_perizinan').html(data["err_nama_perizinan"]); else $('#err_nama_perizinan').html("");
                    if(data["err_definisi"]!="") $('#err_definisi').html(data["err_definisi"]); else $('#err_definisi').html("");
                    if(data["err_status_perizinan"]!="") $('#err_status_perizinan').html(data["err_status_perizinan"]); else $('#err_status_perizinan').html("");
                }else{
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

function postKomen(){
    var url;
    url = base_url + "landing/insert_komentar";
    var formData = new FormData($('#commentform')[0]);
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
                    $('#csrf').val(data["csrf"]);
                    if(data["err_email"]!="") $('#err_email').html(data["err_email"]); else $('#err_email').html("");
                    if(data["err_nama"]!="") $('#err_nama').html(data["err_nama"]); else $('#err_nama').html("");
                    if(data["err_website"]!="") $('#err_website').html(data["err_website"]); else $('#err_website').html("");
                    if(data["err_komentar"]!="") $('#err_komentar').html(data["err_komentar"]); else $('#err_komentar').html("");
                }else{
                    var id_post=$('#id_post').val();
                    //alert(id_post)
                    $('#nama').val("");
                    $('#email').val("");
                    $('#website').val("");
                    $('#isi-komentar').val("");
                    getKomen(id_post);
                }
            }
            else{
                alert(data["message"]);
            }
            
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert(url);
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
                $('#csrf').val(data["csrf"]),
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
            console.clear();
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
            if(data["status"]==true){
                if(data["error"]==true){
                    $('#csrf').val(data["csrf"]);
                    
                if(data["err_id_syarat"]!="") $('#err_id_syarat').html(data["err_id_syarat"]); else $('#err_id_syarat').html("");
                
                if(data["err_id_izin"]!="") $('#err_id_izin').html(data["err_id_izin"]); else $('#err_id_izin').html("");
                
                if(data["err_nama_persyaratan"]!="") $('#err_nama_persyaratan').html(data["err_nama_persyaratan"]); else $('#err_nama_persyaratan').html("");
                
                if(data["err_lampiran"]!="") $('#err_lampiran').html(data["err_lampiran"]); else $('#err_lampiran').html("");
                
                }else{
                    $('#form_persyaratan').modal('hide');
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

function getKomen(id_post){
    var active="class='btn btn-primary btn-sm'";
    var url=base_url + "landing/getkomen/" + id_post;
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
                var komen    = data["data"];
                var jmlData=komen.length;
                var tabel   = "";
                //Create Tabel
                var no=0;
                var tgl="";
                var ar="";
                var arr="";
                var bulan="";
                for(var i=0; i<jmlData;i++){
                    no++;
                    tgl=komen[i]["tgl_komentar"];
                    //ar=tgl.split[" "];
                    console.log(komen[i]["tgl_komentar"]);
                    //console.log(ar);
                    arr=tgl.split("-");
                    if(arr[1]=="01") bulan="Januari";
                    else if(arr[1]=="02") bulan="Februari";
                    else if(arr[1]=="03") bulan="Maret";
                    else if(arr[1]=="04") bulan="April";
                    else if(arr[1]=="05") bulan="Mei";
                    else if(arr[1]=="06") bulan="Juni";
                    else if(arr[1]=="07") bulan="Juli";
                    else if(arr[1]=="08") bulan="Agustus";
                    else if(arr[1]=="09") bulan="September";
                    else if(arr[1]=="10") bulan="Oktober";
                    else if(arr[1]=="11") bulan="November";
                    else if(arr[1]=="12") bulan="Desember";

                    tabel+='<div class="media">';
                    tabel+='<a href="#" class="pull-left"><img src="'+base_url+'assets/img/avatar.png" alt="" class="img-circle"></a>';
                    tabel+='<div class="media-body">';
                    tabel+='<div class="media-content">';
                    tabel+='<h6><span>'+arr[2].substring(0, 2)+' '+bulan+' '+ arr[0]+'</span> '+komen[i]["nama"]+'</h6>';
                    tabel+='<p>';
                    tabel+=komen[i]["komentar"];
                    tabel+='</p>';
                    tabel+='</div>';
                    tabel+='</div>';
                    tabel+='</div>';
                }
                $('#komentar').html(tabel);
                
            }
        }
    });
}

function getKategori(start=0,link=""){
    var url=base_url+"landing/data_kategori/"+link+"?start="+start;
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
                var izin    = data["data"];
                var jmlData=izin.length;
                var limit   = data["limit"]
                var tabel   = "";
                var isi_posting="";
                var StrippedString;
                var link;
                var gambar;
                var tgl_publish;
                var t;
                //Create Tabel
                var start=0;
                var index=0;
                if(jmlData<=0){
                    tabel="";
                }else{
                    for(var i=0; i<jmlData;i++){
                        index=i+1;
                        isi_posting=izin[i]["isi_posting"];
                        var StrippedString = isi_posting.replace(/(<([^>]+)>)/ig,"");

                        if(izin[i]["lampiran_gambar"]!=null || izin[i]["lampiran_gambar"]!=""){
                            gambar=base_url+"images/blog/thumb/THUMB_"+izin[i]["lampiran_gambar"];
                        }else{
                            gambar = base_url+"images/blog/default.jpg";
                        }
                        tgl_publish=izin[i]['tgl_publish'];
                        t=tgl_publish.split("-");
                        link=base_url+t[2]+"/"+t[1]+"/"+t[0]+"/"+izin[i]["link_posting"];
                        start++;
                        tabel+='<li class="item-thumbs span4 design" data-id="id-'+i+'" data-type="design">';
                        tabel+='<div class="team-box thumbnail">';
                        tabel+='<img src="'+gambar+'" alt="">';
                        tabel+='<div class="caption">';
                        tabel+='<h5>'+izin[i]["judul_posting"]+' '+i+'</h5>';
                        tabel+='<p>'
                        tabel+=StrippedString.substr(0,200);
                        tabel+='</p>';
                        tabel+='<ul class="social-network">';
                        tabel+='<li><a href="'+link+'" title="" data-original-title="Selengkapnya"><i class="icon-circled icon-bgdark icon-link"> </i></a></li>';
                        tabel+='</ul>';
                        tabel+='</div>';
                        tabel+='</div>';
                        tabel+='</li>';
                        if(index==2|| index%2==0){
                            tabel+="<div class='row'><span>&nbsp;</span></div>";
                        }
                    }
                }
                
                $('#thumbs').html(tabel);
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
                    var btnFirst="<a href='#' class='btn btn-default btn-sm' onclick='getKategori(0)'><span class='fa fa-angle-double-left'></span> First</a>";
                    if(curIdx>1){
                        var prevSt=((curIdx-1)*data["limit"])-data["limit"];
                        btnFirst+="<a href='#' class='btn btn-default btn-sm' onclick='getKategori("+prevSt+")'><span class='fa fa-angle-left'></span> Prev</a>";
                    }

                    var btnLast="";
                    if(curIdx<jmlPage){
                        var nextSt=((curIdx+1)*data["limit"])-data["limit"];
                        btnLast+="<a href='#' class='btn btn-default btn-sm' onclick='getKategori("+nextSt+")'><span class='fa fa-angle-right'></span> Next</a>";
                    }
                    btnLast+="<a href='#' class='btn btn-default btn-sm' onclick='getKategori("+lastSt+")'><span class='fa fa-angle-double-right'></span> Last</a>";
                    
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
                            if(curIdx==j)  {
                                btnIdx+="<span class=\"current\">"+curIdx+"</span>";
                            }else {
                                btnIdx+="<a href='#'  class='inactive' onclick='getKategori("+ st +")'>" + j +"</a>";
                            }
                            //btnIdx+="<a href='#' class='" +btn +"' onclick='getBerita("+ st +")'>" + j +"</a>";
                        }
                    }else{
                        for (var j = 1; j<=jmlPage; j++) {
                            st=(j*data["limit"])-data["limit"];
                            //if (curIdx==j) {alert(curIdx +' ' +j);}
                            //alert(curIdx +' ' +j);
                            //console.clear();
                            console.log("J = " + j);
                            console.log("LIMIT = " + data["limit"]);
                            console.log("JUMLAH DATA = " + data["limit"]);
                            console.log("ST = J*LIMIT-JUMLAHDATA = " + st);
                            if(curIdx==j)  {
                                btnIdx+="<span class=\"current\">"+curIdx+"</span>";
                            }else {
                                btnIdx+="<a href='#'  class='inactive' onclick='getKategori("+ st +")'>" + j +"</a>";
                            }
                            
                            //console.log(btnIdx);

                        }
                    }
                    
                    pagination+='<span class="all">Page '+curIdx+' of '+jmlPage+'</span>'+btnFirst + btnIdx + btnLast;
                    $('#pagination').html(pagination);
                }
            }
        }
    });
}
function getBerita(start=0){
    var url=base_url+"landing/data_kategori?start="+start;
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
                var izin    = data["data"];
                var jmlData=izin.length;
                var limit   = data["limit"]
                var tabel   = "";
                var isi_posting="";
                var StrippedString;
                var link;
                var gambar;
                var tgl_publish;
                var t;
                //Create Tabel
                var start=0;
                var index=0;
                if(jmlData<=0){
                    tabel="";
                }else{
                    for(var i=0; i<jmlData;i++){
                        index=i+1;
                        isi_posting=izin[i]["isi_posting"];
                        var StrippedString = isi_posting.replace(/(<([^>]+)>)/ig,"");

                        if(izin[i]["lampiran_gambar"]!=null || izin[i]["lampiran_gambar"]!=""){
                            gambar=base_url+"images/blog/thumb/THUMB_"+izin[i]["lampiran_gambar"];
                        }else{
                            gambar = base_url+"images/blog/default.jpg";
                        }
                        tgl_publish=izin[i]['tgl_publish'];
                        t=tgl_publish.split("-");
                        link=base_url+t[2]+"/"+t[1]+"/"+t[0]+"/"+izin[i]["link_posting"];
                        start++;
                        
                        tabel+='<article>';
                          tabel+='<div class="row">';

                            tabel+='<div class="span8">';
                              tabel+='<div class="post-image">';
                                tabel+='<div class="post-heading">';
                                  tabel+='<h3><a href="'+link+'">'+izin[i]["judul_posting"]+'</a></h3>';
                                tabel+='</div>';

                                tabel+='<img src="'+gambar+'" alt="'+izin[i]["judul_posting"]+'" class="img img-responsive" style="float:left; padding-right:20px;max-width:200px;">';
                              tabel+='</div>';
                              tabel+='<div class="meta-post">';
                                tabel+='<ul>';
                                  tabel+='<li><i class="icon-file"></i></li>';
                                  tabel+='<li>By <a href="#" class="author">'+izin[i]["userinput"]+'</a></li>';
                                  tabel+='<li>On <a href="#" class="date">'+izin[i]["tgl_posting"]+'</a></li>';
                                tabel+='</ul>';
                              tabel+='</div>';
                              tabel+='<div class="post-entry">';
                                tabel+='<p>';
                                  tabel+=StrippedString.substr(0,200);
                                tabel+='</p>';
                                tabel+='<a href="'+link+'" class="readmore">Read more <i class="icon-angle-right"></i></a>';
                              tabel+='</div>';
                            tabel+='</div>';
                          tabel+='</div>';
                        tabel+='</article>';
                        /*if(index==2|| index%2==0){
                            tabel+="<div class='row'><span>&nbsp;</span></div>";
                        }*/
                    }
                }
                
                $('#thumbs').html(tabel);
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
                    var btnFirst="<a href='#' class='btn btn-default btn-sm' onclick='getBerita(0)'><span class='fa fa-angle-double-left'></span> First</a>";
                    if(curIdx>1){
                        var prevSt=((curIdx-1)*data["limit"])-data["limit"];
                        btnFirst+="<a href='#' class='btn btn-default btn-sm' onclick='getBerita("+prevSt+")'><span class='fa fa-angle-left'></span> Prev</a>";
                    }

                    var btnLast="";
                    if(curIdx<jmlPage){
                        var nextSt=((curIdx+1)*data["limit"])-data["limit"];
                        btnLast+="<a href='#' class='btn btn-default btn-sm' onclick='getBerita("+nextSt+")'><span class='fa fa-angle-right'></span> Next</a>";
                    }
                    btnLast+="<a href='#' class='btn btn-default btn-sm' onclick='getBerita("+lastSt+")'><span class='fa fa-angle-double-right'></span> Last</a>";
                    
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
                            if(curIdx==j)  {
                                btnIdx+="<span class=\"current\">"+curIdx+"</span>";
                            }else {
                                btnIdx+="<a href='#'  class='inactive' onclick='getBerita("+ st +")'>" + j +"</a>";
                            }
                            //btnIdx+="<a href='#' class='" +btn +"' onclick='getBerita("+ st +")'>" + j +"</a>";
                        }
                    }else{
                        for (var j = 1; j<=jmlPage; j++) {
                            st=(j*data["limit"])-data["limit"];
                            //if (curIdx==j) {alert(curIdx +' ' +j);}
                            //alert(curIdx +' ' +j);
                            //console.clear();
                            console.log("J = " + j);
                            console.log("LIMIT = " + data["limit"]);
                            console.log("JUMLAH DATA = " + data["limit"]);
                            console.log("ST = J*LIMIT-JUMLAHDATA = " + st);
                            if(curIdx==j)  {
                                btnIdx+="<span class=\"current\">"+curIdx+"</span>";
                            }else {
                                btnIdx+="<a href='#'  class='inactive' onclick='getBerita("+ st +")'>" + j +"</a>";
                            }
                            
                            //console.log(btnIdx);

                        }
                    }
                    
                    pagination+='<span class="all">Page '+curIdx+' of '+jmlPage+'</span>'+btnFirst + btnIdx + btnLast;
                    $('#pagination').html(pagination);
                }
            }
        }
    });
}
function statistik(){
    var active="class='btn btn-primary btn-sm'";
    var url=base_url + "landing/statistik";
    //alert(url);
    $.ajax({
        url     : url,
        type    : "GET",
        dataType: "json",
        data    : {get_param : 'value'},
        success : function(data){
            //menghitung jumlah data
            //console.clear();
            //console.log(url);
            var semua       = data["semua"];
            var sekarang    = data["sekarang"];
            var online      = data["online"];
            var bulanini      = data["bulanini"];
            var stat = "<p>Unique Visitor <span style=\"float: right;\">"+semua["unique_visitor"]+"</span></p>";
            stat += "<p>Hits <span style=\"float: right;\">"+semua["hits_visitor"]+"</span></p>";
            stat += "<p>Today Visitor <span style=\"float: right;\">"+sekarang["unique_visitor"]+"</span></p>";
            stat += "<p>Today Hits <span style=\"float: right;\">"+sekarang["hits_visitor"]+"</span></p>";
            stat += "<p>"+data["bulan"]+" Visitor <span style=\"float: right;\">"+bulanini["unique_visitor"]+"</span></p>";
            stat += "<p>"+data['bulan']+" Hits <span style=\"float: right;\">"+bulanini["hits_visitor"]+"</span></p>";
            stat += "<p>Online Visitor <span style=\"float: right;\">"+online["unique_visitor"]+"</span></p>";
            $('#statistik').html(stat);
        }
    });
}

function listBerita(start){
    var url=base_url+"landing/list_berita?start="+start;
    //alert(url);
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
                var izin    = data["data"];
                var jmlData=izin.length;
                var limit   = data["limit"]
                var tabel   = "";
                var isi_posting="";
                var StrippedString;
                var link;
                var gambar;
                var tgl_publish;
                var t;
                //Create Tabel
                var start=0;
                if(jmlData<=0){
                    tabel="";
                }else{
                    for(var i=0; i<jmlData;i++){
                        isi_posting=izin[i]["isi_posting"];
                        var StrippedString = isi_posting.replace(/(<([^>]+)>)/ig,"");

                        if(izin[i]["lampiran_gambar"]!=null || izin[i]["lampiran_gambar"]!=""){
                            gambar=base_url+"images/blog/thumb/THUMB_"+izin[i]["lampiran_gambar"];
                        }else{
                            gambar = base_url+"images/blog/default.jpg";
                        }
                        tgl_publish=izin[i]['tgl_publish'];
                        t=tgl_publish.split("-");
                        link=base_url+t[2]+"/"+t[1]+"/"+t[0]+"/"+izin[i]["link_posting"];
                        start++;
                        tabel+='<li class="item-thumbs span4 design" data-id="id-'+i+'" data-type="design">';
                        tabel+='<div class="team-box thumbnail">';
                        tabel+='<img src="'+gambar+'" alt="">';
                        tabel+='<div class="caption">';
                        tabel+='<h5>'+izin[i]["judul_posting"]+'</h5>';
                        tabel+='<p>'
                        tabel+=StrippedString.substr(0,200);
                        tabel+='</p>';
                        tabel+='<ul class="social-network">';
                        tabel+='<li><a href="'+link+'" title="" data-original-title="Selengkapnya"><i class="icon-circled icon-bgdark icon-link"> </i></a></li>';
                        tabel+='</ul>';
                        tabel+='</div>';
                        tabel+='</div>';
                        tabel+='</li>';
                    }
                }
                
                $('#view_berita').html(tabel);
                
            }
        }
    });
}

function cek(){
    var q = $('#no_permintaan').val();

    var url=base_url+"landing/cek?q="+q;
    console.log(url);
    $.ajax({
        url     : url,
        type    : "GET",
        dataType: "json",
        data    : {get_param : 'value'},
        success : function(data){
            var tabel="";
            if(data["status"]==true){
                var res    = data["data"];
                var jmlData=res.length;
                var asal="";
                var tujuan = "";
                if(jmlData<=0){
                    tabel="";
                }else{
                    tabel+="<table class='table table-bordered'><thead>";
                    tabel+="<tr><td>NIK</td><td colspan='2'>" +res[0]["no_identitas"] +"</td></tr>";
                    tabel+="<tr><td>Nama Pemohon</td><td colspan='2'>" +res[0]["nama_pemohon"] +"</td></tr>";
                    tabel+="<tr><td>No HP</td><td colspan='2'>" +res[0]["no_hp"] +"</td></tr>";
                    tabel+="<tr><td>Alamat Pemohon</td><td colspan='2'>" +res[0]["alamat_pemohon"] +"</td></tr>";
                    tabel+="<tr><td>Layanan</td><td colspan='2'>" +res[0]["nama_perizinan"] +"</td></tr>";
                    tabel+="<tr style='background-color:#545454;color:#FFF'><td >Posisi</td><td>Proses</td><td>Status</td></tr></thead><tbody>";
                    var status;
                    for(var i=0; i<jmlData;i++){
                        status=res[i]["remark_status"];
                        if(res[i]["remark_status"]=="Dilanjutkan") status="OK"; 
                        tabel+="<tr><td>"+res[i]["asal"]+"</td><td>"+res[i]["nama_proses"]+"</td><td><b>"+status+"</b></td></tr>";
                        //console.log(tabel);
                        asal = res[i]["asal"];
                        tujuan = res[i]["tujuan"];
                    }

                    tabel+="<tr><td colspan='3'><b>Menunggu Proses Dari "+tujuan+"</b></td></tr>";
                    tabel+="</tbody></table>";
                }
                console.log(tabel);
                $('#result').html(tabel);
            }
        }
    });
}