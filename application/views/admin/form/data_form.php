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
            if($header->form_lampiran!="" || $header->form_lampiran!=null){
                echo "<th style='width:250px'>Lampiran</th>";
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
                if ($header->form_lampiran != "" || $header->form_lampiran != null) {
                    if(empty($row->isi_lampiran)) echo "<td>Tidak Ada Lampiran</td>";
                    else{
                        $lampiran=explode(',', $row->isi_lampiran);
                        $link="";
                        $i=0;
                        $namalampiran =explode(',',$header->form_lampiran);
                        $idx=0;
                        foreach ($lampiran as $l ) {
                            $i++;
                            $link.= "<a href='" . base_url() . "uploads/lampiran/" . $l . "' class='btn btn-success btn-xs' target='_blank'><span class='fa fa-search'></span> ".$namalampiran[$idx]."</a> &nbsp;";
                            $idx++;
                        }
                        echo "<td>$link</td>";
                    }
                }
                ?>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>