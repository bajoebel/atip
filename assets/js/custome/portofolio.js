function getPortofolio(start) {
    $('#start').val(start);
    var search = $('#q').val();
    var active = "class='btn btn-primary btn-sm'";
    var url = base_url + "welcome/dataportofolio?q=" + search + "&start=" + start
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
                var row = data["data"];
                var jmlData = row.length;
                var limit = data["limit"]
                var tabel = "";
                //Create Tabel
                for (var i = 0; i < jmlData; i++) {
                    start++;
                    tabel += "<tr>";
                    tabel += "<td>" + start + "</td>";
                    tabel += "<td>" + row[i]["nama_lengkap"] + "</td>";
                    tabel += "<td>" + row[i]["email"] + "</td>";
                    tabel += "<td>" + row[i]["alamat"] + "</td>";
                    tabel += "<td>" + row[i]["nohp"] + "</td>";
                    tabel += "<td>" + row[i]["role_nama"] + "</td>";
                    tabel += '<td class=\'text-right\' style="width:200px;">';
                    tabel += '<div class="btn-group btn-group-sm">';
                    tabel += '<button type=\'button\' class=\'btn btn-success \' onclick=\'edit("' + row[i]["row_id"] + '")\'><span class=\'glyphicon glyphicon-pencil\' ></span> Edit</button>';
                    tabel += '<button type=\'button\' class=\'btn btn-danger \' onclick=\'hapus("' + row[i]["row_id"] + '")\'><span class=\'glyphicon glyphicon-remove\' ></span> Hapus</td>';
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
                    var btnFirst = "<button class='btn btn-default btn-sm' onclick='getrow(0)'><span class='glyphicon glyphicon-angle-double-left'></span></button>";
                    if (curIdx > 1) {
                        var prevSt = ((curIdx - 1) * data["limit"]) - jmlData;
                        btnFirst += "<button class='btn btn-default btn-sm' onclick='getrow(" + prevSt + ")'><span class='glyphicon glyphicon-angle-left'></span></button>";
                    }

                    var btnLast = "";
                    if (curIdx < jmlPage) {
                        var nextSt = ((curIdx + 1) * data["limit"]) - data["limit"];
                        btnLast += "<button class='btn btn-default btn-sm' onclick='getrow(" + nextSt + ")'><span class='glyphicon glyphicon-angle-right'></span></button>";
                    }
                    btnLast += "<button class='btn btn-default btn-sm' onclick='getrow(" + lastSt + ")'><span class='glyphicon glyphicon-angle-double-right'></span></button>";

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
                            btnIdx += "<button class='btn " + btn + " btn-sm' onclick='getrow(" + st + ")'>" + j + "</button>";
                        }
                    } else {
                        for (var j = 1; j <= jmlPage; j++) {
                            st = (j * data["limit"]) - data["limit"];
                            if (curSt == st) btn = "btn-success"; else btn = "btn-default";
                            btnIdx += "<button class='btn " + btn + " btn-sm' onclick='getrow(" + st + ")'>" + j + "</button>";
                        }
                    }
                    pagination += btnFirst + btnIdx + btnLast;
                    $('#pagination').html(pagination);
                }
            }
        }
    });
}