<?php
// File automatically generated by PHPEdit
// PHPEdit's unit tests extension might not work as expected if you modify this file

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '../autoload.php';

require_once 'PHPUnit/Util/Filter.php';

PHPUnit_Util_Filter::addFileToFilter(__FILE__);

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'AllTests::main');
    chdir(dirname(dirname(__FILE__)));
}

require_once 'PHPUnit/Framework/TestSuite.php';
require_once 'PHPUnit/TextUI/TestRunner.php';

// PHPEdit Inclusions -- dot not remove this comment
require_once 'lib/AllTests.php';
// /PHPEdit Inclusions -- dot not remove this comment

class AllTests
{
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('PHPUnit_Framework');

		// PHPEdit Tests suites -- dot not remove this comment
		$suite->addTest(lib_AllTests::suite());
		// /PHPEdit Tests suites -- dot not remove this comment

        return $suite;
    }
}

if (PHPUnit_MAIN_METHOD == 'AllTests::main') {
    AllTests::main();
}
?>
