<?php
class tclScraperLignes extends tclScraper
{
    public function get()
    {
        $doc = $this->fetch();

        $ret = array();
        list( $xp ) = $doc->xpath( '//select[@id=\'hor_lignes\']' );
    	foreach( $xp->optgroup as $optgroup )
    	{
    		foreach( $optgroup as $option )
    		{
    			$line = tclLigne::fromComboBoxString( (string)$option['value'] );
    			$ret[$line->id] = $line;
    		}
    	}

        return $ret;
    }
}
?>