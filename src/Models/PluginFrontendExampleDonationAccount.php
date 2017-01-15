<?php
/**
 * Created by IntelliJ IDEA.
 * User: ckunze
 * Date: 15/12/16
 * Time: 12:36
 */

namespace PluginFrontendExample\Models;

use Plenty\Modules\Plugin\DataBase\Contracts\Model;

class PluginFrontendExampleDonationAccount extends Model
{

    /** @var  int */
    public $id;

    /** @var  float */
    public $balance = 0.00;

    /**
     * @return string
     */
    public function getTableName():string
    {
        return 'PluginFrontendExample::donationAccount';
    }
}