<?php
return array(
	// MVC: Misc
	'tclMvcConfiguration' => 'config.php',
	'tclMvcRouter'        => 'router.php',
	'tclController'       => 'controllers/main.php',

	// MVC: Views
	'tclJsonView' => 'views/json.php',
	'tclHtmlView' => 'views/html.php',
	'tclXmlView'  => 'views/xml.php',

	// MVC: View handlers
	'tclMvcXmlViewHandler' => 'view_handlers/xml.php',

	// TCL related
	'tclHoraires'         => 'tcl/horaires.php',
	'tclLigne'            => 'tcl/ligne.php',
	'tclArret'             => 'tcl/arret.php',

	// scrapers
	'tclScraper'             => 'tcl/interfaces/scraper.php', // interface
	'tclScraperLignes'       => 'tcl/scrapers/lignes.php',
	'tclScraperDetailsLigne' => 'tcl/scrapers/details_ligne.php',
	'tclScraperHoraires'     => 'tcl/scrapers/horaires.php',

	// exceptions
	'tclScraperNetworkException' => 'tcl/exceptions/scraper_network.php',
	'tclScraperHTTPException'    => 'tcl/exceptions/scraper_http.php',
	'tclScraperHTMLException'    => 'tcl/exceptions/scraper_html.php',
);
?>