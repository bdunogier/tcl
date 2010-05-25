<?php
$root = '/home/xbmc/gitmisc/tcl';

// Set the include path to the eZ Components location, and bootstrap the
// library. The two lines below assume that you're using eZ Components from
// SVN -- see the installation guide at http://ezcomponents.org/docs/install.
ini_set( 'include_path', "/usr/share/php/ezc:$root" );
require 'Base/ezc_bootstrap.php';

$options = new ezcBaseAutoloadOptions( array( 'debug' => true ) );
ezcBase::setOptions( $options );

// Add the class repository containing our application's classes. We store
// those in the /lib directory and the classes have the "Tcl" prefix.
ezcBase::addClassRepository( "$root/lib", null, 'tcl' );

// Configure the template system by telling it where to find templates, and
// where to put the compiled templates.
$tc = ezcTemplateConfiguration::getInstance();
$tc->templatePath = "$root/templates";
$tc->compilePath = "$root/cache";
?>