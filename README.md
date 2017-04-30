# Login with Google Account
  - get OAuth credentials as described on [https://developers.google.com/+/quickstart/php](https://developers.google.com/+/quickstart/php)
  - run `composer install`
  - rename `oauth-params.inc.dist` to `oauth-params.inc`
  - place client_id, client_secret and redirect_uri in `oauth-params.inc`
  - run local web server `php -S localhost:4567` and login