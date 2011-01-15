<?php
class tclMvcXmlViewHandler extends ezcMvcJsonViewHandler
{
	public function process( $last )
	{
		if ( $last )
		{
			$xml = new SimpleXMLElement( '<response></response>' );
			foreach( $this->variables as $name => $value )
			{
				$this->addChildren( $name, $value, $xml );
			}
			$this->result = $xml->asXML();
		}
	}

	/**
	 * Recursive transformator from array to SimpleXml
	 * @param string $name
	 * @param mixed $value
	 * @return SimpleXMLElement
	 */
	protected function addChildren( $name, $value, SimpleXMLElement $xml )
	{
		if ( $value === null )
			return;
		elseif ( !is_array( $value ) and !is_object( $value ) )
		{
			$label = is_numeric( $name ) ? 'item' : $name;
			$xml->addChild( $label, $value );
		}
		else
		{
			// the node name for an array is the key, while it is the class name for an object
			if ( is_object( $value ) )
			{
				$label = get_class( $value );
			}
			elseif( is_numeric( $name ) )
			{
				$label = 'item';
			}
			else
			{
				$label = $name;
			}
			$child = $xml->addChild( $label );

			// array_walk( $value, array( $this, 'addChildren' ), $child );
			foreach( $value as $subName => $subValue )
				$this->addChildren( $subName, $subValue, $child );
		}
	}
}
?>