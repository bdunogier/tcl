<?php
class tclController extends ezcMvcController
{
    public function doHoraires()
    {
        $res = new ezcMvcResult;

        $scraperHoraires = new tclScraperHoraires( $this->ligne, $this->arret, $this->direction );
        $horaires = $scraperHoraires->get();

        // current time of not specified
        if ( isset( $this->aPartirDe ) )
        {
            list( $heure ) = explode( ':', $this->aPartirDe );
            $dayOffset = ( $heure >= 0 && $heure <= 2 ) ? 'tomorrow ' : '';

            // HH:MM => timestamp
            $fromTimestamp = strtotime( "{$dayOffset}{$this->aPartirDe}" );
        }

        $res->variables['horaires'] = array();
        foreach( $horaires as $horaire )
        {
            if ( isset( $fromTimestamp ) )
            {
                if ( $horaire['unix'] > $fromTimestamp )
                    $res->variables['horaires'][] = $horaire;
                if ( count( $res->variables['horaires'] ) == 3 )
                    break;
            }
            else
            {
                $res->variables['horaires'][] = $horaire;
            }
        }
        $res->variables['tcl-url'] = $scraperHoraires->url;

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
        $result->variables['tcl-url'] = $scrapperLigne->url;

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
        $result->variables['lignes'] = $scrapperLignes->get();
        $result->variables['tcl-url'] = $scrapperLigne->url;

        return $result;
    }

    public function doFatal()
    {
        $result = new ezcMvcResult;
        $result->variables['exception'] = $this->request->variables['exception'];
        return $result;
    }
}
?>
