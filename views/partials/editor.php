<?php

    function getCodeTemplate(): string{

        $path = "code-templates/c++.txt";
        $file = fopen($path, 'r');

        $data = fread($file, filesize($path));

        fclose($file);

        return $data;
    }

?>

<div>
    <div class="bg-light rounded-2">
        <select class="form-control">
            <option>C</option>
            <option>C++</option>
        </select>
    </div>

    <textarea placeholder="Enter your code here..." class="form-control" rows="18"><?php echo getCodeTemplate()?></textarea>
</div>