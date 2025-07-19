password_policy_pwned
======================

This is a Drupal module that adds a Pwned Passwords plugin to the
[Password Policy](https://www.drupal.org/project/password_policy) module.

## Have I Been Pwned
The plugin uses the [Have I Been Pwned](https://haveibeenpwned.com/) Passwords
[API](https://haveibeenpwned.com/API/v2#SearchingPwnedPasswordsByRange).

To protect privacy, the API uses the
[k-Anonymity model](https://en.wikipedia.org/wiki/K-anonymity). A SHA-1 hash of
the password is created, only the first 5 characters of the hash are sent to the
API.

The API response is a list of matching SHA1 hashes representing exposed
passwords known to the service. The plugin then checks if the full SHA-1 is in
the list, without sending the full hash to the API.
