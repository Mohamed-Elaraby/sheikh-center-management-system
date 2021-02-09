<?php
#################   Constants   #################
//Directory Separator Constant
use App\Http\Controllers\Admin\CheckController;
use App\Models\CarModel;
use App\Models\CarSize;
use App\Models\Check;
use App\Models\Client;
use App\Models\User;

#################   Constants   #################

Route::get('test', function () {

    return route('logout');
    // Remove Duplicate Value From Array Script
//    $object = $array ;
//
//    echo 'Original = '.count($object).'<br>';
//    $new_array = [];
//    foreach (array_unique($object) as $value)
//    {
//        echo "'".$value."',";
//        $new_array [] = $value;
//    }
//    echo '<br> New = '.count($new_array);
});



Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){

    // Authentication Routes

    Auth::routes(
        [
            'register' => false, // Registration Routes...
            'reset' => false,   // Password Reset Routes...
            'verify' => false, // Email Verification Routes...
        ]
    );

//    Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

    // Dashboard Route
    Route::group(['middleware' => ['auth', 'dashboardRedirect'], 'namespace' => 'Admin'], function () {
        Route::get('/', 'DashboardController@index') -> name('dashboard');
    });

    Route::prefix('admin')->middleware('auth')->name('admin.')->namespace('Admin')->group(function (){


        // Collection Routes
        Route::get('images/{check_id}/{type}', 'CheckController@images')->name('check.images');
        Route::get('createDeviceReport/{check_id}/{check_number}', 'CheckController@create_device_report')->name('check.createDeviceReport');
        Route::post('storeDeviceReport', 'CheckController@store_device_report')->name('check.storeDeviceReport');
        Route::post('signature', 'CheckController@signature')->name('check.signature');
        Route::get('client_signature/{check_id}/{check_number}', 'CheckController@client_signature')->name('check.clientSignature');
        Route::post('editCheckStatus', 'CheckController@onlyEditCheckStatus')->name('check.onlyEditCheckStatus');
        Route::get('receipt/{check_id}', 'CheckController@receipt')->name('check.receipt');
        Route::get('getAllCheckByAjax', 'CheckController@getAllCheckByAjax')->name('check.getAllCheckByAjax');
        Route::post('getCarSizesByAjax', 'CheckController@getCarSizesByAjax')->name('check.getCarSizesByAjax');
        Route::post('getCarDevCodeAndEnginesByAjax', 'CheckController@getCarDevCodeAndEnginesByAjax')->name('check.getCarDevCodeAndEnginesByAjax');
        Route::get('managementNotes/{check_id}', 'CheckController@managementNotes')->name('check.managementNotes');
        Route::post('managementNotesUpdate/{check_id}', 'CheckController@managementNotesUpdate')->name('check.managementNotesUpdate');
        Route::post('getCarModelByAjax', 'CarSizeController@getCarModelByAjax')->name('getCarModelByAjax');
        Route::post('saveCarModelByAjax', 'CarSizeController@saveCarModelByAjax')->name('saveCarModelByAjax');
        Route::get('selectBranch', 'CheckController@selectBranch')->name('selectBranch');

        Route::resources([
            'check'                     => 'CheckController',
            'users'                     => 'UserController',
            'clients'                   => 'ClientController',
            'checkStatus'               => 'CheckStatusController',
            'branches'                  => 'BranchController',
            'technicals'                => 'TechnicalController',
            'engineers'                 => 'EngineerController',
            'jobTitle'                  => 'JobTitleController',
            'carType'                   => 'CarTypeController',
            'carSize'                   => 'CarSizeController',
            'carModel'                  => 'CarModelController',
            'carEngine'                 => 'CarEngineController',
            'carDevelopmentCode'        => 'CarDevelopmentCodeController',
        ]); // end of resources
    }); // enf of group
}); //end of localization group
