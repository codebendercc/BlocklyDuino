Feature: Interfacing with the Compilerflasher
  In order to send code to Codebender
  As a user
  I need to be able to operate the Compilerflasher integrations

  @cleanup_sketch
  Scenario: Verify Code
    Given I am on the homepage
    And   I load a sketch
    When  I click on the "Verify Code" button
    Then  I see "Verification Successful" in the Status box

  Scenario: Error Message displays when the plugin is missing
    Given I am on the homepage
    And   I do not have the Codebender plugin installed
    Then  I see "To program your Arduino from your browser, install the Codebender Plugin. " in the Status box