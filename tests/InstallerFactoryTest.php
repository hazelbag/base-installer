<?php

namespace Hazelbag\BaseInstaller\Tests;

use Hazelbag\BaseInstaller\InstallerFactory;
use PHPUnit\Framework\TestCase;

class InstallerFactoryTest extends TestCase
{
    /** @test */
    public function it_returns_the_installer_check()
    {
        $installer = new InstallerFactory();

        $envData = $installer->getEnvData();

        $this->assertSame('env Data fetched', $envData);
    }
}