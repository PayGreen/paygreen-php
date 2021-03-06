<?php

namespace Paygreen\Tests\Unit\Payment\V3;

use Paygreen\Sdk\Payment\V3\Utils;
use PHPUnit\Framework\TestCase;

final class UtilsTest extends TestCase
{
    public function testDecodeJWT()
    {
        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2NTIzNjkxMjUsImV4cCI6MTY1MjM2OTcyNSwicm9sZXMiOlsiU0NPUEVfU0VDUkVUX0tFWSIsIlNDT1BFX0NMSUVOVF9QQVlNRU5UX1JFQUQiLCJTQ09QRV9DTElFTlRfUEFZTUVOVF9XUklURSJdLCJ1c2VybmFtZSI6ImRlYzdlMzk5LTkzMzktNDk1Ny05NWM4LTg1ODZkNjBhNjM5NiIsInVzcl8iOiJkZWM3ZTM5OS05MzM5LTQ5NTctOTVjOC04NTg2ZDYwYTYzOTYiLCJoZHZjXyI6bnVsbCwib3RwIjp7ImluaXQiOmZhbHNlLCJ0eXBlIjoiZGVmYXVsdCJ9fQ.drNoJvVbdstmVyHbu87bjfeVn4OHTzGPB0rZkVDSly6MI4Oo1dOki-pphrDIQvqpF4K5gaEOxxqxMufWght1PcJr_-WDZyHcRt43SdySXI_CW2jwASOVqPrikQ6x_QG5JlWhbeYDP1cNIb7hbVMnvFrOhTkldRUHX3MfdPgLZYUSoE3zdUc0cMLNCrrgM6wjiEtkmxw3VgDllW02BQrcQG_gxP4yPW6vMQSgLpZNo3ioRVezwCZ6tHAS4Nc9O2YRW1AunZEBA50vtkFGDVMxJ6ph6Tx4AbrD_Tdih1SRTTFfBpE4_wT6fpcwM4VA2ZfVoHtJjQkdMMK-t4wnXTV46zRlmuXoxAzhFi2nuxJnreIPBcJoYJFa0Df2Pi6j8tfeVXMd-lHjC7z8MgG2m-h0-5CEdEwOYj5ZdgalEpO0-7wB2AIOW_sYSSuyzkPEuMwXs3vu-nkPoc_YRZlKM8nv-_fuQpnJO7j5F8oz0XM6jBAlD85nDfQhuNwiosrkOFeNQ617hdsYZmO7jHKzjcX2zlE2bXX4ArPdBwbMSMGsNMtEk5t7tvGk538JZAcHfYAz10FDQKyz4NJeTg4fpcUDeI9bJfPrntFLvxPK7SuivlKGcWZ1e7WD1MmFiu_K71ZWPwIQOi8tNeEiWo3_lj4FZRKVsbRgvoAotBULdbyjXl0";

        $data = Utils::decodeJWT($token);

        $this->assertEquals('1652369725', $data->exp);
    }
}
