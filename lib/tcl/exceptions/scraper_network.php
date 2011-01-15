<?php
/**
 * File containing the tclScraperNetworkException class
 */

/**
 * A scraper network exception. Thrown when the URL couldn't be fetched at all.
 */
class tclScraperNetworkException extends ezcBaseException
{
    public function __construct( $url )
    {
        $this->url = $url;
        parent::__construct( "A network error has occured fetching URL '$url'" );
    }

    public $url;
}
?>