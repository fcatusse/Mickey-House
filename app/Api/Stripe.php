<?php

namespace App\Api;

use Stripe\Card;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Token;

class Stripe
{

    public function __construct(string $token)
    {
        \Stripe\Stripe::setApiKey($token);
    }

    public function getCardFromToken(string $token): Card
    {
        return Token::retrieve($token)->card;
    }

    public function getCustomer(string $customerId)
    {
        return Customer::retrieve($customerId);
    }

    public function createCustomer(array $data)
    {
        return Customer::create($data);
    }

    public function createCardForCustomer($customer, string $token): Card
    {
        return $customer->sources->create(['source' => $token]);
    }

    public function createCharge(array $data)
    {
        return Charge::create($data);
    }

}