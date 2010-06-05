<?php
$root = dirname( __FILE__ );
ini_set( 'include_path', "/usr/share/php/ezc:$root" );

require 'Base/ezc_bootstrap.php';

$options = new ezcBaseAutoloadOptions( array( 'debug' => true ) );
ezcBase::setOptions( $options );

// Add the class repository containing our application's classes. We store
// those in the /lib directory and the classes have the "tcl" prefix.
ezcBase::addClassRepository( $p = "$root/lib", null, 'tcl' );
?>
