# Force.com Toolkit for PHP

The Force.com PHP Toolkit provides an easy-to-use wrapper for the Force.com Web Services SOAP API, presenting SOAP client implementations for both the enterprise and partner WSDLs.

See the [getting started guide](http://wiki.developerforce.com/index.php/Getting_Started_with_the_Force.com_Toolkit_for_PHP) for sample code to create, retrieve, update and delete records in the Force.com database.

## OAuth SOAP sessions

After obtaining an OAuth access token, create the SOAP connection with a Partner WSDL and call `setOAuthSession()` instead of `login()`:

```php
$client = new \Justia\SalesforcePhpSdk\SforcePartnerClient();
$client->createConnection(__DIR__ . '/wsdl/partner-v67.wsdl.xml');
$client->setOAuthSession($accessToken, $instanceUrl, '67.0');
```

`$instanceUrl` must be the HTTPS `instance_url` returned by Salesforce's OAuth token response. The bundled `wsdl/partner-v67.wsdl.xml` is the production-org Partner WSDL generated for API 67.0. The method sets the SOAP `SessionHeader` to the access token and changes the endpoint to `/services/Soap/u/67.0`; it does not call the legacy SOAP `login()` operation. Existing `login()` consumers remain supported.
