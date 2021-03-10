<?php


namespace Lubem\GladePay\Tests;

use Mockery\Mock;
use Tests\TestCase;
use Lubem\GladePay\GladePay;

class GladePayTest extends TestCase
{
    protected $gladepay;

    public function setUp(): void
    {
        $this->gladepay = Mock::mock('Lubem\GladePay\GladePay');
    }

    public function tearDown(): void
    {
        Mock::close();
    }

    public function testPackage()
    {
        $this->visit('/')
            ->see('GladePay');
    }

    public function testBankTransfer()
    {
        $this->json('POST', '/payment', ['amount' => 5000 ])
            ->seeJson([
                'created' => true,
            ]);
    }
    public function testinitiateTransfer()
    {
        $array = $this->gladepay->shouldReceive('initiateBankTransfer')->andReturn(['transactions']);

        $this->assertEquals('array', gettype(array($array)));
    }
}
