<?php

// OBJET URL + VERIF
class AdresseUrl {
	var $loc;
	var $erreurs;
	var $warnings;
	
	function AdresseUrl ($url) {
		$this->loc = $url;
		list($tab_erreur, $tab_warning) = RecuperationInfo($url);
		$this->erreurs = $tab_erreur;
		$this->warnings = $tab_warning;
	}
}

// OBJET ERREUR
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

//OBJET WARNING
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

function RecuperationInfo ($lien) {
	//Construction du lien W3C
	// URL ONLINE :
	$url = "http://validator.w3.org/check?uri=".$lien."&charset=(detect+automatically)&doctype=Inline&group=0&user-agent=W3C_Validator/1.3+http://validator.w3.org/services";
	// URL OFFLINE $url = "file:///C:/wamp/www/Validator/tmp/1416907869/w3c.html";

	// INITIALISATION cURL
	$ch = curl_init();
	// Page à récupérer
	curl_setopt($ch, CURLOPT_URL, $url);
	// Retour de la page
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
	// Retour dans un tableau
	$resultat = curl_exec ($ch);

	curl_close($ch);
	// Enregistrement du contenue
	$w3cPage = new DOMDocument();
	$w3cPage->loadHTML($resultat);
	$tab_erreur = array();
	$tab_warning = array();

	$result = $w3cPage->getElementsByTagName('td')->item(0)->nodeValue;

	//recherche de la div msg_err
	foreach($w3cPage->getElementsByTagName('li') as $li){
		$ligne = $titre = $code = $descr = '';
		
		// GESTION DES ERREURS
		if(($li->getAttribute('class') == "msg_err") && (preg_match("/Error/", $result))){
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
		}
		
		// GESTION DES WARNINGS
		if((($li->getAttribute('class') == "msg_warn") || ($li->getAttribute('class') == "msg_info"))
		   && (preg_match("/warning/", $result))){
			// Selection des infos
			$titre = $li->getElementsByTagName('em')->item(0)->nodeValue;
			$descr = $li->getElementsByTagName('span')->item(1)->nodeValue;
			if( null !== ($li->getElementsByTagName('code')->item(0)))
				$code = $li->getElementsByTagName('code')->item(0)->nodeValue;
			else
				$code = $li->getElementsByTagName('p')->item(1)->nodeValue;
			if( null !== ($li->getElementsByTagName('ul')->item(0)))
				$code .= $li->getElementsByTagName('ul')->item(0)->nodeValue;
			$info = array (
				'titre' => $titre,
				'descr' => $descr,
				'list' => $code);

			array_push($tab_warning, new Warning($info));
		}
	}
	return array($tab_erreur, $tab_warning) ;
}

echo json_encode(new AdresseUrl($_GET['url']));

?>