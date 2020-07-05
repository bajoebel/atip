getBerita(0);
function getBerita(start = 0) {
    var bulan = $('#bulan').val();
    var tahun = $('#tahun').val();
    var url = base_url + "welcome/dataarchive/" + start + "?tahun=" + tahun + "&bulan="+bulan;
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
                var image = '';
                var string;
                var tglpublish;
                var tgl;
                var start = 0;
                //Create Tabel
                var bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
                console.log(bulan);
                for (var i = 0; i < jmlData; i++) {
                    start++;
                    string = row[i]['content_thumb'];
                    image = string.split(',', 4);
                    tglpublish = row[i]["content_tglpublish"];
                    tgl = tglpublish.split('-', 3);
                    if (tgl.length == 3) {
                        tglpublish = tgl[2] + " " + bulan[parseInt(tgl[1])] + " " + tgl[0];
                    }
                    style = 'col-md-4 col-sm-6 col-xs-6';
                    tabel += '<div class="' + style + '">' +
                        '<div class="card">' +
                        '<img src="' + base_url + 'uploads/media/thumb/403X200/_403X200_' + image[0] + '" class=\'img img-responsive img-thumb-content  img-rounded\' alt = "Avatar" style = "width:100%" >' +
                        '<div class="card-body">' +
                        '<div class=\'tanggal\'>' + tglpublish + '</div>' +
                        '<div class="judul-headline"><a href="' + base_url + row[i]["content_link"] + '" class="link">' + row[i]["content_judul"] + '</a></div>' +
                        '</div>' +
                        '</div>' +
                        '</div>'; 
                    if (start % 3 == 0) tabel += "<div class='desktop-sep'></div>"
                    if (start % 2 == 0) tabel += "<div class='mobile-sep'></div>"

                }
                //console.log(tabel);
                $('#list-berita').html(tabel);
                if (data["row_count"] <= limit) {
                    $('#pagination').html("");
                } else {
                    var pagination = "";
                    var btnIdx = "";
                    var next_link = "";
                    var prev_link = "";
                    jmlPage = Math.ceil(data["row_count"] / limit);
                    offset = data["start"] % limit;
                    curIdx = Math.ceil((data["start"] / data["limit"]) + 1);
                    prev = (curIdx - 2) * data["limit"];
                    next = (curIdx) * data["limit"];

                    console.log('Prev ' + prev);
                    console.log('Next ' + next);
                    if (curIdx == 1) {
                        prev_link = '<div class="col-md-6 col-sm-6 col-xs-6 pull-left">&nbsp;</div>'
                        next_link = '<div class="col-md-6 col-sm-6 col-xs-6 pull-right">' +
                            '<a href = "#" class="link" onclick="getBerita(' + next + ')">Selanjutnya >></a>' +
                            '</div>';
                    } else {
                        if (curIdx >= jmlPage) {


                            console.log(jmlPage);
                            console.log(curIdx);
                            prev_link = '<div class="col-md-6 col-sm-6 col-xs-6 pull-left">' +
                                '<a href = "#" class="link" onclick="getBerita(' + prev + ')" ><< Sebelumnya</a>' + '</div>'
                            next_link = '<div class="col-md-6 col-sm-6 col-xs-6 pull-right">&nbsp;</div>';
                        }
                        else {
                            console.log('jml page : ' + jmlPage);
                            console.log('Cur Idx : ' + curIdx);

                            prev_link = '<div class="col-md-6 col-sm-6 col-xs-6 pull-left">' +
                                '<a href = "#" class="link" onclick="getBerita(' + prev + ')" ><< Sebelumnya</a>' + '</div>'
                            next_link = '<div class="col-md-6 col-sm-6 col-xs-6 pull-right">' +
                                '<a href = "#" class="link" onclick="getBerita(' + next + ')">Selanjutnya >></a>' +
                                '</div>';
                        }
                    }
                    pagination = prev_link + next_link;
                    $('#pagination').html(pagination);
                }

            }
        }
    });
}