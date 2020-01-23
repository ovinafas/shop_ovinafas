<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CheckoutController extends Controller
{
    public function getCheckout() {
        return view('front.pages.checkout');
    }

    public function getCart() {
        //
    }



}
