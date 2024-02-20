<?php

namespace Urisoft;

use Dflydev\DotAccessData\Data;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

class SimpleConfig implements ConfigRepositoryInterface
{
    protected $config = [];
    protected $cachePath;
    protected $allowedFiles = [];
    protected $environment;
    protected $inMemoryCache = [];
    protected $filesystem;

    public function __construct( $configPath, $environment = 'production', $cachePath = 'configCache.php', array $allowedFiles = [] )
    {
        $this->filesystem   = new Filesystem();
        $this->cachePath    = $cachePath;
        $this->allowedFiles = $allowedFiles;
        $this->environment  = $environment;
        $this->config       = new Data();
        $this->loadConfigurations( $configPath );
    }

    public function get( $key, $default = null )
    {
        return $this->config->get( $key, $default );
    }

    public function set( $key, $value ): void
    {
        $this->config->set( $key, $value );
        $this->clearCache();
    }

    public function clearCache(): void
    {
        try {
            if ( $this->filesystem->exists( $this->cachePath ) ) {
                $this->filesystem->remove( $this->cachePath );
            }
        } catch ( IOExceptionInterface $exception ) {
            echo 'An error occurred while removing the cache file at ' . $exception->getPath();
        }
    }

    protected function loadConfigurations( $path ): void
    {
        if ( $this->isCacheValid() ) {
            $cachedConfig = include $this->cachePath;
            $this->config = new Data( $cachedConfig );
        } else {
            foreach ( $this->allowedFiles as $file ) {
                $filePath    = $path . '/' . $file . '.php';
                $envFilePath = $path . '/' . $file . '.' . $this->environment . '.php';

                if ( $this->filesystem->exists( $filePath ) ) {
                    $this->config[ $file ] = include $filePath;
                }
                if ( $this->filesystem->exists( $envFilePath ) ) {
                    $envConfig             = include $envFilePath;
                    $this->config[ $file ] = array_replace_recursive( $this->config[ $file ] ?? [], $envConfig );
                }
            }
            $this->cacheConfigurations();
        }
    }

    protected function isCacheValid()
    {
        return $this->filesystem->exists( $this->cachePath );
    }

    protected function cacheConfigurations(): void
    {
        if ( 'production' !== $this->environment ) {
            return;
        }

        try {
            $this->filesystem->dumpFile( $this->cachePath, '<?php return ' . var_export( $this->config, true ) . ';' );
        } catch ( IOExceptionInterface $exception ) {
            echo 'An error occurred while writing the cache file at ' . $exception->getPath();
        }
    }
}
