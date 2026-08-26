<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlutterwaveVirtualAccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\FlutterwaveController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\Admin\BankAccountController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\KycController;
use App\Http\Controllers\Admin\KycController as AdminKycController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\AirtimeController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\Admin\ReferralController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Models\Transaction;
use App\Models\BankAccount;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| BillHub Public Pages
|--------------------------------------------------------------------------
*/

Route::get('/billvexa', function () {
    return view('BillVexa.home');
})->name('billvexa');

Route::get('/billvexa/about', function () {
    return view('BillVexa.About');
})->name('billvexa.about');

Route::get('/billvexa/contact', function () {
    return view('BillVexa.Contact-us');
})->name('billvexa.contact');

Route::get('/billvexa/faqs', function () {
    return view('BillVexa.FAQs');
})->name('billvexa.faqs');

Route::get('/policy', function () {
    return view('BillVexa.Footer.Privacy Policy');
})->name('policy');

Route::get('/terms', function () {
    return view('BillVexa.Footer.Terms-Conditions');
})->name('terms');

Route::get('/refund', function () {
    return view('BillVexa.Footer.Refund-Policy');
})->name('refund');


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/


Route::get('/signin', function (Illuminate\Http\Request $request) {

    if ($request->has('ref')) {
        session(['referral_code' => $request->ref]);
    }

    return view('BillVexa.Dashboard.signin.sign-up');

})->name('signin');



Route::post('/signin', [AuthController::class, 'sign'])
    ->name('signin');


Route::post('/register', [AuthController::class, 'register'])
    ->name('register');



Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Forgot Password
|--------------------------------------------------------------------------
*/

Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])
    ->name('password.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])
    ->name('password.email');

Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])
    ->name('password.reset');

Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])
    ->name('password.update');

    /*
    |--------------------------------------------------------------------------
    | Two Factor Authentication
    |--------------------------------------------------------------------------
    */
    
    Route::get('/2fa', [AuthController::class, 'showTwoFactorForm'])
        ->name('2fa.verify');
    
    Route::post('/2fa', [AuthController::class, 'verifyTwoFactor'])
        ->name('2fa.verify.post');
    
    Route::post('/2fa/resend', [AuthController::class, 'resendTwoFactor'])
        ->name('2fa.resend');


    Route::post('/kyc/verify', [KycController::class, 'verify'])
        ->middleware('auth')
        ->name('kyc.verify');


