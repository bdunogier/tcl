<?php
class tclHttpView extends ezcMvcView
{
	function createZones( $layout )
	{
		$zones = array();
		// $zones[] = new ezcMvcPhpViewHandler( 'content', '../templates/test.php' );
		$zones[] = new ezcMvcJsonViewHandler( 'content' );
		return $zones;
	}
}
?>