<?php

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
    // Parse the input line
    // Format: "TARGET: n1 n2 n3 ..."
    list($targetPart, $numbersPart) = explode(':', $line, 2);
    $target = (int)trim($targetPart);
    $numbers = array_map('intval', explode(' ', trim($numbersPart)));

    // If there's only one number, just check it directly
    if (count($numbers) == 1) {
        if ($numbers[0] === $target) {
            $total_sum += $target;
        }
        continue;
    }

    $numCount = count($numbers);
    $operatorCount = $numCount - 1;

    // Operators set: '+', '*', '||'
    $ops = ['+', '*', '||'];

    $found = false;
    // Total combinations: 3^(operatorCount)
    $maxCombinations = pow(3, $operatorCount);

    for ($i = 0; $i < $maxCombinations && !$found; $i++) {
        // Determine operators for this combination
        // We can think of $i in base-3 to pick operators.
        $currentOps = [];
        $temp = $i;
        for ($j = 0; $j < $operatorCount; $j++) {
            $currentOps[] = $ops[$temp % 3];
            $temp = intdiv($temp, 3);
        }

        // Evaluate left-to-right
        $result = $numbers[0];
        for ($k = 0; $k < $operatorCount; $k++) {
            $op = $currentOps[$k];
            $nextNum = $numbers[$k + 1];

            if ($op === '+') {
                $result = $result + $nextNum;
            } elseif ($op === '*') {
                $result = $result * $nextNum;
            } elseif ($op === '||') {
                // Concatenate as strings
                $result = (int)($result . $nextNum);
            }
        }

        if ($result === $target) {
            $found = true;
        }
    }

    if ($found) {
        $total_sum += $target;
    }
}

echo $total_sum . "\n";
