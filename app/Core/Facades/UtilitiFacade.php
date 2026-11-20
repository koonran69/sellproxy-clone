<?php

namespace App\Core\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static App\Core\Responses\TraitResponse responseAjax(bool $error = false, string $msg = null, $data = null, $statusCode = 200)
 * @method static App\Core\Responses\TraitResponse responseBack(bool $error = false, string $msg = null, bool $withInput = false)
 * @method static App\Core\Responses\TraitResponse toRoute(string $name, array|int|string $params = null, bool $error = false, string $msg = null)
 * @method static App\Core\Responses\TraitResponse handleType(bool  $error = false, string $msg = null)
 *
 * @see App\Core\Responses\TraitResponse
 */
class UtilitiFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'utilities';
    }
}