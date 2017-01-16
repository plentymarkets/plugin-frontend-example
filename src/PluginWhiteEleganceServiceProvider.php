<?php // strict

namespace PluginWhiteElegance\Providers;

use Plenty\Plugin\ServiceProvider;
use Plenty\Plugin\Templates\Twig;
use Plenty\Plugin\Events\Dispatcher;
use Plenty\Plugin\ConfigRepository;

use IO\Helper\TemplateContainer;
use IO\Helper\CategoryMap;
use IO\Helper\CategoryKey;

class PluginWhiteEleganceServiceProvider extends ServiceProvider
{
    public function register()
    {
        
    }
    
    public function boot(Twig $twig, Dispatcher $eventDispatcher, ConfigRepository $config)
    {
        // Register Twig String Loader to use function: template_from_string
        $twig->addExtension('Twig_Extension_StringLoader');
        
        // provide template to use for content categories
        $eventDispatcher->listen('tpl.category.content', function(TemplateContainer $container, $templateData) {
            $container->setTemplate("PluginWhiteElegance::Category.Content.CategoryContent");
        }, 0);

        // provide template to use for item categories
        $eventDispatcher->listen('tpl.category.item', function(TemplateContainer $container, $templateData) {
            $container->setTemplate("PluginWhiteElegance::Category.Item.CategoryItem");
        }, 0);

        // provide template to use for blog categories
        $eventDispatcher->listen('tpl.category.blog', function(TemplateContainer $container, $templateData) {
            $container->setTemplate("PluginWhiteElegance::PageDesign.PageDesign");
        }, 0);

        // provide template to use for container categories
        $eventDispatcher->listen('tpl.category.container', function(TemplateContainer $container, $templateData) {
            $container->setTemplate("PluginWhiteElegance::PageDesign.PageDesign");
        }, 0);

        // provide template to use for single items
        $eventDispatcher->listen('tpl.item', function(TemplateContainer $container,  $templateData) {
            $container->setTemplate("PluginWhiteElegance::Item.SingleItem");
        }, 0);

        // provide template to use for basket
        $eventDispatcher->listen('tpl.basket', function(TemplateContainer $container, $templateData) {
            $container->setTemplate("PluginWhiteElegance::Basket.Basket");
        }, 0);

        // provide template to use for checkout
        $eventDispatcher->listen('tpl.checkout', function(TemplateContainer $container, $templateData) {
            $container->setTemplate("PluginWhiteElegance::Checkout.Checkout");
        }, 0);

        // provide template to use for my-account
        $eventDispatcher->listen('tpl.my-account', function(TemplateContainer $container, $templateData) {
            $container->setTemplate("PluginWhiteElegance::MyAccount.MyAccount");
        }, 0);

        // provide template to use for confirmation
        $eventDispatcher->listen('tpl.confirmation', function(TemplateContainer $container,  $templateData) {
            $container->setTemplate("PluginWhiteElegance::Checkout.OrderConfirmation");
        }, 0);

        // provide template to use for login
        $eventDispatcher->listen('tpl.login', function(TemplateContainer $container,  $templateData) {
            $container->setTemplate("PluginWhiteElegance::Customer.Login");
        }, 0);

        // provide template to use for register
        $eventDispatcher->listen('tpl.register', function(TemplateContainer $container, $templateData) {
            $container->setTemplate("PluginWhiteElegance::Customer.Register");
        }, 0);

        // provide template to use for guest
        $eventDispatcher->listen('tpl.guest', function(TemplateContainer $container,  $templateData) {
            $container->setTemplate("PluginWhiteElegance::Customer.Guest");
        }, 0);
    
        // provide template to use for item search
        $eventDispatcher->listen('tpl.search', function(TemplateContainer $container,  $templateData) {
            $container->setTemplate("PluginWhiteElegance::ItemList.ItemListView");
        }, 0);

        // provide mapped category IDs
        $eventDispatcher->listen('init.categories', function(CategoryMap $categoryMap) use(&$config) {
            $categoryMap->setCategoryMap(array (
                                             CategoryKey::HOME           => $config->get("PluginWhiteElegance.global.category.home"),
                                             CategoryKey::PAGE_NOT_FOUND => $config->get("PluginWhiteElegance.global.category.page_not_found"),
                                             CategoryKey::ITEM_NOT_FOUND => $config->get("PluginWhiteElegance.global.category.item_not_found")
                                         ));
            
        }, 0);
	}
}
