Feature: I can add end manipulate events

  Dictionary
    Calendar
    Event
    Occurrence
    Date Expression

  Scenario: Create a calendar
    Given there is 0 calendars in calendar repository
    When I add new 'test' calendar
    Then there is 1 calendars in calendar repository
    And calendar 'test' has 0 events

  Scenario: Add event to calendar 'test'
    Given I add new 'test' calendar
    When I add new to <calendar> new event <name> on <expression> at <hours>
      | calendar | name | expression | hours       |
      | test     | abc  | monday     | 10:00-11:00 |

    Then calendar 'test' has 1 events

  Scenario: List events for specified date range

  Scenario: Remove whole event from calendar

  Scenario: Remove one occurrence of event from calendar

  Scenario: Change events description

  Scenario: Update events hours

  Scenario: Move event to other days