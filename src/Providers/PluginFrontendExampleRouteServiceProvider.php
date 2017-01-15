<?php
/**
 * Created by IntelliJ IDEA.
 * User: ckunze
 * Date: 14/12/16
 * Time: 17:44
 */

namespace PluginFrontendExample\Providers;

use Plenty\Plugin\Routing\Router;
use Plenty\Plugin\RouteServiceProvider;

class PluginFrontendExampleRouteServiceProvider extends RouteServiceProvider
{
    /**
     * @param Router $router
     */
    public function map(Router $router)
    {
        $pfeNameSpace = 'PluginFrontendExample\Controllers\PluginFrontendExampleController';

        $router->get( '/rest/donation/counter'          , $pfeNameSpace.'@getDonationCounter');
        $router->get( '/rest/donation/amountCounter'    , $pfeNameSpace.'@getDonationAmountCounter');

        $router->post('/rest/donation/'                 , $pfeNameSpace.'@createDonation');
    }
}