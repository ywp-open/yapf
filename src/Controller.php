<?php
namespace Yapf;

use Yapf\Request;
use Yapf\Response;
use Yapf\Route;
use Yapf\Session;

class Controller
{
    protected ?Request $request = null;
    protected ?Response $response = null;
    protected ?Route $route = null;

    protected function __construct()
    {
        $this->route = Route::getInstance();
        $this->request = Request::getInstance();
        $this->response = new Response();
    }

    protected function getSession():Session
    {
        return Session::getInstance();
    }

    protected function getParam(string $key, $default = null)
    {
        if (is_int($default)) {
            return $this->request->getQStrInt($key, $default);
        }
        else if (is_string($default)) {
            return $this->request->getQStr($key, $default);
        }
        else {
            throw new \Exception("'default' paramater needed a value");
        }
    }

    protected function getPost(string $key, $default = null)
    {
        if (is_int($default)) {
            return $this->request->getPostInt($key, $default);
        }
        else if (is_string($default)) {
            return $this->request->getPost($key, $default);
        }
        else if (is_null($default)) {
            return $this->request->getPostObject($key);
        }
        else{
            throw new \Exception("'default' paramater needed a value");
        }
    }

    protected function getJson(): ?object
    {
        return $this->request->bodyjson();
    }

    /**
     * @param string|array|object $v
     */
    public function output(int $code, $v = '')
    {
        $this->response->json($code, $v);
    }

    public function render(string $file_path,array $data=array())
    {
        $this->response->render($file_path,$data);
    }

    protected function isGet(): bool
    {
        $method = $this->request->requestMethod();
        return $method === 'GET';
    }

    protected function isPost(): bool
    {
        $method = $this->request->requestMethod();
        return $method === 'POST';
    }
}
