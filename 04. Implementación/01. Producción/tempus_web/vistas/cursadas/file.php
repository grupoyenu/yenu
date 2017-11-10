<?php

    
    
    echo '<pre>'; print_r($_POST); echo '</pre>';
    
    if ($_POST['datePrimerLlamado']) {
        echo "<br> HAY FECHA DE PRIMER LLAMADO: " . $_POST['datePrimerLlamado'];
    } else {
        echo "<br> NO HAY FECHA DE PRIMER LLAMADO";
    }
    
    
    $primerllamado = $_POST['datePrimerLlamado'];
    
    if ($primerllamado) {
        echo "<br> HAY FECHA DE PRIMER LLAMADO: " . $primerllamado;
    } else {
        echo "<br> NO HAY FECHA DE PRIMER LLAMADO";
    }