<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function showDelivery($id)
    {
        // 必要な処理をここに記述
        return view('user.delivery', compact('id'));
    }
}
