Feature: I can add end manipulate events

  Dictionary
    Calendar
    Event
    Occurrence
    Date Expression

  Background:
    Given calendar repository is empty

  Scenario: Create a calendar
    Given there is 0 calendars in calendar repository
    When I add new 'test' calendar
    Then there is 1 calendars in calendar repository
    And calendar 'test' has 0 events

  Scenario: Add event to calendar 'test'
    Given I add new 'test' calendar
    When I add to 'test' events:
    | name | expression                    | hours       |
    | abc  | monday or wednesday or friday | 18:00-20:00 |
    | bcd  | saturday or sunday            | 10:00-12:00 |
    Then calendar 'test' has 2 events
    And date 'last wednesday' matches event 'abc' in calendar 'test'

  Scenario Outline: List events for specified date range
    Given I add new 'test' calendar
    When I add to 'test' events:
      | name | expression                                                                   | hours       |
      | abc  | (monday or wednesday or friday) and after 2018-01-01 and before 2018-01-31   | 18:00-20:00 |
      | bcd  | (tuesday or thursday) and after 2018-03-01 and before 2018-03-31             | 18:00-20:00 |
      | cde  | after 2018-04-01 and before 2018-04-30                                       | 18:00-20:00 |
    Then I get <events> events with <occurrences> occurrences for range from <dateFrom> to <dateTo> in calendar 'test'

    Examples:
      | dateFrom  | dateTo      | events | occurrences |
      | 2018-01-01 | 2018-01-07 |      1 |           3 |
      | 2018-01-25 | 2018-03-07 |      2 |           5 |
      | 2018-04-01 | 2018-04-30 |      1 |          30 |

#  Scenario: Remove whole event from calendar
#
#  Scenario: Remove one occurrence of event from calendar
#
#  Scenario: Change events description
#
#  Scenario: Update events hours
#
#  Scenario: Move event to other days