<?php
/**
* page=horaires&etape=4&date=2010|04|01&submit=Valider&Line=10|Bellecour%20-%20Saint%20Genis%20Laval|22|tcl10|Bellecour%20vers%20St%20Genis%20Barolles|St%20Genis%20Barolles%20vers%20Bellecour|1|Bus&Direction=1&StopArea=1493|tcl5002|Bellecour|Lyon%202eme
* 
* page=horaires
* etape=3
* Date=2010|04|01
* Line=10|Bellecour%20-%20Saint%20Genis%20Laval|22|tcl10|Bellecour%20vers%20St%20Genis%20Barolles|St%20Genis%20Barolles%20vers%20Bellecour|1|Bus
* DateFinBases=2010|6|1
* DateMajBases=????|??|??
* StopArea=1496|tcl5002|Bellecour|Lyon%202eme
* submit=Valider
* Direction=1
*/
$baseURL = 'http://tcl.fr/index.asp';

$params['page'] = 'horaires';
$params['etape'] = 3;
$params['Date'] = implode( '|', array( date('Y'), date('m'), date('d') ) );
$params['submit'] = 'Valider';

// ligne de bus
$params['Line'] = '10|Bellecour%20-%20Saint%20Genis%20Laval|22|tcl10|Bellecour%20vers%20St%20Genis%20Barolles|St%20Genis%20Barolles%20vers%20Bellecour|1|Bus';

// Bouton radio ligne / direction
$params['Direction'] = 1;

// nom arrêt
$params['StopArea'] = '1496|tcl5002|Bellecour|Lyon%202eme';

// peut être inutile
$params['DateFinBases'] = '2010|6|1';
$params['DateMajBases'] = '????|??|??';

foreach( $params as $key => $value )
    $URIComponents[] = "$key=$value";

$url = $baseURL . '?'  . implode('&', $URIComponents );

$html = file_get_contents( $url );
$html = substr( $html, strpos( $html, '<!-- Tableau des horaires -->' ) );
$html = substr( $html, 0, strpos( $html, '<div class="myhr">' ) );

/**
* Matches:
* 0 = full
* 1 = horaire complet, HHhMM
* 2 = URL détail
* 3 = heure
* 4 = minutes
*/
preg_match_all( '!<a title="Consulter les horaires à partir de ([0-9]{2}h[0-9]{2})" href="(.*?)"><span>([0-9]+)<abbr title="heure">h</abbr></span>([0-9]+)</a>!',
    $html, $matches, PREG_SET_ORDER );
$currentTime = array( 'h' => date( 'H' ), 'm' => date( 'i' ), 't' => date( 'Hi' ) );
$displayed = 0;
echo "<p>Il est {$currentTime['h']}h{$currentTime['m']}. Prochains bus vers Oullins:</p>";
foreach( $matches as $match )
{
    // echo "<pre>".print_r( $match, true )."</pre>\n";
    if ( str_replace( 'h' , '', $match[1] ) > $currentTime['t'] )
    {
        $horaire = $match[1];
        $tempsRestant = ( ( $match[3] - $currentTime['h'] ) * 60 ) + ( $match[4] - $currentTime['m'] );
        
        echo "10 à $horaire (dans $tempsRestant minutes)<br />";
        $displayed++;
    }
    if ( $displayed == 3 )
        break;
}
?>