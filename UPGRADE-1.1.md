# UPGRADE FROM `1.1.0` TO `1.1.1`

1. We renamed a function whose name was incorrect.
   Check your use of `Paygreen\Sdk\Payment\V3\Enum\StatusEnum`, `getPaymentModes` have been renamed to `getStatus`.
    ```diff
    - Paygreen\Sdk\Payment\V3\Enum\StatusEnum::getPaymentModes();
    + Paygreen\Sdk\Payment\V3\Enum\StatusEnum::getStatus();
    ```

# UPGRADE FROM `1.0.X` TO `1.1.0`

1. We have standardized and corrected all first and last name calls. For all models.  
   Check your creations of objects `Paygreen\Sdk\Payment\V2\Model\Address` and `Paygreen\Sdk\Payment\V2\Model\Customer`.
    ```diff
    $customer = new \Paygreen\Sdk\Payment\V2\Model\Customer();
    - $customer->setFirstname('John');
    + $customer->setFirstName('John');
    - $customer->setLastname('Doe');
    + $customer->setLastName('Doe');
    
    $address = new \Paygreen\Sdk\Payment\V2\Model\Address();
    - $address->setFirstname('John');
    + $address->setFirstName('John');
    - $address->setLastname('Doe');
    + $address->setLastName('Doe');
    ```
