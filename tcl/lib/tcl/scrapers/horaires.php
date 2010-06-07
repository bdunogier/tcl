<?php
class tclScraperHoraires extends tclScraper
{
    /**
     * Constructor
     * @param int $idLigne
     */
    public function __construct( $idLigne, $idArret, $direction )
    {
		$this->params['page'] = 'horaires';
		$this->params['etape'] = 3;
		$this->params['Date'] = implode( '|', array( date('Y'), date('m'), date('d') ) );
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
    	// echo "<pre><b>".__METHOD__.", \$this->params</b>\n"; print_r( $this->params ); echo "</pre>";
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
