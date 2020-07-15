
function getform(start){
    $('#start').val(start);
    var search = $('#q').val();
    var limit = $('#limit').val();
    var active="class='btn btn-primary btn-sm'";
    var url=base_url + "form/data?q=" + search + "&start=" +start+ "&limit=" +limit;
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
                var form    = data["data"];
                var jmlData=form.length;
                var limit   = data["limit"]
                var tabel   = "";
                //Create Tabel
                for(var i=0; i<jmlData;i++){
                    start++;
                    tabel+="<tr>";
                    tabel+="<td>"+start+"</td>";
                    tabel+="<td>"+form[i]["form_title"]+"</td>";
                    tabel+="<td>"+base_link+'form/'+form[i]["form_link"]+"</td>";
                    tabel+='<td class=\'text-right\' style="width:250px;">';
                    tabel+='<div class="btn-group btn-group-sm">';
                    tabel += '<button type=\'button\' class=\'btn btn-warning \' onclick=\'lihat("' + form[i]["form_id"] + '")\'><span class=\'glyphicon glyphicon-search\' ></span> Lihat</button>';
                    tabel+='<button type=\'button\' class=\'btn btn-success \' onclick=\'edit("' +form[i]["form_id"] +'")\'><span class=\'glyphicon glyphicon-pencil\' ></span> Edit</button>';
                    tabel+='<button type=\'button\' class=\'btn btn-danger \' onclick=\'hapus("' +form[i]["form_id"] +'")\'><span class=\'glyphicon glyphicon-remove\' ></span> Hapus</td>';
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
                    var btnFirst="<button class='btn btn-default btn-sm' onclick='getform(0)'><span class='glyphicon glyphicon-angle-double-left'></span></button>";
                    if(curIdx>1){
                        var prevSt=((curIdx-1)*data["limit"])-jmlData;
                        btnFirst+="<button class='btn btn-default btn-sm' onclick='getform("+prevSt+")'><span class='glyphicon glyphicon-angle-left'></span></button>";
                    }

                    var btnLast="";
                    if(curIdx<jmlPage){
                        var nextSt=((curIdx+1)*data["limit"])-data["limit"];
                        btnLast+="<button class='btn btn-default btn-sm' onclick='getform("+nextSt+")'><span class='glyphicon glyphicon-angle-right'></span></button>";
                    }
                    btnLast+="<button class='btn btn-default btn-sm' onclick='getform("+lastSt+")'><span class='glyphicon glyphicon-angle-double-right'></span></button>";
                    
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
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getform("+ st +")'>" + j +"</button>";
                        }
                    }else{
                        for (var j = 1; j<=jmlPage; j++) {
                            st=(j*data["limit"])-data["limit"];
                            if(curSt==st)  btn="btn-success"; else btn= "btn-default";
                            btnIdx+="<button class='btn " +btn +" btn-sm' onclick='getform("+ st +")'>" + j +"</button>";
                        }
                    }
                    pagination+=btnFirst + btnIdx + btnLast;
                    $('#pagination').html(pagination);
                }
            }
        }
    });
}

