<?php
require_once join(DIRECTORY_SEPARATOR, [__DIR__,'..','vendor', 'autoload.php']);

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpCache\Esi;
use Symfony\Component\HttpKernel\HttpCache\HttpCache;
use Symfony\Component\HttpKernel\HttpCache\Store;

$request = Request::createFromGlobals();

$routes = include join(DIRECTORY_SEPARATOR, [__DIR__, '..','content','modules','Josy','Routes', 'web.php']);
$container = include join(DIRECTORY_SEPARATOR, [__DIR__, '..','content','modules','Josy','Container.php']);

$framework= $container->get('framework');
$framework = new HttpCache(
    $framework,
    new Store(join(DIRECTORY_SEPARATOR, [__DIR__, '..','var','cache','cache'])),
    new Esi(),
//options
    array(
        'debug' => true,
    ));
$response =$framework->handle($request);
$response->send();