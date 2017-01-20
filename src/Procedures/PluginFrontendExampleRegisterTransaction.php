<?php
/**
 * Created by IntelliJ IDEA.
 * User: ckunze
 * Date: 15/12/16
 * Time: 16:04
 */

namespace PluginFrontendExample\Procedures;

use Illuminate\Support\Collection;

use Plenty\Modules\Order\Models\Order;
use Plenty\Modules\Order\Models\OrderItem;

use Plenty\Modules\Item\DataLayer;
use Plenty\Modules\Item\DataLayer\Contracts\ItemDataLayerRepositoryContract;
use Plenty\Modules\Item\DataLayer\Models\Record;
use Plenty\Modules\Item\DataLayer\Models\RecordList;

use Plenty\Modules\Order\Models\OrderRelationReference;

use Plenty\Modules\EventProcedures\Events\EventProceduresTriggered;

use Plenty\Plugin\Application;
use Plenty\Plugin\ConfigRepository;

use PluginFrontendExample\Services\PluginFrontendExampleDonationService;


class PluginFrontendExampleRegisterTransaction
{

    /**
     * @var Application
     */
    private $app;

    /**
     * @var ConfigRepository
     */
    private $config;

    /**
     * PluginFrontendExampleRegisterTransaction constructor.
     *
     * @param Application $app
     * @param ConfigRepository $configRepo
     */
    public function __construct(Application $app, ConfigRepository $configRepo)
    {
        $this->app      = $app;
        $this->config   = $configRepo;
    }

    /**
     * Register new transaction
     *
     * Create new DB entry to register a new transaction
     *
     * @param EventProceduresTriggered $eventTriggered
     * @param PluginFrontendExampleDonationService $donationService
     */
    public function registerTransaction(EventProceduresTriggered $eventTriggered, PluginFrontendExampleDonationService $donationService)
    {
        /** @var Order $order */
        $order = $eventTriggered->getOrder();

        $contactId = -1;
        /** @var OrderRelationReference[] $r */
        $relations = $order->relations;

        /** @var OrderRelationReference $a */
        foreach($relations as $relation)
        {
            if($relation->relation == OrderRelationReference::RELATION_TYPE_RECEIVER)
            {
                $contactId = $relation->referenceId;
            }
        }

        /** @var OrderItem[] $orderItem */
        $orderItems = $order->orderItems;
        /** @var RecordList $item */
        $items = $this->loadItemsForCategory($orderItems);

        $totalAmount = 0.00;
        /** @var Record $item */
        foreach($items as $item)
        {

            if($item->variationStandardCategory->getCategoryId() == $this->config->get('PluginFrontendExample.categoryId'))
            {
                /** @var OrderItem $oI */
                $oI = $orderItems->where('itemVariationId', $item->getVariationBase()->getId())->first();
                $totalAmount += $oI->quantity * $item->getVariationRetailPrice()->getPrice();
            }
        }

        if($totalAmount > 0)
        {
            $data['contactId'] = (int)$contactId;
            $data['orderId']   = (int)$order->id;
            $data['amount']    = (float)$totalAmount;
            $donationService->createDonation($data);
        }
    }

    /**
     * Load
     *
     * @param Collection $orderItems
     *
     * @return mixed|RecordList|void
     */
    private function loadItemsForCategory(Collection $orderItems)
    {
        $ids = array();

        /** @var OrderItem $orderItem */
        foreach($orderItems as $orderItem)
        {
            $ids[] = $orderItem->itemVariationId;
        }

        if(count($ids) > 0)
        {
            $itemDataLayer = pluginApp(ItemDataLayerRepositoryContract::class);
            $columns       = ['variationBase'                    => ['id'],
                              'variationStandardCategory'   => ['categoryId'],
                              'variationRetailPrice'        => ['price']    ];

            $filter = [ 'variationBase.hasId' => ['id' => $ids]];
            $params = [ 'plentyId' => $this->app->getPlentyId()];

            /** @var RecordList $recordList */
            $recordList = $itemDataLayer->search($columns, $filter, $params);
            return $recordList;

        }
        return pluginApp(RecordList::class);
    }
}