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
			$ret[] = explode( 'h', substr( (string)$linkHoraire['title'], -5 ) );
        }
        return $ret;
    }
}
?>
