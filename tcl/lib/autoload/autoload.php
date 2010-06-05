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

	// scrappers
	'tclScrapper'             => 'tcl/interfaces/scrapper.php', // interface
	'tclScrapperLignes'       => 'tcl/scrappers/lignes.php',
	'tclScrapperDetailsLigne' => 'tcl/scrappers/details_ligne.php',
);
?>