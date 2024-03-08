<?php

namespace Paygreen\Sdk\Payment\V3\Request\SellingContract;

use Exception;
use GuzzleHttp\Psr7\Request;
use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Paygreen\Sdk\Payment\V3\Model\SellingContractInterface;
use Psr\Http\Message\RequestInterface;

class SellingContractRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @throws Exception
     *
     * @return Request|RequestInterface
     */
    public function getCreateRequest(SellingContractInterface $sellingContract)
    {
        $body = [
            'shop_id' => $sellingContract->getShopId(),
            'number' => $sellingContract->getNumber(),
            'mcc' => $sellingContract->getMcc(),
            'max_amount' => $sellingContract->getMaxAmount(),
            'type' => $sellingContract->getType(),
            'iban' => $sellingContract->getIban(),
            'bic' => $sellingContract->getBic(),
        ];

        return $this->requestFactory->create(
            '/payment/selling-contracts',
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @return Request|RequestInterface
     */
    public function getUpdateRequest(SellingContractInterface $sellingContract)
    {
        $body = [
            'shop_id' => $sellingContract->getShopId(),
            'number' => $sellingContract->getNumber(),
            'mcc' => $sellingContract->getMcc(),
            'max_amount' => $sellingContract->getMaxAmount(),
            'type' => $sellingContract->getType(),
            'iban' => $sellingContract->getIban(),
            'bic' => $sellingContract->getBic(),
        ];

        return $this->requestFactory->create(
            '/payment/selling-contracts/' . urlencode($sellingContract->getId()),
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param $filters
     * @param $pagination
     *
     * @return RequestInterface
     * @throws Exception
     */
    public function getListRequest($filters = [], $pagination = [])
    {
        return $this->requestFactory->create(
            '/payment/selling-contracts?'. $this->getListParameters($filters, $pagination),
            null,
            'GET'
        )->withAuthorization()->isJson()->getRequest();
    }
}
