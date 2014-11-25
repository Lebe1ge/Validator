<?php

/// RECUPERATION DE L'URL DU SITEMAP ///
$sitemap	=	$_GET['url'];

/// CREATION DU SITEMAP TEMPORAIRE ///
$setTime= time();
$sitemap_fileName = "sitemap_".$setTime.".xml";
$w3c_fileName = "w3c_".$setTime.".html";


/*****************************   FOLDER FOR CONTENT           **************************************/
mkdir("tmp/".$setTime, 0777) or die("Cannot create data folder");
chmod("tmp/".$setTime, 0777) or die("Cannot change chmod");

/*****************************   SITEMAP CONTENT              **************************************/
$handle = fopen("tmp/".$setTime."/".$sitemap_fileName, 'x') or die("can't open/create file = ".$sitemap_fileName);
$data = file_get_contents($sitemap) or die("cannot get data from page");
fwrite($handle, $data) or die("cannot write data in file");
fclose($handle);

/*****************************   GET URL LIST           **************************************/

$simple = "http://127.0.0.1/validator/tmp/".$setTime."/sitemap_".$setTime.".xml";

echo $simple;

?>