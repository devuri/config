<?php

namespace Urisoft;

/**
 * Interface ConfigRepositoryInterface.
 *
 * Defines the contract for a configuration repository that manages application settings.
 * This interface provides methods for retrieving and setting configuration values,
 * as well as clearing any cached configurations to ensure settings are up-to-date.
 */
interface ConfigRepositoryInterface
{
    /**
     * Retrieves a configuration value based on a specified key.
     *
     * This method returns the value associated with the given key in the configuration repository.
     * If the key does not exist, the method will return the specified default value or null if no default is provided.
     *
     * @param string $key     The key for the desired configuration value.
     * @param mixed  $default Optional. The default value to return if the key does not exist. Default is null.
     *
     * @return mixed The configuration value associated with the specified key or the default value if the key is not found.
     */
    public function get( $key, $default = null);

    /**
     * Sets a configuration value for a specified key.
     *
     * This method updates the configuration repository with a new value for the specified key.
     * If the key already exists, its value will be overwritten with the new value provided.
     *
     * @param string $key   The key for the configuration value to set.
     * @param mixed  $value The value to set for the specified key.
     *
     * @return void
     */
    public function set( $key, $value): void;

    /**
     * Clears any cached configurations.
     *
     * This method ensures that any cached or stored configurations are cleared,
     * forcing the system to reload configurations from the primary source on the next request.
     * This is useful in ensuring configuration changes take effect immediately without requiring a system restart.
     *
     * @return void
     */
    public function clearCache(): void;
}
