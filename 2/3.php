<?php
error_reporting(E_ERROR | E_PARSE);

// Read the input file and split into rows
$nums = file_get_contents('input.txt');
$rows = explode("\n", $nums);

// Initialize a counter for safe reports
$safeCount = 0;

// Iterate over each row
foreach ($rows as $key => $val) {
    // Skip empty lines (e.g., last line if it's empty)
    if (trim($val) === '') continue;
    
    // Convert the row into an array of integers
    $rowvals = array_map('intval', explode(" ", $val));
    
    // Validate the report
    if (validateReportWithDampener($rowvals)) {
        // Uncomment the following line to print which reports are safe
        // echo "$key Report is safe\n";
        $safeCount++;
    }
}

// Print the total number of safe reports
print "$safeCount reports were safe.\n";

function validateReport($arr) {
    if (count($arr) < 2) return true; // If there's only one level, it's trivially safe

    $increasing = true;
    $decreasing = true;
    
    // Iterate through the array and check the conditions
    for ($i = 1; $i < count($arr); $i++) {
        $diff = abs($arr[$i] - $arr[$i - 1]);
        
        // If the difference is not between 1 and 3, report is unsafe
        if ($diff > 3 || $diff == 0) return false;
        
        // Determine if the sequence is increasing or decreasing
        if ($arr[$i] > $arr[$i - 1]) {
            $decreasing = false;
        } elseif ($arr[$i] < $arr[$i - 1]) {
            $increasing = false;
        }
        
        // If both increasing and decreasing flags are false, report is unsafe
        if (!$increasing && !$decreasing) return false;
    }
    
    return true;
}

function validateReportWithDampener($arr) {
    // First, check if the report is already safe
    if (validateReport($arr)) {
        return true;
    }

    // If not, try removing each level one by one and check if it becomes safe
    for ($i = 0; $i < count($arr); $i++) {
        $tempArr = $arr;
        array_splice($tempArr, $i, 1); // Remove the i-th element
        if (validateReport($tempArr)) {
            return true;
        }
    }

    return false;
}
