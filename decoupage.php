<?php

class AdresseUrl {
	var $loc;
	var $erreurs;
	var $warnings;
	
	function AdresseUrl ($aa) {
		
		foreach ($aa as $k=>$v)
		{
			$this->$k = $aa[$k];
		}
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
				$tbb = array_slice($values, $offset, $len);
				$ext = substr($tbb[0]['value'], strrpos($tbb[0]['value'], '.') + 1);
				if(preg_match("/html/i", substr($tbb[0]['value'], strrpos($tbb[0]['value'], '.') + 1)))
				{
					$tdb[] = parseMol($tbb);
				}
				else
				{
					$tdb[] = "NOHTML";
				}
			}
		} else {
			continue;
		}
	}
	return $tdb;
}

function parseMol($mvalues) {
	for ($i=0; $i < count($mvalues); $i++)
	{
		$mol[$mvalues[$i]["tag"]] = $mvalues[$i]["value"];
		
	}
	$obj = new AdresseUrl($mol);	
	return $obj;
}

$db = readDatabase($_GET['sitemap']);
echo json_encode($db);
?>