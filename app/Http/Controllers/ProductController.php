<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    //
    public function homesubscription(){
        return view('homesubscription');
    }
    public function single_product($id){
        $product = Product::find($id);
        return view('single_product' ,compact('product'));
    } 

    public function storeProduct(Request $request)
    {
        // Validate the form data (you can add validation rules as per your requirements)
        $request->validate([
            'product_name' => 'required|string',
            'product_price' => 'required|numeric',
            'product_description' => 'required|string',
            'product_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Check if the user's subscription status is 4 or above
        $user = Auth::user();
        if ($user->subscription_status < 4) {
            return redirect()->route('dashboard')->with('error', 'Your subscription Rank should be 4 or above to upload a product.');
        }
    
        // Check if the user has at least 50 tokens
      
        if ($user->number_of_tokens < 50) {
            return redirect()->route('dashboard')->with('error', 'You must have at least 50 tokens to upload a product.');
        }
    
        // Get the form input data
        $productName = $request->input('product_name');
        $productPrice = $request->input('product_price');
        $productDescription = $request->input('product_description');
        $productImage = $request->file('product_image');
    
        // Upload the product image and get the file path using the saveImage function
        $productImagePath = $this->saveImage($productImage);
    
        // Create a new Product object and set its properties
        $product = new Product();
        $product->user_id = $user->id;
        $product->product_name = $productName;
        $product->product_price = $productPrice;
        $product->product_description = $productDescription;
        $product->product_image = $productImagePath;
        $product->status = 'Pending';
    
        // Save the Product object to the database
        $product->save();
    
        // Redirect back with a success message (or return a JSON response, etc.)
        return redirect()->route('dashboard')->with('success', 'Product uploaded successfully.');
    }


    public function saveImage($image)
    {
        $ext = $image->getClientOriginalExtension();
        $ext = strtolower($ext);
        if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'svg' || $ext == 'webp') {
            $path = 'assets/front/uploads/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($path, $profileImage);
            return $path . $profileImage;
        }
        return null; // Return null if the image format is not valid
    }

    public function productRequest()
    {
        $pendingProducts = Product::where('status', 'Pending')->get();
        return view('productrequest', compact('pendingProducts'));
    }
    public function approveProduct($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return redirect()->route('productrequest')->with('error', 'Product not found.');
        }

        // Set the status to "Approved"
        $product->status = 'Approved';
        $product->save();

        return redirect()->route('productrequest')->with('success', 'Product approved successfully.');
    }

    public function allProduct(){
        $product=Product::all();
        
        return view('allproduct' , compact('product'));

        
        
    }
    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        // Redirect back to the products list with a success message
        return redirect()->back()->with('success', 'Product deleted successfully');
    }
    public function updateStatus($id)
    {
        $product = Product::findOrFail($id);
        $product->status = 'Pending';
        $product->save();

        // Redirect back to the products list with a success message
        return redirect()->back()->with('success', 'Product status updated to Pending');
    }

    public function myProduct(){
        $user = Auth::user();

        // Retrieve the products uploaded by the logged-in user
        $product = $user->products;

        // Pass the products to the view
        return view('usermyproduct', compact('product'));
    }

}
