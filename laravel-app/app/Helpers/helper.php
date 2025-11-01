<?php

use Ghasedak\GhasedakApi;

function imageUrl($image)
{
    return env('ADMIN_PANEL_URL') . env('PRODUCT_IMAGES_PATH') . $image;
}

function discountPercent($price, $sale_price)
{
    return round((($price - $sale_price) / $price) * 100);
}

function sendOtpSms($cellphone, $otp)
{
    return 'Your Code is : ' . $otp;

    // $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
    // $api->Verify(
    //     $cellphone,  // receptor
    //     1,              // 1 for text message and 2 for voice message
    //     "otp",  // name of the template which you've created in you account
    //     $otp       // parameters (supporting up to 10 parameters)
    // );
}
