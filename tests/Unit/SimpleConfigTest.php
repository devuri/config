<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Urisoft\SimpleConfig;

/**
 * @internal
 *
 * @coversNothing
 */
class SimpleConfigTest extends TestCase
{
    private $testConfigPath;
    private $appConfigFile;
    private $cachePath;

    protected function setUp(): void
    {
        // Define the test configuration path using an environment variable
        $this->testConfigPath = APP_TEST_PATH . '/tmp' ?: sys_get_temp_dir() . '/config_tests';
        $this->appConfigFile = $this->testConfigPath . '/app.php';
        $this->cachePath = $this->testConfigPath . '/configCache.php';

        // Ensure the directory exists
        if ( ! file_exists($this->testConfigPath)) {
            mkdir($this->testConfigPath, 0777, true);
        }
    }

    protected function tearDown(): void
    {
        // Cleanup
        if (file_exists($this->cachePath)) {
            unlink($this->cachePath);
        }
    }

    public function test_get_configuration_values(): void
    {
        $simpleConfig = new SimpleConfig($this->testConfigPath, ['app'], 'production', $this->cachePath);

        // Test basic top-level configuration
        $this->assertSame('MyTestApp', $simpleConfig->get('app.name'));
        $this->assertSame('http://localhost', $simpleConfig->get('app.url'));

        // Test nested configuration
        $this->assertSame('mysql', $simpleConfig->get('app.database.driver'));
        $this->assertSame('test_db', $simpleConfig->get('app.database.database'));
        $this->assertSame('debug', $simpleConfig->get('app.logging.level'));

        // Test default value
        $this->assertSame('default', $simpleConfig->get('app.nonexistent.key', 'default'));
    }
}
