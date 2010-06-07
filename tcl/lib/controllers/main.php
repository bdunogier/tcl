<?php
class tclController extends ezcMvcController
{
	public function doHoraires()
	{
		$res = new ezcMvcResult;

	    /* temporary junk */
		try {
			$scraperHoraires = new tclScraperHoraires( $this->ligne, $this->arret, $this->direction );
			$horaires = $scraperHoraires->get();
		} catch( Exception $e) {
			print_r( $e );
			die();
		}

		if ( isset( $this->aPartirDe ) )
		{
			$res->variables['horaires'] = array();
			$from = explode( 'h', $this->aPartirDe );
			foreach( $horaires as $horaire )
			{
				if ( ( $horaire[0] > $from[0] ) or ( ( $horaire[0] == $from[0] ) && $horaire[1] > $from[1] ) )
				{
					$res->variables['horaires'][] = $horaire;
				}
				if ( count( $res->variables['horaires'] ) == 3 )
					break;
			}
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
    public function doInfosLigne()
    {
    	$result = new ezcMvcResult();

    	$scrapperLigne = new tclScraperDetailsLigne( $this->ligne );
    	$result->variables['ligne'] = $scrapperLigne->get();

    	return $result;
	}

    /**
     * Returns the lines list, with links to further details about each
     * @return ezcMvcResult
     */
    public function doLignes()
    {
        $result = new ezcMvcResult;

        $scrapperLignes = new tclScraperLignes();
        $result->variables = $scrapperLignes->get();

        return $result;
    }

    public function doFatal()
	{
		return new ezcMvcResult;
	}
}
?>
