<?php
abstract class tclScraper
{
	protected $params = array();
	protected $baseURL = 'http://tcl.fr/index.asp';

	/**
	 * Builds the fetch URL, and returns the resulting HTML
	 *
	 * @param string $url
	 * @return string
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
			die( $e->getMessage() );
		}
		$cacheId = md5( $url );

		if ( ( $string = $cache->restore( $cacheId ) ) === false )
		{
			$string = file_get_contents( $url );
			$cache->store( $cacheId, $string );
		}

		return $string;
	}
}
?>