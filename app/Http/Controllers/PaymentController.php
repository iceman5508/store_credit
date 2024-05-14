<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Square\SquareClient;
use Square\Exceptions\ApiException;
use Square\Models\CreatePaymentRequest;
use Square\Models\Money;
use App\Models\{Package, Store};
use Square\Models\CreateCardRequest;
use Square\Models\Error;
use Square\Models\Card;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        $package = Package::find($request->subscription_package);
        $client = new SquareClient([
            'accessToken' => env('SQUARE_ACCESS_TOKEN'),
            'environment' => env('SQUARE_ENVIRONMENT')
        ]);
        $paymentsApi = $client->getPaymentsApi();
        $locationId = env('SQUARE_LOCATION_ID');
        $cardDetails = [
            'card_number' => $request->input('card_number'),
            'expiration' => $request->input('expiry_date'),
            'cvv' => $request->input('cvv'),
        ];

        $tokenizedCardDetails = $this->tokenizeCardDetails($client, $cardDetails);

        if ($tokenizedCardDetails === null) {
            return response()->json(['error' => 'Failed to tokenize card details'], 400);
        }
        $amount = $package->price;
        $amountMoney = new Money();
        $amountMoney->setAmount($amount * 100);
        $amountMoney->setCurrency('USD');
        $createPaymentRequest = new CreatePaymentRequest(
            $tokenizedCardDetails,
            $locationId
        );

        $createPaymentRequest->setIdempotencyKey(uniqid());
        $createPaymentRequest->setAmountMoney($amountMoney);

        try {
            $apiResponse = $paymentsApi->createPayment($createPaymentRequest);
            $paymentResult = $apiResponse->getResult();
            $paymentStatus = $paymentResult->getPayment()->getStatus();
            if($paymentStatus == 'COMPLETED')
            {
                $expiredAt = now();
                if ($request->subscription_package == 1) {
                    $expiredAt->addMonth();
                }
                elseif ($request->subscription_package == 2) {
                    $expiredAt->addYear();
                }
                $store = Store::find($request->store_id)->update([
                    'package_id' => $request->subscription_package,
                    'expired_at' => $expiredAt
                ]);
                if($store)
                {
                    return redirect()->route('addStore')->with('success', 'You subscribe '. $package->name .' successfully');
                }
            }
        } catch (ApiException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    private function tokenizeCardDetails($client, $cardDetails)
{
    try {
        $idempotencyKey = uniqid();
        $sourceId = uniqid();
        $customerId = 'TEST_CUSTOMER_ID';
        $card = new Card([
            'card' => [
                'number' => $cardDetails['card_number'],
                'expiration' => $cardDetails['expiration'],
                'cvv' => $cardDetails['cvv'],
                'customer_id' => $customerId
            ]
        ]);

        $createCardRequest = new CreateCardRequest(
            $idempotencyKey,
            $sourceId,
            $card,
        );
        $response = $client->getCardsApi()->createCard($createCardRequest);
        // return $response;
        // $cardNonce = $response->getResult()->getCard()->getNonce();
        // dd($cardNonce);
        $cardNonce = 'cnon:card-nonce-ok';
        return $cardNonce;
    } catch (ApiException $e) {
        $error = $e->getResponseBody()->getErrors()[0] ?? new Error();
        return null;
    }
}
}
