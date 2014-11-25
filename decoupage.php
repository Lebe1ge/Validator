<?php

class AdresseUrl {
	var $loc;
	


	function AdresseUrl ($aa) {
		foreach ($aa as $k=>$v)
		{
			/* DE BASE $this->$k = $aa[$k]; */
			$this->$k = RecuperationInfo($aa[$k]);
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

	function RecuperationInfo ($url) {
		
		//Construction du lien W3C
		$url = "http://validator.w3.org/check?uri=".$url."&charset=%28detect+automatically%29&doctype=Inline&ss=1&outline=1&group=0&verbose=1&user-agent=W3C_Validator%2F1.3+http%3A%2F%2Fvalidator.w3.org%2Fservices";
		// INITIALISATION cURL
		$ch = curl_init();
		// Page à récupérer
		curl_setopt($ch, CURLOPT_URL, $url);
		// Retour de la page
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// Retour dans un tableau
		$resultat = curl_exec ($ch);
		// Enregistrement du contenue
		$w3cPage = new DOMDocument();
		$w3cPage->loadHTML($resultat);
		//recherche de la div msg_err
		foreach($w3cPage->getElementsByTagName('div') as $div){
    		if($div->getAttribute('class') == "msg_err"){
				// Selection des infos
				$ligne = $div->getElementsByTagName('em')->nodeValue;
				echo($ligne);
			}
    	}
		
		return $url;
	}

$db = readDatabase($_GET['sitemap']);
/*echo json_encode($db);*/
?>