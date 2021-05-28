<?php

namespace Payum\Stripe\Action\CheckoutServer;

use Payum\Core\Action\ActionInterface;
use Payum\Core\ApiAwareInterface;
use Payum\Core\ApiAwareTrait;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Model\PaymentInterface;
use Payum\Core\Request\Convert;
use Payum\Stripe\Keys;

class ConvertPaymentAction implements ActionInterface, ApiAwareInterface
{
    use ApiAwareTrait {
        setApi as _setApi;
    }

    public function __construct()
    {
        $this->apiClass = Keys::class;
    }

    /**
     * {@inheritDoc}
     *
     * @param Convert $request
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);

        /** @var PaymentInterface $payment */
        $payment = $request->getSource();

        $details = ArrayObject::ensureArrayObject($payment->getDetails());
        $details['customer_email'] = $payment->getClientEmail();
        $details['client_reference_id'] = $payment->getNumber();
        $details['payment_intent_data'] = [
            'description' => $payment->getDescription(),
            'metadata' => [
                'paymentNumber' => $payment->getNumber(),
            ],
        ];
        $details['line_items'] = [[
            'name' => $payment->getDescription(),
            'amount' => $payment->getTotalAmount(),
            'currency' => $payment->getCurrencyCode(),
            'quantity' => 1
        ]];
        $details['payment_method_types'] = $this->api->getPaymentMethodTypes();
        $details['mode'] = 'payment';
        $details['submit_type'] = 'pay';
        $details['locale'] = 'auto';

        $request->setResult((array) $details);
    }

    /**
     * {@inheritDoc}
     */
    public function supports($request)
    {
        return
            $request instanceof Convert &&
            $request->getSource() instanceof PaymentInterface &&
            $request->getTo() == 'array'
        ;
    }
}
