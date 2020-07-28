<?php
//print_r($header);
//echo "<br>";
//print_r($data_form) ;
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=DATA_ONLINE_" .date('Ymd').".xls");
	header("Pragma: no-cache");
	header("Expires: 0");

$head = json_decode($header->form_field);
//$res = json_decode($data_form[0]->isi_baris);
//print_r($res);

?>
<table class="table table-bordered">
    <thead class="bg-green">
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <?php
            foreach ($head as $h) {
                echo "<th>" . $h->alias . "</th>";
                $val[]=$h->field;
            }
            if($header->form_lampiran!="" || $header->form_lampiran!=null){
                echo "<th>".$header->form_lampiran."</th>";
            }
            ?>
        </tr>
    </thead>
    <tbody>
        
        <?php 
        $start=0;
        foreach ($data_form as $row) {
            $res=json_decode($row->isi_baris);
            $start++;
            ?>
            <tr>
                <td><?= $start ?></td>
                <td><?= $row->isi_tanggal ?></td>
                <?php 
                //print_r($val);
                foreach ($val as $v ) {
                    echo "<td>".$res->$v."</td>";
                }
                if ($header->form_lampiran != "" || $header->form_lampiran != null) {
                    if(empty($row->isi_lampiran)) echo "<td>Tidak Ada Lampiran</td>";
                    else{
                        
                        echo "<td>".$row->isi_lampiran."</td>";
                    }
                }
                ?>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>