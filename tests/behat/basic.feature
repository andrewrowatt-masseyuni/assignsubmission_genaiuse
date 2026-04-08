@assignsubmission @assignsubmission_genaiuse
Feature: Basic tests for Generative AI use statement

  @javascript
  Scenario: Plugin assignsubmission_genaiuse appears in the list of installed additional plugins
    Given I log in as "admin"
    When I navigate to "Plugins > Plugins overview" in site administration
    And I follow "Additional plugins"
    Then I should see "Generative AI use statement"
    And I should see "assignsubmission_genaiuse"
