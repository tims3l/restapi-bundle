<?php
declare(strict_types=1);

namespace Tims3l\RestApi\Tests\Unit\Service;

use Tims3l\RestApi\Service\StrUtils;
use PHPUnit\Framework\TestCase;

final class StrUtilsTest extends TestCase {

    /**
     * @dataProvider getClassBaseNameProvider
     */
    public function testGetClassBasename(string|object $className, string $expectedBaseName): void
    {
        $this->assertIsString(StrUtils::getClassBasename($className));
        $this->assertNotEmpty(StrUtils::getClassBasename($className));
        $this->assertSame($expectedBaseName, StrUtils::getClassBasename($className));
    }

    /**
     * @return string[][]
     */
    protected function getClassBaseNameProvider(): array
    {
        return [
            'simple test, already a basename' => [
                'fqn' => 'Class',
                'basename' => 'Class',
            ],
            'simple test with leading slashes' => [
                'fqn' => '\\Class',
                'basename' => 'Class',
            ],
            'more namespace' => [
                'fqn' => 'App\\Class',
                'basename' => 'Class',
            ],
            'same with leading slashes' => [
                'fqn' => '\\App\\Class',
                'basename' => 'Class',
            ],
            'even more namespace' => [
                'fqn' => 'Vendor\\Library\\Functionality\\Class',
                'basename' => 'Class',
            ],
            'testing with object' => [
                'fqn' => new \stdClass(),
                'basename' => 'stdClass'
            ],
            'testing with other object' => [
                'fqn' => new StrUtils(),
                'basename' => 'StrUtils'
            ],
            'testing with object and fully qualified name' => [
                'fqn' => new \Tims3l\RestApi\Service\StrUtils(),
                'basename' => 'StrUtils'
            ],
        ];
    }
}
