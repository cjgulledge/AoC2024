<?php

 function gcd($a, $b) {
        $a = abs($a); $b = abs($b);
        while ($b != 0) {
            $t = $a % $b;
            $a = $b;
            $b = $t;
        }
        return $a;
 }

function solve($lines) {
    // Read the lines into a 2D grid
    $grid = array_map('str_split', $lines);
    $rows = count($grid);
    $cols = count($grid[0]);

    // Collect antenna positions by frequency
    $antennas = [];
    for ($r = 0; $r < $rows; $r++) {
        for ($c = 0; $c < $cols; $c++) {
            $ch = $grid[$r][$c];
            if ($ch !== '.') {
                $antennas[$ch][] = [$r, $c];
            }
        }
    }

     $antinode_positions = [];

    // For each frequency, consider all pairs of antennas
    foreach ($antennas as $freq => $positions) {
        $count = count($positions);
        if ($count < 2) {
            // Only one antenna, no line, no antinodes from this frequency
            continue;
        }

        for ($i = 0; $i < $count; $i++) {
            for ($j = $i + 1; $j < $count; $j++) {
                list($x1, $y1) = $positions[$i];
                list($x2, $y2) = $positions[$j];

                $dx = $x2 - $x1;
                $dy = $y2 - $y1;

                // Reduce to smallest step
                $g = gcd($dx, $dy);
                $sx = $dx / $g;
                $sy = $dy / $g;

                // We have a line: (x, y) = (x1 + n*sx, y1 + n*sy)
                // Find range of n to keep (x,y) inside the grid

                // To avoid division by zero, handle special cases:
                if ($sx == 0 && $sy == 0) {
                    // This would only happen if the two antennas are at the same point
                    // Not a realistic scenario given distinct antennas, but just in case:
                    if ($x1 >= 0 && $x1 < $rows && $y1 >= 0 && $y1 < $cols) {
                        $antinode_positions["$x1,$y1"] = true;
                    }
                    continue;
                }

                // Determine n range from row bounds:
                $n_min_row = PHP_INT_MIN;
                $n_max_row = PHP_INT_MAX;
                if ($sx != 0) {
                    if ($sx > 0) {
                        $n_min_row = max($n_min_row, ceil((0 - $x1) / $sx));
                        $n_max_row = min($n_max_row, floor(($rows - 1 - $x1) / $sx));
                    } else { // sx < 0
                        $n_min_row = max($n_min_row, ceil(($rows - 1 - $x1) / $sx));
                        $n_max_row = min($n_max_row, floor((0 - $x1) / $sx));
                    }
                } else {
                    // sx == 0 means x1 is fixed
                    if ($x1 < 0 || $x1 >= $rows) {
                        // line does not intersect grid rows at all
                        continue;
                    }
                    // No vertical movement, so no restriction on n from rows dimension directly
                    // except that x1 must be in range
                }

                // Determine n range from column bounds:
                $n_min_col = PHP_INT_MIN;
                $n_max_col = PHP_INT_MAX;
                if ($sy != 0) {
                    if ($sy > 0) {
                        $n_min_col = max($n_min_col, ceil((0 - $y1) / $sy));
                        $n_max_col = min($n_max_col, floor(($cols - 1 - $y1) / $sy));
                    } else { // sy < 0
                        $n_min_col = max($n_min_col, ceil(($cols - 1 - $y1) / $sy));
                        $n_max_col = min($n_max_col, floor((0 - $y1) / $sy));
                    }
                } else {
                    // sy == 0 means y1 is fixed
                    if ($y1 < 0 || $y1 >= $cols) {
                        // line does not intersect grid columns at all
                        continue;
                    }
                    // No horizontal movement, so no restriction on n from columns dimension
                }

                // Combine the row and column constraints
                $n_start = max($n_min_row, $n_min_col);
                $n_end = min($n_max_row, $n_max_col);

                // If sx == 0 or sy == 0, we didn't fully define the constraints above:
                // Handle those cases properly:
                if ($sx == 0) {
                    // Vertical line: x = x1 fixed. Just vary y
                    // 0 <= y1 + n*sy < cols
                    if ($sy > 0) {
                        $n_start = max($n_start, ceil((0 - $y1) / $sy));
                        $n_end = min($n_end, floor(($cols - 1 - $y1) / $sy));
                    } else if ($sy < 0) {
                        $n_start = max($n_start, ceil(($cols - 1 - $y1) / $sy));
                        $n_end = min($n_end, floor((0 - $y1) / $sy));
                    } else {
                        // This would mean dx=0, dy=0 again handled above.
                    }
                }

                if ($sy == 0) {
                    // Horizontal line: y = y1 fixed. Just vary x
                    // 0 <= x1 + n*sx < rows
                    if ($sx > 0) {
                        $n_start = max($n_start, ceil((0 - $x1) / $sx));
                        $n_end = min($n_end, floor(($rows - 1 - $x1) / $sx));
                    } else if ($sx < 0) {
                        $n_start = max($n_start, ceil(($rows - 1 - $x1) / $sx));
                        $n_end = min($n_end, floor((0 - $x1) / $sx));
                    }
                }

                // If $n_start > $n_end, no valid points
                if ($n_start > $n_end) {
                    // No valid intersection with the grid
                    continue;
                }

                // Iterate over all n in the range and record points
                for ($n = $n_start; $n <= $n_end; $n++) {
                    $X = $x1 + $n*$sx;
                    $Y = $y1 + $n*$sy;
                    // Double-check bounds
                    if ($X >= 0 && $X < $rows && $Y >= 0 && $Y < $cols) {
                        $antinode_positions["$X,$Y"] = true;
                    }
                }
            }
        }
    }

    // Count unique antinode positions
    return count($antinode_positions);
}

// Example usage with the updated scenario.
// Replace $input with your puzzle input lines.
$input = [
    "............",
    "........0...",
    ".....0......",
    ".......0....",
    "....0.......",
    "......A.....",
    "............",
    "............",
    "........A...",
    ".........A..",
    "............",
    "............"
];
$input  = explode("\n",trim(file_get_contents('input.txt')));
$result = solve($input);
echo $result, "\n";
