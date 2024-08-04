<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //
    
    public function addtoCart(Request $request)
    {
        // Assuming you have a logged-in user, you can get the user ID like this:
        $userId = auth()->id();
    
        // Retrieve the product information from the form
        $productId = $request->input('product_id');
        
        $promoCode = $request->input('promocode');
   
        // Save the cart item to the database
        Cart::create([
            'user_id' => $userId,
            'product_id' => $productId,
           'promo_code' => $promoCode,
            
        ]);
    
        // You can also add a success message or redirect the user to the cart page here
        session()->flash('success', 'Product added to cart successfully.');
        return redirect('/')->with('success', 'Product added to cart successfully.');


    }



  public function showCart()
{
    // Get the currently logged-in user
    $user = Auth::user();

    // Retrieve the cart items for the user along with the associated products
    $cartItems = $user->cart()->with('product')->get();

    // Calculate the total charges
    $totalCharges = $cartItems->sum(function ($cartItem) {
        return $cartItem->product->product_price;
    });

    $deliveryCharges = 250;
    $totalCharges += $deliveryCharges;

    // Return the view with the calculated values
    return view('addtocart', compact('cartItems', 'totalCharges', 'deliveryCharges'));
}

    
    public function orderCheckout($product_id)
{
    // Retrieve the product based on the product ID
    $product = Product::findOrFail($product_id);

    // Pass the product information to the view
    return view('ordercheckout', compact('product'));
}


    // If the user is not logged in, you can redirect them to the login page or show an error message
 

public function payment(Request $request){
    // Get the currently logged-in user
    $user = Auth::user();
    $quantity = $request->input('quantity');
  
    // Assuming you have a relationship between User and Cart models
    $cart = $user->cart;
    

    $totalCharges = 0;
    foreach ($cart as $item) {
        $totalCharges += $item->product->product_price;
    }
    $deliveryCharges = 250; // Assuming delivery charges are Rs 250

    return view('ordercheckout', compact('cart', 'user', 'totalCharges', 'deliveryCharges','quantity'));
}


public function placeOrder(Request $request)
{
    // Get the currently logged-in user
    $user = Auth::user();

    // Get the user's current balance
    $currentBalance = $user->current_balance;

    // Get the cart items for the user
    $cart = $user->cart;

    // Calculate the total charges from the cart
    $totalCharges = 0;
    foreach ($cart as $item) {
        $totalCharges += $item->product->product_price;
    }
    $deliveryCharges = 250; // Assuming delivery charges are Rs 250

    // Check if the user has enough balance if they choose to buy from the current balance
    if ($request->input('payment_method') === 'current_balance') {
        if ($currentBalance < $totalCharges + $deliveryCharges) {
            return redirect()->back()->with('error', 'You do not have enough balance to place this order.');
        }

        // Deduct the total charges and delivery charges from the current balance
        $user->current_balance -= $totalCharges + $deliveryCharges;
        $user->save();
    }

    // Store the order data in the database
    $order = new Order();
    $order->user_id = $user->id;
    $order->shipping_address = $request->input('shipping_address');
    $order->total_charges = $totalCharges + $deliveryCharges;
    $order->payment_method = $request->input('payment_method');
    $order->save();

    // You can also store the individual cart items in the database if required
    
    // Redirect the user to a thank you page or any other page as needed
    return redirect('/')->with('success', 'Order placed successfully.');
}
public function storeOrder(Request $request)
{
    // Get the user's total balance
    $user = auth()->user();
    $totalBalance = $user->current_balance;
    $paymentMethod = $request->input('payment_method');
    
    // Calculate the total charges including shipping and any other costs
    $totalCharges = floatval($request->total_charges);

    if ($paymentMethod === 'from_balance') {
        // Check if the user has enough balance to purchase
        if ($totalBalance >= $totalCharges) {
            // Calculate the new balance after purchase
            $newBalance = $totalBalance - $totalCharges;

            // Update the user's total balance
            $user->update(['current_balance' => $newBalance]);

            // Create the order
            $order = Order::create([
                'user_id' => $request->user_id,
                'product_name' => 'Items from Cart',
                'promocode' => $request->promocode,
                'shipping_address' => $request->shipping_address,
                // Add other fields if needed
            ]);

            Cart::where('user_id', $user->id)->delete();

            // Return a success message
            $products = Product::with('user')->where('status', 'Approved')->get();
            return view('welcome', compact('products'))->with('success', 'Order placed successfully.');
        } else {
            // User does not have enough balance, show an error message
            $products = Product::with('user')->where('status', 'Approved')->get();
            return view('welcome', compact('products'))->with('error', 'Your Current Balance is Low To Buy This Product');
        }
    } else if ($paymentMethod === 'cash_on_delivery') {
        // Handle "Cash on Delivery" payment method
        
        $order = Order::create([
            'user_id' => $request->user_id,
            'product_name' =>'Items from Cart',
            'promocode' => $request->promocode,
            'shipping_address' => $request->shipping_address,
            // Add other fields if needed
        ]);

        // Optionally, you can also delete the cart items
        Cart::where('user_id', $user->id)->delete();

        // Return a success message
        $products = Product::with('user')->where('status', 'Approved')->get();
        return view('welcome', compact('products'))->with('success', 'Order placed successfully.');
    } else {
        // Handle other payment methods (if needed)
        // ...

        // Redirect back with a success message
        $products = Product::with('user')->where('status', 'Approved')->get();
        return view('welcome', compact('products'))->with('success', 'Order placed successfully.');
    }
}

    
}
