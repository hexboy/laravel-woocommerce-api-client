<?php
/**
 * WooCommerce REST API HTTP Client Options
 *
 * @category HttpClient
 * @package  Hexboy/WooCommerce
 */

namespace Hexboy\WooCommerce\HttpClient;

/**
 * REST API HTTP Client Options class.
 *
 * @package Hexboy/WooCommerce
 */
class Options
{

    /**
     * Default WooCommerce REST API version.
     */
    const VERSION = 'wc/v3';

    /**
     * Default request timeout.
     */
    const TIMEOUT = 15;

    /**
     * Default WP API prefix.
     * Including leading and trailing slashes.
     */
    const WP_API_PREFIX = '/wp-json/';

    /**
     * Default User Agent.
     * No version number.
     */
    const USER_AGENT = 'WooCommerce API Client-PHP';

    /**
     * Options.
     *
     * @var array
     */
    private $options;

    /**
     * Initialize HTTP client options.
     *
     * @param array $options Client options.
     */
    public function __construct($options)
    {
        $this->options = $options;
    }

    /**
     * Get API version.
     *
     * @return string
     */
    public function getVersion()
    {
        return isset($this->options['version']) ? $this->options['version'] : self::VERSION;
	}

    /**
     * Check to for basic auth.
     *
     * @return bool
     */
    public function basicAuth()
    {
        return isset($this->options['query_auth_type']) ? $this->options['query_auth_type'] == 'BASIC' : false;
    }

    /**
     * Check if need to verify SSL.
     *
     * @return bool
     */
    public function verifySsl()
    {
        return isset($this->options['verify_ssl']) ? (bool) $this->options['verify_ssl'] : true;
    }

    /**
     * Get timeout.
     *
     * @return int
     */
    public function getTimeout()
    {
        return isset($this->options['timeout']) ? (int) $this->options['timeout'] : self::TIMEOUT;
    }

    /**
     * Check if is WP REST API.
     *
     * @return bool
     */
    public function isWPAPI()
    {
        return isset($this->options['wp_api']) ? (bool) $this->options['wp_api'] : true;
    }

    /**
     * Custom API Prefix for WP API.
     *
     * @return string
     */
    public function apiPrefix()
    {
        return isset($this->options['wp_api_prefix']) ? $this->options['wp_api_prefix'] : self::WP_API_PREFIX;
    }

    /**
     * Custom user agent.
     *
     * @return string
     */
    public function userAgent()
    {
        return isset($this->options['user_agent']) ? $this->options['user_agent'] : self::USER_AGENT;
    }

    /**
     * Get follow redirects
     *
     * @return bool
     */
    public function getFollowRedirects()
    {
        return isset($this->options['follow_redirects']) ? (bool) $this->options['follow_redirects'] : false;
    }
}
