<?php

namespace Framework\mvc;

class ControllerBase{
    public function Render(string $viewUri, array $data = []): void{
        // extract to the local space, and extract to global variable
        extract($data);
        $GLOBALS['_VIEW'] = $data;

        include "views/$viewUri";
    }
}
