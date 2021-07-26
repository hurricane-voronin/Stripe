<?php

namespace Payum\Stripe;

final class Keys
{
    /** @var string */
    private $publishable;

    /** @var string */
    private $secret;

    /** @var array */
    private $paymentMethodTypes = [];

    /** @var string */
    private $signingSecret;

    public function __construct(string $publishable, string $secret, ?array $paymentMethodTypes = [], string $signingSecret = '')
    {
        if (empty($paymentMethodTypes)) {
            $paymentMethodTypes[] = Constants::PAYMENT_METHOD_TYPE_CARD;
        }

        $this->publishable = $publishable;
        $this->secret = $secret;
        $this->paymentMethodTypes = $paymentMethodTypes;
        $this->signingSecret = $signingSecret;
    }

    public function getSecretKey(): string
    {
        return $this->secret;
    }

    public function getPublishableKey(): string
    {
        return $this->publishable;
    }

    public function getPaymentMethodTypes(): array
    {
        return array_values($this->paymentMethodTypes);
    }

    public function getSigningSecret(): string
    {
        return $this->signingSecret;
    }
}
