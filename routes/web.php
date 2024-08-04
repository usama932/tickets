<?php

use App\Http\Controllers\OrderController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $products = Product::with('user')->where('status', 'Approved')->get();

    // Pass the approved products data to the view
    return view('welcome', compact('products'));
})->name('home');

Route::get('/product', function () {
    return view('product');
});
Route::get('/about', function () {
    return view('about');
});
Route::get('/privacy-policy', function () {
    return view('privacy');
});
Route::get('/faq', function () {
    return view('faqs');
});

// Packges\
Route::get('homesubscription', [App\Http\Controllers\ProductController::class, 'homesubscription'])->name('homesubscription');

Route::get('/sub', 'App\Http\Controllers\PackageController@subrip');

// Sign up route
Route::get('/signup', 'App\Http\Controllers\UserController@showSignupForm');
Route::post('/signup', 'App\Http\Controllers\UserController@signup');
Route::get('/register/{referral_code}', 'App\Http\Controllers\UserController@register');

Route::resource('packages', 'App\Http\Controllers\PackageController');
Route::post('/feature/{package_id}', [App\Http\Controllers\FeatureController::class, 'store'])->name('feature');

Route::get('myteam', [App\Http\Controllers\UserController::class, 'myTeam'])->name('myteam');


Route::get('single_product/{id}', [App\Http\Controllers\ProductController::class, 'single_product'])->name('single_product');
// Sign in route
Route::get('/signin', 'App\Http\Controllers\UserController@showSigninForm');
Route::post('/signin', [App\Http\Controllers\UserController::class, 'signin'])->name('signin');

// Dashboard

//Forgot password routes
Route::get('/forgot-password', [App\Http\Controllers\ForgotPasswordController::class, 'forgotPasswordForm'])->name('forgotPasswordForm');
Route::post('/find-account', [App\Http\Controllers\ForgotPasswordController::class, 'findAccount'])->name('findAccount');
Route::get('reset-password', [App\Http\Controllers\ForgotPasswordController::class, 'showResetPasswordForm'])->name('resetPasswordForm');
Route::post('reset-password', [App\Http\Controllers\ForgotPasswordController::class, 'submitResetPasswordForm'])->name('resetPassword');



Route::get('/signout', [App\Http\Controllers\DashboardController::class, 'signout'])->name('signout');

