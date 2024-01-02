@paymentOrder
Feature: Manage payment order
  In order to manage payment order
  Being authenticated

  Background: I have an authenticated Client
    Given A payment order object
    Given A buyer object
    Given A ready to use Client
    And I authenticate the Client

  Scenario: Create a new payment order
    Given I add the buyer object to the payment order object
    When I create a payment order
    Then I receive a 200 status code
    And I receive a response with the payment order
    And I add the payment order id to the payment order object
    When I update the payment order
    Then I receive a 200 status code
    And I receive a response with the payment order

  Scenario: Create a new payment order with buyer id
    When I create a buyer
    Then I receive a 200 status code
    And I receive a response with the buyer
    And I add the buyer_id to the buyer object
    And I add the buyer object to the payment order object
    When I create a payment order
    Then I receive a 200 status code
    And I receive a response with the payment order

  Scenario: Capture a payment order
    Given I add the buyer object to the payment order object
    And I set auto_capture to false in the payment order object
    When I create a payment order
    Then I receive a 200 status code
    And I receive a response with the payment order
    Given I authorize payment with pgjs
    When I capture a payment order
    Then I receive a 200 status code

  @instrument
  Scenario: Capture a payment order with instrument
    Given I create an instrument with pgjs
    Given I add the buyer object to the payment order object
    And I set auto_capture to true in the payment order object
    When I create a payment order
    Then I receive a 200 status code
    And I receive a response with the payment order
    When I authorize payment with pgjs

  Scenario: Refund a payment order
    Given I add the buyer object to the payment order object
    When I create a payment order
    Then I receive a 200 status code
    And I receive a response with the payment order
    Given I authorize payment with pgjs
    When I refund a payment order
    Then I receive a 200 status code

  Scenario: Partially refund a payment order
    Given I add the buyer object to the payment order object
    When I create a payment order
    Then I receive a 200 status code
    And I receive a response with the payment order
    Given I authorize payment with pgjs
    When I refund partially a payment order
    Then I receive a 200 status code

  Scenario: Partially and fully refund a payment order
    Given I add the buyer object to the payment order object
    When I create a payment order
    Then I receive a 200 status code
    And I receive a response with the payment order
    Given I authorize payment with pgjs
    When I refund partially a payment order
    Then I receive a 200 status code
    When I refund a payment order
    Then I receive a 200 status code

  Scenario: Cancel a pending payment order
    Given I add the buyer object to the payment order object
    When I create a payment order
    Then I receive a 200 status code
    And I receive a response with the payment order
    When I cancel a payment order
    Then I receive a 200 status code

  Scenario: Cancel an authorized payment order
    Given I add the buyer object to the payment order object
    When I create a payment order
    Then I receive a 200 status code
    And I receive a response with the payment order
    Given I authorize payment with pgjs
    When I cancel a payment order
    Then I receive a 422 status code

  @mit
  Scenario: Make a Merchant Initialized Transaction
    Given I create a buyer
    And I add the buyer_id to the buyer object
    Given I create a reusable instrument with pgjs
    Given I add the instrument id to the payment order object
    And I set auto_capture to true in the payment order object
    And I set merchant_initiated to true in the payment order object
    When I create a payment order
    Then I receive a 200 status code
    And I receive a response with the payment order
