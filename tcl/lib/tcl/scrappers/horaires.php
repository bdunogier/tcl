<?php
class tclScrapperHoraires extends tclScrapper
{
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