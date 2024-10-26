<?php

session_start();

if (!isset($_SESSION['step'])) {
    $_SESSION['step'] = 0;
}

if (!isset($_SESSION['form_data'])) {
    $_SESSION['form_data'] = [];
}

$inputs = [
    'nama' => 'text',
    'umur' => 'number',
    'hobi' => 'text'
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $step = $_POST['step'];
    $next = $step + 1;

    $data = [];

    foreach (array_keys($inputs) as $key) {
        if (isset($_POST[$key]))
            $data[$key] = $_POST[$key];
    }

    $_SESSION['form_data'] = $data;
    $_SESSION['step'] = $next;
}


if ($_SESSION['step'] >= count($inputs)) {
    foreach ($_SESSION['form_data'] as $key => $value) {
        echo "<p><strong>" . ucfirst($key) . ":</strong> $value</p>";
    }

    session_destroy();
} else {
    $step = $_SESSION['step'];
    $input_keys = array_keys($inputs);
    $input_key = $input_keys[$step];
    $input_type = $inputs[$input_key];
    $title = ucfirst($input_key) . ' Anda: ';

    echo "<form method='POST'>";
    echo "<label>$title</label>";
    echo "<input type='$input_type' id='$input_key' name='$input_key' required />";

    foreach ($_SESSION['form_data'] as $key => $value) {
        echo "<input type='hidden' name='$key' value='$value'/>";
    }

    echo "<input type='hidden' name='step' value='$step'/>";
    echo "<br><br>";
    echo "<button type='submit'>Submit</button>";
    echo "</form>";
}
