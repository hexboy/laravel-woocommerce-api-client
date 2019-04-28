<?php
/**
 * WooCommerce REST API Client
 *
 * @category WooCommerceClient
 * @package  Hexboy/WooCommerce
 */

namespace Hexboy\WooCommerce;

use Hexboy\WooCommerce\HttpClient\HttpClient;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;

/**
 * REST API Client class.
 *
 * @package Hexboy/WooCommerce
 */
class WooCommerceClient
{

    /**
     * WooCommerce REST API WooCommerceClient version.
     */
    const VERSION = '1.0.0';

    /**
     * Store API URL.
     *
     * @var string
     */
    protected $url;

    /**
     * Client options.
     *
     * @var Options
     */
    protected $options;

    /**
     * HttpClient instance.
     *
     * @var HttpClient
     */
    public $http;

    /**
     * Initialize client.
     *
     * @param string $url          Store URL.
     * @param array  $options      Options (version, timeout, verify_ssl).
     */
    public function __construct($url, $options = [])
    {
        $this->url = $url;
        $this->options = $options;
        $this->http = new HttpClient($url, [], $options);
    }


    /**
     * init woocommerce client.
     * @param array $authParams Authenticate data (username, password, token).
     */
    public function auth($authParams)
    {
        $this->http = new HttpClient($this->url, $authParams, $this->options);
    }

    /**
     * POST method.
     *
     * @param string $endpoint API endpoint.
     * @param array  $data     Request data.
     *
     * @return array
     */
    public function post($endpoint, $data)
    {
        return $this->http->request($endpoint, 'POST', $data);
    }

    /**
     * PUT method.
     *
     * @param string $endpoint API endpoint.
     * @param array  $data     Request data.
     *
     * @return array
     */
    public function put($endpoint, $data)
    {
        return $this->http->request($endpoint, 'PUT', $data);
    }

    /**
     * GET method.
     *
     * @param string $endpoint   API endpoint.
     * @param array  $parameters Request parameters.
     *
     * @return array
     */
    public function get($endpoint, $parameters = [], $paginate = false)
    {
        if (!isset($parameters['page'])) {
            $parameters['page'] = Input::get('page', 1);
        }

        if (!isset($parameters['per_page'])) {
            $parameters['per_page'] = 10;
        }

        $result = $this->http->request($endpoint, 'GET', [], $parameters);

        if ($paginate == false) {
            return $result;
        }

        return new LengthAwarePaginator($result, $this->totalResults(), $parameters['per_page']);
    }

    /**
     * DELETE method.
     *
     * @param string $endpoint   API endpoint.
     * @param array  $parameters Request parameters.
     *
     * @return array
     */
    public function delete($endpoint, $parameters = [])
    {
        return $this->http->request($endpoint, 'DELETE', [], $parameters);
    }

    /**
     * OPTIONS method.
     *
     * @param string $endpoint API endpoint.
     *
     * @return array
     */
    public function options($endpoint)
    {
        return $this->http->request($endpoint, 'OPTIONS', [], []);
	}

    /**
     * Get the http response headers from the last request
     *
     * @return \Hexboy\WooCommerce\HttpClient\Response
     */
    public function getResponse()
    {
        return $this->http->getResponse();
	}

	/**
     * Return the total number of pages for this result
     *
     * @return mixed
     */
    public function totalPages()
    {
        return (int)$this->getResponse()->getHeaders()['X-WP-TotalPages'];
    }

    /**
     * Return the total number of results
     *
     * @return int
     */
    public function totalResults()
    {
        return (int)$this->getResponse()->getHeaders()['X-WP-Total'];
    }
}
