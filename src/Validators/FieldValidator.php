<?php
/**
 * Created by IntelliJ IDEA.
 * User: ckunze
 * Date: 19/12/16
 * Time: 14:43
 */

namespace PluginFrontendExample\Validators;


use Plenty\Validation\Validator;

class FieldValidator extends Validator
{

    protected function defineAttributes()
    {
        $this->addInt('amount');
        $this->addInt('orderId');
        $this->addInt('contactId');
    }
}