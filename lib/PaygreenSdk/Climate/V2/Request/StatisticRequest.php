<?php

namespace Paygreen\Sdk\Climate\V2\Request;

use Exception;
use Paygreen\Sdk\Climate\V2\Enum\FootprintStatusEnum;
use Paygreen\Sdk\Climate\V2\Model\DeliveryData;
use Paygreen\Sdk\Climate\V2\Model\WebBrowsingData;
use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Psr\Http\Message\RequestInterface;

class StatisticRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @return RequestInterface
     */
    public function getGetRequest()
    {
        return $this->requestFactory->create(
            '/carbon/statistics/reports',
            null,
            'GET'
        )->withAuthorization()->withTestMode()->isJson()->getRequest();
    }
}