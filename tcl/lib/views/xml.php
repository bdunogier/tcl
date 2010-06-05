<?php
class tclXmlView extends ezcMvcView
{
	function createZones( $layout )
	{
		$zones = array();
		$zones[] = new tclMvcXmlViewHandler( 'content' );
		return $zones;
	}
}
?>