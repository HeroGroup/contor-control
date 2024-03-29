<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'api/postElectricityMeterData',
        'api/postElectricityMeterFieldModifyConfirm',
        'api/updateElectricityMeterRelayStatus',
        'api/updateElectricityMeterRelay2Status',
        'api/updateCoolingDevice',
        'api/v2/postElectricityMeterData',
        'api/v2/nodes',
    ];
}
