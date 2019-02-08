<?php

namespace App\Api;

use Stripe\Card;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Token;

/**
 * Class Stripe
 * @package App\Api
 * Connection with the Stripe's API
 */
class Stripe
{

    /**
     * Stripe constructor.
     * Set the token to Stripe
     * @param string $token
     */
    public function __construct(string $token)
    {
        \Stripe\Stripe::setApiKey($token);
    }

    /**
     * Retrieve the user's card with the token
     * @param string $token
     * @return Card
     */
    public function getCardFromToken(string $token): Card
    {
        return Token::retrieve($token)->card;
    }

    /**
     * Retrieve the customer with the customer's id
     * @param string $customerId
     * @return \Stripe\StripeObject
     */
    public function getCustomer(string $customerId)
    {
        return Customer::retrieve($customerId);
    }

    /**
     * Create a customer
     * @param array $data
     * @return \Stripe\ApiResource
     */
    public function createCustomer(array $data)
    {
        return Customer::create($data);
    }

    /**
     * Return a card from the token
     * @param $customer
     * @param string $token
     * @return Card
     */
    public function createCardForCustomer($customer, string $token): Card
    {
        return $customer->sources->create(['source' => $token]);
    }

    /**
     * Create and return the charge
     * @param array $data
     * @return \Stripe\ApiResource
     */
    public function createCharge(array $data)
    {
        return Charge::create($data);
    }

}