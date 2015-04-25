Feature: Sketch manipulation buttons
  In order to save, load, and discard a sketch
  As a user
  I need to be able to operate the sketch manipulation buttons

  @cleanup_sketch
  Scenario: Load a sketch
    Given I am on the homepage
    When  I click on the "Load Sketch" button
    And   I select a sketch to load
    And   I click on the "Arduino" button
    Then  the code on the page should match the sketch file

  @cleanup_sketch @wip1
  Scenario: Save a sketch
    Given I load a sketch
    When  I click on the "Save Sketch" button
    And   I save the sketch
    Then  I should see the saved file in the correct directory

  Scenario: Discard a sketch
    Given I load a sketch
    When  I click on the "Discard Sketch" button
    Then  I see a modal dialog asking "Delete all # blocks?"
    When  I accept the modal dialog
    And   I click on the "Arduino" button
    Then  the code on the page should be reset

  @wip1
  Scenario: Discard a sketch using the trash can
    Given I load a sketch
    When  I click on the trash can icon
    Then  I see a modal dialog asking "Delete all # blocks?"
    When  I accept the modal dialog
    And   I click on the "Arduino" button
    Then  the code on the page should be reset