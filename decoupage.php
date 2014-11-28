<?php

class AdresseUrl {
	var $loc;
	var $erreurs;
	var $warnings;
	
	function AdresseUrl ($aa) {
		
		foreach ($aa as $k=>$v)
		{
			
			$this->$k = $aa[$k];
			list($tab_erreur, $tab_warning) = RecuperationInfo($aa[$k]);
			
			/*foreach($tab_erreur as $err=>$ve)
			//for($i = 0 ; $i<count($tab) ; $i++)
			{
				//$this->$err = $tab_erreur[$err];*/
				$this->erreurs = $tab_erreur;/*
			}
			foreach($tab_warning as $warn=>$vw)
			//for($i = 0 ; $i<count($tab) ; $i++)
			{
				//$this->$warn = $tab_warning[$warn];*/
				$this->warnings = $tab_warning;/*
			}*/
		}
	}
}

class Rorre {
	var $ligne;
	var $titre;
	var $code;
	
	function Rorre ($aa) {
		foreach ($aa as $k=>$v)
		{
			$this->$k = $aa[$k];
		}
	}
}

class Warning {
	var $titre;
	var $descr;
	var $list;
	
	function Warning ($aa) {
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
	{
		$mol[$mvalues[$i]["tag"]] = $mvalues[$i]["value"];
		
	}
	$obj = new AdresseUrl($mol);
	//$obj->erreurs = new Rorre($obj->log);
	//$obj = RecuperationInfo($mol);	
	return $obj;
}

	function RecuperationInfo ($url) {
		//Construction du lien W3C
		/* URL ONLINE : $url = "http://validator.w3.org/check?uri=".$url."&charset=%28detect+automatically%29&doctype=Inline&ss=1&outline=1&group=0&verbose=1&user-agent=W3C_Validator%2F1.3+http%3A%2F%2Fvalidator.w3.org%2Fservices";*/
		$url = "file:///C:/wamp/www/Validator/tmp/1416907869/w3c.html";
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
		$tab_erreur = array();
		$tab_warning = array();
		//recherche de la div msg_err
		foreach($w3cPage->getElementsByTagName('li') as $li){
    		if($li->getAttribute('class') == "msg_err"){
				// Selection des infos
				$ligne = $li->getElementsByTagName('em')->item(0)->nodeValue;
				$titre = $li->getElementsByTagName('span')->item(1)->nodeValue;
				if( null !== ($li->getElementsByTagName('code')->item(0)))
					$code = $li->getElementsByTagName('code')->item(0)->nodeValue;
				else
					$code = $li->getElementsByTagName('p')->item(1)->nodeValue;
				$info = array (
					'ligne' => $ligne,
					'titre' => $titre,
					'code' => $code);
				
				array_push($tab_erreur, new Rorre($info));
				//$tab_erreur[] = new Rorre($info);
			}
    		if(($li->getAttribute('class') == "msg_warn") || ($li->getAttribute('class') == "msg_info")){
				// Selection des infos
				$titre = $li->getElementsByTagName('span')->item(1)->nodeValue;
				$descr = $li->getElementsByTagName('p')->item(1)->nodeValue;
				if( null !== ($li->getElementsByTagName('p')->item(1)))
					$list = $li->getElementsByTagName('p')->item(1)->nodeValue;
				else
					$list = $li->getElementsByTagName('ul')->item(0)->nodeValue;
				$info = array (
					'titre' => $titre,
					'descr' => $descr,
					'list' => $list);
				
				array_push($tab_warning, new Warning($info));
			}
    	}
		return array($tab_erreur, $tab_warning) ;
	}

$db = readDatabase($_GET['sitemap']);
echo json_encode($db);
?>