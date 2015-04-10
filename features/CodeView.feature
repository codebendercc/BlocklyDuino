Feature: Viewing code or blocks
  In order to learn more about Arduino programming
  As a user
  I need to be able to toggle between the Blockly blocks view and the Arduino code view

  Scenario: Blocks View
    Given I am on "/"
    When  I click on the "Blocks" button
    Then  I should see blocks

  Scenario: Arduino View
    Given I am on "/"
    When  I click on the "Arduino" button
    Then  I should see code