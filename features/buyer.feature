@buyer
Feature: Manage buyers
    In order to manage buyers
    Being authenticated

    Background: I have an authenticated Client
        Given A ready to use Client
        And I authenticate the Client

    Scenario: Create a new buyer
        Given A buyer object
        When I create a buyer
        Then I receive a 200 status code
        And I receive a response with the buyer
        And I add the buyer_id to the buyer object
        When I update the buyer
        Then I receive a 200 status code
        And I receive a response with the buyer
        When I delete the buyer
        Then I receive a 200 status code

    Scenario: Get all buyers
        When I get all buyers
        Then I receive a 200 status code
        And I receive a response with all buyers
