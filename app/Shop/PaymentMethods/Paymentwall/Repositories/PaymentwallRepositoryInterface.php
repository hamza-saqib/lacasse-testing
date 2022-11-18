<?php

namespace App\Shop\PaymentMethods\Paymentwall\Repositories;

use Illuminate\Http\Request;

interface PaymentwallRepositoryInterface
{
    public function getApiContext();

    public function process($shippingFee, Request $request);

    public function execute(Request $request);
}
