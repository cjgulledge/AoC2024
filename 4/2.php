<?php
error_reporting(E_ERROR | E_PARSE);
function findXmas($grid) {
    $count = 0;
    $rows = count($grid);
    $cols = strlen($grid[0]);

    // Define the directions for the X pattern:
    $directions1 = [
        [-1, -1], // up-left
        [1, 1]    // down-right
    ];

    $directions2 = [
        [-1, 1],  // up-right
        [1, -1]   // down-left
    ];

    // Iterate through each cell in the grid
    for ($i = 0; $i < $rows; $i++) {
        for ($j = 0; $j < $cols; $j++) {
            if ($i == 0) continue; // we aren't worried about row zero
            if ($grid[$i][$j] == 'A') { // Check if current cell is 'A'
                  $matches = 0; //
                  //print "found a at ". $i." ". $j."\n";
                  $upleft = $grid[$i+$directions1[0][0]][$j+$directions1[0][1]];
                  $downright = $grid[$i+$directions1[1][0]][$j+$directions1[1][1]];
                  if ($upleft == "M" && $downright == "S" || $upleft == "S" && $downright == "M") $matches++;

                  $upright = $grid[$i+$directions2[0][0]][$j+$directions2[0][1]];
                  $downleft = $grid[$i+$directions2[1][0]][$j+$directions2[1][1]];
                  if ($upright == "M" && $downleft == "S" || $upright == "S" && $downleft == "M") $matches++;

		  if ($matches == 2) $count++;
                   
            }
        }
    }

    return $count;
}
$gridData = file_get_contents('input.txt');
$grid = explode("\n",$gridData);
array_pop($grid);

echo findXmas($grid); // Output the number of X-MAS patterns found

?>

