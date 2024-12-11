<?php

//$input = "0 1 10 99 999";
//$input = "125 17";
$input = "70949 6183 4 3825336 613971 0 15 182";

$input = explode(" ",$input);

for ($i = 1; $i <= 25; $i++) { 
    $newInput =  array();
    foreach ($input as $key=>$val) {
	$newVals = applyRules($val);
        foreach($newVals as $vkey=>$vVal) {
	    array_push($newInput, $vVal);
	}
    }
    $input = $newInput;   

}

//print "now last: \n";
//print_r($newInput); 
print "there are ". count($newInput)." stones\n";




function applyRules($num) {
   if ($num == 0) {    
        return [1];
    }
    if(strlen((string)$num) % 2 == 0){   
         return splitInteger($num);
    }
    return [$num*2024];
}


function splitInteger($num) {
    // Convert the number to a string
    $numStr = strval($num);
    // Find the middle index
    $midIndex = floor(strlen($numStr) / 2);
    // Split the string into two parts
    $firstHalf = intval(substr($numStr, 0, $midIndex));
    $secondHalf = intval(substr($numStr, $midIndex));
    return [$firstHalf, $secondHalf];
}
