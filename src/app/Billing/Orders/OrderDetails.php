<?php

namespace App\Billing\Orders;

use App\Billing\PaymentGatewayContract;

class OrderDetails
{
    private $paymentGateway;

    public function __construct(PaymentGatewayContract $paymentGateway) {
        $this->paymentGateway = $paymentGateway;
    }

    public function all() {

        $this->paymentGateway->setDiscount(500);

        return [
            'name' => 'John Doe',
            'address' => 'New York',
        ];
    }
}
