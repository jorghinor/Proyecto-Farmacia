<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;

class CartComposer
{
    public function compose(View $view)
    {
        $cart = session()->get('cart', []);
        $cartCount = count($cart);

        $view->with('cartCount', $cartCount);
    }
}
