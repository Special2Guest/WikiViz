<?php

# original by Charles Imilkowski /modified by Alex Junge
function HomepageLaden($url, $postdata)
{
    $agent = "Meine Browserkennung v1.0 :)";
    $header[] = "Accept: text/vnd.wap.wml,*.*";
    $ch = curl_init($url);

    if ($ch)
        {
        curl_setopt($ch,    CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,    CURLOPT_USERAGENT, $agent);
        curl_setopt($ch,    CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch,    CURLOPT_FOLLOWLOCATION, 1);

        # mit den nächsten 2 Zeilen könnte man auch Cookies
        # verwenden und in einem DIR speichern
        #curl_setopt($ch,    CURLOPT_COOKIEJAR, "cookie.txt");
        #curl_setopt($ch,    CURLOPT_COOKIEFILE, "cookie.txt");

        if (isset($postdata))
            {
            curl_setopt($ch,    CURLOPT_POST, 1);
            curl_setopt($ch,    CURLOPT_POSTFIELDS, $postdata);
            }

        $tmp = curl_exec ($ch);
        curl_close ($ch);
        }           
            
    return $tmp;
}

#Funktion um den Eingegebenen String für Suchanfragen bereitzustellen
function makeReadable($search){

    $readable = htmlspecialchars($search);
    $readable = ucwords($readable);    
    $readable = str_replace(' ', '_', $readable);
    $readable = str_replace('+', '_', $readable);

    return $readable;

}

#Generiert den Link zu der Page
function createURL($search){
    
    $search = "http://de.wikipedia.org/w/index.php?title=$search&action=render";

    return $search;                
}

#----------------------------------------------------------------
#Funktion um den String auf das Wesentliche zu kürzen
function cutPage($string, $search){

    $pos = strpos($string, $search);

    if ($pos === false) {
        #fb('Die Suche konnte nicht gefunden werden!');
    } 
    else {
        #fb('Die Suche wurde im String gefunden und befindet sich an $pos');
    }

    $cutString = substr($string, $pos);

    return $cutString;
}
#---------------------------------------------------------------

#--------------------------------------------------------------
#Funktionen um Werte im PHP auszulesen
#_________________________________________________________
#Funktion um Wörter zu zählen
function countWords($string){

    $words = str_word_count($string, 0);
    return $words;
}

#Funktion um Links zu zählen
function countLinks($string){

    $links = substr_count($string, '<a ', 0);
    return $links;
}

#Funktion um Zitate zu zählen
function countCites($string){

    $cites = substr_count($string, 'id="cite_note', 0);
    return $cites;
}

#Funktion um Bilder zu zählen
function countPictures($string){

    $pictures = substr_count($string, 'img alt=', 0);
    return $pictures;
}
#________________________________________________________
#Redaktionelle Bewertungen von Wikipedia
##Lesenswert
function isLesenswert($string){
    if(strpos($string, '#Vorlage_Lesenswert') == true){
        return true;
    }
    else{
        return false;
    }

}
##Excellent
function isExcellent($string){
    if(strpos($string, '#Vorlage_Excellent') == true){
        return true;
    }
    else{
        return false;
    }

}
##Informativ
function isInformativ($string){
    if(strpos($string, '#Vorlage_Informativ') == true){
        return true;
    }
    else{
        return false;
    }

}
##Gute Bilder
function isGoodPictures($string){
    if(strpos($string, 'Vorlage_Exzellentes_Bild') == true){
        return true;
    }
    else{
        return false;
    }

}
##Belege Fehlen
function noBelege($string){
    if(strpos($string, 'Vorlage_Belege_fehlen') == true){
        return true;
    }
    else{
        return false;
    }
}
##Überarbeiten
function needsWork($string){
    if(strpos($string, 'Vorlage_Uberarbeiten') == true){
        return true;
    }
    else{
        return false;
    }
}
##Lückenhaft
function isLueckenhaft($string){
    if(strpos($string, 'Vorlage_Lueckenhaft') == true){
        return true;
    }
    else{
        return false;
    }
}
##Neutralität
function isNotNeutral($string){
    if(strpos($string, 'Vorlage_Neutralitat') == true){
        return true;
    }
    else{
        return false;
    }
}
##Nur Liste
function onlyListe($string){
    if(strpos($string, 'Vorlage_NurListe') == true){
        return true;
    }
    else{
        return false;
    }
}
##Wiederspruch
function hasWiederspruch($string){
    if(strpos($string, 'Vorlage_Widerspruch') == true){
        return true;
    }
    else{
        return false;
    }
}
##Zu viele Bilder
function tooManyPictures($string){
    if(strpos($string, '#Vorlage_VieleBilder') == true){
        return true;
    }
    else{
        return false;
    }
}


