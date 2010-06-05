<?php
class tclLigne
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
        $lineData = explode( '|', $strLigne );

        if ( count( $lineData ) != 8 )
            throw new ezcBaseValueException( 'lineData', $lineData, "8 elements array", 'parameter' );

        $line = new self;
        list( $line->id, $line->label, $line->misc1, $line->internalId,
            $line->direction1, $line->direction2,
            $line->misc2, $line->type ) = $lineData;

        return $line;
    }

    public $id;
    public $label;
    protected $misc1, $misc2;
    public $internalId;
    public $direction1, $direction2;
    public $type;
}
?>