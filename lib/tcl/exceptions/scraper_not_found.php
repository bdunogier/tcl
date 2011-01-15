<?php
/**
 * File containing the tclScraperHTTPException class
 */

/**
 * A scraper HTTP tclScraperHTTPException. Thrown when a non 'OK' HTTP response was obtained.
 */
class tclScraperNotFoundException extends ezcBaseException
{
    public function __construct( $itemType, $itemValue )
    {
        $this->itemType = $itemType;
        $this->itemValue = $itemValue;
        parent::__construct( "The requested $itemType item with ID $itemValue was not found" );
    }

    /**
     * The fetched URL
     * @var string
     */
    public $url;

    /**
     * The HTTP body response
     * @var array
     */
    public $body;
}
?>