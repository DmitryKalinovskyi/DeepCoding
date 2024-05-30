<?php
/** @var \DeepCode\Models\Problem\Problem $problem */

use DeepCode\Models\Problem\Problem;


function getCodeTemplate(): string{

        $path = "code-templates/c++.txt";
        $file = fopen($path, 'r');

        $data = fread($file, filesize($path));

        fclose($file);

        return $data;
    }

?>

<form class="h-100" method="post">

<div class="d-flex flex-column h-100">
    <div class="bg-light rounded-2">
        <div class="input-group mb-2">
            <div class="input-group-text">
                Select your compiler:
            </div>
            <select class="form-control" name="compiler">
                <option>C</option>
                <option>C++</option>
            </select>
        </div>
    </div>

    <textarea name="code" placeholder="Enter your code here..." class="form-control editor-area flex-grow-1 mb-2"><?php echo getCodeTemplate()?></textarea>
    <input name="problemId" value="<?php echo $problem->Id ?> " hidden>
    <div>
    <button class="btn btn-indigo" type="submit">Send</button>
    </div>

</div>
</form>
