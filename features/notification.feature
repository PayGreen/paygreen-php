@notification
Feature: Manage notification
    In order to manage notifications
    Being authenticated

    Background: I have an authenticated Client
        Given A ready to use Client
        And I authenticate the Client

    Scenario: Create a new listener
        Given A listener object
        When I create a listener
        Then I receive a 200 status code
        And I receive a response with the listener
        When I update the listener
        Then I receive a 200 status code
        And I receive a response with the listener
        When I get the listener
        Then I receive a 200 status code
        And I receive a response with the listener
        When I get all notifications
        Then I receive a 200 status code
        And I receive a response with all notifications
        When I delete the listener
        Then I receive a 204 status code

    Scenario: Get all listeners
        When I get all listeners
        Then I receive a 200 status code
        And I receive a response with all listeners

    Scenario: Replay a notification
        When I replay the notification