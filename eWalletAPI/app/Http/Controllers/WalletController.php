<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function checkBalance(){
    $user_wallet_addr = $this->user()->user_wallet_addr;

    $result = DB::select('CALL `ewallet`.`spCheckBalance`(?, ?, @out)',array($user_wallet_addr, 1));

    return $result;
  }

  public function pay(Request $request){
    $sender_wallet_addr = $this->user()->user_wallet_addr;
    $receiver_wallet_addr = $request->receiver_wallet_addr;
    $amount = $request->amount;

    $status = DB::select('CALL `ewallet`.`spMakeTransaction`(?, ?, ?)',array($sender_wallet_addr, $receiver_wallet_addr, $amount));

    return $status;
  }

  public function topup(Request $request){
    $sender_wallet_addr = env('ADMIN_ADDR', ''); // admin wallet address
    $receiver_wallet_addr = $this->user()->user_wallet_addr;
    $amount = $request->amount;

    $status = DB::select('CALL `ewallet`.`spMakeTransaction`(?, ?, ?)',array($sender_wallet_addr, $receiver_wallet_addr, $amount));

    return $status;
  }

  private function user(){
    return auth()->guard('api')->user();
  }
}
