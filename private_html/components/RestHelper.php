<?php
/**
 * Created by PhpStorm.
 * User: Yusef
 * Date: 2/17/2018
 * Time: 5:13 PM
 */

namespace app\components;

use linslin\yii2\curl\Curl;
use yii\base\Component;
use yii\helpers\Json;
use yii\web\HttpException;

/**
 * Class RestHelper
 * @package app\components
 */

class RestHelper extends Component
{
    /**
     * @var string $host
     */
    public $host;
    /**
     * @var string $port
     */
    public $port=80;
    /**
     * @var bool $throwException
     */
    protected $throwException = false;
    /**
     * @var bool $_connectionValid
     */
    private  $_connectionValid = false;

    private $client;

    public function init($throwException = false)
    {
        parent::init();
        $this->throwException = $throwException;
        if(!$this->_connectionValid) {
            if (!$this->host || empty($this->host) || !$this->port || empty($this->port))
                throw new HttpException(500, 'Rest Host IP or Port not been set in config.');
//            if ($socks = @fsockopen($this->host, $this->port, $errno, $errstr, Setting::get('server.timeout') ?: 30))
//                fclose($socks);
//            else
//                throw new \Exception(trim($errstr),$errno);
            if (strpos($this->host, '/', strlen($this->host) - 1) === false)
                $this->host .= '/';
            $this->_connectionValid = true;
        }
        $this->client = new Curl();
    }

    private function reset()
    {
        $this->client->reset();
        $this->client
            ->setOption(CURLOPT_ENCODING, 'gzip')
            ->setHeaders([
                'Content-type' => "application/json",
                'Cache-Control' => "no-cache",
            ]);
    }

    /**
     * Get Request
     *
     * @param $action
     * @param array $params
     * @return int|mixed|null|string
     * @throws HttpException
     */
    public function post($action, $params = [])
    {
        $this->reset();
        if ($params)
            $this->client->setRawPostData(json_encode($params));
//                ->setPostParams($params);
        $response = $this->client->post($this->host . $action);
        return $this->normalizeResponse($response);
    }

    /**
     * Post Request
     *
     * @param $action
     * @param array $params
     * @return int|mixed|null|string
     * @throws HttpException
     */
    public function get($action, $params = [])
    {
        $this->reset();
        if ($params)
            $this->client->setGetParams($params);
        $response = $this->client->get($this->host . $action);
        return $this->normalizeResponse($response);
    }

    /**
     * @return RestHelper
     */
    public static function client()
    {
        return new RestHelper();
    }

    /**
     * @param $response
     * @return int|mixed|null|string
     * @throws HttpException
     */
    protected function normalizeResponse($response)
    {
        // List of status codes here http://en.wikipedia.org/wiki/List_of_HTTP_status_codes
        switch ($this->client->responseCode) {
            case 'timeout':
                //timeout error logic here
                break;
            case 404:
                //404 Error logic here
                break;
        }

        if ($this->client->errorCode === null || $this->client->errorCode === CURLE_OK) {
            if ($this->client->responseType == 'application/json')
                return Json::decode($response, false);
            return $response;
        } else {
            $this->_connectionValid = false;
            // List of curl error codes here https://curl.haxx.se/libcurl/c/libcurl-errors.html
            switch ($this->client->errorCode) {
                case CURLE_COULDNT_RESOLVE_HOST:
                    $message = 'Couldn\'t resolve host. The given remote host was not resolved.';
                    break;
                case CURLE_COULDNT_CONNECT:
                    $message = 'Failed to connect to host.';
                    break;
                default:
                    $message = $this->client->errorCode;
                    break;
            }
            if ($this->throwException)
                throw new HttpException(500, $message);
            return $message;
        }
    }
}