/*
|--------------------------------------------------------------------------
| Dashboard (Protected)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/billvexa/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');
    /*
    |--------------------------------------------------------------------------
    | Dashboard Pages
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard/service', function () {
        return view('BillVexa.Dashboard.service');
    })->name('service');

    Route::get('/dashboard/refer', function () {

        $user = auth()->user();

        $totalReferrals = $user->referrals()->count();

        $successfulReferrals = $user->referrals()->count();

        $earnings = $successfulReferrals * 500;

        return view(
            'BillVexa.Dashboard.refer',
            compact(
                'user',
                'totalReferrals',
                'successfulReferrals',
                'earnings'
            )
        );

    })->middleware('auth')->name('refer');

    /*
    |--------------------------------------------------------------------------
    | Transactions
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard/history', [TransactionController::class, 'index'])
        ->name('history');
    
        /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard/notifications', [
        NotificationController::class,
        'index'
    ])->name('notification');

    Route::post('/dashboard/notifications/{id}/read', [
        NotificationController::class,
        'markAsRead'
    ])->name('notification.read');

    Route::post('/dashboard/notifications/read-all', [
        NotificationController::class,
        'markAllAsRead'
    ])->name('notification.readAll');

    Route::delete('/dashboard/notifications/clear-read', [
        NotificationController::class,
        'clearRead'
    ])->name('notification.clearRead');

    Route::delete('/dashboard/notifications/{id}', [
        NotificationController::class,
        'destroy'
    ])->name('notification.delete');

    Route::get('/dashboard/notifications/count', [
        NotificationController::class,
        'count'
    ])->name('notification.count');

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */


    Route::get('/dashboard/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::put('/dashboard/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    // Change Password
    Route::put('/dashboard/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.password');

        Route::post('/dashboard/profile/two-factor', [ProfileController::class, 'toggleTwoFactor'])
    ->name('profile.twofactor');

    // View Active Devices
    Route::get('/dashboard/profile/devices', [ProfileController::class, 'devices'])
        ->name('profile.devices');

    // Logout Other Devices
    Route::delete('/dashboard/profile/devices/logout', [ProfileController::class, 'logoutOtherDevices'])
        ->name('profile.devices.logout');


    /*
    |--------------------------------------------------------------------------
    | Wallet
    |--------------------------------------------------------------------------
    */

    Route::post('/wallet/fund', [WalletController::class, 'fund'])
        ->name('wallet.fund');

    Route::get('/wallet/add-money', [WalletController::class, 'addMoney'])
        ->name('wallet.add-money');
    /*
    |--------------------------------------------------------------------------
    | Quick Services
    |--------------------------------------------------------------------------
    */

    Route::get('/quick/airtime', function () {
        return view('BillVexa.Dashboard.Quick.airtime');
    })->name('airtime');


    Route::get('/quick/data', function () {
        return view('BillVexa.Dashboard.Quick.data');
    })->name('data');

    Route::get('/quick/bet', function () {
        return view('BillVexa.Dashboard.Quick.betting');
    })->name('bet');

    Route::get('/quick/cable', function () {
        return view('BillVexa.Dashboard.Quick.cable');
    })->name('cable');

    Route::get('/quick/electricity', function () {
        return view('BillVexa.Dashboard.Quick.Electricity');
    })->name('electricity');

    

    /*
    |--------------------------------------------------------------------------
    | Admin Bank Accounts
    |--------------------------------------------------------------------------
    */

    Route::resource('bank-accounts', BankAccountController::class)->middleware('auth');


    /*
    |--------------------------------------------------------------------------
    | Social link
    |--------------------------------------------------------------------------
    */



    // Route::get('/auth/google', [SocialController::class, 'redirectToGoogle']);
// Route::get('/auth/google/callback', [SocialController::class, 'handleGoogleCallback']);

    Route::get('/auth/github', [SocialController::class, 'redirectToGithub']);
    Route::get('/auth/github/callback', [SocialController::class, 'handleGithubCallback']);

    Route::get('/auth/facebook', [SocialController::class, 'redirectToFacebook']);
    Route::get('/auth/facebook/callback', [SocialController::class, 'handleFacebookCallback']);




    Route::get('/auth/google', [GoogleController::class, 'redirect'])
        ->name('google.login');

    Route::get('/auth/google/callback', [GoogleController::class, 'callback']);



    /*
|--------------------------------------------------------------------------
| Airtime 
|--------------------------------------------------------------------------
*/

    Route::middleware(['auth'])->group(function () {

        Route::get('/quick/airtime', [AirtimeController::class, 'index'])
            ->name('airtime');

        Route::post('/airtime/purchase', [AirtimeController::class, 'purchase'])
            ->name('airtime.purchase');

    });

    Route::post(
        '/wallet/fund/flutterwave',
        [FlutterwaveController::class, 'initialize']
    )->name('flutterwave.initialize');

    Route::post(
    '/flutterwave/webhook',
    [FlutterwaveController::class, 'webhook']
)->name('flutterwave.webhook');

Route::post(
    '/wallet/create-virtual-account',
    [FlutterwaveVirtualAccountController::class, 'create']
)->name('wallet.create.virtual.account');


});

Route::get(
    '/payment/flutterwave/callback',
    [FlutterwaveController::class, 'callback']
)->name('flutterwave.callback');

/*
|--------------------------------------------------------------------------
| Data
|--------------------------------------------------------------------------
*/



Route::get('/quick/data', [DataController::class, 'index'])->name('data');

Route::post('/data/purchase', [DataController::class, 'purchase'])
    ->name('data.purchase');


