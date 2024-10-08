<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;



class HomeController extends Controller
{
    public function index()
    {
     $pendingOrdersCount = Order::where('status', 'pending')->count();
     $runningOrdersCount = Order::where('status', 'running')->count();
     $completeOrdersCount = Order::where('status', 'complete')->count();
     $declinedOrdersCount = Order::where('status', 'declined')->count();
     $returningOrdersCount = Order::where('status', 'returning')->count();
     $returnedOrdersCount = Order::where('status', 'returned')->count();


     $orderItems = Order::where('status','complete');
     $grandTotalSum = $orderItems->sum('grand_total');
     $usersCount = User::where('type', 'user')->count();
     $orderItem = Order::where('status','returned');
     $returnedGrandTotalSum = $orderItem->sum('grand_total');




             return view('admin.adminHome',compact('pendingOrdersCount','runningOrdersCount','completeOrdersCount','declinedOrdersCount','grandTotalSum','usersCount','returningOrdersCount','returnedOrdersCount','returnedGrandTotalSum'));
    }
}
