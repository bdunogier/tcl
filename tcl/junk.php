<?php
class HorairesTCL
{
    private $params = array();
    private $baseURL = 'http://tcl.fr/index.asp';

    public function __construct( ParamsHorairesTCL $params )
    {
        $this->params = array();
        $this->params['page'] = 'horaires';
        $this->params['etape'] = 3;
        $this->params['Date'] = implode( '|', array( date('Y'), date('m'), date('d') ) );
        $this->params['submit'] = 'Valider';
        
        $this->params = array_merge( $this->params, $params->getParams() );
    }
    
    public function horaires()
    {
        foreach( $this->params as $key => $value )
            $URIComponents[] = "$key=$value";

        $url = $this->baseURL . '?'  . implode('&', $URIComponents );

        $html = file_get_contents( $url );
        $html = substr( $html, strpos( $html, '<!-- Tableau des horaires -->' ) );
        $html = substr( $html, 0, strpos( $html, '<div class="myhr">' ) );

        /**
         * Matches:
         * 0 = full
         * 1 = horaire complet, HHhMM
         * 2 = URL détail
         * 3 = heure
         * 4 = minutes
         */
        preg_match_all( '!<a title="Consulter les horaires à partir de ([0-9]{2}h[0-9]{2})" href="(.*?)"><span>([0-9]+)<abbr title="heure">h</abbr></span>([0-9]+)</a>!',
            $html, $matches, PREG_SET_ORDER );
        
        return $matches;
    }
}

class ParamsHorairesTCLLigne10 implements ParamsHorairesTCL
{
    public function getParams()
    {
        $params = array();
        
        $params['Line'] = '10|Bellecour%20-%20Saint%20Genis%20Laval|22|tcl10|Bellecour%20vers%20St%20Genis%20Barolles|St%20Genis%20Barolles%20vers%20Bellecour|1|Bus';
        $params['Direction'] = 1;
        $params['StopArea'] = '1496|tcl5002|Bellecour|Lyon%202eme';
        
        return $params;
    }
}

class paramsHorairesTCLLigne88 implements ParamsHorairesTCL
{
    public function getParams()    
    {
        $params = array();

        $params['Line'] = '88|Bellecour%20-%20H%F4pital%20Lyon%20Sud|141|tcl88|Bellecour%20vers%20Hopital%20Lyon%20Sud|Hopital%20Lyon%20Sud%20vers%20Bellecour|1|Bus';
        $params['StopArea'] = '1496|tcl5002|Bellecour|Lyon%202eme';
        $params['Direction'] = 1;
        
        return $params;
    }
}

interface ParamsHorairesTCL
{
    public function getParams();
}
?>