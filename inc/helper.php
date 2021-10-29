<?php 

// =============== DEBUG ==================
function dd($variable, $dieOrNot = false) {
    echo '<pre>';
    print_r($variable);
    echo '</pre>';

    $dieOrNot ? die() : ''; 
}