function getfield(formid,start) {
    $('#start').val(start);
    var search = $('#q').val();
    var limit = $('#limit').val();
    var active = "class='btn btn-primary btn-sm'";
    var url = base_url + "form/data_form/"+formid+"?q=" + search + "&start=" + start + "&limit=" + limit;
    console.log(url);
    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
        data: { get_param: 'value' },
        success: function (data) {
            //menghitung jumlah data
            //console.clear();
            if (data["status"] == true) {
                var isi = data["data"];
                var limit = data["limit"]
                console.log(isi)
                $('#data').html(isi);
                //Create Pagination
                if (data["row_count"] <= limit) {
                    $('#pagination').html("");
                } else {
                    var pagination = "";
                    var btnIdx = "";
                    jmlPage = Math.ceil(data["row_count"] / limit);
                    offset = data["start"] % limit;
                    curIdx = Math.ceil((data["start"] / data["limit"]) + 1);
                    prev = (curIdx - 2) * data["limit"];
                    next = (curIdx) * data["limit"];

                    var curSt = (curIdx * data["limit"]) - data["limit"];
                    var st = start;
                    var btn = "btn-default";
                    var lastSt = (jmlPage * data["limit"]) - data["limit"]
                    var btnFirst = "<button class='btn btn-default btn-sm' onclick='getform(0)'><span class='glyphicon glyphicon-angle-double-left'></span></button>";
                    if (curIdx > 1) {
                        var prevSt = ((curIdx - 1) * data["limit"]) - jmlData;
                        btnFirst += "<button class='btn btn-default btn-sm' onclick='getform(" + prevSt + ")'><span class='glyphicon glyphicon-angle-left'></span></button>";
                    }

                    var btnLast = "";
                    if (curIdx < jmlPage) {
                        var nextSt = ((curIdx + 1) * data["limit"]) - data["limit"];
                        btnLast += "<button class='btn btn-default btn-sm' onclick='getform(" + nextSt + ")'><span class='glyphicon glyphicon-angle-right'></span></button>";
                    }
                    btnLast += "<button class='btn btn-default btn-sm' onclick='getform(" + lastSt + ")'><span class='glyphicon glyphicon-angle-double-right'></span></button>";

                    if (jmlPage >= 25) {
                        if (curIdx >= 20) {
                            var idx_start = curIdx - 20;
                            var idx_end = idx_start + 25;
                            if (idx_end >= jmlPage) idx_end = jmlPage;
                        } else {
                            var idx_start = 1;
                            var idx_end = 25;
                        }
                        for (var j = idx_start; j <= idx_end; j++) {
                            st = (j * data["limit"]) - data["limit"];
                            if (curSt == st) btn = "btn-success"; else btn = "btn-default";
                            btnIdx += "<button class='btn " + btn + " btn-sm' onclick='getform(" + st + ")'>" + j + "</button>";
                        }
                    } else {
                        for (var j = 1; j <= jmlPage; j++) {
                            st = (j * data["limit"]) - data["limit"];
                            if (curSt == st) btn = "btn-success"; else btn = "btn-default";
                            btnIdx += "<button class='btn " + btn + " btn-sm' onclick='getform(" + st + ")'>" + j + "</button>";
                        }
                    }
                    pagination += btnFirst + btnIdx + btnLast;
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
    $('#err_form_id').html("");
    $('#err_form_title').html("");
    $('#err_form_link').html("");
    $('#form_id').val("");
    $('.modal-title').text('Tambah Data form'); 
}
function save(){
    var url;
    url = base_url + "form/save";
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
            //console.log(data);
            if(data["status"]==true){
                if(data["error"]==true){
                    $('#csrf').val(data["csrf"]);
                    if(data["err_form_id"]!="") $('#err_form_id').html(data["err_form_id"]); else $('#err_form_id').html("");
                    if(data["err_form_title"]!="") $('#err_form_title').html(data["err_form_title"]); else $('#err_form_title').html("");
                    if(data["err_form_link"]!="") $('#err_form_link').html(data["err_form_link"]); else $('#err_form_link').html("");
                    
                }else{
                    $('#csrf').val(data["csrf"]);
                    $('#modal_form').modal('hide');
                    var start=$('#start').val();
                    getform(start);
                    
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
    var url = base_url + "form/tambah/" + id;
    window.location.href=url;
}

function lihat(id) {
    var url = base_url + "form/lihat/" + id;
    window.location.href = url;
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
            url : base_url + "form/delete/" +id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                var start=$('#start').val();
                getform(start);
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
function CreateField(){
    var jml = $('#jml_field').val();
    var control = '<div class="col-md-4">' +
        '<label for="field">Field</label>' +
        '</div>'+
        '<div class="col-md-4">' +
        '<label for="field">Control</label>' +
        '</div>'+
        '<div class="col-md-4">' +
        '<label for="field">Source</label>' +
        '</div>';
    //console.log(jml);
    for(var i=0; i<parseInt(jml);i++){
        console.log('create file...')
        control += '<div class="form-group">' +
            '<div class="col-md-4">' +
            '<input type="text" name="field[]" id="field" class="form-control" required>' +
            '</div>' +
            '<div class="col-md-4">' +
            '<select name="control[]" id="control" class="form-control" required>' +
            '<option value="textbox">Textbox</option>' +
            '<option value="datepicker">Datepicker</option>' +
            '<option value="textarea">Textarea</option>' +
            '<option value="combobox">Combobox</option>' +
            '<option value="checkbox">Checkbox</option>' +
            '<option value="Radio">Radio</option>' +
            '</select>' +
            '</div>' +
            '<div class="col-md-4">' +
            '<input type="text" name="source[]" id="source" class="form-control" value="-" required>' +
            '</div>' +
            '</div>';
            //console.log(control);
    }

    $('#field').html(control);
}

function addField(){
    var jml_field = $('#jml_field').val();
    var plus = parseInt(jml_field) +1;
    $('#jml_field').val(plus);
    var control = '<div class="form-group" id="row'+jml_field+'">' +
        '<div class="col-md-3">' +
        '<input type="hidden" name="idx[]" id="idx' + jml_field + '" class="form-control" value="'+jml_field+'" required>' +
        '<input type="text" name="field' + jml_field + '" id="field'+jml_field+'" class="form-control" required>' +
        '</div>' +
        '<div class="col-md-3">' +
        '<select name="control' + jml_field + '" id="control' + jml_field + '" class="form-control" onchange="getSource(' + jml_field +')" required>' +
        '<option value="textbox">Textbox</option>' +
        '<option value="datepicker">Datepicker</option>' +
        '<option value="textarea">Textarea</option>' +
        '<option value="combobox">Combobox</option>' +
        '<option value="checkbox">Checkbox</option>' +
        '<option value="Radio">Radio</option>' +
        '</select>' +
        '</div>' +
        '<div class="col-md-6">' +
        '<div class="col-md-12">' +
        '</div>' +
        '<div class="col-md-6">' +
        '<select name="source' + jml_field + '" id="source' + jml_field + '" class="form-control" onchange="lainnya(' + jml_field +')">' +
        '<option value="-">Lainnya</option>' +
        '</select>' +
        '</div>' +
        '<div class="col-md-6" id="lain' + jml_field +'" style="display: block;">' +
        '<div class="input-group">' +
        '<input type="text" name="source_lain' + jml_field + '" id="source_lain' + jml_field +'" class="form-control" value="-" required>' +
        '<span class="input-group-addon" style="background-color:#b92727;border-coloe:#b92727;color#fff"><a href="#" onclick="removeField('+jml_field+')"><span class="fa fa-trash-o"></span></a></span>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>';
        $('#field').append(control);
}
function removeField(deleteindex){
    $("#row" + deleteindex).remove();
}
function getSource(idx){
    var control = $('#control'+idx).val();
    if(control=="combobox"){
        $("#source_lain" + idx).prop('readonly', false);
        listSource(idx);
    } else if (control == "checkbox" || control == "Radio"){
        $("#source_lain" + idx).prop('readonly', false);
    }else{ 
        $("#source_lain" + idx).prop('readonly', true);
    }
}
function listSource(idx){
    var url=base_url+"form/source";
    console.log(url);
    $.ajax({
        url: url,
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            var jmlData = data.length;
            var option = "";
            //Create Tabel
            for (var i = 0; i < jmlData; i++) {
                option += "<option value='" + data[i]["form_link"] + "'>" + data[i]["form_title"] +"</option>"
            }
            option+="<option value='-'>Lainnya</option>";
            
            if (jmlData > 0) $("#source_lain" + idx).prop('readonly', true);
            else  $("#source_lain" + idx).prop('readonly', false);
            $('#source'+idx).html(option);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            swal({
                title: "Terjadi Kesalahan..!",
                text: "Gagal Saat Pengambilan data",
                type: "error",
                timer: 5000
            });
        }
    });
}
function lainnya(idx){
    var source = $('#source'+idx).val();
    if (source == "-") $('#source_lain'+idx).prop('readonly', false);
    else $('#source_lain' + idx).prop('readonly', true);
}