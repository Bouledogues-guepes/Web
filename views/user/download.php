<?php

    $json=$user;

    header('Content-disposition: attachment; filename=donnee.json');
    header('Content-type: application/json');

    json_encode($json);


?>