<?php
/**
 * Created by PhpStorm.
 * User: marcamon
 * Date: 07/10/2016
 * Time: 20:13
 */

$app->add(new \App\Middleware\ValidationMiddleware($container));
$app->add(new \App\Middleware\CsrfMiddleware($container));
$app->add($container->get('csrf'));