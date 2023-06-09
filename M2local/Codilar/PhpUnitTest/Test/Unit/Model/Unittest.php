<?php

namespace Codilar\PhpUnitTest\Test\Unit\Model;

class Unittest extends \PHPUnit\Framework\TestCase
{
    public function setUp() : void
    {
        $this->_objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $this->_calculator = $this->_objectManager->getObject("Codilar\PhpUnitTest\Model\Unittest");
    }

    /**
     * this function will perform the addition of two numbers
     * @return void
     */
    public function testcaseAddition(): void
    {
        $this->_actulResult = $this->_calculator->additiondata(7, 7); // call additiondata method from model file
        $this->_desiredResult = 14; // actual result compare set
        $this->assertEquals($this->_desiredResult, $this->_actulResult); /* check test case match or not if true the give ok message otherwise give error */
    }
}
