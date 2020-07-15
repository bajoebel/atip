<?php
//print_r($header);
//echo "<br>";
//print_r($data_form) ;

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
            ?>
        </tr>
    </thead>
    <tbody>
        
        <?php 
        
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
                ?>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>