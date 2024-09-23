<?php

function reCalcMonth($team, $date) 
{
    $output = db_connect()->table('progress')
    ->selectSum('coefficent')
    ->where('team', $team)
    ->where('date', $date)
    ->get()
    ->getRowArray();
    $progress = (!empty($output['coefficent'])) ? $output['coefficent'] : 0;

    $output2 = db_connect()->table('product_modification')
    ->selectSum('coef')
    ->where('team', $team)
    ->where('date', $date)
    ->get()
    ->getRowArray();
    $modifications = (!empty($output2['coef'])) ? $output2['coef'] : 0;

    $total = $progress + $modifications;
    return $total;
}  