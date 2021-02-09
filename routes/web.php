<?php

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', function () { return redirect('/redirectUserToProperPage'); })->name('client.home');
Route::get('/client/login', function () { return view('client.home'); })->name('client.login');
Route::get('/redirectUserToProperPage', 'HomeController@redirectUserToProperPage');
Route::get('/mqtt', 'InstallerController@mqtt');

// Route::get('/fill', 'GatewayController@fill');
// Route::get('/randomFillModify', 'HomeController@randomFillModify');
// Route::get('convertHistories', 'HomeController@convertHistories');
// Route::get('getCurrent', 'HomeController@getCurrent');
Route::group(['middleware' => 'auth'], function() {
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/', 'HomeController@dashboard');
        Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');

        Route::resource('gateways', 'AdminGatewayController')->except(['index', 'show']);
        Route::get('gateways/{type?}', 'AdminGatewayController@index')->name('gateways.index');
        Route::get('gateways/{gateway}/coolingDevices', 'AdminGatewayController@devices')->name('gateways.devices');
        Route::get('gateways/patterns/index', 'PatternController@gatewayPatternsIndex')->name('gateways.patterns.index');
        Route::get('gateways/{gateway}/patterns', 'AdminGatewayController@patterns')->name('gateways.patterns');
        Route::get('gateways/patterns/create', 'PatternController@createGatewayPattern')->name('gateways.patterns.create');
        Route::post('gateways/patterns/store', 'PatternController@storeGatewayPattern')->name('gateways.patterns.store');
        Route::post('gateways/patterns/massStore', 'PatternController@massStore')->name('gateways.patterns.massStore');
        Route::delete('gateways/patterns/{pattern}', 'PatternController@destroyGatewayPattern')->name('gateways.patterns.destroy');
        Route::get('gateways/{gateway}/destroySinglePatternRow/{pattern}', 'PatternController@destroySingleGatewayPattern')->name('gateways.patterns.destroySingle');
        Route::get('gateways/{gateway}/children', 'AdminGatewayController@getChildren')->name('gateways.getChildren');

        Route::resource('electricalMeterTypes', 'ElectricalMeterTypeController');

        Route::resource('electricalMeters', 'ElectricalMeterController');
        Route::get('electricalMeters/{id}/history', 'ElectricalMeterController@history')->name('electricalMeters.history');

        Route::resource('/coolingDeviceTypes', 'CoolingDeviceTypeController');
        Route::resource('coolingDevices', 'CoolingDeviceController')->except(['index', 'create', 'show']); // store, edit, update, destroy
        Route::get('coolingDevices/{gateway}', 'CoolingDeviceController@index')->name('coolingDevices.index');
        Route::get('coolingDevices/{gateway}/create', 'CoolingDeviceController@create')->name('coolingDevices.create');
        Route::get('coolingDevices/{id}/history', 'CoolingDeviceController@history')->name('coolingDevices.history');
        Route::get('coolingDevices/{id}/changeStatus', 'CoolingDeviceController@changeStatus')->name('coolingDevices.changeStatus');

        Route::get('coolingDevices/{device}/patterns', 'CoolingDeviceController@patterns')->name('coolingDevices.patterns');
        Route::get('coolingDevices/patterns/new/{gateway?}/{device?}', 'PatternController@createCoolingDevicePattern')->name('coolingDevices.patterns.new');
        Route::post('coolingDevices/patterns/store', 'CoolingDeviceController@storePattern')->name('coolingDevices.patterns.store');
        Route::post('coolingDevices/patterns/massStore', 'CoolingDeviceController@massStore')->name('coolingDevices.patterns.massStore');

        Route::group(['middleware' => 'role:admin'], function () {
            Route::resource('users', 'UserController');
            Route::get('users/{user}/resetPassword', 'UserController@resetPassword')->name('users.resetPassword');
            Route::get('users/{user}/changePassword', 'UserController@changePassword')->name('users.changePassword');
            Route::post('users/updatePassword', 'UserController@updatePassword')->name('users.updatePassword');

            Route::get('permissions', 'PermissionController@index')->name('permissions.index');

            Route::post('roles', 'PermissionController@storeRole')->name('roles.store');
            Route::put('roles/{role}', 'PermissionController@updateRole')->name('roles.update');
            Route::delete('roles/{role}', 'PermissionController@destroyRole')->name('roles.destroy');

            Route::post('permissions', 'PermissionController@storePermission')->name('permissions.store');
            Route::put('permissions/{permission}', 'PermissionController@updatePermission')->name('permissions.update');
            Route::delete('permissions/{permission}', 'PermissionController@destroyPermission')->name('permissions.destroy');

            // updateRolePermissions
            Route::post('rolePermissions', 'PermissionController@updateRolePermissions')->name('roles.updateRolePermissions');
            Route::post('userRoles', 'PermissionController@updateUserRoles')->name('roles.updateUserRoles');

            Route::post('gateways/assignUser', 'UserController@assignUserGateway')->name('gateways.assignUser');
            Route::post('gateways/revokeUser', 'UserController@revokeUserGateway')->name('gateways.revokeUser');
        });

        Route::get('/patterns', 'PatternController@index')->name('patterns.index');
        Route::get('/patterns/create', 'PatternController@create')->name('patterns.create');
        Route::post('/patterns/store', 'PatternController@storeCoolingDevicePattern')->name('patterns.store');
        Route::get('/patterns/{pattern}/show', 'PatternController@show')->name('patterns.show');
        Route::delete('/patterns/rows/{row}', 'PatternController@destroyRow')->name('patterns.rows.destroy');
        Route::delete('/patterns/{pattern}', 'PatternController@destroy')->name('patterns.destroy');
        Route::get('/getDevicesList/{gateway?}', 'PatternController@getDevices');
        Route::post('/patterns/checkNameUniqueness', 'PatternController@checkNameUniqueness')->name('patterns.checkNameUniqueness');

        Route::resource('pumpPatterns', 'PumpPatternController');
        Route::post('pumpPatterns/massStore')->name('pumpsPatterns.massStore');

        Route::resource('groups', 'GroupController');
        Route::get('groups/{group}/groupGatewayPattern', 'GroupController@groupGatewayPattern')->name('groups.gatewayPattern');
        Route::post('groups/patterns/store', 'GroupController@storeGatewayGroupPatterns')->name('groups.gatewayPatterns.store');
        Route::post('groups/patterns/removeSingle', 'GroupController@removeSingleGatewayGroupPattern')->name('groups.gatewayPatterns.removeSingle');
        Route::post('groups/patterns/updateGroupDevicePattern', 'GroupController@storeDeviceGroupPattern')->name('groups.devicePatterns.update');

        Route::get('/reports', 'ReportController@index')->name('reports');
        Route::post('report', 'ReportController@report')->name('reports.post');
        Route::get('/codes', 'CodeController@index')->name('codes.index');
        Route::get('/getCodes/{coolingDeviceTypeId}', 'CodeController@getCodes')->name('codes.getCodes');
        Route::post('/codes', 'CodeController@store')->name('codes.store');
    });

    Route::group(['middleware' => 'role:installer'], function () {

        Route::get('/newGatewayTypeB', 'InstallerController@newGatewayTypeB');
        Route::get('/newGatewayTypeA', 'InstallerController@newGatewayTypeA');
        Route::get('/newSplit', 'InstallerController@newSplit');
    });
    Route::get('/editProfile', 'InstallerController@editProfile');
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

    Route::group(['prefix' => 'v2'], function() {
        Route::get('/getTime', 'Api\V2Controller@getTime')->name('getTime');
        Route::get('/getLatestElectricalMeterConfig/{gatewayId}', 'Api\V2Controller@getLatestElectricalMeterConfig')->name('v2.getLatestElectricalMeterConfig');
        Route::post('/postElectricityMeterData', 'Api\V2Controller@@postElectricityMeterData')->name('v2.postElectricityMeterData');
    });
});
/*  ============================================================================    */
