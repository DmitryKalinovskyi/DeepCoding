<?php

class ControllerBase{
    public function Render(string $viewUri, array $data = []): void{
        extract($data);

        include "views/$viewUri";
    }
}
