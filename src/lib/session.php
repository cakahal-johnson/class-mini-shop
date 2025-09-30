<?php

// safe session start with regeneration
if(session_status() === PHP_SESSION_NONE){
    session_start();
    // optional: regenerate id every N requests
    if(!isset($_SESSION['regen'])) {
        $_SESSION['regen'] = time();
    } elseif (time() - $_SESSION['regen'] > 300) {
        session_regenerate_id(true);
        $_SESSION['regen'] = time();
    }
}