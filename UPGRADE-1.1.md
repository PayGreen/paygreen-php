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
