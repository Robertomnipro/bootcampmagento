<?php

namespace OmniPro\ProductUpdate\Logger;

use Monolog\Logger;

class Handler extends \MAgento\Framework\Logger\Handler\Base
{
    protected $loggerType = Logger::DEBUG;
    protected $fileName = '/var/log/omnipor.log';   

}