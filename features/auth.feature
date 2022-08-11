@authentication @publicKey
Feature: Authenticate a shop
    In order to retrieve a bearer token
    Which will then allow to make all authenticated requests

    Scenario: Authenticate a shop
        Given A ready to use Client
        When I authenticate the Client
        Then I should be able to make authenticated requests
        And I should be able to retrieve the expiration date of the bearer token

    Scenario: Retrieve public key information
        Given A ready to use Client
        When I authenticate the Client
        Then I should be able to retrieve public key information