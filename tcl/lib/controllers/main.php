<?php
class tclController extends ezcMvcController
{
	public function doHoraires()
	{
		$res = new ezcMvcResult;
		$res->variables['test'] = 'test';

		$horaires = array();

	    /* temporary junk */
		try {
			$tcl = new tclHoraires( new tclParamsHorairesL10 );
	        foreach( $tcl->horaires() as $match )
	        {
	            if ( str_replace( 'h' , '', $match[1] ) > $currentTime['t'] )
	            {
	                $horaire = $match[1];
	                $tempsRestant = ( ( $match[3] - $currentTime['h'] ) * 60 ) + ( $match[4] - $currentTime['m'] );

	                $horaires[] = "10 à $horaire (dans $tempsRestant minutes)";
	                $displayed++;
	            }
	            if ( $displayed == 3 )
	                break;
	        }
			$res->variables['horaires'] = $horaires;
		} catch( Exception $e) {
			print_r( $e );
			die();
		}


        return $res;
	}

	public function doDefault()
	{
		$res = new ezcMvcResult;
		$res->variables['test'] = 'test';
		return $res;
	}

    /**
     * Returns stops for a line
     * @return ezcMvcResult
     */
    public function doArrets() {}

    /**
     * Returns informations about a line
     * @return ezcMvcResult
     */
    public function doInfosLigne() {}

    /**
     * Returns the lines list, with links to further details about each
     * @return ezcMvcResult
     */
    public function doLignes()
    {
        $result = new ezcMvcResult;

        $parserLignes = new tclLignes();
        $result->variables['lignes'] = $parserLignes->get();

        return $result;
    }

    public function doFatal()
	{
		return new ezcMvcResult;
	}
}
?>