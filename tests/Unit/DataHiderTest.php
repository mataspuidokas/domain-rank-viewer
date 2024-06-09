<?php

declare(strict_types = 1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Src\Helpers\DataHider;

class DataHiderTest extends TestCase
{
    /** @test */
    public function hide(): void
    {
        define( 'ABSPATH', sys_get_temp_dir());
        $data = 'sensitiveData123';

        $expectedResult = '****a123';
        $dataHider = new DataHider();
        $result = $dataHider::hide($data);

        $this->assertEquals($expectedResult, $result);
    }
}