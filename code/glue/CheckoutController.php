<?php

class CheckoutController
{
    public function postCheckout(PostCheckoutRequest $request)
    {
        $orderData = $request->validated();

        $order = Order::query()->create($orderData);

        $content = $this->getContentForAPI($request, $order);

        $url = config('app.payment_url') . config('app.payment_api');
        $response = Curl::to($url)->withData($content)->post();

        $res = json_decode($response, true);

        if ($res['data']) {
            $payment_url = $res['data']['payment_url'];
            return redirect($payment_url);
        } else {
            return redirect()->route('main-page')->with('danger', 'On the side of payment system revealed problems. Please try again.');
        }
    }

    public function getContentForAPI($request, $order): array
    {
        return [
            "type" => $request->input('type'),
            "order_id" => $order->id,
            "currency" => $request->input('currency'),
            "amount" => $request->input('amount'),
            "description" => $request->input('description'),
            "delivery" => $order->delivery,
            "gateway" => $request->input('gateway'),

            "payment_options" => [
                "notification_url" => $request->input('notification_url'),
                "redirect_url" => $request->input('redirect_url'),
                "cancel_url" => $request->input('cancel_url')
            ],

            "customer" => [
                "first_name" => $order->name,
                "last_name" => $order->surname,
                "city" => $order->placename,
                "address1" => $order->street,
                "house_number" => $order->housenumber,
                "zip_code" => $order->zipcode
            ]
        ];
    }

    public function optionsCheckout(Request $request)
    {
        $postcode1 = config('app.post_code_default_1');
        $postcode2 = config('app.post_code_default_2');
        $postcode3 = config('app.post_code_default_3');

        if ($request->has('postcode1')) {
            $postcode1 = $request->get('postcode1');
        }
        if ($request->has('postcode2')) {
            $postcode2 = $request->get('postcode2');
        }
        if ($request->has('postcode3')) {
            $postcode3 = $request->get('postcode3');
        }

        $responseCity = Curl::to(config('app.payment_url') . '/' . $postcode1 . $postcode2 . '/' . $postcode3 )
            ->withHeader('X-Api-Key: ' . config('app.post_code_api_key'))
            ->get();
        $responseCity = json_decode($responseCity, true);

        return response()->json([
            'city' => $responseCity['city'],
            'street' => $responseCity['street'],
        ]);
    }


}