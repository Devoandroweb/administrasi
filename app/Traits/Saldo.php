<?php

namespace App\Traits;

use App\Models\MSaldo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait Saldo
{

    public function updateSaldo($saldoBalance,$plus = true)
    {
        $saldo = MSaldo::first();
        if($plus){
            $saldo->saldo = (int)$saldo->saldo + $saldoBalance;
        }else{
            $saldo->saldo = (int)$saldo->saldo - $saldoBalance;
        }
        $saldo->update();
        return $saldo->saldo;
    }
    function cekSaldo($total)
    {
        $saldo = MSaldo::first()->saldo;
        if ($saldo >= (int)$total) {
            return true;
        }
        return false;
    }
}