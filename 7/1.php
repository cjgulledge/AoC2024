<?php

// Sample input as given in the puzzle description.
// Normally, you might read from a file or STDIN. Ensure each line is in the format:
// "<target>: <num1> <num2> <num3> ..."
// If reading from a file, you might do something like:
// $lines = file('input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$input = <<<INPUT
190: 10 19
3267: 81 40 27
83: 17 5
156: 15 6
7290: 6 8 6 15
161011: 16 10 13
192: 17 8 14
21037: 9 7 18 13
292: 11 6 16 20
INPUT;


$input = file_get_contents('input.txt');

$lines = explode("\n", trim($input));

$total_sum = 0;

foreach ($lines as $line) {
    // Parse the line
    // Format: "<target>: <n1> <n2> <n3> ..."
    // Example: "190: 10 19"
    list($targetPart, $numbersPart) = explode(':', $line, 2);
    $target = (int)trim($targetPart);
    $numbers = array_map('intval', explode(' ', trim($numbersPart)));
    
    // If there's only one number, just check directly
    if (count($numbers) == 1) {
        if ($numbers[0] === $target) {
            $total_sum += $target;
        }
        continue;
    }

    $numCount = count($numbers);
    $operatorCount = $numCount - 1; // positions where operators can be placed (+ or *)
    
    // We'll brute force all combinations of operators.
    // For each position, we can have either '+' or '*'.
    // That's 2^(operatorCount) combinations.
    
    $found = false;
    $maxCombinations = 1 << $operatorCount; // 2^(operatorCount)
    
    for ($mask = 0; $mask < $maxCombinations; $mask++) {
        // Build the sequence of operations
        // 0 bit => '+', 1 bit => '*'
        $value = $numbers[0];
        for ($i = 0; $i < $operatorCount; $i++) {
            $op = (($mask >> $i) & 1) ? '*' : '+';
            $nextNum = $numbers[$i + 1];
            // Evaluate step by step (left-to-right)
            if ($op === '+') {
                $value = $value + $nextNum;
            } else {
                $value = $value * $nextNum;
            }
        }
        
        if ($value === $target) {
            $found = true;
            break; // No need to check other combinations once found
        }
    }
    
    if ($found) {
        $total_sum += $target;
    }
}

echo $total_sum . "\n";
