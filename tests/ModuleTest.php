<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBiosTest\Comment\Doctrine;

use MSBios\Comment\Doctrine\Module;
use PHPUnit\Framework\TestCase;

/**
 * Class ModuleTest
 * @package MSBiosTest\Comment\Doctrine
 */
class ModuleTest extends TestCase
{
    /**
     *
     */
    public function testGetConfig()
    {
        $this->assertInternalType('array', (new Module)->getConfig());
    }

    /**
     *
     */
    public function testGetAutoloaderConfig()
    {
        $this->assertInternalType('array', (new Module)->getAutoloaderConfig());
    }
}
