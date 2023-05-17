<?php

namespace Paygreen\Sdk\Climate\V2\Request;

use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Psr\Http\Message\RequestInterface;

class EmissionFactorRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param int $page
     * @param int $limit
     * @param string|null $search
     * @param int|null $emissionType
     * @param int|null $category
     *
     * @return RequestInterface
     */
    public function getListRequest(
      $page = 1,
      $limit = 25,
      $search = null,
      $emissionType = null,
      $category  = null
    ) {
        $body = [
            'page' => $page,
            'limit' => $limit,
            'search' => $search,
            'emissionType' => $emissionType,
            'category' => $category
        ];

        $body = (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body);

        return $this->requestFactory->create(
            '/carbon/emissionFactors?' . http_build_query($body),
            null,
            'GET'
        )->withAuthorization()->getRequest();
    }

    /**
     * @param string $emissionFactorId
     *
     * @return RequestInterface
     */
    public function getGetRequest($emissionFactorId)
    {
        return $this->requestFactory->create(
            '/carbon/emissionFactors/' . urlencode($emissionFactorId),
            null,
            'GET'
        )->withAuthorization()->getRequest();
    }
}