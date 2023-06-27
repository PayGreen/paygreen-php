<?php

namespace Paygreen\Sdk\Charity\V2\Request;

use Paygreen\Sdk\Charity\V2\Model\Donation;
use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Psr\Http\Message\RequestInterface;

class DonationRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param Donation $donation
     *
     * @return RequestInterface
     */
    public function getCreateRequest($donation)
    {
        $body = [
            'donationReference' => $donation->getReference(),
            'idAssociation' => $donation->getAssociationId(),
            'type' => $donation->getType(),
            'donationAmount' => $donation->getDonationAmount(),
            'totalAmount' => $donation->getTotalAmount(),
            'currency' => $donation->getCurrency(),
            'buyer' => [
                'email' => $donation->getBuyer()->getEmail(),
                'externalId' => $donation->getBuyer()->getReference(),
                'firstname' => $donation->getBuyer()->getFirstName(),
                'lastname' => $donation->getBuyer()->getLastName(),
                'address' => $donation->getBuyer()->getAddressLine(),
                'address2' => $donation->getBuyer()->getAddressLineTwo(),
                'city' => $donation->getBuyer()->getCity(),
                'zipCode' => $donation->getBuyer()->getPostalCode(),
                'country' => $donation->getBuyer()->getCountryCode(),
                'company' => $donation->getBuyer()->getCompanyName(),
                'phone' => $donation->getBuyer()->getPhoneNumber(),
            ],
            'isAPledge' => $donation->isAPledge()
        ];

        return $this->requestFactory->create(
            '/donation',
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->withTestMode()->isJson()->getRequest();
    }

    /**
     * @param integer $donationId
     *
     * @return RequestInterface
     */
    public function getGetRequest($donationId)
    {
        return $this->requestFactory->create(
            '/donation/' . urlencode($donationId),
            null,
            'GET'
        )->withAuthorization()->withTestMode()->getRequest();
    }
}