#Funktion um die Werte in ein Array zu speichern
function getPageInfo($wikiPage){

    $pageInfo = array(
        "Woerter" => countWords($wikiPage), 
        "Verlinkungen" => countLinks($wikiPage), 
        "Bilder" => countPictures($wikiPage), 
        "Quellen" => countCites($wikiPage), 
        "Score" => "Not yet defined",               
        "Lesenswert" => isLesenswert($wikiPage), 
        "Exzellent" => isExcellent($wikiPage), 
        "Informativ" => isInformativ($wikiPage), 
        "Gute Bilder" => isGoodPictures($wikiPage),               
        "Belege Fehlen" => noBelege($wikiPage), 
        "Ueberarbeitung" => needsWork($wikiPage), 
        "Lueckenhaft" => isLueckenhaft($wikiPage), 
        "Unneutral" => isNotNeutral($wikiPage), 
        "Nur Bilder" => tooManyPictures($wikiPage), 
        "Wiederspruch" => hasWiederspruch($wikiPage), 
        "Nur Liste" => onlyListe($wikiPage),             
        "Gesamtgewicht" => 50
        );


    #Bilder zählen Wikimedia Version
    /*$pagePicturesLink = "http://de.wikipedia.org/w/api.php?action=query&prop=images&format=json&imlimit=100&titles=$search";
    $pagePicturesSource = HomepageLaden($pagePicturesLink, $search);
    $pictures_array = json_decode($pagePicturesSource, true);       

    echo count($pictures_array);

    print_r(array_values($pictures_array));

    #pageInfo[0]["pictures"] = $pagePictures;*/

    return $pageInfo;
}

#------------------------------------------------------------------------------------------
#Funktionen um die Page zu bewerten
#Absolute Werte wie Wörter bewerten
function rateAbsolute($amount, $min_amount, $max_amount, $neg_weight, $pos_weight){
    
    if($amount <= $min_amount){                    
        return $neg_weight;            
    }            
    else if($amount > $min_amount && $amount < $max_amount){
        return 0;            
    }        
    else if($amount > $max_amount){            
        return $pos_weight; 
    }            
}

function rateRelative($amount, $amountWords, $min_amount, $max_amount, $neg_weight, $pos_weight){
    
    $ratio = $amountWords/$amount;        
    
    if($ratio >= $min_amount){            
        return $neg_weight;            
    }
    
    else if($ratio < $min_amount && $ratio > $max_amount){            
        return $pos_weight;            
    }
    
    else if($ratio < $max_amount){            
        return $neg_weight;            
    }
    
}

function rateBool($wiki, $weight){
    
    if($wiki == 1){
        return $weight;
    }
    else{       
        return 0;
        
    }

function rateBacklinks($myNumber){

    if($myNumber <= 10){
        $result = 1;
    }

    elseif($myNumber > 10 && $myNumber <= 100){
        $result = 2;
    }

    elseif($myNumber > 100 && $myNumber <= 500){
        $result = 3;
    }

    elseif($myNumber > 500 && $myNumber <= 1000){
        $result = 4;
    }

    elseif($myNumber > 1000 && $myNumber <= 2000){
        $result = 5;
    }

    elseif($myNumber > 2000 && $myNumber <= 4000){
        $result = 6;
    }

    elseif($myNumber > 4000 && $myNumber <= 10000){
        $result = 7;
    }

    elseif($myNumber > 10000 && $myNumber <= 20000){
        $result = 8;
    }

    elseif($myNumber > 20000){
        $result = 9;
    }

    else{
        $result = 0;
    }

    return $result;
}

}
#Funktion um die Gesamte Page zu bewerten
function rateWikiPage($string, $configPath){

    include $configPath;

    $xml = new SimpleXMLElement($xmlstr);
    $pageinfo = getPageInfo($string, $xml);
    $pageWeights;
    $gesamtgewicht = 50;
    $singleWeight = 0;
                            
    foreach ($xml->category as $cat) { 
        
        if ($cat->rabsolute){                
            $singleWeight = rateAbsolute($pageinfo["$cat->cat_name"], $cat->min_value, $cat->max_value, $cat->neg_weight, $cat->pos_weight);                
        }
        else if ($cat->rrelative){                
            $singleWeight = rateRelative($pageinfo["$cat->cat_name"], $pageinfo["Woerter"], $cat->min_value, $cat->max_value, $cat->neg_weight, $cat->pos_weight);                
        }
        else if($cat->rboolean){                
            $singleWeight = rateBool($pageinfo["$cat->cat_name"], $cat->weight);                
        }
        $pageWeights["$cat->cat_name"] = intval($singleWeight);
        $gesamtgewicht += $singleWeight;            
    }

    $pageWeights["Gesamtgewicht"] = $gesamtgewicht;       

    return $pageWeights;
}

