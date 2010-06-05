<?php
class tclScraperDetailsLigne extends tclScraper
{
    /**
     * Constructor
     * @param string $idLigne
     */
	public function __construct( $idLigne )
    {
		$this->params['page'] = 'horaires';
		$this->params['etape'] = 2;
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

        $doc = new DOMDocument( '1.0', 'utf-8' );
        $doc->strictErrorChecking = FALSE;
        $doc->loadHTML( $this->fetch() );
        $doc = simplexml_import_dom( $doc );

        $ret = array( 'arrets' => array(), 'directions' => array() );

		// stops
		list( $xp ) = $doc->xpath( '//select[@id="stoparea"]' );
		try {
			foreach( $xp->option as $option )
			{
				$value = (string)$option['value'];
				if ( $value !== "" )
				{
					$stop = tclArret::fromComboBoxString( $value );
					$ret['arrets'][$stop->id] = $stop;
				}
			}
		} catch( Exception $e ) {
			echo "Exception: " . $e->getMessage() . "\n";
			return array();
		}

		// direction 1
		$ret['directions'] = array(
			'fw' => $this->getDirection( '//label[@for=\'sensForw\']', $doc ),
			'bw' => $ret['directions']['bw'] = $this->getDirection( '//label[@for=\'sensBack\']', $doc ),
		);

        return $ret;
    }

	protected function getDirection( $xpathExpression, SimpleXMLElement $xml )
	{
		list( $xp ) = $xml->xpath( $xpathExpression );

		// required due to weird encoding behaviour
		$string = utf8_decode( $xp->asXML() );
		$string = substr( $string, strpos( $string, "Sens : " ) + 7, -8 );
		return array(
			'label' => $string,
			'code' => (string)$xp->input['value']
		);
	}
}
?>