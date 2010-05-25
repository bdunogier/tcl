<?php
class tclMvcRouter extends ezcMvcRouter
{
	public function createRoutes()
	{
		return array(
		    new ezcMvcRailsRoute( '/horaire', 'tclController', 'horaires' ),
		    new ezcMvcRailsRoute( '/',        'tclController', 'root' ),
		    new ezcMvcRailsRoute( '/fatal',   'tclController', 'fatal' ),
		);
	}
}
?>