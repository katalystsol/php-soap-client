<?php

namespace Katalystsol\PhpSoapClient;

use \SoapClient;

class SoapClientLogger
{
    /** @var SoapClient  */
    protected $client;

    protected $logPrefix = '[SOAP_CLIENT_LOGGER]';

    /**
     * SoapClientLogger constructor.
     *
     * @param SoapClient $client
     */
    public function __construct(SoapClient $client)
    {
        $this->client = $client;
    }

    public function __call($method, $parameters)
    {
        if (count($parameters) && isset($parameters[0])) {
            $parameters = $parameters[0];
        }

        try {
            $response = call_user_func([$this->client, $method], $parameters);
            $this->logSoapRequest($method);
            Log::info($this->logPrefix."[RESPONSE]", (array) $response);
        } catch (\SoapFault $e) {
            $this->logSoapRequest($method);
            Log::error($this->logPrefix."[SOAP_FAULT] Code [".$e->getCode()."] Message: ".$e->getMessage());
            return false;
        }

        return $response;
    }

    /**
     * Log the SOAP request
     *
     * Scrubs the password used if not in a local (e.g. development) environment
     *
     * @param string $method The called method
     */
    protected function logSoapRequest($method)
    {
        $lastRequest = $this->client->__getLastRequest();
        $env = env('APP_ENV', 'production');

        // do not log the password unless in a local environment for development
        if ($env != 'local') {
            $regex = '/<ns1:strPassword>(.*)<\/ns1:strPassword>/i';
            $replace = '<ns1:strPassword>********</ns1:strPassword>';
            $lastRequest = preg_replace($regex, $replace, $lastRequest);
        }

        Log::info($this->logPrefix."[REQUEST] {$method}. " . $lastRequest);
    }
}