Route::middleware(['auth', \App\Http\Middleware\AuthenticateDashboard::class])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    //withdraw

    Route::get('/withdrawals/create', [App\Http\Controllers\WithdrawalController::class, 'showWithdrawalForm'])->name('withdrawals.create');
    Route::post('/withdrawals', [App\Http\Controllers\WithdrawalController::class, 'store'])->name('withdraws.store');
    // deposit
    Route::get('/deposit', [App\Http\Controllers\DepositController::class, 'create'])->name('deposit.create');
    Route::post('/deposit', [App\Http\Controllers\DashboardController::class, 'dipoststore'])->name('deposit.store');
    Route::get('/deposit/{id}', [App\Http\Controllers\DepositController::class, 'show'])->name('deposit.show');
    Route::get('/deposit/{id}/edit', [App\Http\Controllers\DepositController::class, 'edit'])->name('deposit.edit');
    Route::get('/deposit/{id}', [App\Http\Controllers\DashboardController::class, 'dipositupdate'])->name('deposit.update');

    Route::get('/deposit/reject/{id}', [App\Http\Controllers\DashboardController::class, 'depositreject'])->name('deposit.reject');
    Route::get('/total/deposits', [App\Http\Controllers\DepositController::class, 'getTotalDeposits'])->name('total_deposits');


    Route::get('/withdrawal/{id}', [App\Http\Controllers\DashboardController::class, 'withdrawupdate'])->name('withdrawal.update');
    Route::get('/withdrawal/reject/{id}/', [App\Http\Controllers\DashboardController::class, 'withdrawreject'])->name('withdrawal.reject');
    Route::get('/activate/{id}/', [App\Http\Controllers\DashboardController::class, 'activate'])->name('activate');
    Route::get('subscriptionsPakages', [App\Http\Controllers\subscriptionsController::class, 'subscriptionsView'])->name('subscriptions');
    Route::get('subscriptionsfiveparts', [App\Http\Controllers\subscriptionsController::class, 'subscriptionsfiveparts'])->name('subscriptionsfiveparts');
    Route::get('investment_option', [App\Http\Controllers\subscriptionsController::class, 'investment_option'])->name('investment_option');
    Route::post('/activate-subscription', [App\Http\Controllers\subscriptionsController::class, 'activateSubscription'])->name('activateSubscription');
    Route::post('/process-purchase-request', [App\Http\Controllers\subscriptionsController::class, 'tokkenRequest'])->name('tokkenRequest');
    Route::get('accepttokenrequest', [App\Http\Controllers\subscriptionsController::class, 'accepttokenrequest'])->name('accepttokenrequest');
    Route::get('token-requests',  [App\Http\Controllers\subscriptionsController::class, 'showTokenRequests'])->name('admin.tokenRequests');
    Route::post('/admin/token-requests/{id}/activate', [App\Http\Controllers\subscriptionsController::class, 'activateTokenRequest'])->name('admin.activateTokenRequest');
    Route::post('loanrequest', [App\Http\Controllers\LoanRequestController::class, 'loanRequest'])->name('loan.request');
    Route::get('loanrequestview', [App\Http\Controllers\LoanRequestController::class, 'loanrequestview'])->name('loanrequestview');
    Route::post('/approve-loan-request/{id}', [App\Http\Controllers\LoanRequestController::class, 'approveLoanRequest'])->name('approveLoanRequest');
    Route::post('/store-product', [App\Http\Controllers\ProductController::class, 'storeProduct'])->name('store.product');

    Route::get('productrequest', [App\Http\Controllers\ProductController::class, 'productrequest'])->name('productrequest');
    
    Route::post('/approveProduct/{id}', [App\Http\Controllers\ProductController::class, 'approveProduct'])->name('approveProduct');
    Route::post('addtocart', [App\Http\Controllers\OrderController::class, 'addtoCart'])->name('addtocart');
    Route::get('showCart', [App\Http\Controllers\OrderController::class, 'showCart'])->name('showCart');

    Route::get('ordercheckout/{product_id}', [App\Http\Controllers\OrderController::class, 'orderCheckout'])->name('ordercheckout');
    Route::get('cart', [App\Http\Controllers\OrderController::class, 'cart'])->name('cart');
    Route::post('storeOrder', [App\Http\Controllers\OrderController::class, 'storeOrder'])->name('storeOrder');

    Route::get('payment', [App\Http\Controllers\OrderController::class, 'payment'])->name('payment');
    Route::post('/paymentpost', [OrderController::class, 'payment'])->name('paymentpost');
    Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('place-order');




    Route::get('alluser', [App\Http\Controllers\DashboardController::class, 'alluser'])->name('alluser');
    Route::post('/users/{id}/update', [App\Http\Controllers\DashboardController::class, 'updateUser'])->name('updateUser');
    Route::delete('/users/{id}', [App\Http\Controllers\DashboardController::class, 'deleteUser'])->name('deleteUser');







    Route::get('allproducts', [App\Http\Controllers\ProductController::class, 'allProduct'])->name('allProduct');

    Route::delete('/product/{id}', [ProductController::class, 'deleteProduct'])->name('deleteProduct');
    Route::put('/product/{id}/update-status', [ProductController::class, 'updateStatus'])->name('updateStatus');


    Route::get('rank', [App\Http\Controllers\DashboardController::class, 'rank'])->name('rank');
    Route::post('/users/{id}/suspend', [App\Http\Controllers\UserController::class, 'suspend'])->name('suspendUser');

    // Route to activate a user
    Route::post('/users/{id}/activate', [App\Http\Controllers\UserController::class, 'activate'])->name('activateUser');
    Route::get('myproducts', [App\Http\Controllers\ProductController::class, 'myProduct'])->name('myproducts');
});
