<?php

$router = $di->getRouter();

// Define your routes here
$router->addGet(
    "/curl/get", array(
        'controller' => 'curl',
        'action' => 'get',
    )
);
$router->addPost(
    "/curl/post", array(
        'controller' => 'curl',
        'action' => 'post',
    )
);
$router->addPut(
    "/curl/put/([0-9]+)", array(
        'controller' => 'curl',
        'action' => 'put',
        'param' => 1
    )
);
$router->addDelete(
    "/curl/delete/([0-9]+)", array(
        'controller' => 'curl',
        'action' => 'delete',
        'param' => 1
    )
);

$router->handle();
