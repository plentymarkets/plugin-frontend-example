<?php
/**
 * Created by IntelliJ IDEA.
 * User: ckunze
 * Date: 14/12/16
 * Time: 17:46
 */

namespace PluginFrontendExample\Migrations;

use Plenty\Modules\Plugin\DataBase\Contracts\Migrate;
use PluginFrontendExample\Models\PluginFrontendExampleDonationAccount;
use PluginFrontendExample\Models\PluginFrontendExampleDonationTransactions;

class PluginFrontendExampleCreateDbMigration_1_0_0
{

    /**
     * @param Migrate $migrate
     */
    public function run(Migrate $migrate)
    {
        $migrate->createTable(PluginFrontendExampleDonationAccount::class);

        $migrate->createTable(PluginFrontendExampleDonationTransactions::class);
    }
}