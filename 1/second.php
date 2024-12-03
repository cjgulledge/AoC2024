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

$countArray = array_count_values($listb);

$runningTotal = 0;
foreach ($lista as $key=>$val) {
   //see if its in valb
   $count = isset($countArray[$val]) ? $countArray[$val] : 0;

   if ($count > 0) {
     $runningTotal += $val * $count;
   }
   
}

print $runningTotal."\n";
