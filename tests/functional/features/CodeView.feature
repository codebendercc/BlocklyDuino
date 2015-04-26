Feature: Viewing code or blocks
  In order to learn more about Arduino programming
  As a user
  I need to be able to toggle between the Blockly blocks view and the Arduino code view
  and display elements within the Blockly view

  Scenario: Blocks View
    Given I am on the homepage
    When  I click on the "Blocks" button
    Then  I should see blocks

  Scenario: Arduino View
    Given I am on the homepage
    When  I click on the "Arduino" button
    Then  I should see code

  @wip @john
  Scenario: Block view blocks menu displays
    Given I am on the homepage
    When  I click on the "Blocks" button
    Then  the blocks menu displays