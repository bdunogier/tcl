<?php
/**
 * File containing the tclScraperHTTPException class
 */

/**
 * A scraper HTTP tclScraperHTTPException. Thrown when a non 'OK' HTTP response was obtained.
 */
class tclScraperHTTPException extends ezcBaseException
{
    public function __construct( $url, $http_response_headers )
    {
        $this->url = $url;
        $this->http_response_headers = $http_response_headers;
        parent::__construct( "An HTTP error code was returned while fetching URL '$url'" );
    }

    /**
     * The fetched URL
     * @var string
     */
    public $url;

    /**
     * The HTTP response headers obtained from the request
     * @var array
     */
    public $http_response_headers;
}
?>