<?php
error_reporting(E_ERROR | E_PARSE);

$data = file_get_contents('input.txt');
$pattern = $pattern = '/(do\(\)|don\'t\(\)|mul\((\d+),(\d+)\))/';
preg_match_all($pattern, $data, $matches);


$process = true;
$total =0;
foreach ($matches[0] as $val) {
    if ($val == "don't()") $process = false;
    if ($val == "do()") 
    {
         $process = true;
	 continue;
    }

    if ($process == true) {
        $nums = test($val);
	$total += intval($nums[0]) * intval($nums[1]); 
    }
}
print $total;
print "\n";


function test($blah) {
   $test = explode(",",str_replace(array("mul(",")"), '',$blah));
   return $test;
}
