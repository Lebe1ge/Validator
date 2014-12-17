<?php

function TestUrl($lien) {
	
    $ch = curl_init($lien);
	curl_setopt($ch, CURLOPT_URL, $lien);
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // follow redirects
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1); // set referer on redirect
    curl_exec($ch);
    $target = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    curl_close($ch);

    if ($target)
        return $target;

    return false;
}

function recup($url){
	$ch = curl_init();
	// Page à récupérer
	curl_setopt($ch, CURLOPT_URL, $url);
	// Retour de la page
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
	// Retour dans un tableau
	$resultat = curl_exec ($ch);
	curl_close($ch);
	
	return $resultat;
}

function decoup($url_sitemap) {
	
	// Récupération sitemap cURL
	$resultat = recup($url_sitemap);
	// Enregistrement du contenue
	$sitemapPage = new SimpleXMLElement($resultat);
	$tab_sitemap = $tab_inter = $info_url = array();

	foreach($sitemapPage->url as $url){
		$doublons = false;
		$info_url = parse_url($url->loc);
		$redir = parse_url(TestUrl($url->loc));
		if($redir != false){
			$tab_inter['extension'] = "redirection";
			$tab_inter['url'] = $redir['scheme']."://".$redir['host'].$redir['path'];
		}
		else
		{
			$tab_inter['extension'] = substr($info_url['path'], strrpos($info_url['path'], '.') + 1);
			$tab_inter['url'] = $info_url['scheme']."://".$info_url['host'].$info_url['path'];
		}
		
		foreach($tab_sitemap as $ligne){
			if ($ligne['url'] == $tab_inter['url'])
				$doublons = true;
		}
		
		if (!$doublons)
			$tab_sitemap[] = $tab_inter;
	}


return $tab_sitemap;
}

echo json_encode(decoup($_GET['sitemap']));
?>