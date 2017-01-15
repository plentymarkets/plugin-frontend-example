<?php
/**
 * Created by IntelliJ IDEA.
 * User: ckunze
 * Date: 12/1/17
 * Time: 12:02
 */

namespace PluginFrontendExample\Providers;

use Plenty\Plugin\Templates\Twig;

class PluginFrontendExampleDataProvider
{

    public function call(Twig $twig):string
    {
        return $twig->render('PluginFrontendExample::content.pluginFrontendExampleDonationShowData.twig');
    }

}