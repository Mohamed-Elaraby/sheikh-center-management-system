<?php
#################   Constants   #################
//Directory Separator Constant
use App\Http\Controllers\Admin\CheckController;
use App\Models\CarModel;
use App\Models\CarSize;
use App\Models\Check;
use App\Models\Client;
use App\Models\Technical;
use App\Models\User;

#################   Constants   #################

Route::get('test', function () {
$technical = check::find(5);
dd($technical->images);
//    return $client -> carTypes;
//    return Check::where('client_id', 1)->where('car_type_id', 1)->select('client_id', 'car_type_id', 'check_number')->get();
//   foreach ($client -> carTypes as $car)
//   {
//       dump($car ->id);
//   }
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
        Route::post('getCarSizesByAjax', 'CarController@getCarSizesByAjax')->name('car.getCarSizesByAjax');
        Route::post('getCarDevCodeAndEnginesByAjax', 'CarController@getCarDevCodeAndEnginesByAjax')->name('car.getCarDevCodeAndEnginesByAjax');
        Route::get('managementNotes/{check_id}', 'CheckController@managementNotes')->name('check.managementNotes');
        Route::post('managementNotesUpdate/{check_id}', 'CheckController@managementNotesUpdate')->name('check.managementNotesUpdate');
//        Route::get('getAllCheckByAjax', 'CheckController@getAllCheckByAjax')->name('check.getAllCheckByAjax');
//        Route::post('getCarModelByAjax', 'CarSizeController@getCarModelByAjax')->name('getCarModelByAjax');
//        Route::post('saveCarModelByAjax', 'CarSizeController@saveCarModelByAjax')->name('saveCarModelByAjax');
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
            'cars'                      => 'CarController',
            'carType'                   => 'CarTypeController',
            'carSize'                   => 'CarSizeController',
            'carModel'                  => 'CarModelController',
            'carEngine'                 => 'CarEngineController',
            'carDevelopmentCode'        => 'CarDevelopmentCodeController',
        ]); // end of resources
    }); // enf of group
}); //end of localization group
