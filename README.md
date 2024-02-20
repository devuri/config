# SimpleConfig Package

SimpleConfig is a lightweight PHP configuration management library designed to provide an easy and flexible way to handle configuration settings. It leverages `dflydev/dot-access-data` for convenient access to nested configuration values using dot notation.

## Features

- Easy loading and merging of configuration files.
- Environment-specific configuration overrides.
- Simple dot notation for accessing nested configuration values.
- Optional caching mechanism to enhance performance.

## Installation

Use Composer to install SimpleConfig into your project:

```bash
composer require devuri/config
```

## Usage

### Basic Usage

```php
use Urisoft\SimpleConfig;

// Define your configuration path and allowed files
$configPath = __DIR__ . '/config';
$allowedFiles = ['app', 'database'];

// Instantiate the SimpleConfig object
$config = new SimpleConfig($configPath, $allowedFiles, 'production', 'path/to/configCache.php');

// Access configuration values
$appName = $config->get('app.name');
$dbHost = $config->get('database.connections.mysql.host');
```

### Setting Configuration Values

```php
// Set a new configuration value
$config->set('app.timezone', 'UTC');

// Retrieve the newly set value
echo $config->get('app.timezone'); // Outputs: UTC
```

### Clearing Cache

```php
// Manually clear the configuration cache
$config->clearCache();
```

## Contributing

Please submit pull requests or create issues for any features, fixes, or improvements.

## License

Licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

