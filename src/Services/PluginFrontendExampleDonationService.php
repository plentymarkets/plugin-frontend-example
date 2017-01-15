<?php
/**
 * Created by IntelliJ IDEA.
 * User: ckunze
 * Date: 14/12/16
 * Time: 17:38
 */

namespace PluginFrontendExample\Services;

use PluginFrontendExample\Validators\FieldValidator;
use Plenty\Modules\Plugin\DataBase\Contracts\DataBase;
use PluginFrontendExample\Models\PluginFrontendExampleDonationAccount;
use PluginFrontendExample\Models\PluginFrontendExampleDonationTransactions;

use Plenty\Plugin\ConfigRepository;


class PluginFrontendExampleDonationService
{
    /**
     * @var ConfigRepository
     */
    private $config;

    /** @var  DataBase */
    private $db;

    public function __construct(DataBase $db, ConfigRepository $configRepo)
    {
        $this->db = $db;
        $this->config = $configRepo;
    }

    /**
     * Get total donation amount
     *
     * @return float
     */
    public function getDonationAmountCounter()
    {
        /** @var PluginFrontendExampleDonationTransactions[] $accountQuery */
        $accountQuery = $this->db->query('PluginFrontendExample\Models\PluginFrontendExampleDonationAccount')
            ->where('id', '=', '1')->get();

        $amount = isset($accountQuery) && (bool)$this->config->get('PluginFrontendExample.isDonationAmountCountable') ? $accountQuery[0]->balance : 0.00;

        return $amount;
    }


    /**
     * Get number of donations
     *
     * @return int
     */
    public function getDonationCounter()
    {
        /** @var PluginFrontendExampleDonationTransactions[] $accountQuery */
        $accountQuery = $this->db->query('PluginFrontendExample\Models\PluginFrontendExampleDonationTransactions')->get();

        $numberOfDonations = isset($accountQuery) && (bool)$this->config->get('PluginFrontendExample.isDonationCounterActive') ? count($accountQuery) : 0;

        return $numberOfDonations;
    }


    /**
     * Create new donation
     *
     * @param   $data
     * @return  PluginFrontendExampleDonationTransactions
     */
    public function createDonation($data)
    {
        FieldValidator::validateOrFail(['amount'    => $data['amount'],   'orderId'   => $data['orderId'],
                                        'contactId' => $data['contactId'] ]);

        $accountQuery = $this->db->query('PluginFrontendExample\Models\PluginFrontendExampleDonationAccount')
            ->where('id', '=', '1')->get();

        /** @var PluginFrontendExampleDonationAccount $donationAcc */
        $donationAcc = !($accountQuery[0] instanceof PluginFrontendExampleDonationAccount) ? pluginApp(PluginFrontendExampleDonationAccount::class) : $accountQuery[0];

        if($donationAcc->id != 1)
            $donationAcc->id = 1;

        $donationAcc->balance += (float)$data['amount'];

        /** @var PluginFrontendExampleDonationTransactions $transaction */
        $transaction = pluginApp(PluginFrontendExampleDonationTransactions::class);

        $this->fillDonationTransactionModel($data, $transaction);

        if((bool)$this->config->get('PluginFrontendExample.isDonationAmountCountable'))
            $this->db->save($donationAcc);

        if($this->config->get('PluginFrontendExample.isDonationCounterActive'))
            $createdTransaction = $this->db->save($transaction);

        return  isset($createdTransaction) && $createdTransaction instanceof  PluginFrontendExampleDonationTransactions ?
            $createdTransaction : pluginApp(PluginFrontendExampleDonationTransactions::class);
    }

    /**
     * Fill Transaction model with right data
     *
     * @param array $data
     * @param PluginFrontendExampleDonationTransactions $transactions
     */
    private function fillDonationTransactionModel(array $data, PluginFrontendExampleDonationTransactions &$transactions)
    {
        $transactions->contactId    =   (int)$data['contactId'];
        $transactions->orderId      =   (int)$data['orderId'];
        $transactions->amount       = (float)$data['amount'];
        $transactions->createdAt    = date("Y-m-d H:i:s");
    }

}