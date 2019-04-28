<?php
/**
 * WooCommerce JWT Authentication
 *
 * @category HttpClient
 * @package  Hexboy/WooCommerce
 */

namespace Hexboy\WooCommerce\HttpClient;

/**
 * JWT Authentication class.
 *
 * @package Hexboy/WooCommerce
 */
class JWTAuth
{

    /**
     * JWT Token.
     *
     * @var string
     */
    protected $token;

    /**
     * Request headers.
     *
     * @var array
     */
    protected $headers;

    /**
     * Initialize JWT Authentication class.
     *
     * @param string   $token    Bearer token.
     */
    public function __construct($token)
    {
        $this->token = $token;

        $this->processAuth();
    }

    /**
     * Process auth.
     */
    protected function processAuth()
    {
        $this->headers = ['Authorization' => 'Bearer ' . $this->token];
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
