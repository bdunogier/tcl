<?php
class tclScraperHoraires extends tclScraper
{
    /**
     * Constructor
     * @param int $idLigne
     * @param int $idArret
     * @param string $direction fw|bw
     * @param int $date The date to fetch departures for, as a UNIX timestamp
     */
    public function __construct( $idLigne, $idArret, $direction, $date = null )
    {
        $this->params['page'] = 'horaires';
        $this->params['etape'] = 3;

        if ( $date === null )
            $this->params['Date'] = date( 'Y|m|d' );
        else
            $this->params['Date'] = date( 'Y|m|d', $date );

        $this->params['submit'] = 'Valider';

        // use tclScraperLignes to get the line string
        // very bad, this needs some server side storage :)
        // but since the HTML file is cached... so be it
        try {
            $scrapper = new tclScraperDetailsLigne( $idLigne );
            $line = $scrapper->get();
        } catch( Exception $e ) {
            die( $e->getMessage() );
        }

        $this->params['Line'] = $line->string;
        $this->params['Direction'] = $line->directions[$direction]['code'];
        $this->params['StopArea'] = $line->arrets[$idArret]->string;
    }

    public function get()
    {
        $doc = $this->fetch();

        // <a title="Consulter les horaires à partir de
        $xp = $doc->xpath( "//a[starts-with(@title, 'Consulter')]" );
        foreach( $xp as $linkHoraire )
        {
            $time = array();
            $time['split'] = explode( 'h', substr( (string)$linkHoraire['title'], -5 ) );;

            // times between 0:00 and 2:59 are for tomorrow. Approximative but should work.
            $dayOffset = ( $time['split'][0] >= 0 && $time['split'][0] <= 2 ) ? 'tomorrow' : '';
            $time['unix'] = strtotime( "{$dayOffset}{$time['split'][0]}:{$time['split'][1]}" );
            $ret[] = $time;
        }
        return $ret;
    }

    public $date = null;
}
?>
