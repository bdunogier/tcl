<?php
class tclController extends ezcMvcController
{
	public function doHoraires()
	{
		$res = new ezcMvcResult;
		$res->variables['test'] = 'test';

	    /* temporary junk */
	    $tcl = new tclHoraires( new tclParamsHorairesL10 );
        foreach( $tcl->horaires() as $match )
        {
            if ( str_replace( 'h' , '', $match[1] ) > $currentTime['t'] )
            {
                $horaire = $match[1];
                $tempsRestant = ( ( $match[3] - $currentTime['h'] ) * 60 ) + ( $match[4] - $currentTime['m'] );

                echo "10 à $horaire (dans $tempsRestant minutes)<br />";
                $displayed++;
            }
            if ( $displayed == 3 )
                break;
        }

        return $res;
	}

	public function doRoot()
	{
		$res = new ezcMvcResult;
		$res->variables['test'] = 'test';
		return $res;
	}

	public function doFatal()
	{
		return new ezcMvcResult;
	}
}
?>