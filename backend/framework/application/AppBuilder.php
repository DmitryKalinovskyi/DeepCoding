<?php

namespace Framework\application;

use Closure;
use Framework\dependency\IServiceCollection;
use Framework\exceptions\ServiceConflictException;
use Framework\exceptions\ServiceNotResolvedException;
use Framework\http\HttpContext;
use Framework\middlewares\Routing\ControllerRouter;
use Framework\middlewares\Routing\Router;
use Framework\mvc\ControllerBase;
use Framework\mvc\Views\ViewRenderer;

class AppBuilder{
    private App $app;

    private array $middlewares;

    public function __construct(){
        $this->app = new App();
    }

    /**
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

    public function use(Closure $middleware): self{
        $this->middlewares[] = $middleware;

        return $this;
    }

    private function prepareMiddlewares(): ?Closure{
        $next = null;

        // link them
        for($i = count($this->middlewares)-1; $i >= 0; $i--){
            $middleware = $this->middlewares[$i];

            $next = function()use($middleware, $next){
                $this->services()->invokeFunction($middleware, ["next" => $next]);
            };
        }

        return $next;
    }

    public function useMiddleware(string $middlewareClass, array $constructorParams=[]): self{

        $middleware = $this->services()->resolve($middlewareClass, $constructorParams);

        $this->use($middleware(...));

        return $this;
    }

    public function build(): App{
        $this->use(function(ControllerRouter $router){
            $router->redirect($_SERVER['REQUEST_URI']);
        });

        $this->app->middlewarePipeline = $this->prepareMiddlewares();
        return $this->app;
    }

    public function services(): IServiceCollection{
        return $this->app->services;
    }
}
