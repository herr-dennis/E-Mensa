<?php

/**
 * Praktikum DBWT. Autoren:
 * Dennis, Schwarz, 3557435
 * Przemyslaw, Slusarczyk, 3278806
 */
function add ( int $wert1, int $wert2=0 ): int{

    $wert1 = $wert1 + $wert2;

    return $wert1;
}
function mult (int $wert1 , int $wert2):int{

    return $wert2*$wert1;

}