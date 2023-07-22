<?php 

    session_start();

    if(!isset($_SESSION['user'])) {
        header('Location: login.php');
    }

?>

<?php require __DIR__ . '/partials/header.php' ?>
<?php

// Note: The path to python.exe may vary on your system. You might need to adjust the path accordingly.
$python = "C:/Users/DELL/AppData/Local/Programs/Python/Python310/python.exe";

// Get the Python script's path
$pythonScript = "C:\Users\DELL\Pictures\Assessment\main.py";
$ans = null;

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $function_name = "solveExpression";
    $param1 = $_POST['expression'];

    if ($param1) {
        exec("$python $pythonScript $function_name $param1 ", $output, $return_var);


        // Output any result or error
        if ($return_var === 0) {
            // echo "Python script executed successfully!";
            // print_r($output[0]);
            $ans = $output[0];
            
        } else {
            echo "Error executing Python script!";
        }
    }
}

?>

<div class="container">
    <div class="calculator">
        <div class="display">
            <p id="result" class="result"><?= isset($ans) ? $ans : 0 ?></p>
        </div>

        <div class="keys">
            <div class="rows">
                <button class="key sci">sin</button>
                <button class="key sci">cos</button>
                <button class="key sci">tan</button>
                <button class="key pow" data-operator="^">x<sup>n</sup></button>
                <button class="key sqrt">sqrt</button>
            </div>

            <div class="rows">
                <button class="key num">7</button>
                <button class="key num">8</button>
                <button class="key num">9</button>
                <button class="key AC">AC</sup></button>
                <button class="key DEL">DEL</button></button>
            </div>
            <div class="rows">
                <button class="key">6</button>
                <button class="key">5</button>
                <button class="key">4</button>
                <button class="key">+</sup></button>
                <button class="key">-</button>
            </div>
            <div class="rows">
                <button class="key">3</button>
                <button class="key">2</button>
                <button class="key">1</button>
                <button class="key">*</sup></button>
                <button class="key">/</button>
            </div>
            <div class="rows">
                <button class="key">(</button>
                <button class="key">0</button>
                <button class="key">)</button>
                <button class="key">.</sup></button>
                <form action="" method="post" class="key equals">
                    <input type="hidden" id="expression" name="expression" value="<?= $ans ?>">
                    <button type="submit" class="submit">=</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php require __DIR__ . '/partials/footer.php' ?>