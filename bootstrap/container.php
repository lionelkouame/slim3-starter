<?php
/**
 * Created by PhpStorm.
 * User: marcamon
 * Date: 07/10/2016
 * Time: 16:09
 */

$container = $app->getContainer();

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function () use ($capsule) {
    return $capsule;
};

$container['auth'] = function () {
    return new App\Auth\Auth();
};

$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__ . '/../resources/views', [
        'cache' => false
    ]);

    $view->addExtension(new \Slim\Views\TwigExtension(
        $container->get('router'),
        $container->get('request')->getUri()
    ));

    $view->getEnvironment()->addGlobal('auth', [
        'check' => $container->get('auth')->check(),
        'user' => $container->get('auth')->user()
    ]);

    $view->getEnvironment()->addGlobal('flash', $container->get('flash'));
    return $view;
};


$container['validation'] = function () {
    return new \App\Validation\Validator;
};
$container['csrf'] = function () {
    return new \Slim\Csrf\Guard;
};

