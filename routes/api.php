<?php

use App\Http\Controllers\API\v1\AddAmountController;
use App\Http\Controllers\API\v1\AddComplaintsController;
use App\Http\Controllers\API\v1\BankAccountDetailsController;
use App\Http\Controllers\API\v1\BrandListController;
use App\Http\Controllers\API\v1\CancelController;
use App\Http\Controllers\API\v1\canceledLocationController;
use App\Http\Controllers\API\v1\CancelRequeteBookController;
use App\Http\Controllers\API\v1\CancelRequeteBookingController;
use App\Http\Controllers\API\v1\CancelRequeteController;
use App\Http\Controllers\API\v1\CarDriverConfirmController;
use App\Http\Controllers\API\v1\CarImagesDriversNameController;
use App\Http\Controllers\API\v1\CarServiceBookController;
use App\Http\Controllers\API\v1\CarServiceBookHistoryController;
use App\Http\Controllers\API\v1\ChangeStatusControlller;
use App\Http\Controllers\API\v1\ChangeStatusForpaymentController;
use App\Http\Controllers\API\v1\CompleteRequeteController;
use App\Http\Controllers\API\v1\ConfirmedRequeteBookController;
use App\Http\Controllers\API\v1\ConfirmRequeteController;
use App\Http\Controllers\API\v1\ContactUsController;
use App\Http\Controllers\API\v1\DashboardController;
use App\Http\Controllers\API\v1\DeleteFavoriteRideController;
use App\Http\Controllers\API\v1\DeleteUserController;
use App\Http\Controllers\API\v1\DiscountController;
use App\Http\Controllers\API\v1\DocumentsController;
use App\Http\Controllers\API\v1\DriverController;
use App\Http\Controllers\API\v1\DriverReviewController;
use App\Http\Controllers\API\v1\DriversVehicleController;
use App\Http\Controllers\API\v1\DriverWalletHistoryController;
use App\Http\Controllers\API\v1\DriverWithdrawalsController;
use App\Http\Controllers\API\v1\ExistingUserController;
use App\Http\Controllers\API\v1\FavoriteRequeteUserController;
use App\Http\Controllers\API\v1\FavoriteRideController;
use App\Http\Controllers\API\v1\ForgotPersonalIteamController;
use App\Http\Controllers\API\v1\generateotpController;
use App\Http\Controllers\API\v1\GetDriverWithdrawalsController;
use App\Http\Controllers\API\v1\getFcmController;
use App\Http\Controllers\API\v1\GetProfileByPhoneController;
use App\Http\Controllers\API\v1\GetVehicleController;
use App\Http\Controllers\API\v1\LaunguageController;
use App\Http\Controllers\API\v1\LocationController;
use App\Http\Controllers\API\v1\ModelListController;
use App\Http\Controllers\API\v1\NoteController;
use App\Http\Controllers\API\v1\TokenPaymentController;
use App\Http\Controllers\API\v1\NotificationListController;
use App\Http\Controllers\API\v1\NotifyController;
use App\Http\Controllers\API\v1\OldUserPhotoController;
use App\Http\Controllers\API\v1\OnrideRequeteBookController;
use App\Http\Controllers\API\v1\OnrideRequeteController;
use App\Http\Controllers\API\v1\OtpVerificationController;
use App\Http\Controllers\API\v1\PayFastController;
use App\Http\Controllers\API\v1\PaymentByCashController;
use App\Http\Controllers\API\v1\PaymentMethodController;
use App\Http\Controllers\API\v1\payments\PaymentController;
use App\Http\Controllers\API\v1\payments\RazorPayController;
use App\Http\Controllers\API\v1\PaymentSettingController;
use App\Http\Controllers\API\v1\PayRequeteController;
use App\Http\Controllers\API\v1\PayRequeteWalletController;
use App\Http\Controllers\API\v1\PositionController;
use App\Http\Controllers\API\v1\privacyPolicyController;
use App\Http\Controllers\API\v1\ReqFeelSafeController;
use App\Http\Controllers\API\v1\ReqNotFeelSafeController;
use App\Http\Controllers\API\v1\RequeteBookCancelController;
use App\Http\Controllers\API\v1\RequeteBookCancelUserController;
use App\Http\Controllers\API\v1\RequeteBookConfirmController;
use App\Http\Controllers\API\v1\RequeteBookConfirmUserController;
use App\Http\Controllers\API\v1\RequeteBookController;
use App\Http\Controllers\API\v1\RequeteBookRejectedController;
use App\Http\Controllers\API\v1\RequeteBookUserappController;
use App\Http\Controllers\API\v1\RequeteCompleteController;
use App\Http\Controllers\API\v1\RequeteConfirmController;
use App\Http\Controllers\API\v1\RequeteController;
use App\Http\Controllers\API\v1\RequeteOnrideController;
use App\Http\Controllers\API\v1\RequeteRegisterController;
use App\Http\Controllers\API\v1\RequeteRejectController;
use App\Http\Controllers\API\v1\RequeteUserappCanceledController;
use App\Http\Controllers\API\v1\RequeteUserappCompleteController;
use App\Http\Controllers\API\v1\RequeteUserappConfirmationController;
use App\Http\Controllers\API\v1\RequeteUserappController;
use App\Http\Controllers\API\v1\RequeteUserappOnRideController;
use App\Http\Controllers\API\v1\ResertPasswordController;
use App\Http\Controllers\API\v1\RideDetailsController;
use App\Http\Controllers\API\v1\SendResetPasswordOtpController;
use App\Http\Controllers\API\v1\SetCarServiceBookController;
use App\Http\Controllers\API\v1\SetLocationController;
use App\Http\Controllers\API\v1\SetRejectedRequeteController;
use App\Http\Controllers\API\v1\SetRequeteBookController;
use App\Http\Controllers\API\v1\SettingsController;
use App\Http\Controllers\API\v1\SosController;
use App\Http\Controllers\API\v1\taxiController;
use App\Http\Controllers\API\v1\TerminalCourseController;
use App\Http\Controllers\API\v1\termsofConditionController;
use App\Http\Controllers\API\v1\TransactionController;
use App\Http\Controllers\API\v1\UpdatefcmController;
use App\Http\Controllers\API\v1\UseGenderController;
use App\Http\Controllers\API\v1\User_LoginController;
use App\Http\Controllers\API\v1\UserAddressController;
use App\Http\Controllers\API\v1\UserController;
use App\Http\Controllers\API\v1\UserEmailController;
use App\Http\Controllers\API\v1\UserLicenceController;
use App\Http\Controllers\API\v1\UserLoginController;
use App\Http\Controllers\API\v1\UsermdpController;
use App\Http\Controllers\API\v1\UserNameController;
use App\Http\Controllers\API\v1\UserNicController;
use App\Http\Controllers\API\v1\UserNoteController;
use App\Http\Controllers\API\v1\UserPendingPaymentController;
use App\Http\Controllers\API\v1\UserPhoneController;
use App\Http\Controllers\API\v1\UserPhotoController;
use App\Http\Controllers\API\v1\UserPreNameController;
use App\Http\Controllers\API\v1\UserRoadWorthyDocController;
use App\Http\Controllers\API\v1\VehicleBrandController;
use App\Http\Controllers\API\v1\VehicleCategoryController;
use App\Http\Controllers\API\v1\VehicleColorController;
use App\Http\Controllers\API\v1\VehicleController;
use App\Http\Controllers\API\v1\VehicleImagesController;
use App\Http\Controllers\API\v1\VehicleModelController;
use App\Http\Controllers\API\v1\AgoraController;
use App\Http\Controllers\API\v1\VehicleNumberplateController;

