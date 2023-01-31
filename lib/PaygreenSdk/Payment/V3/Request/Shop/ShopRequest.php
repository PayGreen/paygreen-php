<?php

namespace Paygreen\Sdk\Payment\V3\Request\Shop;

use GuzzleHttp\Psr7\Request;
use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Paygreen\Sdk\Payment\V3\Model\Address;
use Paygreen\Sdk\Payment\V3\Model\Shop;
use Psr\Http\Message\RequestInterface;

class ShopRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**     *
     * @return Request|RequestInterface
     */
    public function getListRequest($filters = [], $pagination = [])
    {
        if($filters === null) {
            $filters = [];
        }

        if (empty($pagination)) {
            $pagination = $this->getDefaultPagination();
        }

        $parameters = http_build_query(
            array_merge($filters, $pagination)
        );

        return $this->requestFactory->create(
            "/account/shops?" . $parameters,
            null,
            'GET'
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param string|null $shopId
     *
     * @return Request|RequestInterface
     */
    public function getGetRequest($shopId = null)
    {
        if ($shopId === null) {
            $shopId = $this->environment->getShopId();
        }

        return $this->requestFactory->create(
            "/account/shops/$shopId",
            null,
            'GET'
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param Shop $shop
     *
     * @return Request|RequestInterface
     * @deprecated @param string $name
     * @deprecated @param string $nationalId
     */
    public function getCreateRequest($name = null, $nationalId = null, $shop = null)
    {
        if ($shop === null) {
            $shop = new Shop();
        }

        if (!empty($name) && empty($shop->getName())) {
            $shop->setName($name);
        }

        if (!empty($nationalId) && empty($shop->getNationalId())) {
            $shop->setNationalId($nationalId);
        }

        $body = [
            'name' => $shop->getName(),
            'national_id' => $shop->getNationalId(),
            'mcc' => $shop->getMcc(),
            'annual_processing_volume' => $shop->getAnnualProcessingVolume(),
            'average_transaction_value' => $shop->getAverageTransactionValue(),
            'highest_transaction_value' => $shop->getHighestTransactionValue(),
            'activity_categories' => $shop->getActivityCategories(),
            'activity_description' => $shop->getActivityDescription(),
            'commercial_name' => $shop->getCommercialName(),
            'creation_date' => $shop->getCreationDate() ? $shop->getCreationDate()->format('Y-m-d') : null,
            'economic_model' => $shop->getEconomicModel(),
            'legal_category' => $shop->getLegalCategory(),
            'primary_activity' => $shop->getPrimaryActivity(),
            'product_type' => $shop->getProductType(),
            'website_url' => $shop->getWebsiteUrl(),
            'legal_notice_url' => $shop->getLegalNoticeUrl(),
            'address' => null
        ];

        if ($shop->getAddress() instanceof Address) {
            $body['address'] = [
                "line_1" => $shop->getAddress()->getStreetLineOne(),
                "line_2" => $shop->getAddress()->getStreetLineTwo(),
                "postal_code" => $shop->getAddress()->getPostalCode(),
                "city" => $shop->getAddress()->getCity(),
                "country" => $shop->getAddress()->getCountryCode(),
                "state" => $shop->getAddress()->getState(),
            ];
        }

        return $this->requestFactory->create(
            "/account/shops",
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->isJson()->getRequest();
    }
}
