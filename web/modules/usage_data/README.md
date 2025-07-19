# Usage Data

This module is intended for internal site analytics, treating page
views and downloads as events which are recorded to a usage_data table.
You can then pull your data out with Views Database Connector
(drupal.org/project/views_database_connector) or by writing your own
queries. You can add your own columns to the usage_data table by writing
your own install hook (hook_install()).

The default structure is as follows:

| id | event_type | entity_id | entity_type_id | path     | timestamp  | uid | user_name | user_role       | count |
|----|------------|-----------|----------------|----------|------------|-----|-----------|-----------------|-------|
| 1  | view       | 2         | node           | /about   | 1635444980 | 1   | admin     | administrator   | 1     |
| 2  | download   | 30        | media          | /reports | 1635444981 | 2   | editor    | content_manager | 1     |


Please be responsible when collecting data from your users.

**Authors:** Nia Kathoni (nikathone) & Daniel Cothran (andileco)
