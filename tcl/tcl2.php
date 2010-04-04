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
include 'junk.php';

$currentTime = array( 'h' => date( 'H' ), 'm' => date( 'i' ), 't' => date( 'Hi' ) );
$displayed = 0;

// Ligne 10
$tcl = new HorairesTCL( new ParamsHorairesTCLLigne10 );
foreach( $tcl->horaires() as $match )
{
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

// Ligne 88
$displayed = 0;
$tcl = new HorairesTCL( new ParamsHorairesTCLLigne88 );
foreach( $tcl->horaires() as $match )
{
    if ( str_replace( 'h' , '', $match[1] ) > $currentTime['t'] )
    {
        $horaire = $match[1];
        $tempsRestant = ( ( $match[3] - $currentTime['h'] ) * 60 ) + ( $match[4] - $currentTime['m'] );
        
        echo "88 à $horaire (dans $tempsRestant minutes)<br />";
        $displayed++;
    }
    if ( $displayed == 3 )
        break;
}
?>