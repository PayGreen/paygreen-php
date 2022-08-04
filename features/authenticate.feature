Feature: Authenticates a shop to get a bearer token
    In order to retrieve a bearer token
    Which will then allow to make all authenticated requests

    Scenario: Create an Environment
        Given A new Environment
        And A shop id is added to the Environment
        And A secret key is added to the Environment
        And An endpoint is added to the Environment
        Then The Environment is ready to use

    Scenario: Create a Client
        Given A ready to use Environment
        And A PSR7 http client
        Then The Client is ready to use but not authenticated