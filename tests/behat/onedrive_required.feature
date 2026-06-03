@assignsubmission @assignsubmission_genaiuse
Feature: OneDrive link required field for Generative AI use statement

  Background:
    Given the following "courses" exist:
      | fullname | shortname | category | groupmode |
      | Course 1 | C1        | 0        | 1         |
    And the following "users" exist:
      | username | firstname | lastname | email                |
      | teacher1 | Teacher   | 1        | teacher1@example.com |
      | student1 | Student   | 1        | student1@example.com |
    And the following "course enrolments" exist:
      | user     | course | role           |
      | teacher1 | C1     | editingteacher |
      | student1 | C1     | student        |
    And I change the window size to "large"

  @javascript
  Scenario: OneDrive link is required when the setting is set to required
    Given the following "activity" exists:
      | activity                                | assign                   |
      | course                                  | C1                       |
      | name                                    | OneDrive Required assign |
      | submissiondrafts                        | 0                        |
      | assignsubmission_genaiuse_enabled       | 1                        |
      | assignsubmission_genaiuse_onedrivelink  | 2                        |
      | assignsubmission_onlinetext_enabled     | 1                        |
    And I am on the "OneDrive Required assign" Activity page logged in as student1
    When I press "Add submission"
    And I set the field "Online text" to "My submission text."
    And I click on "//div[@class='submission_genaiuse_radio_title'][normalize-space(.)='No AI Used']" "xpath_element"
    And I set the field "genaiuse_ack_confirmed" to "1"
    And I click on "//div[@class='submission_genaiuse_radio_title'][normalize-space(.)='No supporting evidence supplied']" "xpath_element"
    And I press "Save changes"
    Then I should see "A OneDrive link is required for this assignment."
    And I should not see "No generative AI was used"

  @javascript
  Scenario: OneDrive card shows required badge and red trim when required
    Given the following "activity" exists:
      | activity                                | assign                   |
      | course                                  | C1                       |
      | name                                    | OneDrive Required assign |
      | submissiondrafts                        | 0                        |
      | assignsubmission_genaiuse_enabled       | 1                        |
      | assignsubmission_genaiuse_onedrivelink  | 2                        |
      | assignsubmission_onlinetext_enabled     | 1                        |
    And I am on the "OneDrive Required assign" Activity page logged in as student1
    When I press "Add submission"
    And I click on "//div[@class='submission_genaiuse_radio_title'][normalize-space(.)='No AI Used']" "xpath_element"
    Then I should see "Required" in the ".submission_genaiuse_card_required .submission_genaiuse_badge_required" "css_element"

  @javascript
  Scenario: Student can submit when a OneDrive link is provided in required mode
    Given the following "activity" exists:
      | activity                                | assign                   |
      | course                                  | C1                       |
      | name                                    | OneDrive Required assign |
      | submissiondrafts                        | 0                        |
      | assignsubmission_genaiuse_enabled       | 1                        |
      | assignsubmission_genaiuse_onedrivelink  | 2                        |
      | assignsubmission_onlinetext_enabled     | 1                        |
    And I am on the "OneDrive Required assign" Activity page logged in as student1
    When I press "Add submission"
    And I set the field "Online text" to "My draft submission."
    And I click on "//div[@class='submission_genaiuse_radio_title'][normalize-space(.)='No AI Used']" "xpath_element"
    And I set the field "genaiuse_ack_confirmed" to "1"
    And I click on "//div[@class='submission_genaiuse_radio_title'][normalize-space(.)='No supporting evidence supplied']" "xpath_element"
    And I set the field "genaiuse_onedrivelink" to "https://example.com/onedrive/share/abc"
    And I press "Save changes"
    Then I should see "No generative AI was used"

  @javascript
  Scenario: No OneDrive link radio option is disabled in required mode
    Given the following "activity" exists:
      | activity                                | assign                   |
      | course                                  | C1                       |
      | name                                    | OneDrive Required assign |
      | submissiondrafts                        | 0                        |
      | assignsubmission_genaiuse_enabled       | 1                        |
      | assignsubmission_genaiuse_onedrivelink  | 2                        |
      | assignsubmission_onlinetext_enabled     | 1                        |
    And I am on the "OneDrive Required assign" Activity page logged in as student1
    When I press "Add submission"
    And I click on "//div[@class='submission_genaiuse_radio_title'][normalize-space(.)='No AI Used']" "xpath_element"
    Then the "input[name='genaiuse_onedrivelink_choice'][value='no']" "css_element" should be disabled
