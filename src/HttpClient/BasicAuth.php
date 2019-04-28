<?php
/**
 * WooCommerce Basic Authentication
 *
 * @category HttpClient
 * @package  Hexboy/WooCommerce
 */

namespace Hexboy\WooCommerce\HttpClient;

/**
 * Basic Authentication class.
 *
 * @package Hexboy/WooCommerce
 */
class BasicAuth
{

    /**
     * Username.
     *
     * @var string
     */
    protected $username;

    /**
     * Password.
     *
     * @var string
     */
    protected $password;

    /**
     * Request headers.
     *
     * @var array
     */
    protected $headers;

    /**
     * Initialize Basic Authentication class.
     *
     * @param resource $ch             cURL handle.
     * @param string   $username    Username.
     * @param string   $password Password.
     */
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;

        $this->processAuth();
    }

    /**
     * Process auth.
     */
    protected function processAuth()
    {
        $this->headers = ['Authorization' => 'Basic ' . base64_encode($this->username . ':' . $this->password)];
    }

    /**
     * Get headers.
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}
