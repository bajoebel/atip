getComent();
function getComent() {
    var id_post=$('#idx').val();
    
    var url = base_url + "welcome/coment/" + id_post;
    console.clear();
    console.log(url);
    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
        data: { get_param: 'value' },
        success: function (data) {
            //menghitung jumlah data
            
            console.log(data);
            if (data["status"] == true) {
                var row = data["data"];
                var jmlData = row.length;
                var tabel="";
                for (var i = 0; i < jmlData; i++) {
                    tabel += '<div class="comment"><label>Oleh : '+row[i]["nama"]+'</label><br><br>'+row[i].komentar+'</div>';
                }
                //console.log(tabel);
                $('#komentar').html(tabel);
                if (jmlData > 0) $('#label-komentar').show();
                
            }
        }
    });
}
function postKomentar(){
    var formData = new FormData($('#form')[0]);
    var url=base_url+"welcome/postkomentar";
    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'JSON',
        success: function (data) {
            if (data["status"] == true) {
                $('#csrf').val(data["csrf"]);
                $('#email').val("");
                $('#website').val("");
                $('#nama').val("");
                $('#isi_komentar').val("");
                getComent();
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