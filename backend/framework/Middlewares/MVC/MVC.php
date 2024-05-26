<?php

namespace Framework\Middlewares\MVC;

use Framework\Dependency\IServiceCollection;
use Framework\Http\HttpContext;
use Framework\Middlewares\Routing\ControllerRouter;
use Framework\MVC\Views\ViewRenderer;

class MVC
{
    public function __invoke(IServiceCollection $services, $next): void{
        $services->addScoped(HttpContext::class);
        $services->addScoped(ControllerRouter::class);
        $services->addScoped(ViewRenderer::class);

        $next();
    }
}