/*
|--------------------------------------------------------------------------
| Notifications
|--------------------------------------------------------------------------
*/
Route::get('/notifications/read/{notification}', [NotificationController::class, 'read'])
    ->middleware('auth')
    ->name('notifications.read');
    
    /*
    |--------------------------------------------------------------------------
    | Admin Login
    |--------------------------------------------------------------------------
    */
    
    Route::prefix('admin')->name('admin.')->group(function () {
    
        // Guest routes
        Route::get('/login', [AdminAuthController::class, 'showLogin'])
        ->name('login');
    
        Route::post('/login', [AdminAuthController::class, 'login'])
            ->name('login.submit');

            Route::get('/2fa', [
                \App\Http\Controllers\Admin\AdminAuthController::class,
                'showTwoFactor'
            ])->name('2fa');
    
            Route::post('/2fa', [
                \App\Http\Controllers\Admin\AdminAuthController::class,
                'verifyTwoFactor'
            ])->name('2fa.verify');
        
       
    
        /*
        |--------------------------------------------------------------------------
        | Protected Routes
        |--------------------------------------------------------------------------
        */
    
        Route::middleware('auth:admin')->group(function () {

        Route::get('/users/create', [AdminController::class, 'createUser'])
        ->name('user.create');
    
    Route::post('/users', [AdminController::class, 'storeUser'])
        ->name('user.store');
  
    
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');
    
            Route::get('/profile', [AdminController::class, 'profile'])
                ->name('profile');
    
            Route::put('/profile', [AdminController::class, 'updateProfile'])
                ->name('profile.update');
    
            Route::put('/password', [AdminController::class, 'updatePassword'])
                ->name('password.update');

                Route::put('/profile', [AdminController::class, 'updateProfile'])
    ->name('profile.update');
    
                Route::get('/settings', [SettingController::class,'index'])
                ->name('setting');
            
            Route::post('/settings', [SettingController::class,'update'])
                ->name('settings.update');

                Route::post('/settings/security', [
                \App\Http\Controllers\Admin\SettingController::class,
                'updateSecurity'
            ])->name('settings.security');
    
            Route::get('/users', [AdminController::class, 'users'])
                ->name('user');
    
                Route::get('/transactions', [AdminTransactionController::class, 'index'])
                ->name('transaction');

                Route::get('/transactions/export', [AdminTransactionController::class, 'exportTransactions'])
                ->name('transaction.export');
            
            Route::get('/transactions/{transaction}', [AdminTransactionController::class, 'show'])
                ->name('transaction.show');
            
            Route::post('/transactions/{transaction}/approve', [AdminTransactionController::class, 'approve'])
                ->name('transaction.approve');
            
            Route::post('/transactions/{transaction}/reverse', [AdminTransactionController::class, 'reverse'])
                ->name('transaction.reverse');
            
            Route::post('/transactions/{transaction}/refund', [AdminTransactionController::class, 'refund'])
                ->name('transaction.refund');
            
          
            Route::get('/wallet', [AdminController::class, 'wallet'])
                ->name('wallet');
    
                Route::get('/services', [ServiceController::class,'index'])
                ->name('service');
    
            Route::post('/services', [ServiceController::class,'store'])
                ->name('service.store');
    
            Route::put('/services/{service}', [ServiceController::class,'update'])
                ->name('service.update');
    
            Route::delete('/services/{service}', [ServiceController::class,'destroy'])
                ->name('service.delete');
    
            Route::post('/services/{service}/enable', [ServiceController::class,'enable'])
                ->name('service.enable');
    
            Route::post('/services/{service}/disable', [ServiceController::class,'disable'])
                ->name('service.disable');
    
            Route::post('/services/{service}/profit', [ServiceController::class,'profit'])
                ->name('service.profit');
    
            Route::post('/services/{service}/charge', [ServiceController::class,'charge'])
                ->name('service.charge');
    
            Route::post('/services/{service}/limit', [ServiceController::class,'limit'])
                ->name('service.limit');
    
            Route::post('/services/{service}/api', [ServiceController::class,'api'])
                ->name('service.api');
    
            Route::post('/services/{service}/test', [ServiceController::class,'test'])
                ->name('service.test');
    
                Route::get('/deposit',
                [AdminController::class,'deposit']
            )->name('deposit');
            
            Route::post('/deposit/{deposit}/approve',
                [AdminController::class,'approveDeposit']
            )->name('deposit.approve');
            
            Route::post('/deposit/{deposit}/reject',
                [AdminController::class,'rejectDeposit']
            )->name('deposit.reject');
                   
                Route::get('/kyc', [AdminKycController::class, 'index'])
                ->name('kyc');
            
            Route::get('/kyc/{user}', [AdminKycController::class, 'show'])
                ->name('kyc.show');
            
            Route::post('/kyc/{user}/approve', [AdminKycController::class, 'approve'])
                ->name('kyc.approve');
            
            Route::post('/kyc/{user}/reject', [AdminKycController::class, 'reject'])
                ->name('kyc.reject');
            
            Route::get('/kyc/{user}/download', [AdminKycController::class, 'download'])
                ->name('kyc.download');
    
                Route::get('/referrals', [ReferralController::class,'index'])
                ->name('referrals.index');
    
                Route::get('/report',
                [ReportController::class,'index'])
                ->name('report');
    
            Route::get('/reports/{type}',
                [ReportController::class,'generate'])
                ->name('reports.generate');
    
            Route::get('/reports/export/{type}/{format}',
                [ReportController::class,'export'])
                ->name('reports.export');
    
                Route::get(
                    '/notifications',
                    [AdminNotificationController::class,'index']
                )->name('notification');

                Route::get('/notification/read-all', [AdminNotificationController::class, 'readAll'])
    ->name('notification.read-all');
        
                Route::post(
                    '/notifications',
                    [AdminNotificationController::class,'store']
                )->name('notifications.store');
        


                Route::get('/audit-logs', [
                    AuditLogController::class,
                    'index'
                ])->name('audit-logs.index');
    
            Route::get('/search', [AdminController::class, 'search'])
                ->name('search');

            Route::get('/users/{user}', [AdminController::class, 'showUser'])
                 ->name('user.show');

            Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])
                ->name('user.edit');

            Route::put('/users/{user}', [AdminController::class, 'updateUser'])
                ->name('user.update');

            Route::post('/users/{user}/credit', [AdminController::class, 'creditWallet'])
                ->name('user.credit');

            Route::post('/users/{user}/debit', [AdminController::class, 'debitWallet'])
                ->name('user.debit');

            Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])
                ->name('user.delete');

                Route::post('/logout', [AdminAuthController::class, 'logout'])
                ->name('logout');


        });
    });