<?php

namespace Framework\application;

use Closure;
use Framework\dependency\IServiceCollection;
use Framework\exceptions\ServiceConflictException;
use Framework\exceptions\ServiceNotResolvedException;
use Framework\http\HttpContext;
use Framework\middlewares\Middleware;
use Framework\middlewares\Routing\ControllerRouter;
use Framework\middlewares\Routing\Router;
use Framework\mvc\ControllerBase;
use Framework\mvc\Views\ViewRenderer;

class AppBuilder{
    private App $app;

    public function __construct(){
        $this->app = new App();
    }

    /**
     * @return void
     * @throws ServiceConflictException
     */
    public function useMVC(): self{
        $this->useHttpContext();
        $this->useControllers();
        $this->useServerSideRendering();

        return $this;
    }

    public function useCors(): self{
        header("Access-Control-Allow-Origin: *");
        return $this;
    }

    /**
     * @throws ServiceConflictException
     */
    public function useHttpContext(): self{
        $this->app->services->addSingleton(HttpContext::class, new HttpContext());
        return $this;
    }

    /**
     * @throws ServiceConflictException
     */
    public function useControllers(): self{
        $this->app->services->addScoped(ControllerRouter::class, ControllerRouter::class);
        return $this;
    }

    /**
     * @throws ServiceConflictException
     */
    public function useServerSideRendering(): self{
        $this->app->services->addScoped(ViewRenderer::class, ViewRenderer::class);
        return $this;
    }

//    public function useMiddleware(Middleware $middleware): self{
//        $this->app->useMiddleware($middleware);
//        return $this;
//    }

    public function use(Closure $middleware): self{
        $this->app->useMiddleware($middleware);

        return $this;
    }

    public function useMiddleware(string $middlewareClass, array $constructorParams=[]): self{
        // it should be inherited from Middleware

        $middleware = $this->services()->resolve($middlewareClass, $constructorParams);

        $this->app->useMiddleware($middleware);

        return $this;
    }

    public function build(): App{
        $this->app->useMiddleware(function(ControllerRouter $router){
            $router->redirect($_SERVER['REQUEST_URI']);
        });

        return $this->app;
    }

    public function services(): IServiceCollection{
        return $this->app->services;
    }
}


//class AppBuilder
//{
//    private App $_app;
//    /**
//     * @throws ServiceConflictException
//     */
//    public function __construct()
//    {
//        $this->_app = new App();
//        $this->_lastMiddleware = null;
//
//        $this->_app->services->addSingleton(HttpContext::class, new HttpContext());
//    }
//
//    /**
//     * @throws ServiceConflictException
//     */
//    public function useControllers():self {
//        $this->_app->services->addScoped(Router::class, Router::class);
//        $this->_app->services->addScoped(RouteMapper::class, RouteMapper::class);
//        return $this;
//    }
//    public function useMiddleware(Middleware $middleware): self{
//        if($this->_lastMiddleware !== null){
//            $this->_lastMiddleware->setNext($middleware);
//        }
//        else{
//            $this->_app->requestPipeline = $middleware;
//        }
//
//        $this->_lastMiddleware = $middleware;
//        return $this;
//    }
//
//    public function build(): App{
//
//        // assign router at the end
////        $this->useMiddleware($this->_router);
//
//        $app = $this->_app;
//        $this->_app = new App();
//
//        return $app;
//    }
//
//    public function services(): IServiceCollection{
//        return $this->_app->services;
//    }
//}