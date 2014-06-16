<?php
	#require_once('FirePHPCore/FirePHP.class.php');
	#ob_start();
	include 'controller.php'; 
	
	if(isset($_GET["search"])){

		echo 'Seach Request accepted <br/>';

		$mySearch = $_GET["search"];
		$underscoreSearch = makeReadable($mySearch);
		$searchURL = createURL($underscoreSearch);

		$wikiPage = HomepageLaden(createURL($underscoreSearch), $underscoreSearch);
		$wikiPage = cutPage($wikiPage, $mySearch);
		
		$wikiweight = rateWikiPage($wikiPage, 'models/config.php');

		#Alle Gewichtungen der Seite ausgeben
		/*foreach($wikiweight as $key => $value){
            echo "$key was weighted: $value <br/>";
        }*/

        #JSON ausgeben
        $linkData = getLinksAndEncode($wikiPage, $mySearch, $searchURL, $wikiweight["Gesamtgewicht"]);
        #echo $linkData;

		#echo '<br/>';

		#echo makeAbstract($wikiPage, 5000);

		
				
	}

	else{
		echo 'Noch keine Suche eingegeben';
	}



?>
