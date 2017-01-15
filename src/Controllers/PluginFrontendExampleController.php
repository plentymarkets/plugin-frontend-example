<?php
/**
 * Created by IntelliJ IDEA.
 * User: ckunze
 * Date: 15/12/16
 * Time: 14:31
 */

namespace PluginFrontendExample\Controllers;


use PluginFrontendExample\Services\PluginFrontendExampleDonationService;
use Plenty\Plugin\Controller;

use Plenty\Plugin\Http\Request;
use Plenty\Plugin\Http\Response;

class PluginFrontendExampleController extends Controller
{

    /**
     * Create new transaction
     *
     * @param Request $request
     * @param Response $response
     * @param PluginFrontendExampleDonationService $service
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createDonation(Request $request, Response $response, PluginFrontendExampleDonationService $service)
    {
        return $response->json($service->createDonation($request->all()));
    }

    /**
     * Get number of realized donations
     *
     * @param Response $response
     * @param PluginFrontendExampleDonationService $service
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getDonationCounter(Response $response, PluginFrontendExampleDonationService $service)
    {
        return $response->json($service->getDonationCounter());
    }

    /**
     * Get total amount of realized donations
     *
     * @param Response $response
     * @param PluginFrontendExampleDonationService $service
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getDonationAmountCounter(Response $response, PluginFrontendExampleDonationService $service)
    {
        return $response->json($service->getDonationAmountCounter());
    }


}