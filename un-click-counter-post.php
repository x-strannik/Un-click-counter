<?php
$dwhtxt = $_POST['dnld_href_txt']; 
$dhtxt = trim($dwhtxt);
$filename = __DIR__ . '/calc/' . $dhtxt;
if ( !empty($dhtxt) ) {	
if (file_exists($filename)) {
$count = file_get_contents( $filename);
file_put_contents($filename, ++$count);
echo $count;
} else {
$cnt = 1;
file_put_contents($filename, $cnt);
echo $cnt;
}
}
?>