<?php
use Doctrine\ORM\Tools\Setup;
use Josy\Framework;
use Symfony\Component\DependencyInjection;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\EventDispatcher;
use Symfony\Component\HttpFoundation;
use Symfony\Component\HttpKernel;
use Symfony\Component\Routing;

$containerBuilder = new DependencyInjection\ContainerBuilder();

$containerBuilder->register('context', Routing\RequestContext::class);

if(isset($routes)){
    $containerBuilder->register('matcher', Routing\Matcher\UrlMatcher::class)
        ->setArguments(array($routes, new Reference('context')));
}

$containerBuilder->register('request_stack', HttpFoundation\RequestStack::class);

$containerBuilder->register('controller_resolver', HttpKernel\Controller\ControllerResolver::class);

$containerBuilder->register('argument_resolver', HttpKernel\Controller\ArgumentResolver::class);

$containerBuilder->register('listener.router', HttpKernel\EventListener\RouterListener::class)
    ->setArguments(array(new Reference('matcher'), new Reference('request_stack')));

$containerBuilder->register('listener.response', HttpKernel\EventListener\ResponseListener::class)
    ->setArguments(array('UTF-8'));

$containerBuilder->register('listener.exception', HttpKernel\EventListener\ExceptionListener::class)
    ->setArguments(array('Josy\Controller\ErrorController::exceptionAction'));

$containerBuilder->register('dispatcher', EventDispatcher\EventDispatcher::class)
        ->addMethodCall('addSubscriber', array(new Reference('listener.router')))
        ->addMethodCall('addSubscriber', array(new Reference('listener.response')))
        ->addMethodCall('addSubscriber', array(new Reference('listener.exception'))
    );
$containerBuilder->register('framework', Framework::class)
    ->setArguments(array(
        new Reference('dispatcher'),
        new Reference('controller_resolver'),
        new Reference('request_stack'),
        new Reference('argument_resolver'),
    ));
$conn= include join(DIRECTORY_SEPARATOR, [__DIR__, '..','..','..','config', 'db_connect.php']);
$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$entitiesPath = [
    join(DIRECTORY_SEPARATOR, [__DIR__, "Entity"])
];
$config = Setup::createAnnotationMetadataConfiguration(
    $entitiesPath,
    $isDevMode,
    $proxyDir,
    $cache,
    $useSimpleAnnotationReader
);
$containerBuilder->register('entity_manager', Josy\DoctrineManager::class)
->setArguments(array(
    $conn,
    $config
));


return $containerBuilder;
