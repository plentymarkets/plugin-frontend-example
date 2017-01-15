<?php
/**
 * Created by IntelliJ IDEA.
 * User: ckunze
 * Date: 14/12/16
 * Time: 17:46
 */

namespace PluginFrontendExample\Providers;

use PluginFrontendExample\Extensions\TwigServiceProvider;
use Plenty\Plugin\ServiceProvider;
use Plenty\Plugin\Events\Dispatcher;

use Plenty\Modules\EventProcedures\Services\Entries\ProcedureEntry;
use Plenty\Modules\EventProcedures\Services\EventProceduresService;
use Plenty\Plugin\Templates\Twig;


class PluginFrontendExampleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->getApplication()->register(PluginFrontendExampleRouteServiceProvider::class);
    }

    public function boot(Twig $twig, Dispatcher $eventDispatcher, EventProceduresService $eventProceduresService)
    {
        $twig->addExtension(TwigServiceProvider::class);

        $eventProceduresService->registerProcedure(
            'plentyPluginFrontendExample',
            ProcedureEntry::EVENT_TYPE_ORDER,
            [   'de' => 'Spende registrieren',
                'en' => 'Register donation'],
            '\PluginFrontendExample\Procedures\PluginFrontendExampleRegisterTransaction@registerTransaction');

    }

}