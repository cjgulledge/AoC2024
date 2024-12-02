<?php
$list = file_get_contents('list.txt');
$data = explode("\n",$list);
$lista=[];
$listb=[];

foreach ($data as $key=>$val) {
   $vals = explode("\t",$val);
    if ($vals[0]) {
    $lista[] = $vals[0]; 
    $listb[] = $vals[1]; 
   }
}
sort($lista);
sort($listb);

$distance = 0;
foreach($lista as $key=>$val) {

    $vala = $lista[$key];
    $valb = $listb[$key];

    if ($vala > $valb) {
      //print "$vala - $valb\n";
      $distance += $vala - $valb;
    } else {
      $distance += $valb - $vala;
    }
}
print $distance;
