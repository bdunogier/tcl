<?php
class tclMvcRouter extends ezcMvcRouter
{
	public function createRoutes()
	{
		return array(
		    // next 3 departures after a given time
			new ezcMvcRailsRoute( '/horaires/:ligne/:arret/:direction/:aPartirDe', 'tclController', 'horaires' ),

			// all departures for today
			new ezcMvcRailsRoute( '/horaires/:ligne/:arret/:direction', 'tclController', 'horaires' ),

		    // details about a line (stops, directions)
			new ezcMvcRailsRoute( '/lignes/:ligne',                     'tclController', 'infosLigne' ),

			// all lines
			new ezcMvcRailsRoute( '/lignes',                            'tclController', 'lignes' ),
		    new ezcMvcRailsRoute( '/',                                  'tclController', 'default' ),
		    new ezcMvcRailsRoute( '/fatal',                             'tclController', 'fatal' ),
		);
	}
}
?>