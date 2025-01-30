<?php

function renderView($viewName, $variables = [])
{
    // Extract variables array into individual variables
    extract($variables);

    // Include the header (from your Layers folder)
    include 'views/Layers/header.php';

    // Include the specific page's view
    include "views/{$viewName}.php";

    // Include the footer (from your Layers folder)
    include 'views/Layers/footer.php';
}

