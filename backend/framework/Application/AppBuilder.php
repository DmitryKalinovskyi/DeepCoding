<?php

namespace Framework\Application;

use Closure;
use Framework\Dependency\IServiceCollection;
use Framework\Exceptions\ServiceConflictException;
use Framework\Exceptions\ServiceNotResolvedException;
use Framework\Http\HttpContext;
use Framework\middlewares\Routing\ControllerRouter;
use Framework\middlewares\Routing\Router;
use Framework\MVC\ControllerBase;
use Framework\MVC\Views\ViewRenderer;

class AppBuilder{
    private App $app;

    private array $middlewares;

    public function __construct(){
        $this->app = new App();
    }

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

    public function useHttpContext(): self{
        $this->app->services->addScoped(HttpContext::class);
        return $this;
    }

    /**
     * @throws ServiceConflictException
     */
    public function useControllers(): self{
        $this->app->services->addScoped(ControllerRouter::class);
        return $this;
    }

    /**
     * @throws ServiceConflictException
     */
    public function useServerSideRendering(): self{
        $this->app->services->addScoped(ViewRenderer::class);
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