use App\Http\Controllers\API\v1\wallet;
use App\Http\Controllers\API\v1\DriverRideReviewController;
use Illuminate\Http\Request;
use App\Http\Controllers\API\v1\CouponController;
use Illuminate\Support\Facades\Route;

//use App\Http\Controllers\api\v1\UserController;


Route::get('v1/driver', [DriverController::class, 'getData']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('v1/reset-password-otp/', [SendResetPasswordOtpController::class, 'resetPasswordOtp']);
Route::post('v1/resert-password/', [ResertPasswordController::class, 'resertPassword']);


    /*Guest Request*/
    Route::get('v1/testkey/', [UserLoginController::class, 'testkey']);
    Route::post('v1/user/', [UserController::class, 'register']);
    Route::post('v1/user-login/', [UserLoginController::class, 'login']);
    Route::get('v1/buy_token/', [UserLoginController::class, 'tokens']);

    Route::post('v1/existing-user/', [ExistingUserController::class, 'getData']);
    Route::post('v1/update-user-nic/', [UserNicController::class, 'updateUserNic']);
    Route::get('v1/language/', [LaunguageController::class, 'getData']);
    Route::get('v1/privacy-policy/', [privacyPolicyController::class, 'getData']);
    Route::get('v1/terms-of-condition/', [termsofConditionController::class, 'getData']);
    Route::get('v1/settings/', [SettingsController::class, 'getData']);
    Route::post('v1/profilebyphone/', [GetProfileByPhoneController::class, 'getData']);

    Route::get('v1/documents/', [DocumentsController::class, 'getData']);
    Route::post('v1/driver-documents-add/', [DocumentsController::class, 'addDriverDocuments']);
    Route::post('v1/driver-documents-update/', [DocumentsController::class, 'updateDriverDocuments']);
    Route::post('v1/driver-cpvs/', [DocumentsController::class, 'cpvRequirement']);
    Route::get('v1/driver-getcpvs/{driver_id}', [DocumentsController::class, 'getcpvRequirement']);
    Route::get('v1/driver-documents/', [DocumentsController::class, 'getDriverDocuments']);

    Route::get('v1/get-ride-review/', [RideDetailsController::class, 'getRideReview']);   // get ride reviews of users or driver

    Route::get('v1/get-status/', [DriverController::class, 'get_statut']);


    /*Auth Request*/
    // Route::get('v1/testdev/', [UserController::class, 'test']);
    Route::get('v1/users/', [UserController::class, 'index']);

    Route::post('v1/vehicle/', [VehicleController::class, 'register']);
    Route::post('v1/update-vehicle-numberplate/', [VehicleController::class, 'updateVehicle']);
    Route::post('v1/update-vehicle-color/', [VehicleController::class, 'updateVehicleColor']);
    Route::post('v1/update-vehicle-brand/', [VehicleController::class, 'updateVehicleBrand']);
    Route::post('v1/update-vehicle-model/', [VehicleController::class, 'updateVehicleModel']);
    Route::post('v1/update-vehicle-car_category/', [VehicleController::class, 'updateVehicleCat']);
    Route::get('v1/Vehicle-category/', [VehicleController::class, 'getVehicleCategoryData']);

    Route::post('v1/update-Vehicle-category/', [VehicleController::class, 'updateVehicleType']);
    Route::get('v1/vehicle-get/', [VehicleController::class, 'getVehicleData']);

    Route::post('v1/driver-note/', [UserNoteController::class, 'register']); // can driver write review to users
    Route::post('v1/user-note/', [NoteController::class, 'register']);   // can user write reviews to drivers
    Route::get('v1/driver-review/', [DriverReviewController::class, 'getData']);
    Route::get('v1/driver-review-ride/', [DriverRideReviewController::class, 'getRideReview']);   // get ride reviews
    Route::get('v1/user-note/', [DriverRideReviewController::class, 'getUserReviews']);   // get user reviews

    Route::post('v1/car-service/', [CarServiceBookController::class, 'register']);
    Route::post('v1/requete-register/', [RequeteRegisterController::class, 'register']);
    Route::post('v1/amount/', [AddAmountController::class, 'register']);
    Route::get('v1/otp_verify/', [OtpVerificationController::class, 'VerifyOTP']);
    Route::get('v1/otp/', [generateotpController::class, 'OTP']);

    Route::post('v1/forgot-personal-iteam/', [ForgotPersonalIteamController::class, 'register']);
    Route::post('v1/favorite-ride/', [FavoriteRideController::class, 'register']);
    Route::post('v1/onride-requete/', [OnrideRequeteController::class, 'register']);
    Route::post('v1/onride-requete-book/', [OnrideRequeteBookController::class, 'register']);
    Route::post('v1/set-requete-book/', [setRequeteBookController::class, 'register']);
    Route::post('v1/set-Location/', [SetLocationController::class, 'register']);
    Route::post('v1/canceled-location/', [canceledLocationController::class, 'delete']);
    Route::get('v1/cancel/', [cancelController::class, 'cancel']);
    Route::post('v1/cancel-requete/', [CancelRequeteController::class, 'cancel']);
    Route::get('v1/cancel-requete-book/', [CancelRequeteBookController::class, 'cancel']);
    Route::get('v1/cancel-requete-booking/', [CancelRequeteBookingController::class, 'cancel']);
    Route::get('v1/delete-favorite-ride/', [DeleteFavoriteRideController::class, 'deleteFavoriteRide']);
    Route::get('v1/favorite/', [FavoriteRequeteUserController::class, 'getData']);
    Route::get('v1/location/', [LocationController::class, 'getData']);
    Route::get('v1/notification/', [NotificationListController::class, 'getData']);
    Route::get('v1/payment-method/', [PaymentMethodController::class, 'getData']);


    Route::get('v1/requete/', [RequeteController::class, 'getData']);


    Route::get('v1/requete-book/', [RequeteBookController::class, 'getData']);
    // driver ride details
    Route::get('v1/driver-ride-details/', [RequeteBookController::class, 'driverRideDetails']);

    Route::get('v1/requete-book-cancel-user/', [RequeteBookCancelUserController::class, 'getData']);
    Route::get('v1/wallet/', [wallet::class, 'getData']);
    Route::get('v1/user-gender/', [UseGenderController::class, 'getData']);
    Route::get('v1/transaction/', [TransactionController::class, 'getData']);
    Route::get('v1/taxi/', [taxiController::class, 'getData']);

    Route::get('v1/user-ride/', [RequeteUserappOnRideController::class, 'getData']);

    Route::get('v1/user-confirmation/', [RequeteUserappConfirmationController::class, 'getData']);
    Route::get('v1/user-current-ride/', [RequeteUserappConfirmationController::class, 'userCurrentRide']);

    Route::get('v1/user-complete/', [RequeteUserappCompleteController::class, 'getData']);
    Route::get('v1/user-cancel/', [RequeteUserappCanceledController::class, 'getData']);
    Route::get('v1/user-delete/', [DeleteUserController::class, 'deleteuser']);
    Route::get('v1/requete-userapp/', [RequeteUserappController::class, 'getData']);

    Route::get('v1/requete-reject/', [RequeteRejectController::class, 'getData']);

    Route::get('v1/requete-onride/', [RequeteOnrideController::class, 'getData']);
    Route::get('v1/requete-confirm/', [RequeteConfirmController::class, 'getData']);
    Route::get('v1/requete-current-ride/', [RequeteConfirmController::class, 'currentRide']);

    Route::get('v1/requete-complete/', [RequeteCompleteController::class, 'getData']);

    Route::get('v1/requete-book-userapp/', [RequeteBookUserappController::class, 'getData']);
//     user all book details
    Route::get('v1/user-ride-details/', [RequeteBookUserappController::class, 'userRideDetails']);

    Route::get('v1/requete-book-confirm/', [RequeteBookConfirmController::class, 'getData']);
    Route::get('v1/requete-book-rejected/', [RequeteBookRejectedController::class, 'getData']);


    Route::post('v1/change-vehicle-status', [DriverController::class, 'changeStatus']);

    Route::get('v1/dashboard/', [DashboardController::class, 'getData']);
    Route::get('v1/discount-list/', [DiscountController::class, 'discountList']);
    Route::get('v1/car-service-book/', [CarServiceBookHistoryController::class, 'getData']);
    Route::get('v1/car-images-driver-name/', [CarImagesDriversNameController::class, 'getData']);


    Route::get('v1/vehicle-driver/', [DriversVehicleController::class, 'getData']);
    Route::post('v1/fcm-token/', [getFcmController::class, 'getData']);
    Route::get('v1/payment-settings/', [PaymentSettingController::class, 'getData']);
    Route::post('v1/model/', [ModelListController::class, 'getData']);
    Route::get('v1/brand/', [BrandListController::class, 'getData']);
    Route::post('v1/add-bank-details/', [BankAccountDetailsController::class, 'register']);
    Route::get('v1/bank-details/', [BankAccountDetailsController::class, 'getData']);
    Route::post('v1/withdrawals/', [DriverWithdrawalsController::class, 'Withdrawals']);
    Route::get('v1/withdrawals-list/', [GetDriverWithdrawalsController::class, 'WithdrawalsList']);
    Route::get('v1/ridedetails/', [RideDetailsController::class, 'ridedetails']);
    Route::post('v1/update-user-mdp/', [UsermdpController::class, 'UpdateUsermdp']);
    Route::post('v1/update-user-email/', [UserEmailController::class, 'UpdateUserEmail']);
    Route::post('v1/update-user-roadworthy/', [UserRoadWorthyDocController::class, 'updateRoadWorthy']);
    Route::post('v1/update-user-photo/', [UserPhotoController::class, 'updateUserPhoto']);
    Route::post('v1/update-user-licence/', [UserLicenceController::class, 'updateUserLicence']);
    Route::post('v1/update-position/', [PositionController::class, 'updatePosition']);    // add heading type double
    Route::post('v1/feel-safe/', [ReqFeelSafeController::class, 'UpdateReq']);

    Route::post('v1/notify/', [NotifyController::class, 'UpdateNotify']);
    Route::post('v1/driver-confirm/', [CarDriverConfirmController::class, 'confirm']);
    Route::post('v1/change-status/', [ChangeStatusControlller::class, 'changeStatus']);
    Route::post('v1/complete-requete/', [CompleteRequeteController::class, 'completeRequest']);
    Route::post('v1/confirm-requete/', [ConfirmRequeteController::class, 'confirmRequest']);
    Route::post('v1/contact-us/', [ContactUsController::class, 'contact']);
    Route::post('v1/pay-requete-wallet/', [PayRequeteWalletController::class, 'UpdatePayRequeteWallet']);
    Route::post('v1/payment-by-cash/', [PaymentByCashController::class, 'UpdatePayment']);
    Route::post('v1/teminer-courses/', [TerminalCourseController::class, 'terminerCourse']);
    Route::post('v1/user-pending-payment/', [UserPendingPaymentController::class, 'userpayment']);

    Route::post('v1/update-fcm/', [UpdatefcmController::class, 'updatefcm']);
    Route::post('v1/user-address/', [UserAddressController::class, 'UpdateUserAddress']);
    Route::post('v1/set-rejected-requete/', [SetRejectedRequeteController::class, 'rejectedRequest']);
    Route::post('v1/user-name/', [UserNameController::class, 'UpdateUserName']);
    Route::post('v1/user-pre-name/', [UserPreNameController::class, 'UpdateUserPreName']);
    Route::post('v1/user-phone/', [UserPhoneController::class, 'UpdateUserPhone']);
    Route::post('v1/not-feel-safe/', [ReqNotFeelSafeController::class, 'UpdateReq']);

    Route::post('v1/get_previous/', [SetRejectedRequeteController::class, 'get_single_ride']);

    Route::post('v1/change-status-payment/', [ChangeStatusForpaymentController::class, 'ChangeStatus']);
    Route::get('v1/requete-book-cancel/', [RequeteBookCancelController::class, 'getData']);
    Route::post('v1/storesos/', [SosController::class, 'storeSos']);
    Route::post('v1/update-user-carservice/', [SetCarServiceBookController::class, 'updateCarServiceBook']);

    /*Payments*/
    Route::post('v1/payments/getpaytmchecksum', [PaymentController::class, 'getPaytmChecksum']);
    Route::post('v1/payments/validatechecksum', [PaymentController::class, 'validateChecksum']);
    Route::post('v1/payments/initiatepaytmpayment', [PaymentController::class, 'initiatePaytmPayment']);
    Route::post('v1/payments/paytmpaymentcallback', [PaymentController::class, 'paytmPaymentcallback']);
    Route::post('v1/payments/paypalclientid', [PaymentController::class, 'getPaypalClienttoken']);
    Route::post('v1/payments/paypaltransaction', [PaymentController::class, 'createBraintreePayment']);
    Route::post('v1/payments/stripepaymentintent', [PaymentController::class, 'createStripePaymentIntent']);
    Route::post('v1/payments/razorpay/createorder', [RazorPayController::class, 'createOrderid']);
    Route::post('v1/pay-requete/', [PayRequeteController::class, 'UpdatePayRequete']);
    Route::post('v1/complaints/', [AddComplaintsController::class, 'register']);

    //Token Paymeny
    Route::post('v1/token_pay/', [TokenPaymentController::class, 'token_pay']);
    Route::post('v1/remaining_token/', [TokenPaymentController::class, 'remain_token']);
    //Coupen
    Route::post('v1/coupons/update/{id}', [TokenPaymntController::class, 'updateDiscount']);
    Route::post('v1/coupons/store',[TokenPaymentController::class, 'store_coupon']);
    Route::post('v1/get/coupons/{id}', [TokenPaymentController::class, 'get_coupen']);
    Route::post('v1/coupons/{code}', [TokenPaymentController::class, 'coupen']);
    Route::post('v1/user_coupons/{user_id}', [TokenPaymentController::class, 'get_user_coupon']);
    Route::get('v1/use_coupons/{driver_id}', [TokenPaymentController::class, 'get_use_coupon']);

    Route::post('v1/destination', [DriverController::class, 'destination']);
    Route::get('v1/ride_settings', [TokenPaymentController::class, 'settings']);
    Route::post('v1/check_balance', [TokenPaymentController::class, 'check_balance']);

    //passenger not show
    Route::post('v1/not_show', [TokenPaymentController::class, 'passenger_not_show']);

    Route::get('v1/wallet-history/', [DriverWalletHistoryController::class, 'getData']);


//not found
Route::get('v1/requete-book-confirm-user/', [RequeteBookConfirmUserController::class, 'getData']);
Route::get('v1/changestatuspayment/', [UserController::class, 'test']);
Route::post('v1/user-login-ag/', [User_LoginController::class, 'login']);
Route::get('v1/payfast/', [PayFastController::class, 'getData']);
Route::post('v1/user-photo/', [OldUserPhotoController::class, 'UpdateUserPhoto']);
Route::post('v1/confirm-requete-book/', [ConfirmedRequeteBookController::class, 'confirmRequest']);
Route::get('v1/driver_reached/{user_id}', [ConfirmRequeteController::class, 'reached_token']);
Route::get('v1/driver_hours/{driver_id}', [ConfirmRequeteController::class, 'driver_hours']);

Route::post('v1/active/{driver_id}', [ConfirmedRequeteBookController::class, 'active_hour']);

Route::post('v1/inactive/{driver_id}', [ConfirmedRequeteBookController::class, 'inactive_hour']);
//not found end

Route::post('search_driver', [\App\Http\Controllers\API\v1\CustomerCurrentLocationController::class, 'updateLocation']);
Route::get('v1/driver-current-location/{id}', [\App\Http\Controllers\API\v1\DriverCurrentLocationController::class, 'currentLocation']);

Route::post('v1/send-message', [\App\Http\Controllers\API\v1\ChatController::class, 'sendMessage']);
Route::post('v1/create-chat', [\App\Http\Controllers\API\v1\ChatController::class, 'createChat']);
Route::get('v1/all-chats',[\App\Http\Controllers\API\v1\ChatController::class,'allChats']);
Route::get('v1/all-chat-messages',[\App\Http\Controllers\API\v1\ChatController::class,'getChatMessage']);



Route::post('/agora/rtc_token',[AgoraController::class,'rtc_token']);








