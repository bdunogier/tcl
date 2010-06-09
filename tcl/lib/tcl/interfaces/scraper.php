<?php
abstract class tclScraper
{
    protected $params = array();
    protected $baseURL = 'http://tcl.fr/index.asp';

    const HTTP_OK = 1;
    const HTTP_KO = 2;

    /**
     * Builds the fetch URL, and returns the resulting as a SimpleXML Object
     *
     * @param string $url
     * @return SimpleXMLElement
     * @throws tclScraperNetworkException If the URL couldn't be fetched
     */
    protected function fetch()
    {
        $url = $this->baseURL;
        if ( count( $this->params ) > 0 )
        {
            foreach( $this->params as $key => $value )
                $URIComponents[] = "$key=" . urlencode( $value );
            $url .= '?'  . implode( '&', $URIComponents );
        }

        try {
            $cache = ezcCacheManager::getCache( 'scrapers' );
        } catch( Exception $e ) {
            throw $e;
        }
        $cacheId = md5( $url );

        if ( ( $string = $cache->restore( $cacheId ) ) === false )
        {
            set_error_handler( array( $this, 'phpFileGetContentsErrorHandler' ) );
            $string = @file_get_contents( $url, 0, stream_context_create( array(
                'http' => array( 'timeout' => 5 )
            ) ) );
            restore_error_handler();

            if( $this->HTTPStatus( $http_response_header ) != self::HTTP_OK )
                throw new tclScraperHTTPException( $url, $http_response_header );
            $cache->store( $cacheId, $string );
        }
        $doc = new DOMDocument();
        $doc->strictErrorChecking = FALSE;
        if ( @$doc->loadHTML( $string ) === false )
            throw new tclScraperHTMLException( $url, $string );

        $doc = simplexml_import_dom( $doc );

        return $doc;
    }

    /**
     * Extracts the HTTP Status from $http_response_headers
     * @return int self::HTTP_OK, or self::HTTP_KO
     */
    public function HTTPStatus( $headers )
    {
        if( substr( $headers[0], -2 ) == 'OK' )
            return self::HTTP_OK;
        else
            return self::HTTP_KO;
    }

    /**
     * Custom error handler used for the file_get_contents call
     *
     * @param mixed $errno
     * @param mixed $errstr
     * @param mixed $errfile
     * @param mixed $errline
     * @return void
     */
    public function phpFileGetContentsErrorHandler( $errno, $errstr, $errfile, $errline, $errcontext )
    {

        if ( $errno === E_WARNiNG )
            throw new tclScraperNetworkException( $errcontext['url'] );
        else
            return false;
    }
}
?>