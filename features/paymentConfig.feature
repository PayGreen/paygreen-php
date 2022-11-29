@paymentConfig
Feature: Manage payment config
  In order to manage payment config
  Being authenticated

  Background: I have an authenticated Client
    Given A payment order object
    Given A buyer object
    Given A ready to use Client
    And I authenticate the Client

  Scenario: Create a new payment config
    Given A payment config object
    When I create a payment config
    Then I receive a 400 status code
    And I receive 'Property national_id must be completed on your shop. Property postal_code must be completed on your shop address. ' error message

  Scenario: Get all payment configs
    When I get all payment configs
    Then I receive a 200 status code
    And I receive a response with all payment configs
