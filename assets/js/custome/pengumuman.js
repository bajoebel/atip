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
                    tabel += '<div class="col-md-4">' +
                        '<img src="' + base_url + 'uploads/media/thumb/' + image[0] + '" alt="" class=" img-thumb-content img img-responsive img-rounded" >' +
                        '<div class=\'tanggal\'>' + tglpublish + '</div>' +
                        '<div class="judul-headline"><a href="' + base_url + row[i]["content_link"] + '" class="link">' + row[i]['content_judul'] + '</a></div>' +
                        '</div>';
                    if(start%3==0) tabel+= "<div class='row'></div>"
                    
                }
                $('#list-pengumuman').html(tabel);
                
            }
        }
    });
}