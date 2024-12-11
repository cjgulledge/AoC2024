<?php

function applyRules($num) {
    // Apply transformation rules to a number
    if ($num == 0) {
        return [1];
    }
    if (strlen((string)$num) % 2 == 0) {
        return splitInteger($num);
    }
    return [$num * 2024];
}

//i think this is more performant than what I did for part 1 of this puzzle
function splitInteger($num) {
    // Split a number into two halves
    $numStr = (string)$num;
    $midIndex = intdiv(strlen($numStr), 2);
    $firstHalf = (int)substr($numStr, 0, $midIndex);
    $secondHalf = (int)substr($numStr, $midIndex);
    return [$firstHalf, $secondHalf];
}

function processNumbers($initialNumbers, $maxIterations) {
    // Use array to count occurrences of numbers
    $currentNumbers = array_count_values($initialNumbers); // PHP equivalent to Counter

    for ($iteration = 1; $iteration <= $maxIterations; $iteration++) {
        echo "Iteration $iteration... Processing " . array_sum($currentNumbers) . " numbers.\n";
        $nextNumbers = [];

        // Process each number and its count
        foreach ($currentNumbers as $num => $count) {
            $results = applyRules((int)$num);
            foreach ($results as $result) {
                if (!isset($nextNumbers[$result])) {
                    $nextNumbers[$result] = 0;
                }
                $nextNumbers[$result] += $count;
            }
        }

        // Update for the next iteration
        $currentNumbers = $nextNumbers;
    }

    // Final count of numbers
    return array_sum($currentNumbers);
}

// Initial input and parameters
$input = [70949, 6183, 4, 3825336, 613971, 0, 15, 182]; // Single starting number
$maxIterations = 75;

// Run the process
$resultCount = processNumbers($input, $maxIterations);
echo "There are $resultCount stones after $maxIterations iterations.\n";

