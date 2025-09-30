<?php

function redirect($path) {
    header("Location: " . BASE_URL . $path);
    exit;
}

// function flash message
function flash($name, $message = '', $class = 'alert alert-info') {   
    if ($message) {
        $_SESSION['flash'][$name] = ['msg' => $message, 'class'=> $class];
    } else {    
        $flash = $_SESSION['flash'][$name];
        unset($_SESSION['flash'][$name]);
        return '<div class="' . $flash['class'] . '">' . htmlspecialchars($flash['msg']) .'</div>';

    } 
    return '';
}

// functions for price
function priceFormat($num){
    return '$' . number_format($num, 2);
}