<?php
function str2html(string $string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
