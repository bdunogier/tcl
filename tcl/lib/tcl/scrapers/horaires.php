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
		$scrapper = new tclScraperLignes();
		$lines = $scrapper->get();
		if ( !isset( $lines[$idLigne] ) )
			throw new Exception( "Unknown line '$idLigne'" );

		$this->params['Line'] = $lines[$idLigne]->string;
    }

	public function get()
    {
        $url = $this->baseURL;

        $doc = new DOMDocument();
        $doc->strictErrorChecking = FALSE;
        $doc->loadHTML( $this->fetch() );
        $doc = simplexml_import_dom( $doc );

        $ret = array();
        list( $xp ) = $doc->xpath( '//select[@id=\'hor_lignes\']' );
        foreach( $xp->optgroup->option as $option )
        {
            $line = tclLigne::fromComboBoxString( (string)$option['value'] );
            $ret[$line->id] = $line;
        }

        return $ret;
    }
}
?>