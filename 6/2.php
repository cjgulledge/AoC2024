<?php
$day = 6;

// Read the input file
$dat = @file('input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
if ($dat === false) {
    die("Error: Unable to read input file.\n");
}

$grid = array_map('str_split', $dat);

// Part 1
$start = null;
foreach ($grid as $x => $row) {
    foreach ($row as $y => $cell) {
        if ($cell === '^') {
            $start = [$x, $y];
            break 2;
        }
    }
}

$dxy = [
    [-1, 0],
    [0, 1],
    [1, 0],
    [0, -1]
];

function sim($start, $grid) {
    global $dxy;
    $d = 0;
    $pos = [];
    $pos[implode(',', $start)] = true;
    [$x, $y] = $start;

    while (true) {
        $nx = $x + $dxy[$d][0];
        $ny = $y + $dxy[$d][1];

        if ($nx < 0 || $nx >= count($grid) || $ny < 0 || $ny >= count($grid[0])) {
            break;
        }

        if ($grid[$nx][$ny] === '#') {
            $d = ($d + 1) % 4;
            continue;
        }

        $x = $nx;
        $y = $ny;
        $pos["$nx,$ny"] = true;
    }

    return $pos;
}

$path = sim($start, $grid);
print count($path) . "\n";

// Part 2
function sim2($start, $grid) {
    global $dxy;
    $d = 0;
    $pos = [];
    $pos[implode(',', array_merge($start, [$d]))] = true;
    [$x, $y] = $start;
    $inf = false;

    while (true) {
        $nx = $x + $dxy[$d][0];
        $ny = $y + $dxy[$d][1];

        if ($nx < 0 || $nx >= count($grid) || $ny < 0 || $ny >= count($grid[0])) {
            break;
        }

        if ($grid[$nx][$ny] === '#') {
            $d = ($d + 1) % 4;
            continue;
        }

        $x = $nx;
        $y = $ny;

        $key = "$nx,$ny,$d";
        if (isset($pos[$key])) {
            $inf = true;
            break;
        }

        $pos[$key] = true;
    }

    return [$pos, $inf];
}

$c = 0;
$path = sim($start, $grid);

foreach ($path as $key => $value) {
    [$x, $y] = explode(',', $key);
    if ($grid[$x][$y] !== '.') {
        continue;
    }

    $t_grid = $grid;
    $t_grid[$x][$y] = '#';

    if (sim2($start, $t_grid)[1]) {
        $c++;
    }
}

print $c . "\n";

