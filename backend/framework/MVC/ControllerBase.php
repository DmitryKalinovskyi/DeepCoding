<?php

namespace Framework\MVC;

class ControllerBase{
    protected function render(string $viewUri, array $data = []): void{
        // extract to the local space, and extract to global variable
        extract($data);

        include "src/Views/$viewUri";
    }

    public function redirect(string $url): void{
        header("Location: $url");
    }

    // TODO: write redirect methods
    // TODO: add Middlewares

}
