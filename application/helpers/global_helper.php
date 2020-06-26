<?php 
function longdate($date){
    $exp1 = explode(' ',$date);
    $exp2 = explode('-', $exp1[0]);
    if(count($exp1)>1){
        if(count($exp2)!=3) return false;
    }
    $bulan=array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
    return $exp2[2] ." " .$bulan[intval($exp2[1])] ." " .$exp2[0];
}
function getHari($tgl){
    $hari = array(
        'Sunday' => 'Minggu',
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu'

    );
    $enghari = date('l', strtotime($tgl));
    return $hari[$enghari];
}
?>