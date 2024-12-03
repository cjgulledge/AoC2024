<?php

$data = file_get_contents('input.txt');
$pattern = '/mul\((\d+),(\d+)\)/';
preg_match_all($pattern, $data, $matches);

$total = 0;
foreach($matches[0] as $val) {
    $nums = test($val);
    $total += intval($nums[0]) * intval($nums[1]); 
}
print $total;

function test($blah) {
   $test = explode(",",str_replace(array("mul(",")"), '',$blah));
   return $test;
}
