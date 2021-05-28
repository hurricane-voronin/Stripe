<?php

namespace Payum\Stripe;

final class Constants
{
    public const STATUS_SUCCEEDED = 'succeeded';

    public const STATUS_PAID = 'paid';

    public const STATUS_FAILED = 'failed';

    public const PAYMENT_METHOD_TYPE_CARD = 'card';
    public const PAYMENT_METHOD_TYPE_BANCONTACT = 'bancontact';
    public const PAYMENT_METHOD_TYPE_EPS = 'eps';
    public const PAYMENT_METHOD_TYPE_GIROPAY = 'giropay';
    public const PAYMENT_METHOD_TYPE_IDEAL = 'ideal';
    public const PAYMENT_METHOD_TYPE_P24 = 'p24';

    private function __construct()
    {
    }
}
