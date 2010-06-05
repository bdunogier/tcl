<?php
class tclMvcRouter extends ezcMvcRouter
{
	public function createRoutes()
	{
		return array(
		    new ezcMvcRailsRoute( '/horaire',                  'tclController', 'horaires' ),
		    new ezcMvcRailsRoute( '/arrets/:ligne/:direction', 'tclController', 'arrets' ),
		    new ezcMvcRailsRoute( '/infosLigne/:ligne',        'tclController', 'infosLigne' ),
		    new ezcMvcRailsRoute( '/lignes',                   'tclController', 'lignes' ),
		    new ezcMvcRailsRoute( '/',                         'tclController', 'default' ),
		    new ezcMvcRailsRoute( '/fatal',                    'tclController', 'fatal' ),
		);
	}
}
?>