<?php

require dirname(__DIR__) . '/src/Justia/SalesforcePhpSdk/SforceBaseClient.php';

class OAuthSessionTestSoapClient
{
    public $location;

    public function __setLocation($location)
    {
        $this->location = $location;
    }
}

class OAuthSessionTestClient extends \Justia\SalesforcePhpSdk\SforceBaseClient
{
    public function useSoapClient($client)
    {
        $this->sforce = $client;
        $this->namespace = 'urn:partner.soap.sforce.com';
    }

    public function sessionIdForTest()
    {
        return $this->sessionId;
    }
}

function oauthSessionAssertSame($expected, $actual, $message)
{
    if ($expected !== $actual) {
        fwrite(STDERR, $message . PHP_EOL);
        exit(1);
    }
}

$soapClient = new OAuthSessionTestSoapClient();
$client = new OAuthSessionTestClient();
$client->useSoapClient($soapClient);

$endpoint = $client->setOAuthSession('access-token', 'https://justia.my.salesforce.com/', '67.0');

oauthSessionAssertSame('https://justia.my.salesforce.com/services/Soap/u/67.0', $endpoint, 'OAuth endpoint was not derived correctly.');
oauthSessionAssertSame($endpoint, $soapClient->location, 'SOAP client location was not updated.');
oauthSessionAssertSame('access-token', $client->sessionIdForTest(), 'OAuth token was not set as the session id.');

echo "OAuth session test passed.\n";
