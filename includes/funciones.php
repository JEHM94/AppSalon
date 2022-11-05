<?php
define('CUENTA_NUEVA', 'cuenta_nueva');
define('CUENTA_EXISTENTE', 'cuenta_existente');

function debuguear($variable): string
{
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html): string
{
    $s = htmlspecialchars($html);
    return $s;
}
