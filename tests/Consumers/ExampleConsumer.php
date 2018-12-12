<?php

namespace Katalystsol\PhpSoapClient\Test\Consumers;


use Katalystsol\PhpSoapClient\Consumer;
use SoapClient;

class ExampleConsumer extends Consumer
{
    /**
     * Override the parent namespace
     *
     * @return string
     */
    public function getClassNameSpace()
    {
        return __NAMESPACE__;
    }
}
