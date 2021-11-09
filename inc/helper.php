<?php 

// =============== DEBUG ==================
function pr($variable, $dieOrNot = false) {
    echo '<pre>';
    print_r($variable);
    echo '</pre>';

    $dieOrNot ? die() : ''; 
}