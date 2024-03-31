<?php

namespace Framework\mvc;

class ControllerBase{
    protected function render(string $viewUri, array $data = []): void{
        // extract to the local space, and extract to global variable
        extract($data);

        include "views/$viewUri";
    }

    // TODO: write redirect methods
    // TODO: add middlewares

}
