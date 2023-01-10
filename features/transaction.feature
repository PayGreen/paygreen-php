@transaction
Feature: Manage transaction
  In order to manage transaction
  Being authenticated

  Background: I have an authenticated Client
    Given A payment order object
    Given A buyer object
    Given A ready to use Client
    And I authenticate the Client

  Scenario: Get the transaction
    When I get a transaction id
    When I get the transaction
    Then I receive a 200 status code
    And I receive a response with the transaction

  Scenario: Get all transactions
    When I get all transactions
    Then I receive a 200 status code
    And I receive a response with all transactions
