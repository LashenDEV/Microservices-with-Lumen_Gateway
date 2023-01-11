<?php

require_once __DIR__.'/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

date_default_timezone_set(env('APP_TIMEZONE', 'UTC'));

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

 $app->withFacades();

 $app->withEloquent();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);


/*
|--------------------------------------------------------------------------
| Register Config Files
|--------------------------------------------------------------------------
|
| Now we will register the "app" configuration file. If the file exists in
| your configuration directory it will be loaded; otherwise, we'll load
| the default version. You may register other files below as needed.
|
*/

$app->configure('app');
$app->configure('services');
$app->configure('auth');

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

// $app->middleware([
//     App\Http\Middleware\ExampleMiddleware::class
// ]);

 $app->routeMiddleware([
//     'auth' => App\Http\Middleware\Authenticate::class,
     'client.credentials' => Laravel\Passport\Http\Middleware\CheckClientCredentials::class,
 ]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

// $app->register(App\Providers\AppServiceProvider::class);
// $app->register(App\Providers\EventServiceProvider::class);
$app->register(App\Providers\AuthServiceProvider::class);
$app->register(Laravel\Passport\PassportServiceProvider::class);
$app->register(Dusterio\LumenPassport\PassportServiceProvider::class);

/*eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI1IiwianRpIjoiMzYyODYzNTA0NGMxNzQ1MWU1YjA4MzUxZWJiODFkZDlkZjAzY2RkNjBkMWRmZThiODQ4MTZmOTE4ZWYwZmVkOGQxZDNjM2Y2YmI1MjViMWEiLCJpYXQiOjE2NzM0NDk5OTguNDMwNTk3LCJuYmYiOjE2NzM0NDk5OTguNDMwNjAyLCJleHAiOjE3MDQ5ODU5OTguNDE0NDQyLCJzdWIiOiIiLCJzY29wZXMiOltdfQ.KHZthUlrKc7mNGlW76ncu2_Qy5-f4gEDnUKSibSla-A32WHDjX7wNY8YYthOIEY_f7D9xlvhrxbGdhP9j8MbgDTCBNwkUnQugve6HJz1D4ZQL22RaTa30bq-TtMf3UL7UIMbv3pkdcdRnF7Mq5xL40AkTGawOQmIua3YBaLcoTFesqKbCPHT4gT7Vu7Za6Fo3hRgyFGLDya78SG8iBuk8P3i1vDa-lGKA-8dh-PmLvE2Q4KKiYtZIeep_O4jbBzMUkxe2FNGS2ijPSt9EUs54tRA9lAgeUf1hckGE5-pixyTQJkZwCO3zBgXFayd8ausMimOLI-A3HFHVKIJjzXhlK4lisqGJATCYLmjtK0Xw2SS_lIyflVu48AmEqrGoV1lmYfGJjGPmzkwmXE25DJLdzW8M-JxtYoJrAiS1LdzWfuQ3XSnuzZ3C4Bu2RTxpdJaZVUKQXtQl8CdE1cwAXAqmeohBHyqO-hXalH0mBQtAkU2kJl-Nl6fFuyg0aWrCcVD4lXevJHiz6qUGg-kXDnAvbGgQesmL5ZBuXWNwNmlz1NqJFosV1smgiVuO6ekC7tnH7PHyCVx1aCftSiWZ4PY8ALq4iEkAEX-rLM4qyaeXvnRi1ukClTV6lLZQp0_vkPtnTeyT02mqNHLd8pEjkPJWfljIGeLksYKZ80RhHMT5_A
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__.'/../routes/web.php';
});

return $app;
