<?php
class tclMvcConfiguration implements ezcMvcDispatcherConfiguration
{
	/**
	 * @return ezcMvcRequestParser
	 */
	function createRequestParser()
	{
		$requestParser = new ezcMvcHttpRequestParser;
		$requestParser->prefix = '/index.php';
		return $requestParser;
	}

	/**
	 * @return ezcMvcRouter
	 */
	function createRouter( ezcMvcRequest $request )
	{
		return new tclMvcRouter( $request );
	}

	/**
	 * @return ezcMvcView
	 */
	function createView( ezcMvcRoutingInformation $routeInfo,
		ezcMvcRequest $request, ezcMvcResult $result )
	{
		switch ( $routeInfo->matchedRoute )
		{
			case '/horaire':
			case '/FATAL':
			case '/':
				return new tclHttpView( $request, $result );
			default:
				return new tclRootView( $request, $result );
		}
	}

	/**
	 * @return ezcMvcResponseWriter
	 */
	function createResponseWriter( ezcMvcRoutingInformation $routeInfo,
		ezcMvcRequest $request, ezcMvcResult $result,
		ezcMvcResponse $response )
	{
		return new ezcMvcHttpResponseWriter( $response );
	}

	/**
	 * @return ezcMvcRequest
	 */
	function createFatalRedirectRequest( ezcMvcRequest $request,
		ezcMvcResult $result,
		Exception $response )
	{
		$req = clone $request;
		$req->uri = '/FATAL';

		return $req;
	}

	function runResultFilters( ezcMvcRoutingInformation $routeInfo, ezcMvcRequest $request, ezcMvcResult $result )
	{
		$result->variables['installRoot'] = preg_replace( '@/index\.php$@', '', $_SERVER['SCRIPT_NAME'] );
	}

	function runPreRoutingFilters( ezcMvcRequest $request )
	{
	}

	function runRequestFilters( ezcMvcRoutingInformation $routeInfo, ezcMvcRequest $request )
	{
	    echo "<pre>"; print_r( $routeInfo );; echo "</pre>";
	}

	function runResponseFilters( ezcMvcRoutingInformation $routeInfo, ezcMvcRequest $request, ezcMvcResult $result, ezcMvcResponse $response )
	{
	}
}
?>