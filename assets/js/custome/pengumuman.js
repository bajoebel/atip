getPengumuman(0);
function getPengumuman(start=0) {
    $('#start').val(start);
    var search = $('#q').val();
    var active = "class='btn btn-primary btn-sm'";
    var url = base_url + "welcome/datapengumuman/"+start;
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
                var image='';
                var string;
                var start=0;
                var tglpublish;
                var tgl;
                var bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                //Create Tabel
                for (var i = 0; i < jmlData; i++) {
                    start++;
                    string = row[i]['content_thumb'];
                    image=string.split(',',4);
                    tglpublish = row[i]["content_tglpublish"];
                    tgl = tglpublish.split('-', 3);
                    if (tgl.length == 3) {
                        tglpublish = tgl[2] + " " + bulan[parseInt(tgl[1])] + " " + tgl[0];
                    }
                    console.log(image);
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
                    if(start%3==0) tabel+= "<div class='row'></div>"
                    
                }
                $('#list-pengumuman').html(tabel);
                
            }
        }
    });
}