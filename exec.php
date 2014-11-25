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


class AdresseUrl {
	var $loc;

	function AdresseUrl ($aa) {
		foreach ($aa as $k=>$v)
			$this->$k = $aa[$k];
	}
}

function readDatabase($filename) {
	$data = implode("",file($filename));
	$parser = xml_parser_create();
	xml_parser_set_option($parser,XML_OPTION_CASE_FOLDING,0);
	xml_parser_set_option($parser,XML_OPTION_SKIP_WHITE,1);
	xml_parse_into_struct($parser,$data,$values,$tags);
	xml_parser_free($parser);

	foreach ($tags as $key=>$val) {
		if ($key == "url") {
			$molranges = $val;
			for ($i=0; $i < count($molranges); $i+=2) {
				$offset = $molranges[$i] + 1;
				$len = $molranges[$i + 1] - $offset;
				$tdb[] = parseMol(array_slice($values, $offset, $len));
			}
		} else {
			continue;
		}
	}
	return $tdb;
}

function parseMol($mvalues) {
	for ($i=0; $i < count($mvalues); $i++)
		$mol[$mvalues[$i]["tag"]] = $mvalues[$i]["value"];
	return new AdresseUrl($mol);
}

$db = readDatabase($simple);

return $db;

?>