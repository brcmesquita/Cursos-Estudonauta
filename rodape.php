<?php

    echo "<footer>";
    echo "<p>Acessado por " . $_SERVER['REMOTE_ADDR'];
    echo " em " . date('d/m/y') . "</p>";
    echo "<p>Desenvolvido com ♥ por Raphael Cabral © 2021-" . date('Y') . "</p>";




    $banco->close();