<?php
//Construction du lien W3C
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
		//recherche de la div msg_err
		foreach($w3cPage->getElementsByTagName('li') as $li){
    		if($li->getAttribute('class') == "msg_err"){
				// Selection des infos
				$ligne = $li->getElementsByTagName('em')->item(0)->nodeValue;
				$titre = $li->getElementsByTagName('span')->item(1)->nodeValue;
				$code = $li->getElementsByTagName('code')->item(0)->nodeValue;
				echo("ligne ".$ligne."\ntitre ".$titre."\ncode ".$code."\n");
			}
    	}

?>