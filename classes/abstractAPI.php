<?php

abstract class abstractAPI
{
    /*
    * the resource URI: /<model>/<verb>/<arg0>/<arg1>
    */

    /* GET, POST, PUT or DELETE  */
    protected $method = '';

    /* An optional additional descriptor about the resource */
    protected $verb = '';

    /* array arguments */
    protected $args = Array();

    /* data sent by POST or PUT request  */
    protected $content = Null;

    public function __construct($request)
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");

        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->args = explode('/', rtrim($request, '/'));

        if (array_key_exists(0, $this->args) && !is_numeric($this->args[0]))
        {
            $this->verb = array_shift($this->args);
        }

        if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) 
        {
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
                $this->method = 'DELETE';
            } else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
                $this->method = 'PUT';
            } else {
                throw new Exception("Unexpected Header");
            }
        }

        switch($this->method) 
        {
            case 'DELETE':
                break;
            case 'POST':
                $this->request = $this->_cleanInputs($_POST);
                $this->content = file_get_contents("php://input");
                break;
            case 'GET':
                $this->request = $this->_cleanInputs($_GET);
                break;
            case 'PUT':
                $this->request = $this->_cleanInputs($_GET);
                $this->content = file_get_contents("php://input");
                break;
            default:
                $this->_response('Invalid Method', 405);
                break;
        }
    }

    abstract public function process();

    protected function _response($data, $status = 200)
    {
        header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));
        return json_encode($data);
    }

    private function _cleanInputs($data)
    {
        $clean_input = Array();
        if (is_array($data))
        {
            foreach ($data as $k => $v) {
                $clean_input[$k] = $this->_cleanInputs($v);
            }
        }
        else
        {
            $clean_input = trim(strip_tags($data));
        }
        return $clean_input;
    }

    private function _requestStatus($code)
    {
        $status = array(
            200 => 'OK',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        );
        return ($status[$code]) ?$status[$code] : $status[500];
    }
}