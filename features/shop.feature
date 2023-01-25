@shop
Feature: Create shop for marketplace
    Being authenticated

    Background: I have an authenticated Client
        Given A ready to use marketplace Client
        And I authenticate the Client

    Scenario: Create a new shop
        When I get a shop
        Then I receive a response with the shop
