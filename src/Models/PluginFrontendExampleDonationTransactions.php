<?php
/**
 * Created by IntelliJ IDEA.
 * User: ckunze
 * Date: 15/12/16
 * Time: 12:49
 */

namespace PluginFrontendExample\Models;

use PluginFrontendExample\Models\PluginFrontendExample;

use Plenty\Modules\Plugin\DataBase\Contracts\Model;

/**
 * Class PluginFrontendExampleTransactions
 *
 * @property int        $id
 * @property int        $contactId
 * @property int        $orderId
 * @property float      $amount
 * @property int        $mopId
 * @property string     $createdAt
 * @property int        $status
 * @property string     $bookingText
 *
 * @package PluginFrontendExample\Models
 */
class PluginFrontendExampleDonationTransactions extends Model
{
    /** @var  int */
    public $id;

    /** @var  int */
    public $contactId;

    /** @var  int */
    public $orderId;

    /** @var  float */
    public $amount;

    /** @var  string */
    public $createdAt;

    /**
     * @return string
     */
    public function getTableName():string
    {
        return 'PluginFrontendExample::donationTransactions';
    }

}
