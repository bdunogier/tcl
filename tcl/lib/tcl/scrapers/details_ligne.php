<?php
class tclScraperDetailsLigne extends tclScraper
{
    /**
     * Constructor
     * @param string $idLigne
     */
    public function __construct( $idLigne )
    {
        $this->idLigne = $idLigne;

        $this->params['page'] = 'horaires';
        $this->params['etape'] = 2;
        $this->params['Date'] = implode( '|', array( date('Y'), date('m'), date('d') ) );
        $this->params['submit'] = 'Valider';

        // use tclScraperLignes to get the line string
        // very bad, this needs some server side storage :)
        $scrapper = new tclScraperLignes();
        $lines = $scrapper->get();
        if ( !isset( $lines[$idLigne] ) )
            throw new tclScraperNotFoundException( 'line', $idLigne );

        $this->ligne = $lines[$idLigne];

        $this->params['Line'] = $this->ligne->string;
    }

    public function get()
    {
        $doc = $this->fetch();

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
                    $this->ligne->arrets[$stop->id] = $stop;
                }
            }
        } catch( Exception $e ) {
            throw new tclScraperHTMLException( $this->requestUrl, $this->responseBody );
        }

        // direction 1
        $this->ligne->directions = array(
            'fw' => $this->getDirection( '//label[@for=\'sensForw\']', $doc ),
            'bw' => $ret['directions']['bw'] = $this->getDirection( '//label[@for=\'sensBack\']', $doc ),
        );

        return $this->ligne;
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

    /**
     * @var tclLigne
     */
    protected $ligne;
}
?>