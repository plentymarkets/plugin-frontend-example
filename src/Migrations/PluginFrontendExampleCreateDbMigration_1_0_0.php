<?php
/**
 * Created by IntelliJ IDEA.
 * User: ckunze
 * Date: 14/12/16
 * Time: 17:46
 */

namespace PluginFrontendExample\Migrations;

use Plenty\Plugin\ConfigRepository;
use Plenty\Modules\Category\Contracts\CategoryRepositoryContract;
use Plenty\Modules\Category\Models\Category;
use Plenty\Modules\Plugin\DataBase\Contracts\Migrate;
use PluginFrontendExample\Models\PluginFrontendExampleDonationAccount;
use PluginFrontendExample\Models\PluginFrontendExampleDonationTransactions;

class PluginFrontendExampleCreateDbMigration_1_0_0
{

    /**
     * @var CategoryRepositoryContract
     */
    private $categoryRepo;

    /**
     * @var ConfigRepository $config
     */
    private $config;

    /**
     * @var array
     */
    private $categoriesToCreate = [ 'global.category.home' => [ 'de' => 'Spende',
                                                                'en' => 'Donation' ]    ];

    /**
     * CategoriesMigration constructor.
     * @param CategoryRepositoryContract $categoryRepo
     */
    public function __construct(CategoryRepositoryContract $categoryRepo, ConfigRepository $configRepo)
    {
        $this->categoryRepo = $categoryRepo;
        $this->config       = $configRepo;
    }

    /**
     * @param Migrate $migrate
     */
    public function run(Migrate $migrate)
    {
        $migrate->createTable(PluginFrontendExampleDonationAccount::class);
        $migrate->createTable(PluginFrontendExampleDonationTransactions::class);

        $this->createCategory();

    }

    private function createCategory()
    {
        foreach($this->categoriesToCreate as $configKey => $categories)
        {
            $details = [];
            foreach ($categories as $lang => $name)
            {
                $details[] = [
                    'plentyId' => 0,
                    'lang'     => $lang,
                    'name'     => $name
                ];
            }

            $newCategory = [ 'parentCategoryId' => '',
                             'level'            => 0,
                             'type'             => 'item',
                             'linklist'         => 'Y',
                             'right'            => 'all',
                             'sitemap'          => 'Y',
                             'details'          => $details,
                             'clients'          => [ [ 'plentyId' => 0 ] ]
            ];

            /** @var Category $createdCategory */
            $createdCategory = $this->categoryRepo->createCategory($newCategory);

        }
    }

}