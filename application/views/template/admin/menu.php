<?php 
$menu='<li class="xn-title">Navigation</li>';
$menu.='<li>';
$menu.='<a href="' .base_url() .'admin/dashboard">';
$menu.='<i class="fa fa-home"></i> <span>Home</span>';
$menu.='<span class="pull-right-container">';
$menu.='<small class="label pull-right bg-orange">new</small>';
$menu.='</span>';
$menu.='</a>';
$menu.='</li>';
$i=0;
//echo $buka;exit;
foreach ($menu_data as $m ) {
    if($buka==$m->induk_id) $open='active';
    else $open="";
    
    if($link==$m->link) $link1='active';
    else $link1='';
    if($i==0){
        //echo $m->induk_nama . " " . $open . "<br>";
        $menu.="<li class=\"xn-openable ".$open."\">";
        $menu.="<a href=\"#\"><i class=\"".$m->induk_icon."\"></i>" .$m->induk_nama ."</a>";
        $menu.="<ul>";
        $menu.="<li class='" .$link1. "'><a href=\"" . base_url() ."admin/" .$m->link."\"><span class=\"fa fa-circle-o\"></span>".$m->nama_modul."</a></li>";
        $induk=$m->induk_nama;
    }else{
        if($induk==$m->induk_nama){
            
            if($i-1==$jmlData){
                
            $menu.= "<li class='xn-openable " . $open . "'>
            <a href=\"".base_url()."admin/".$m->link."\"><span class=\"fa fa-circle-o\"></span>".$m->nama_modul ." </a></li>";
            $menu.="</ul></li>";
            
            }else{
                //echo $m->induk_nama . " " . $open . "<br>";
            $menu.= "<li class='" . $link1 . "'><a href=\"".base_url()."admin/".$m->link."\"><span class=\"fa fa-circle-o\"></span>".$m->nama_modul."</a></li>";
            //alert("INDUK LAMA ".induk." INDUK : ".$m->induk_nama." ANAK NAMA: ".$m->nama_modul);
            }
            $induk=$m->induk_nama;
        }else{
            //alert("BEDA INDUK LAMA ".induk." INDUK : ".$m->induk_nama." ANAK NAMA: ".$m->nama_modul);
            $menu.="</ul></li>";
            if($i-1==$jmlData){
            
            $menu.= "<li class='xn-openable " . $open . "' >";
            $menu.="<a href=\"#\"><i class=\"".$m->induk_icon."\"></i>" .$m->induk_nama  ."</a>";
            $menu.="<ul class=\"".$open."\">'";
            $menu.= "<li class='" . $link1 . "'><a href=\"".base_url()."admin/".$m->link."\"><span class=\"fa fa-circle-o\"></span>".$m->nama_modul."</a></li>";
            
            }else{
                //echo $open ."<br>";
                if($open=="active") $menu.="<li class=\"xn-openable active\">";
                else $menu .= "<li class=\"xn-openable\">";
            $menu.="<a href=\"#\"><i class=\"".$m->induk_icon."\"></i>" .$m->induk_nama  ."</a>";
            $menu.="<ul >'";
            $menu.= "<li class='" . $link1 . "'><a href=\"".base_url()."admin/".$m->link."\"><span class=\"fa fa-circle-o\"></span>".$m->nama_modul."</a></li>";
            $induk=$m->induk_nama;
            }
        }
    
    }
    $i++;
}
echo $menu ."</ul></li>";
?>