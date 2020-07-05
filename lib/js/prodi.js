function getcontent(start) {
    $('#start').val(start);
    var search = $('#q').val();
    var active = "class='btn btn-primary btn-sm'";
    var limit = $('#limit').val();
    var tipe = $('#tipe').val();
    var url = base_url + "admin/prodi/data?q=" + search + "&start=" + start + "&limit=" + limit + "&tipe=" + tipe;
    console.clear();
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
                var content = data["data"];
                var jmlData = content.length;
                var limit = data["limit"]
                var tabel = "";
                //Create Tabel
                for (var i = 0; i < jmlData; i++) {
                    start++;
                    tgl = content[i]["content_tglpublish"];
                    arr = tgl.split("-");

                    tabel += "<tr>";
                    tabel += "<td>" + start + "</td>";
                    tabel += "<td>" + content[i]["content_judul"] + "</td>";
                    if (content[i]["content_tipe"] == "Berita") {
                        tabel += "<td>" + content[i]["nama_kategori"] + "</td>";
                    }

                    tabel += "<td>" + content[i]["content_tglpost"] + "</td>";
                    tabel += "<td>" + content[i]["content_tglpublish"] + "</td>";
                    if (content[i]["content_tipe"] == "Berita") {
                        if (content[i]["content_tglexp"] == '0000-00-00') tabel += "<td>Tidak Pernah Expire</td>";
                        else tabel += "<td>" + content[i]["content_tglexp"] + "</td>";
                    }


                    tabel += "<td>" + base_url + content[i]["content_link"] + "</td>";
                    // id='sebagai_galery"+media[i]["id_group"]+"' onclick='setGalery(\""+media[i]["id_group"]+"\")'
                    if (content[i]["content_komentar"] == 1) {
                        tabel += '<td style="width:100px;">';
                        tabel += '<label class="switch switch-small">';
                        tabel += '<input type="checkbox" checked value="1" id="content_komentar' + content[i]["content_id"] + '"  onclick="setKomentar(\'' + content[i]["content_id"] + '\')"/>';
                        tabel += '<span></span>';
                        tabel += '</label>';
                        tabel += '</td>'
                        //tabel+="<td style='width:100px;'><button class='btn btn-success btn-sm'>Aktif</button></td>";
                    } else {
                        tabel += '<td style="width:100px;">';
                        tabel += '<label class="switch switch-small">';
                        tabel += '<input type="checkbox" value="1" id="content_komentar' + content[i]["content_id"] + '"  onclick="setKomentar(\'' + content[i]["content_id"] + '\')"/>';
                        tabel += '<span></span>';
                        tabel += '</label>';
                        tabel += '</td>'
                        //tabel+="<td style='width:100px;'><button class='btn btn-danger btn-sm'>Non Aktif</button></td>";
                    }

                    tabel += "<td>";
                    if (content[i]["content_status"] == "Publish") {
                        var style = 'success';
                    } else if (content[i]["content_status"] == "Draft") {
                        var style = 'warning';
                    } else {
                        var style = 'danger';
                    }
                    tabel += '<button type="button" class="btn btn-' + style + ' btn-sm dropdown-toggle" data-toggle="dropdown">' + content[i]["content_status"] + ' <span class="caret"></span></button>';
                    tabel += '<ul class="dropdown-menu" role="menu">';
                    if (content[i]["content_status"] == "Unpublish") tabel += '<li role="presentation" class="dropdown-header">Unpublish</li>'; else tabel += '<li><a href="#"  onclick="setStatus(\'' + content[i]["content_id"] + '\',\'Unpublish\')">Unpublish</a></li>';
                    if (content[i]["content_status"] == "Draft") tabel += '<li role="presentation" class="dropdown-header">Draft</li>'; else tabel += '<li><a href="#" onclick="setStatus(\'' + content[i]["content_id"] + '\',\'Draft\')">Draft</a></li>';
                    if (content[i]["content_status"] == "Publish") tabel += '<li role="presentation" class="dropdown-header">Publish</li>'; else tabel += ' <li><a href="#" onclick="setStatus(\'' + content[i]["content_id"] + '\',\'Publish\')">Publish</a></li>';
                    tabel += "</td>";
                    tabel += "<td>" + content[i]["content_hits"] + "</td>";
                    tabel += "<td>" + content[i]["userinput"] + "</td>";

                    tabel += '<td class=\'text-right\' style="width:250px;">';
                    tabel += '<div class="btn-group btn-group-sm">';
                    tabel += '<a href=\'' + base_url + 'admin/prodi/lampiran/' + content[i]["content_id"] + '\' class=\'btn btn-info\'><span class=\'glyphicon glyphicon-paperclip\' ></span>Lampiran</a>';
                    tabel += '<a href=\'' + base_url + 'admin/prodi/form/' + content[i]["content_id"] + '\' class=\'btn btn-success\'><span class=\'glyphicon glyphicon-pencil\' ></span> Edit</a>';
                    tabel += '<button type=\'button\' class=\'btn btn-danger \' onclick=\'hapus("' + content[i]["content_id"] + '")\'><span class=\'glyphicon glyphicon-remove\' ></span> Hapus</td>';
                    tabel += '</div>';
                    tabel += '</td>';


                    tabel += "</tr>";
                }
                $('#data').html(tabel);
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
                    var btnFirst = "<button class='btn btn-default btn-sm' onclick='getcontent(0)'><span class='fa fa-angle-double-left'></span></button>";
                    if (curIdx > 1) {
                        var prevSt = ((curIdx - 1) * data["limit"]) - data["limit"];
                        btnFirst += "<button class='btn btn-default btn-sm' onclick='getcontent(" + prevSt + ")'><span class='fa fa-angle-left'></span></button>";
                    }

                    var btnLast = "";
                    if (curIdx < jmlPage) {
                        var nextSt = ((curIdx + 1) * data["limit"]) - data["limit"];
                        btnLast += "<button class='btn btn-default btn-sm' onclick='getcontent(" + nextSt + ")'><span class='fa fa-angle-right'></span></button>";
                    }
                    btnLast += "<button class='btn btn-default btn-sm' onclick='getcontent(" + lastSt + ")'><span class='fa fa-angle-double-right'></span></button>";

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
                            btnIdx += "<button class='btn " + btn + " btn-sm' onclick='getcontent(" + st + ")'>" + j + "</button>";
                        }
                    } else {
                        for (var j = 1; j <= jmlPage; j++) {
                            st = (j * data["limit"]) - data["limit"];
                            if (curSt == st) btn = "btn-success"; else btn = "btn-default";
                            btnIdx += "<button class='btn " + btn + " btn-sm' onclick='getcontent(" + st + ")'>" + j + "</button>";
                        }
                    }
                    pagination += btnFirst + btnIdx + btnLast;
                    $('#pagination').html(pagination);
                }
            }
        }
    });
}
function getlampiran(prodiid) {

    var url = base_url + "admin/prodi/data_lampiran/" + prodiid;
    console.clear();
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
                var content = data["data"];
                var jmlData = content.length;
                var limit = data["limit"]
                var start = 0;
                var tabel = "";
                //Create Tabel
                for (var i = 0; i < jmlData; i++) {
                    start++;

                    tabel += "<tr>";
                    tabel += "<td>" + start + "</td>";
                    tabel += "<td>" + content[i]["judul_lampiran"] + "</td>";
                    tabel += "<td>" + content[i]["jenis_lampiran"] + "</td>";
                    if (content[i]["jenis_lampiran"] == "Gambar") {
                        tabel += "<td><img src='" + base_url + "uploads/media/icon/" + content[i]["isi_lampiran"] + "'></td>";
                    } else {
                        tabel += "<td>" + content[i]["isi_lampiran"] + "</td>";
                    }
                    tabel += '<td class=\'text-right\' style="width:250px;">';
                    tabel += '<div class="btn-group btn-group-sm">';
                    tabel += '<button type=\'button\' class=\'btn btn-warning \' onclick=\'editLampiran("' + content[i]["idx"] + '")\'><span class=\'glyphicon glyphicon-pencil\' ></span> Edit</button>';
                    tabel += '<button type=\'button\' class=\'btn btn-danger \' onclick=\'hapusLampiran("' + content[i]["idx"] + '")\'><span class=\'glyphicon glyphicon-remove\' ></span> Hapus</td>';
                    tabel += '</div>';
                    tabel += '</td>';


                    tabel += "</tr>";
                }
                $('#data-lampiran').html(tabel);

            }
        }
    });
}
function saveLampiran() {
    var url;
    url = base_url + "admin/prodi/save_lampiran";
    //alert("user");
    var formData = new FormData($('#form')[0]);
    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'JSON',
        success: function (data) {
            console.log(data);
            if (data["status"] == true) {
                if (data["error"] == true) {
                    $('.csrf').val(data["csrf"]);
                } else {
                    $('.csrf').val(data["csrf"]);
                    resetFormLampiran();
                    //var start = $('#start').val();
                    //getcontent(start);
                    var content_id = $('#content_id').val();
                    getlampiran(content_id);
                    swal({
                        title: "Sukses",
                        text: data["message"],
                        type: "success",
                        timer: 5000
                    });
                }
            } else {
                swal({
                    title: "Peringatan",
                    text: data["message"],
                    type: "warning",
                    timer: 5000
                });
            }

        },
        error: function (jqXHR, textStatus, errorThrown) {
            swal({
                title: "Terjadi Kesalahan ",
                text: "Gagal Menyimpan Data",
                type: "error",
                timer: 5000
            });
        }
    });
}
function editLampiran(id) {
    var url;
    save_method = 'update';
    $('#form')[0].reset();
    $.ajax({
        url: base_url + "admin/prodi/editlampiran/" + id,
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            console.log(data);
            if (data["status"] == false) {
                swal({
                    title: "Peringatan",
                    text: data["message"],
                    type: "error",
                    timer: 5000
                });
                //alert(data["message"]);
            } else {
                var content = data["data"];

                $('#content_id').val(content.content_id);
                $('#id_lampiran').val(content.idx);
                $('#judul_lampiran').val(content.judul_lampiran);
                if(content.jenis_lampiran=="Gambar") {
                    $("#gambar").prop("checked", true);
                    var control = '<img src="'+base_url+'uploads/media/original/'+content.isi_lampiran+'" class="img img-responsive">'
                        +'<input type="hidden" id="isi_lampiran" name="isi_lampiran"  value="'+content.isi_lampiran+'">';
                    $('#viewlampiran').html(control);
                }
                else if(content.jenis_lampiran=="Link") {
                    $("#link").prop("checked", true);
                    var control = '<input type="text" id="isi_lampiran" class="form-control" placeholder="Link Lampiran" name="isi_lampiran"  value="' + content.isi_lampiran + '">'
                    $('#viewlampiran').html(control);
                }else{
                    $('#cari-lampiran').hide();
                    $("#group").prop("checked", true);
                    var url = base_url + "admin/prodi/allmedia";
                    console.clear();
                    console.log(url);
                    $.ajax({
                        url: url,
                        type: "GET",
                        dataType: "json",
                        data: { get_param: 'value' },
                        async:false,
                        success: function (data) {
                            var media = data["data"];
                            var jmlData = media.length;
                            var control = '<label for="inputEmail3" class="col-sm-12 ">Group Media</label>'
                                + '<div class="col-sm-12">'
                                + '<select class="form-control" id="isi_lampiran" name="isi_lampiran" placeholder="Link Lampiran" onchange="viewLampiran()">'
                                + '<option value="">Pilih Group Media</option>';
                            for (var i = 0; i < jmlData; i++) {
                                start++;
                                console.log(content.isi_lampiran +" = "+media[i]["id_group"])
                                if(content.isi_lampiran==media[i]["id_group"]) var check="selected"; else var check="";
                                control += "<option value='" + media[i]["id_group"] + "' "+check+">" + media[i]["nama_group"] + "</td>";
                                //tabel += "<tr class='view-media' id='view-media" + media[i]["id_group"] + "' style='display:none;'><td colspan='5'  ><input type='hidden' class='open' id='open" + media[i]["id_group"] + "' value='0'><div class='col-md-12' id='data-media" + media[i]["id_group"] + "'></div></td></tr>";
                            }
                            //$('#data-media').html(tabel);
                            control += '</select>'
                                + '<span class="text-error" id="err_isi_lampiran"></span>'
                                + '<div id="list-media"></div>'
                                + '</div>'
                            $('#viewlampiran').html(control);
                            viewLampiran(content.isi_lampiran);
                        }
                    });
                }
                
                $('#err_judul_lampiran').html("");
                $('#err_jenis_lampiran').html("");
                $('#csrf').val(data["csrf"]);
                
            }

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
function viewLampiran(id_group=""){
    if (id_group == "") id_group = $('#isi_lampiran').val();
    var url = base_url + "admin/prodi/detailmedia/" + id_group;
    //alert(url);
    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
        data: { get_param: 'value' },
        success: function (data) {
            //menghitung jumlah data
            console.clear();
            console.log(url);
            if (data["status"] == true) {
                var media = data["data"];
                var jmlData = media.length;
                var limit = data["limit"]
                var tabel = '<table class="table table-bordered">';
                var mod = 1;
                var start = 0;
                //Create Tabel
                for (var i = 0; i < jmlData; i++) {
                    start++;
                    tabel += "<tr>";
                    tabel += "<td>";
                    file = media[i]["namafile"];
                    arr = file.split(".");
                    jml_split = arr.length;
                    ext = arr[jml_split - 1];
                    //console.log(ext);
                    //console.log("jml SPLIT : " + jml_split);
                    if (ext == "jpg" || ext == "JPG" || ext == "png" || ext == "PNG" || ext == "gif" || ext == "GIF" || ext == "jpeg" || ext == "JPEG") {
                        tabel += "<img src='" + base_url + "uploads/media/thumb/" + media[i]["namafile"] + "' style='width:30px' class='img img-responsive'>";
                    } else {
                        tabel += "<img src='" + base_url + "uploads/media/" + ext + ".png' style='width:30px' class='img img-responsive'>";
                    }
                    //tabel+="<img src='"+base_url+"uploads/media/"+media[i]["namafile"]+"' class='img img-responsive'>";
                    tabel += "</td><td>" + media[i]["keterangan"] + "</td></tr>";
                    
                }
                tabel+="</table>"
                //console.clear();
                //console.log(tabel);
                $('#list-media').html(tabel);

            }
        }
    });
}
function resetFormLampiran(){
    $('#id_lampiran').val("");
    $('#judul_lampiran').val("");
    $('#viewlampiran').html("");
    $("#gambar").prop("checked", false);
    $("#link").prop("checked", true);
}
function hapusLampiran(id) {
    swal({
        title: "Apakah Anda Yakin?",
        text: "Akan menghapus lampiran",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, Saya Yakin!",
        cancelButtonText: "Tidak, Tolong Batalkan!",
        closeOnConfirm: true,
        closeOnCancel: true
    },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: base_url + "admin/prodi/deletelampiran/" + id,
                    type: "GET",
                    dataType: "JSON",
                    success: function (data) {
                        if(data["status"]==true){
                            var id_content = $('#content_id').val();
                            getlampiran(id_content);
                        }else{
                            swal({
                                title: "Peringatan",
                                text: data["message"],
                                type: "warning",
                                timer: 5000
                            });
                        }
                        
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
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

function getMedia(start) {
    $('#start').val(start);
    var search = $('#q').val();
    var active = "class='btn btn-primary btn-sm'";
    var url = base_url + "admin/prodi/datamedia?q=" + search + "&start=" + start;
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
                var media = data["data"];
                var jmlData = media.length;
                var limit = data["limit"]
                var tabel = "";
                //Create Tabel
                for (var i = 0; i < jmlData; i++) {
                    start++;
                    tabel += "<tr>";
                    tabel += "<td><button type='button' class='btn btn-success btn-xs' onclick='openMedia(\"" + media[i]["id_group"] + "\")'><span class='fa fa-plus icon-group' id='icon-group" + media[i]["id_group"] + "'></span></button></td>";

                    tabel += "<td>" + media[i]["nama_group"] + "</td>";

                    tabel += "</tr>";
                    tabel += "<tr class='view-media' id='view-media" + media[i]["id_group"] + "' style='display:none;'><td colspan='5'  ><input type='hidden' class='open' id='open" + media[i]["id_group"] + "' value='0'><div class='col-md-12' id='data-media" + media[i]["id_group"] + "'></div></td></tr>";
                }
                $('#data-media').html(tabel);
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
                    var btnFirst = "<button type='button' class='btn btn-default btn-sm' onclick='getMedia(0)'><span class='fa fa-angle-double-left'></span></button>";
                    if (curIdx > 1) {
                        var prevSt = ((curIdx - 1) * data["limit"]) - data["limit"];
                        btnFirst += "<button  type='button' class='btn btn-default btn-sm' onclick='getMedia(" + prevSt + ")'><span class='fa fa-angle-left'></span></button>";
                    }

                    var btnLast = "";
                    if (curIdx < jmlPage) {
                        var nextSt = ((curIdx + 1) * data["limit"]) - data["limit"];
                        btnLast += "<button type='button' class='btn btn-default btn-sm' onclick='getMedia(" + nextSt + ")'><span class='fa fa-angle-right'></span></button>";
                    }
                    btnLast += "<button type='button' class='btn btn-default btn-sm' onclick='getMedia(" + lastSt + ")'><span class='fa fa-angle-double-right'></span></button>";

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
                            btnIdx += "<button type='button' class='btn " + btn + " btn-sm' onclick='getMedia(" + st + ")'>" + j + "</button>";
                        }
                    } else {
                        for (var j = 1; j <= jmlPage; j++) {
                            st = (j * data["limit"]) - data["limit"];
                            if (curSt == st) btn = "btn-success"; else btn = "btn-default";
                            btnIdx += "<button type='button' class='btn " + btn + " btn-sm' onclick='getMedia(" + st + ")'>" + j + "</button>";
                        }
                    }
                    pagination += btnFirst + btnIdx + btnLast;
                    $('#pagination').html(pagination);
                }
            }
        }
    });
}
function showMedia() {
    var j_lampiran = $("input[type='radio']:checked").val();
    if (j_lampiran == "Gambar") {
        $('#cari-lampiran').show();
    } else if(j_lampiran=='Link'){
        $('#cari-lampiran').hide();
        var control = '<label for="inputEmail3" class="col-sm-12 ">LINK</label>'
            + '<div class="col-sm-12">'
            + '<input type="text" class="form-control" id="isi_lampiran" name="isi_lampiran" placeholder="Link Lampiran" value="">'
            + '<span class="text-error" id="err_isi_lampiran"></span>'
            + '</div>'
        $('#viewlampiran').html(control);
    }else{
        $('#cari-lampiran').hide();
        var url = base_url + "admin/prodi/allmedia";
        console.clear();
        console.log(url);
        $.ajax({
            url: url,
            type: "GET",
            dataType: "json",
            data: { get_param: 'value' },
            success: function (data) {
                var media = data["data"];
                var jmlData = media.length;
                var control = '<label for="inputEmail3" class="col-sm-12 ">Group Media</label>'
                    + '<div class="col-sm-12">'
                    + '<select class="form-control" id="isi_lampiran" name="isi_lampiran" placeholder="Link Lampiran" onchange="viewLampiran()">'
                    + '<option value="">Pilih Group Media</option>';
                for (var i = 0; i < jmlData; i++) {
                    start++;
                    control += "<option value='"+media[i]["id_group"]+"'>" + media[i]["nama_group"] + "</td>";
                    //tabel += "<tr class='view-media' id='view-media" + media[i]["id_group"] + "' style='display:none;'><td colspan='5'  ><input type='hidden' class='open' id='open" + media[i]["id_group"] + "' value='0'><div class='col-md-12' id='data-media" + media[i]["id_group"] + "'></div></td></tr>";
                }
                //$('#data-media').html(tabel);
                control += '</select>'
                    + '<span class="text-error" id="err_isi_lampiran"></span>'
                    + '<div id="list-media"></div>'
                    + '</div>'
                $('#viewlampiran').html(control);
            }
        });
        
    }

}
function insertLampiran() {
    var gambar = $('#original_gambar').val();
    var file = $('#namafile').val();
    var control = gambar + '<input type="hidden" class="form-control" id="isi_lampiran" name="isi_lampiran" placeholder="Link Lampiran" value="' + file + '">';
    $('#viewlampiran').html(control);
    $('#cari-lampiran').hide();
    $('#modal_view').modal('hide');
}
function InsertPostThumb() {
    /**
     * Get Summernote value
     */
    var isi = $('.note-editable').html();
    isi += $('#thumb_gambar').val();
    $('.note-editable').html(isi);
    $('#modal_view').modal('hide');
}
function openMedia(id_group) {
    var status = $('#open' + id_group).val();
    if (status == 0) {
        $('.open').val("0");
        $('#open' + id_group).val("1");
        $('.view-media').hide();
        $('#view-media' + id_group).show();
        $('.icon-group').removeClass('fa-minus');
        $('.icon-group').addClass('fa-plus');
        $('#icon-group' + id_group).removeClass('fa-plus');
        $('#icon-group' + id_group).addClass('fa-minus');
        getDatamedia(id_group);
    } else {
        $('#open' + id_group).val("0");
        $('#view-media' + id_group).hide();
        $('#icon-group' + id_group).removeClass('fa-minus');
        $('#icon-group' + id_group).addClass('fa-plus');
    }

}
function getDatamedia(id_group) {
    //$('#start').val(start);
    //var search = $('#q').val();
    //var active="class='btn btn-primary btn-sm'";
    var url = base_url + "admin/prodi/detailmedia/" + id_group;
    //alert(url);
    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
        data: { get_param: 'value' },
        success: function (data) {
            //menghitung jumlah data
            console.clear();
            console.log(url);
            if (data["status"] == true) {
                var media = data["data"];
                var jmlData = media.length;
                var limit = data["limit"]
                var tabel = '<div class="col-md-12"><button type="button" class="btn btn-default btn-lg btn-block" onclick="formUpload(' + id_group + ')"><span class="fa fa-plus"></span></button></div><br><br>';
                var mod = 1;
                var start = 0;
                //Create Tabel
                for (var i = 0; i < jmlData; i++) {
                    start++;
                    tabel += "<div class='col-md-2'>";
                    tabel += "<a href='#' onclick='viewMedia(\"" + media[i]["id_media"] + "\")'>";
                    file = media[i]["namafile"];
                    arr = file.split(".");
                    jml_split = arr.length;
                    ext = arr[jml_split - 1];
                    //console.log(ext);
                    //console.log("jml SPLIT : " + jml_split);
                    if (ext == "jpg" || ext == "JPG" || ext == "png" || ext == "PNG" || ext == "gif" || ext == "GIF" || ext == "jpeg" || ext == "JPEG") {
                        tabel += "<img src='" + base_url + "uploads/media/thumb/88X88/_88X88_" + media[i]["namafile"] + "' class='img img-responsive'>";
                    } else {
                        tabel += "<img src='" + base_url + "uploads/media/" + ext + ".png' class='img img-responsive'>";
                    }
                    //tabel+="<img src='"+base_url+"uploads/media/"+media[i]["namafile"]+"' class='img img-responsive'>";
                    tabel += "<div>" + media[i]["keterangan"] + "</div></div>";
                    mod = start % 6;
                    console.log(mod);
                    if (start % 6 == 0) tabel += "<div class='row'></div>";
                }
                //console.clear();
                //console.log(tabel);
                $('#data-media' + id_group).html(tabel);

            }
        }
    });
}
function formUpload(idgroup) {
    $('#uploadgroup').val(idgroup);
    $('#modal_upload').modal('show');
}
function viewMedia(idmedia) {
    var url = base_url + "admin/prodi/viewmedia/" + idmedia;
    $.ajax({
        url: url,
        type: "GET",
        dataType: "HTML",
        success: function (data) {

            $('#modal_view').modal('show');
            $('#view-media').html(data);
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
function add() {
    save_method = 'add';
    $('#form')[0].reset();
    $('#modal_form').modal('show');

    $('#err_content_id').html("");
    $('#err_id_kategori').html("");
    $('#err_content_judul').html("");
    $('#err_isi_content').html("");
    $('#err_tgl_content').html("");
    $('#err_content_tglpublish').html("");
    $('#err_content_tglexp').html("");
    $('#err_lampiran_gambar').html("");
    $('#err_content_link').html("");
    $('#err_content_tipe').html("");
    $('#err_content_komentar').html("");
    $('#err_content_status').html("");
    $('#err_content_hits').html("");
    $('#err_userinput').html("");
    $('.modal-title').text('Tambah Data content');
}
function save() {
    var url;
    url = base_url + "admin/prodi/save";
    //alert("user");
    var formData = new FormData($('#form')[0]);
    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'JSON',
        success: function (data) {
            //alert(data["message"]);
            //console.log(data);
            if (data["status"] == true) {
                if (data["error"] == true) {
                    $('#csrf').val(data["csrf"]);

                    if (data["err_content_id"] != "") $('#err_content_id').html(data["err_content_id"]); else $('#err_content_id').html("");

                    if (data["err_id_kategori"] != "") $('#err_id_kategori').html(data["err_id_kategori"]); else $('#err_id_kategori').html("");

                    if (data["err_content_judul"] != "") $('#err_content_judul').html(data["err_content_judul"]); else $('#err_content_judul').html("");

                    if (data["err_isi_content"] != "") $('#err_isi_content').html(data["err_isi_content"]); else $('#err_isi_content').html("");

                    if (data["err_tgl_content"] != "") $('#err_tgl_content').html(data["err_tgl_content"]); else $('#err_tgl_content').html("");

                    if (data["err_content_tglpublish"] != "") $('#err_content_tglpublish').html(data["err_content_tglpublish"]); else $('#err_content_tglpublish').html("");

                    if (data["err_content_tglexp"] != "") $('#err_content_tglexp').html(data["err_content_tglexp"]); else $('#err_content_tglexp').html("");

                    if (data["err_lampiran_gambar"] != "") $('#err_lampiran_gambar').html(data["err_lampiran_gambar"]); else $('#err_lampiran_gambar').html("");

                    if (data["err_content_link"] != "") $('#err_content_link').html(data["err_content_link"]); else $('#err_content_link').html("");

                    if (data["err_content_tipe"] != "") $('#err_content_tipe').html(data["err_content_tipe"]); else $('#err_content_tipe').html("");

                    if (data["err_content_komentar"] != "") $('#err_content_komentar').html(data["err_content_komentar"]); else $('#err_content_komentar').html("");

                    if (data["err_content_status"] != "") $('#err_content_status').html(data["err_content_status"]); else $('#err_content_status').html("");

                    if (data["err_content_hits"] != "") $('#err_content_hits').html(data["err_content_hits"]); else $('#err_content_hits').html("");

                    if (data["err_userinput"] != "") $('#err_userinput').html(data["err_userinput"]); else $('#err_userinput').html("");

                } else {
                    $('#csrf').val(data["csrf"]);
                    $('#modal_form').modal('hide');
                    var start = $('#start').val();

                    getcontent(start);
                    swal({
                        title: "Sukses",
                        text: data["message"],
                        type: "success",
                        timer: 5000
                    });
                }
            }
            else {
                swal({
                    title: "Peringatan",
                    text: data["message"],
                    type: "warning",
                    timer: 5000
                });
            }

        },
        error: function (jqXHR, textStatus, errorThrown) {
            swal({
                title: "Terjadi Kesalahan ",
                text: "Gagal Menyimpan Data",
                type: "error",
                timer: 5000
            });
        }
    });
}
function edit(id) {
    var url;
    save_method = 'update';
    $('#form')[0].reset();
    $.ajax({
        url: base_url + "admin/prodi/edit/" + id,
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            if (data["status"] == false) {
                swal({
                    title: "Peringatan",
                    text: data["message"],
                    type: "error",
                    timer: 5000
                });
                //alert(data["message"]);
            } else {
                var content = data["data"];

                $('#content_id').val(content.content_id);
                $('#id_kategori').val(content.id_kategori);
                $('#content_judul').val(content.content_judul);
                $('#isi_content').val(content.isi_content);
                $('#tgl_content').val(content.tgl_content);
                $('#content_tglpublish').val(content.content_tglpublish);
                $('#content_tglexp').val(content.content_tglexp);
                $('#lampiran_gambar').val(content.lampiran_gambar);
                $('#content_link').val(content.content_link);
                $('#content_tipe').val(content.content_tipe);
                if (content.content_komentar == 1) $('#content_komentar').prop("checked", true);
                $('#content_status').val(content.content_status);
                $('#content_hits').val(content.content_hits);
                $('#userinput').val(content.userinput);

                $('#err_content_id').html("");
                $('#err_id_kategori').html("");
                $('#err_content_judul').html("");
                $('#err_isi_content').html("");
                $('#err_tgl_content').html("");
                $('#err_content_tglpublish').html("");
                $('#err_content_tglexp').html("");
                $('#err_lampiran_gambar').html("");
                $('#err_content_link').html("");
                $('#err_content_tipe').html("");
                $('#err_content_status').html("");
                $('#err_content_hits').html("");
                $('#err_userinput').html("");
                $('#csrf').val(data["csrf"]),
                    $('#modal_form').modal('show');
                $('.modal-title').text('Edit Data content');
            }

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
function hapus(id) {
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
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: base_url + "admin/prodi/delete/" + id,
                    type: "GET",
                    dataType: "JSON",
                    success: function (data) {
                        var start = $('#start').val();
                        getcontent(start);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
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

function insertThumb() {
    var thumb = $('#thumb_gambar').val();
    var file = $('#namafile').val();
    var jml_lampiran = $('#jml_lampiran').val();
    var jmlbaru = parseInt(jml_lampiran) + 1;
    $('#jml_lampiran').val(jmlbaru);
    var keterangan = $('#keterangan').val();
    keterangan = keterangan.replace('_', ' ')
    $('#lampiran_gambar').val(file);
    if (jmlbaru > 1) {
        var card = $('#priv-img').html();
    } else {
        var card = "";
    }
    card += '<div id="lampiran' + jmlbaru + '"><div class="col-sm-4" >'
        + '<div class="thumbnail" >'
        + '<div class="caption text-center" >'
        + '<div class="position-relative">'
        + thumb + '<input type="hidden" name="file[]" id="file' + jmlbaru + '" value="' + file + '">'
        + '</div>'
        + '</div>'
        + '<div class="caption card-footer text-center">'
        + '<ul class="list-inline">'
        + '<li><button class="btn btn-danger btn-xs btn-block" type="button" onclick="removeThumb(' + jmlbaru + ')"><i class="glyphicon glyphicon-remove"></i>Hapus Thumb</button></li>'
        + '</ul>'
        + '</div>'
        + '</div >'
        + '</div ></div>'
    $('#priv-img').html(card);
    //$('#userfile').val("");
    //$('#filecontrol').hide();
    $('#modal_view').modal('hide');
}

function removeThumb(idx) {
    $('#lampiran' + idx).html("");
    var jml_lampiran = $('#jml_lampiran').val();
    var jmlbaru = parseInt(jml_lampiran) - 1;
    $('#jml_lampiran').val(jmlbaru);
}
function InsertPostOri() {
    /**
     * Get Summernote value
     */
    console.clear();
    //var imgOri = $('#original_gambar').val();
    //$('.summernote').summernote('editor.insertImage', imgOri);
    var isi = $('.note-editable').html();
    isi += $('#original_gambar').val();
    $('.note-editable').html(isi);
    $('#modal_view').modal('hide');
}


function setKomentar(id_group) {
    if ($('#content_komentar' + id_group).is(':checked')) {
        var url = base_url + "admin/prodi/komentar/" + id_group + "/1";
    } else {
        var url = base_url + "admin/prodi/komentar/" + id_group + "/0";
    }
    console.log(url);
    $.ajax({
        url: url,
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            getcontent(0);
            if (data["status"] == false) {
                swal({
                    title: "Peringatan",
                    text: data["message"],
                    type: "error",
                    timer: 5000
                });
                //alert(data["message"]);
            }
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

function setStatus(id_group, status) {
    var url = base_url + "admin/prodi/status/" + id_group + "/" + status;
    console.log(url);
    $.ajax({
        url: url,
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            getcontent(0);
            if (data["status"] == false) {
                swal({
                    title: "Peringatan",
                    text: data["message"],
                    type: "error",
                    timer: 5000
                });
                //alert(data["message"]);
            }
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
function cekKategori() {
    var idx = $('#content_kategoriid').val();
    if (idx == 'Lainnya') {
        $('#modal_kategori').modal('show');
    }
}
function addKategori() {
    var url;
    url = base_url + "admin/prodi/add_kategori";
    //alert("user");
    var formData = new FormData($('#form-kategori')[0]);
    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'JSON',
        success: function (data) {
            //alert(data["message"]);
            console.log(data);
            if (data["status"] == true) {
                if (data["error"] == true) {
                    $('#csrf').val(data["csrf"]);
                    if (data["err_nama_kategori"] != "") $('#err_nama_kategori').html(data["err_nama_kategori"]); else $('#err_nama_kategori').html("");
                } else {
                    $('#csrf').val(data["csrf"]);
                    $('#modal_kategori').modal('hide');
                    getKategori(data.idx);
                    /*swal({
                        title: "Sukses",
                        text: data["message"],
                        type: "success",
                        timer: 5000
                    });*/
                }
            }
            else {
                swal({
                    title: "Peringatan",
                    text: data["message"],
                    type: "warning",
                    timer: 5000
                });
            }

        },
        error: function (jqXHR, textStatus, errorThrown) {
            swal({
                title: "Terjadi Kesalahan ",
                text: "Gagal Menyimpan Data",
                type: "error",
                timer: 5000
            });
        }
    });
}
function getKategori(selected) {
    var url = base_url + "admin/prodi/getkategori";
    console.clear();
    console.log(url);
    $.ajax({
        url: url,
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            if (data["status"] == false) {
                swal({
                    title: "Peringatan",
                    text: data["message"],
                    type: "error",
                    timer: 5000
                });
                //alert(data["message"]);
            } else {
                var kategori = data["data"];
                var option = "";
                for (var i = 0; i < kategori.length; i++) {
                    if (kategori[i]["id_kategori"] == selected) option += "<option value='" + kategori[i]["id_kategori"] + "' selected>" + kategori[i]['nama_kategori'] + "</option>";
                    else option += "<option value='" + kategori[1]['id_kategori'] + "'>" + kategori[i]['nama_kategori'] + "</option>";
                }
                option += "<option value='Lainnya'>Lainnya</option>"
                $('#content_kategoriid').html(option);
            }

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
function addGroup() {
    $('#nama_group').val("");
    $('#modal_group').modal('show');
}
function addGroupMedia() {
    var url;
    url = base_url + "admin/prodi/add_group";
    //alert("user");
    var formData = new FormData($('#form-group')[0]);
    console.log(formData);
    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'JSON',
        success: function (data) {
            //alert(data["message"]);
            console.log(data);
            $('#modal_group').modal('hide');
            $('.csrf').val(data["csrf"]);
            if (data["status"] == true) {
                getMedia(0);

            }
            else {
                swal({
                    title: "Peringatan",
                    text: data["message"],
                    type: "warning",
                    timer: 5000
                });
            }

        },
        error: function (jqXHR, textStatus, errorThrown) {
            swal({
                title: "Terjadi Kesalahan ",
                text: errorThrown,
                type: "error",
                timer: 5000
            });
        }
    });
}