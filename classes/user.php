<?php

require_once 'abstractAPI.php';

class User extends abstractAPI
{
    public function __construct($origin, $request)
    {
        // todo origin validation
        // todo security validation

        parent::__construct($request);

    }

    public function process ()
    {
        switch($this->method)
        {
            case 'GET':
                return $this->_response($this->getUser($this->args));
                break;
            case 'POST':
                return $this->_response($this->createUser($this->args, $this->content));
                break;
            case 'PUT':
                return $this->_response($this->updateUser($this->args, $this->content));
                break;
            case 'DELETE':
                return $this->_response($this->deleteUser($this->args));
                break;
        }
    }

    private function getUser($args)
    {
        /*
         * ...
         * todo search and retrieve implementation
         * ...
        */

        $user = array ('Firstname' => 'Bruce', 'Lastname' => 'Springsteen', 'job' => 'Singer', 'Result' => 'GET');

        return $user;
    }

    private function createUser($args, $content)
    {
        parse_str($content, $data);

        $user = array ('firstname' => $data['firstname'], 'lastname' => $data['lastname'], 'job' => $data['job'], 'Result' => 'POST');

        /*
         * ...
         * todo save implementation
         * ...
        */

        return $user;
    }

    private function updateUser($args, $content)
    {
        parse_str($content, $data);

        $user = array ('firstname' => $data['firstname'], 'lastname' => $data['lastname'], 'job' => $data['job'], 'Result' => 'PUT');

        /*
         * ...
         * todo save implementation
         * ...
        */

        return $user;
    }

    private function deleteUser($args)
    {
        /*
         * ...
         * todo delete implementation
         * ...
        */

        $user = array ('Firstname' => 'Bruce', 'Lastname' => 'Springsteen', 'job' => 'Singer', 'Result' => 'DELETE');

        return $user;
    }

}