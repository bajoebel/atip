getPortofolio(0);
function getPortofolio(start=0) {
    $('#start').val(start);
    var search = $('#q').val();
    var active = "class='btn btn-primary btn-sm'";
    var url = base_url + "welcome/dataportofolio/"+start;
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
                //Create Tabel
                for (var i = 0; i < jmlData; i++) {
                    start++;
                    string = row[i]['content_thumb'];
                    image=string.split(',',4);
                    console.log(image);
                    if (image.length==3){
                        tabel += '<div class="col-md-4">' +
                            '<div class="thumb">' +
                            '<div class="main-thumb">' +
                            '<img src="' + base_url + 'uploads/media/thumb/' + image[0] +'" alt="" class="main-image" >' +
                            '</div>' +
                            '<div class="right-thumb">' +
                            '<img src="' + base_url + 'uploads/media/icon/' + image[1] +'" alt="" class="radius-top-right">' +
                            '<img src="' + base_url + 'uploads/media/icon/' + image[2] +'" alt="" class="radius-bottom-right">' +
                            '</div>' +
                            '</div >' +
                            '<div class="thumb-title"><a href="'+base_url+row[i]["content_link"]+'" class="link">'+row[i]["content_judul"]+'</a></div>' +
                            '</div>';
                    } else if (image.length == 2){
                        tabel += '<div class="col-md-4">' +
                            '<div class="thumb">' +
                            '<img src="' + base_url + 'uploads/media/thumb/' + image[0] +'" alt="" class="half-image" >' +
                            '<img src="' + base_url + 'uploads/media/thumb/' + image[1] +'" alt="" class="radius-right" >' +
                            '</div >' +
                            '<div class="thumb-title"><a href="'+base_url+row[i]["content_link"]+'" class="link">' + row[i]['content_judul'] +'</a></div>' +
                            '</div>';
                    }else{
                        tabel += '<div class="col-md-4">' +
                            '<img src="' + base_url + 'uploads/media/thumb/' + image[0] + '" alt="" class="full-image" >' +
                            '<div class="thumb-title"><a href="'+base_url+row[i]["content_link"]+'" class="link">'+row[i]['content_judul']+'</a></div>' +
                            '</div>';
                    }
                    if(start%3==0) tabel+= "<div class='row'></div>"
                    
                }
                $('#list-portofolio').html(tabel);
                
            }
        }
    });
}