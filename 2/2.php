<?php
error_reporting(E_ERROR | E_PARSE);
$nums = file_get_contents('input.txt');
$rows = explode("\n",$nums);
array_pop($rows); // remove last array entry since its empty anyway

    $cnt = 0;
foreach ($rows as $key=>$val) {
   $rowvals = explode(" ",$val);
   for ($i=0; $i < count($rowvals);$i++) {
      $copy = $rowvals;
    
    unset($copy[$i]); 
    $copy = array_values($copy);
    if (validateReport($copy)) {
        echo $key." Report is safe\n";
        $cnt++;
        continue(2);
    } else {
//        echo "Report is unsafe\n";
    }

   }
}
print $cnt."reports were safe.\n";

function validateReport($arr) { 
        $increasing = false;
	$decreasing = false;
        
	if ($arr[1] < $arr[0]) {
	   $decreasing = true;
	} elseif ($arr[1] > $arr[0]) {
	   $increasing = true;
	} else {
           return false; // first two numbers were the same. this report is invalid 
	}
	foreach ($arr as $key=>$val) {
             if($key >0) {
		     $lastkey = $key-1;
	//	     print $val." - ". $arr[$key-1]." = ";
		     $diff = abs(intval($val) - intval($arr[$lastkey]));
	//	     print $diff."\n";
		     if ($diff > 3 || $diff < 1) return false;
                     if ($arr[$lastkey] < $val) {
			    $decreasing = false;
		     }
		     if ($arr[$lastkey] > $val) {
			   $increasing = false;
		     }
		     if ($increasing == false && $decreasing == false) return false;
	     }
	}
	return true;
die;
}
