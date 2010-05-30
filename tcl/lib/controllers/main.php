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