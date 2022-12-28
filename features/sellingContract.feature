@sellingContract
Feature: Manage sellingContract
  In order to manage sellingContract
  Being authenticated

  Background: I have an authenticated Client
    Given A selling contract object
    Given A ready to use Client
    And I authenticate in AM the Client

  Scenario: Create a new selling contract
    When I create a selling contract
    Then I receive a 200 status code
    And I receive a response with the selling contract

  Scenario: Get all selling contracts
    When I get all selling contracts
    Then I receive a 200 status code
    And I receive a response with all selling contracts