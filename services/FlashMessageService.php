<?php

function handleFlashMessages()
{
    $flash_message = '';
    if (isset($_SESSION['flash'])) {
        $flash_message = $_SESSION['flash'];
        unset($_SESSION['flash']);
    }
}
