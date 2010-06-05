<?php
class tclArret// implements IteratorAggregate
{
    /**
     * Constructs a tclLigne object based on the string found in the website's combo box
     * @param string $strLigne
     *        String obtained from the website's combobox
     *        Example:
     *        C1|Gare Part Dieu Vivier Merle - CitÃ© Internationale|34|tclC1|Gare Part-Dieu Vivier Merle vers CitÃ© Internationale|CitÃ© Internationale vers Gare Part-Dieu Vivier Merle|1|Bus
     * @return tclLigne
     */
    public static function fromComboBoxString( $strLigne )
    {
        $stopData = explode( '|', $strLigne );

        if ( count( $stopData ) != 4 )
            throw new ezcBaseValueException( 'stopData', $stopData, "4 elements array", 'parameter' );

        $stop = new self;
        list( $stop->id, $stop->internalId, $stop->label, $stop->quartier )
            = $stopData;

        return $stop;
    }

	public function __get( $property )
	{
		switch( $property )
		{
			case 'link':
				return "/lignes/{$this->id}";
				break;
			default:
				throw new ezcBasePropertyNotFoundException( $property );
		} // switch
	}

    public $id;
    public $label;
    public $internalId;
    public $quartier;
}
?>