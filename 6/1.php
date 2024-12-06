<?php
//'....#.....',
$grid = [
'....#.....',
'.........#',
'..........',
'..#.......',
'.......#..',
'..........',
'.#..^.....',
'........#.',
'#.........',
'......#...'];

$grid = [
'....#.....',
'.........#',
'..........',
'..#.......',
'.......#..',
'..........',
'.#..^.....',
'........#.',
'#.........',
'......#...'];

/*
$grid = file_get_contents('input.txt');
$grid = explode("\n",$grid);
array_pop($grid);
 */

//count the number of grid spaces we have touched
$spotsTouched = array();

$startDirection = 'up';
$startPos = findStart($grid, $startDirection);

//replace the start position  with a period

$go = $startDirection;
$iterations = 0;
$pos = $startPos;

$spotsTouched[
	strval(strval($pos[0]).".".strval($pos[1]))
             ] = 1;


while (1==1) {
        $prevPos = $pos;
        $pos = findNext($pos,$go);
        if ($pos == false) {
	}
        //print_r($pos);
	$val = substr($grid[$pos[0]],$pos[1],1);
	//print $val;
        if ($val == '.' || $val == '^') {
            //direction doesn't change. 
           $iterations++; 
           //$spotsTouched[strval($pos[0].$pos[1])] = 1;
	   $spotsTouched[strval(strval($pos[0]).".".strval($pos[1]))] = 1;
	} elseif ($val == '#') {
            //change direcction
	    $go = getNewDirection($go);
            $pos = $prevPos;
            //print "changing direction at iteration ". $iterations;
            //print ". new direction is ". $go;
	    //print ". pos is now ". print_r($pos,1)."\n";
	} else {
              //we are DONE
	      //print "WE AARE DONE: at ". print_r($pos,1)."\n";
	   break;
	}
	 if ($iterations> 200000) break;
}
print "\n";
print "iterations were ". $iterations;
print "\n";
print "spots touched were ". count($spotsTouched)."\n";

function getNewDirection($dir) {
    if ($dir == 'up') return 'right';
    if ($dir == 'right') return 'down';
    if ($dir == 'down') return 'left';
    if ($dir == 'left') return 'up';
}

function findNext($curPos, $direction) {
     global $grid;

     $dirs = 
	[
           'up' => [-1,0],
	   'right' => [0,1],
	   'down' =>[1,0],
	   'left' => [0,-1]
        ];

        //curpos is [X,Y]
	$nextPos = [$curPos[0]+$dirs[$direction][0],  $curPos[1]+$dirs[$direction][1]];
        //check to see next position exists
	//if (in_array(substr($grid[$nextPos[0]],$nextPos[1],1),['.','#','^'])) {
               return $nextPos;
//	} else {
 //          return false;
//	}
}




function findStart($grid) {
  foreach ($grid as $key=>$row) {
       $loc = strpos($row,'^');
       if ($loc !== false) return [$key,$loc];
  }
}

findStart($grid);
