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
    protected ?Session $session = null;

    protected function __construct()
    {
        $this->route = Route::getInstance();
        $this->request = Request::getInstance();
        $this->response = new Response();
        $this->session = new Session();
    }

    protected function getParam(string $key,$default=null)
    {
        if(is_int($default)){
            return $this->request->getQStrInt($key,$default);
        }
        else if(is_string($default)){
            return $this->request->getQStr($key,$default);
        }
        else{
            throw new \Exception("'default' paramater needed a value");
        }
    }

    protected function getPost(string $key,$default=null)
    {
        if(is_int($default)){
            return $this->request->getPostInt($key,$default);
        }
        else if(is_string($default)){
            return $this->request->getPost($key,$default);
        }
        else if(is_null($default)){
            return $this->request->getPostObject($key);
        }
    }

    protected function getJson()
    {
        return $this->request->bodyjson();
    }

    /**
     * @param string|array|object $v
     */
    public function output(int $code,$v='')
    {
        $this->response->json($code,$v);
    }

    protected function isGet():bool
    {
        $method = $this->request->requestMethod();
        return $method=='GET'?true:false;
    }

    protected function isPost():bool
    {
        $method = $this->request->requestMethod();
        return $method=='POST'?true:false;
    }
}
