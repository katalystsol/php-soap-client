<?php

namespace Katalystsol\PhpSoapClient;

use Katalystsol\PhpSoapClient\Exceptions\SoapMethodMissingParameter;
use SoapClient;

abstract class ConsumerMethod
{
    /** @var SoapClient  */
    protected $client;

    /** @var array Any errors from the request */
    protected $errors = [];

    /** @var array Soap Headers to send with request */
    protected $headers = [];

    /** @var array Optional parameters for the given child class */
    protected $optionalParameters = [];

    /** @var array Required parameters for the given child class */
    protected $requiredParameters = [];

    /** @var boolean */
    protected $useRequestObject = false;

    /**
     * ConsumerMethod constructor.
     *
     * @param SoapClient $client
     */
    public function __construct($client)
    {
        $this->client = $client;
        $this->setSoapHeaders();
    }

    /**
     * Execute the SOAP request
     *
     * @param array $parameters The parameters to pass with the request
     *
     * @return mixed
     */
    public function execute($parameters)
    {
        $methodName = $this->getClassMethod();
        $resultName = $this->getClassMethodResult();

        if (count($parameters) && isset($parameters[0])) {
            $parameters = $parameters[0];
        }

        $requestParameters = $this->getRequestParameters($parameters);

        if (!$requestParameters) {
            return false;
        }

        if ($this->useRequestObject) {
            $requestParameters = $this->createRequestObject($requestParameters);
        }

        if (count($this->headers)) {
            $this->client->__setSoapHeaders($this->headers);
        }

        $response = $this->client->$methodName($requestParameters);

        if (!$response) {
            $responseMessage = is_null($response) ?
                "NULL Response" :
                $response === false ?
                    "FALSE Response" : $response." Response";
            $this->errors[] = "[RESPONSE] ".$responseMessage;
            return false;
        }

        return json_decode(json_encode($response->$resultName, true));
    }

    /**
     * Get any errors that were thrown
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Get the request parameters to send via the SOAP method
     *
     * @param array $parameters
     *
     * @return mixed|array|bool
     */
    protected function getRequestParameters(array $parameters = [])
    {
        try {
            $this->hasRequiredParameters($parameters);
        } catch (SoapMethodMissingParameter $e) {
            return false;
        }

        $parameterList = array_merge($this->requiredParameters, $this->optionalParameters);

        $defaultParameters = $this->getDefaultParameters();
        $requestParameters = [];

        // do checks and set defaults... will not return any parameters not in $parameterList
        foreach ($parameterList as $param) {
            if (isset($parameters[$param])) {
                $requestParameters[$param] = $parameters[$param];
            } elseif (array_key_exists($param, $defaultParameters)) {
                $requestParameters[$param] = $defaultParameters[$param];
            }
        }

        return $requestParameters;
    }

    /**
     * Does the parameter list include the required parameters?
     *
     * @param array $parameters
     *
     * @return bool
     * @throws SoapMethodMissingParameter
     */
    protected function hasRequiredParameters($parameters)
    {
        $defaultParameters = $this->getDefaultParameters();

        foreach ($this->requiredParameters as $requiredParameter) {
            if (!isset($parameters[$requiredParameter]) && !$defaultParameters[$requiredParameter]) {
                $errorMessage = '[MISSING_PARAMETER] '.$requiredParameter;
                $this->errors[] = $errorMessage;
                throw new SoapMethodMissingParameter($errorMessage);
            }
        }

        return true;
    }

    /**
     * Default parameters that vast majority of methods require
     *
     * Override this method if you have default parameters to send with every request
     *
     * @return array
     */
    protected function getDefaultParameters()
    {
        return [];
    }

    /**
     * Get the child class name
     *
     * It is used for the method to be called
     *
     * @return string
     */
    protected function getClassMethod()
    {
        $class = get_class($this);
        $baseName = basename(str_replace('\\', '/', $class));

        return lcfirst($baseName);
    }

    /**
     * Sets the default result to expect
     *
     * May need to be overridden in a few classes
     *
     * @return string
     */
    protected function getClassMethodResult()
    {
        return $this->getClassMethod().'Result';
    }

    /**
     * Create the request object
     *
     * This will need to be overridden in the method Class when a complexType / object is required to be sent
     *
     * @param array $parameters
     *
     * @return mixed
     */
    protected function createRequestObject(array $parameters)
    {
        return $parameters;
    }

    /**
     * Set the SOAP headers
     *
     * This class should be overridden when headers are required
     */
    protected function setSoapHeaders()
    {
        $this->headers = [];
    }
}