#-----------------------------------------------------------------------------------
#Funktion um ein Abstract aus einer Wikipage zu generieren
function makeAbstract($mystring, $newlength){

    echo "<p>Der Text wird entweder bis zum Inhaltsverzeichnis gekürzt, oder wenn zu lange auf $newlength Zeichen</p> <br/>";

    $newString = strip_tags($mystring, '<p>');  
    $gliederungsPos = strpos($newString, 'Inhaltsverzeichnis');    
    $newString = substr($newString, 0, $gliederungsPos);

    #Überprüfen ob weiteres Trimmen notwendig ist
    if(strlen($newString) > $newlength){        
        $newString = preg_replace("/[^ ]*$/", '', substr($newString, 0, $newlength));
    }

    return $newString;
    
}

#-----------------------------------------------------------------------------------
#Funktionen um die Links zu erhalten

#Funktion um alle Links auf der Seite auszulesen
function getLinks($string){
    $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";

    $linkarr = array(array());

    if(preg_match_all("/$regexp/siU", $string, $matches, PREG_SET_ORDER)) { 
        $i = 0;
        
        foreach($matches as $match) {             
            if($i < 20){

                $linkGewicht = intval(HomepageLaden("http://toolserver.org/~dispenser/cgi-bin/backlinkscount.py?title=$match[3]"));

                $linkarr[$i] = array('url' => $match[2], 'name' => $match[3], 'gewicht' => $linkGewicht);
            } 
                       
            $i++;
        }        

        #Alle Werte in seperate Arrays sepeichern zum Sortieren
        foreach ($linkarr as $key => $row) {           
            $gewicht[$key] = $row['gewicht'];
        }

        array_multisort($gewicht, SORT_DESC, $linkarr);        

        #Alle Werte des Arrays ausgeben nachdem es sortiert wurde
        /*echo "<br/><br/><hr/><br/>";
        foreach ($linkarr as $key => $row) {
            echo "Name: $row['name'] <br/>";            
            echo "URL: $row['url'] <br/>";            
            echo "GEWICHT: $row['gewicht']] <br/><br/>";
        }
        echo "<br/><hr/><br/>";    */  
        
        return $linkarr;
    }
}


#Funktion um die Links in ein JSON Format zu bringen
function encodeLinks($two_dim_array, $originalSearch, $originalUrl, $originalWeight){

    $subArray1[] = array("name" => "$originalSearch", "rad" => $originalWeight/10);    
    $subArray2[] = array("source" => 0, "target" => 1);

    for ($i=0; $i < 20; $i++) { 

        $linkName = $two_dim_array[$i]['name'];
        $linkSource = $two_dim_array[$i]['url'];
        $linkWeight = $two_dim_array[$i]['gewicht'];

        echo "Link $i = $linkWeight | " ;

        #$linkWeight = rateBacklinks($linkWeight);

        $node = array("name" => "$linkName", "rad" => 5);
        #$link = array("source" => "$linkSource", "target" => 0);
        $link = array("source" => 0, "target" => $i+1);

        $subArray1[] = $node;
        $subArray2[] = $link;
    }

    $linkArray = array(
        "nodes" => $subArray1,
        "edges" => $subArray2
        );

    return json_encode($linkArray);

}

function getLinksAndEncode($string, $originalSearch, $originalUrl, $originalWeight){

    $linkArray = getLinks($string);

    $linkJson = encodeLinks($linkArray, $originalSearch, $originalUrl, $originalWeight);

    return $linkJson;

}


?>