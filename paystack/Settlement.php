<?php
/**
 * Created by PhpStorm.
 * User: smladeoye
 * Date: 10/30/2016
 * Time: 10:53 AM
 */
//namespace components\sml\payment\paystack;
namespace components\sml\paystack;

use yii\base\Component;

class Settlement extends Component
{
    public $from;
    public $to;
    public $subaccount;

    private $settlement = array(
        'baseUrl'=>'/settlement',
        'beforeSend'=>array(),
        'afterSend'=>array()
    );

    public function __construct(Paystack $paystack, $config = [])
    {
        $this->attachBehavior('Resources',array('class'=> Resources::className()));

        $this->setPaystack($paystack);

        $this->settlement = array_replace($this->settlement,$paystack->settlement);
        $this->setConfig($this->settlement);

        parent::__construct($config);
    }

    public function fetchAll($from = null,$to = null, $subaccount = null)
    {
        $options = array();
        if (is_array($from))
        {
            $this->setRequestOptions($from);
        }
        else
        {
            if ($from)
                $options['from'] = $from;
            if ($to)
                $options['to'] = $to;
            if ($subaccount)
                $options['subaccount'] = $subaccount;

            $this->setRequestOptions($options);
        }

        $this->sendRequest(Paystack::OP_SETTLEMENT_LIST);
        $this->setResponseOptions();

        return $this;
    }
}