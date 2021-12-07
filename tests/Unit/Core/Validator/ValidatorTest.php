<?php

namespace Paygreen\Tests\Unit\Core\Component;

use Exception;
use Paygreen\Sdk\Core\Validator\Validator;
use PHPUnit\Framework\TestCase;

final class ValidatorTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testCanOnlyValidateModel()
    {
        $this->expectException(Exception::class);
        Validator::validateModel('string');
    }
}