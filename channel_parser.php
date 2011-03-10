<?php

require './show.class.php';

$data = file_get_contents('./data/26.dat');

$lines = explode("\n", $data);

$all_shows = array();

foreach ($lines as $line)
{
	$fields = explode("~", $line);
	if ( count($fields) != 23) { continue; }
	
	$s = new Show($fields);
	$all_shows[] = $s;
}

foreach ($all_shows as $s)
{
	echo $s;
}
