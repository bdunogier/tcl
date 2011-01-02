<?php
define( 'ROOT', dirname( __FILE__ ) );
ini_set( 'include_path', "/usr/share/php/ezc:" . ROOT );

require 'Base/ezc_bootstrap.php';

$options = new ezcBaseAutoloadOptions( array( 'debug' => true ) );
ezcBase::setOptions( $options );

// Add the class repository containing our application's classes. We store
// those in the /lib directory and the classes have the "tcl" prefix.
ezcBase::addClassRepository( ROOT . "/lib", ROOT . "/lib/autoload", 'mm' );

class mmLazyDatabaseConfiguration implements ezcBaseConfigurationInitializer
{
    public static function configureObject( $instance )
    {
        return ezcDbFactory::create( 'sqlite://' . __DIR__ . '/tmp/mkvmanager.db' );
    }
}

ezcBaseInit::setCallback(
    'ezcInitDatabaseInstance',
    'mmLazyDatabaseConfiguration'
);

class mmLazyPersistentSessionConfiguration implements ezcBaseConfigurationInitializer
{
    public static function configureObject( $instance )
    {
        return new ezcPersistentSession(
            ezcDbInstance::get(),
            new ezcPersistentCodeManager( ROOT . "/lib/po/" )
        );
    }
}

ezcBaseInit::setCallback(
    'ezcInitPersistentSessionInstance',
    'mmLazyPersistentSessionConfiguration'
);

/*class customLazyCacheConfiguration implements ezcBaseConfigurationInitializer
{
	public static function configureObject( $id )
	{
		$options = array( 'ttl' => 1800 );

		switch ( $id )
		{
			case 'scrapers':
				ezcCacheManager::createCache( 'scrapers', '../cache/scrapers', 'ezcCacheStorageFilePlain', $options );
				break;
		}
	}
}

ezcBaseInit::setCallback(
	'ezcInitCacheManager',
	'customLazyCacheConfiguration'
);*/
?>
