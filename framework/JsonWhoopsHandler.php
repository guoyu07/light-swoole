<?php 

namespace LightSwoole\Framework;


use Whoops\Exception\Formatter;
use Whoops\Handler\Handler;
use League\Route\Http\Exception\HttpExceptionInterface;


class JsonWhoopsHandler extends Handler
{

    /**
     * @var http status code
     */
    private $status_code = 500;

    /**
     * @var bool
     */
    private $jsonApi = false;

    /**
     * Returns errors[[]] instead of error[] to be in compliance with the json:api spec
     * @param bool $jsonApi Default is false
     * @return $this
     */
    public function setJsonApi($jsonApi = false)
    {
        $this->jsonApi = (bool) $jsonApi;
        return $this;
    }

    /**
     * @return int
     */
    public function handle()
    {
        $e = $this->getException();
        if ($e instanceof HttpExceptionInterface) {
            $code = $e->getStatusCode();
            $this->status_code = $code;
        }  else {
            $code = 500;
        }
        if ($this->jsonApi === true) {
            $response = [
                'code' => $code,
                'msg' => $e->getMessage(),
                'errors' => [
                    Formatter::formatExceptionAsDataArray(
                        $this->getInspector(),
                        false
                    ),
                ]
            ];
        } else {
            $response = [
                'code' => $code,
                'msg' => $e->getMessage(),
                'error' => Formatter::formatExceptionAsDataArray(
                    $this->getInspector(),
                    false
                ),
            ];
        }

        $this->getRun()->sendHttpCode($this->status_code);
        echo json_encode($response, defined('JSON_PARTIAL_OUTPUT_ON_ERROR') ? JSON_PARTIAL_OUTPUT_ON_ERROR : 0);

        return Handler::QUIT;
    }

    /**
     * @return string
     */
    public function contentType()
    {
        return 'application/json';
    }
}