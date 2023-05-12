<?php

namespace App\Http\Controllers;

use App\Billing\PaymentGatewayContract;
use App\Billing\Orders\OrderDetails;
use Illuminate\Http\Request;

class PayOrderController extends Controller
{
    public function store(OrderDetails $orderDetails, PaymentGatewayContract $paymentGateway) {

    	$order = $orderDetails->all();
    	//$paymentGateway = new PaymentGateway('dollar');
    	dd($paymentGateway->charge(2500));

    }
}
