<?php
Auth::routes(['register' => false]);
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', function () { return redirect('/admin/gateways'); })->name('client.home');
Route::get('/client/login', function () { return view('client.home'); })->name('client.login');

Route::get('/fill', 'GatewayController@fill');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
    //Route::get('/dashboard')
    Route::get('/', function() { return redirect('/admin/gateways'); });
    Route::resource('gateways', 'AdminGatewayController');
    Route::get('gateways/{gateway}/coolingDevices', 'AdminGatewayController@devices')->name('gateways.devices');
    Route::get('gateways/{gateway}/patterns', 'AdminGatewayController@patterns')->name('gateways.patterns');
    Route::get('gateways/patterns/create', 'PatternController@createGatewayPattern')->name('gateways.patterns.create');
    Route::post('gateways/patterns/store', 'PatternController@storeGatewayPattern')->name('gateways.patterns.store');

    Route::resource('electricalMeterTypes', 'ElectricalMeterTypeController');

    Route::resource('electricalMeters', 'ElectricalMeterController');
    Route::get('electricalMeters/{id}/history', 'ElectricalMeterController@history')->name('electricalMeters.history');

    Route::resource('coolingDevices', 'CoolingDeviceController')->except(['index', 'create', 'show']); // store, edit, update, destroy
    Route::get('coolingDevices/{gateway}', 'CoolingDeviceController@index')->name('coolingDevices.index');
    Route::get('coolingDevices/{gateway}/create', 'CoolingDeviceController@create')->name('coolingDevices.create');
    Route::get('coolingDevices/{id}/history', 'CoolingDeviceController@history')->name('coolingDevices.history');
    Route::get('coolingDevices/{id}/changeStatus', 'CoolingDeviceController@changeStatus')->name('coolingDevices.changeStatus');

    Route::get('coolingDevices/{device}/patterns', 'CoolingDeviceController@patterns')->name('coolingDevices.patterns');
    Route::get('coolingDevices/patterns/new/{gateway?}/{device?}', 'PatternController@createCoolingDevicePattern')->name('coolingDevices.patterns.new');

    Route::resource('users', 'UserController');
    Route::get('users/{user}/resetPassword', 'UserController@resetPassword')->name('users.resetPassword');
    Route::get('users/{user}/changePassword','UserController@changePassword')->name('users.changePassword');
    Route::post('users/updatePassword', 'UserController@updatePassword')->name('users.updatePassword');

    Route::get('/patterns/create', 'PatternController@create')->name('patterns.create');
    Route::post('/patterns/store', 'PatternController@store')->name('patterns.store');
    Route::delete('/patterns/{pattern}', 'PatternController@destroy')->name('patterns.destroy');
    Route::get('/getDevicesList/{gateway?}', 'PatternController@getDevices');

});

/*  ==========================  API ROUTES  ====================================    */
Route::group(['prefix' => 'api'], function() {
    Route::post('/postElectricityMeterData', 'GatewayController@postElectricityMeterData')->name('postElectricityMeterData');
    Route::get('/getAMIGatewayConfig/{gateway}', 'GatewayController@getAMIGatewayConfig')->name('getAMIGatewayConfig');
    Route::get('/getLatestElectricalMeterConfig/{gatewayId}', 'GatewayController@getLatestElectricalMeterConfig')->name('getLatestElectricalMeterConfig');
    Route::post('/updateElectricityMeterRelayStatus', 'GatewayController@updateElectricityMeterRelayStatus')->name('updateElectricityMeterRelayStatus');
    Route::post('/updateElectricityMeterRelay2Status', 'GatewayController@updateElectricityMeterRelay2Status')->name('updateElectricityMeterRelay2Status');
    Route::post('/updateCoolingDevice', 'GatewayController@updateCoolingDevice')->name('updateCoolingDevice');
    Route::get('/getElectricityMeterFieldModify/{gateway}', 'GatewayController@getElectricityMeterFieldModify')->name('getElectricityMeterFieldModify');
    Route::post('postElectricityMeterFieldModifyConfirm', 'GatewayController@confirmFieldModify')->name('confirmFieldModify');
});
/*  ============================================================================    */
