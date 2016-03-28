<?php

$data = http_build_query(
    array(
        'firstname' => 'Bruce',
        'lastname' => 'Springsteen',
        'job' => 'Singer'
    )
);

$params = array('http' =>
    array(
        'method'  => 'DELETE',
        'header'  => 'Content-Type: application/json',
        'content' => $data
    )
);

$context  = stream_context_create($params);

$result = file_get_contents('http://localhost/restful/user/1', false, $context);

echo $result;