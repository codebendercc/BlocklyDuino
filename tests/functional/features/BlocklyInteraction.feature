Feature: Blockly Interaction
  In order to learn more about Arduino programming
  As a user
  I need to be able to manipulate the Blockly view

  @wip
  Scenario: User can place a block
    Given I am on the homepage
    And   I click on the "Blocks" button
    When  I place a block
    And   I click on the "Arduino" button
    Then  the placed block shows up in the code