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
                        '<img src="' + base_url + 'uploads/media/thumb/' + image[0] + '" class=\'img img-responsive img-rounded\' alt = "Avatar" style = "width:100%" >' +
                        '<div class="card-body">' +
                        '<div class=\'tanggal\'>' + tglpublish + '</div>' +
                        '<h4><a href="' + base_url + row[i]["content_link"] + '" class="link">' + row[i]["content_judul"] + '</a></h4>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                    if (start % 3 == 0) tabel += "<div class='row'></div>"

                }
                //console.log(tabel);
                $('#list-berita').html(tabel);

            }
        }
    });
}