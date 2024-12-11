<?php

function parseMap($input) {
    $map = array_map('str_split', explode("\n", trim($input)));
    return array_map(function($row) {
        return array_map('intval', $row);
    }, $map);
}

function isTrailhead($map, $x, $y) {
    return $map[$y][$x] === 0;
}

function countDistinctTrails($map, $x, $y, $height = 0, $visited = []) {
    $width = count($map[0]);
    $heightMap = count($map);

    // Base cases
    if ($x < 0 || $x >= $width || $y < 0 || $y >= $heightMap || $map[$y][$x] !== $height || isset($visited["$x,$y"])) {
        return 0;
    }

    if ($map[$y][$x] === 9) {
        return 1; // Reached a distinct trail end
    }

    $visited["$x,$y"] = true;
    $nextHeight = $height + 1;
    $distinctTrails = 0;

    // Explore all 4 possible directions (up, down, left, right)
    foreach ([[-1, 0], [1, 0], [0, -1], [0, 1]] as $dir) {
        $nx = $x + $dir[0];
        $ny = $y + $dir[1];
        $distinctTrails += countDistinctTrails($map, $nx, $ny, $nextHeight, $visited);
    }

    return $distinctTrails;
}

function calculateTrailheadRatings($map) {
    $ratings = [];
    for ($y = 0; $y < count($map); $y++) {
        for ($x = 0; $x < count($map[$y]); $x++) {
            if (isTrailhead($map, $x, $y)) {
                $ratings[] = countDistinctTrails($map, $x, $y);
            }
        }
    }
    return $ratings;
}

$input = file_get_contents('input.txt');
$map = parseMap($input);
$ratings = calculateTrailheadRatings($map);
echo "Trailhead ratings: " . implode(", ", $ratings) . PHP_EOL;
echo "Sum of ratings: " . array_sum($ratings) . PHP_EOL;
?>
