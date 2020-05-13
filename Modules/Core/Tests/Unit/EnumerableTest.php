<?php

declare(strict_types=1);

namespace Modules\Core\Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Enum\Enumerable;
use Modules\Core\Exceptions\EnumNotFoundException;

class EnumerableTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testIdAndNameGettersReturnCorrectData(): void
    {
        $enum = TestEnum::testCase();

        $this->assertEquals('test_id', $enum->id());
        $this->assertEquals('test_name', $enum->name());
    }

    public function testReturnDescriptionGetter(): void
    {
        $this->assertEquals('Test Case Description', TestEnum::testCaseWithDescription()->description());
        $this->assertEquals('', TestEnum::testCase()->description());
    }

    public function testSameTwoEnumCases(): void
    {
        $enumOne = TestEnum::testCase();
        $enumTwo = TestEnum::testCase();

        $this->assertSame($enumOne, $enumTwo);
    }

    public function testReturnOnlyFinalPublicStaticMethods(): void
    {
        $enum = TestEnum::enum();

        $this->assertArrayHasKey('test_id', $enum);
        $this->assertArrayHasKey('test_id_2', $enum);
        $this->assertArrayNotHasKey('random_id', $enum);

        $this->assertSame(TestEnum::testCase(), $enum['test_id']);
        $this->assertSame(TestEnum::testCaseTwo(), $enum['test_id_2']);
    }

    public function testCanCreateCasesFromId(): void
    {
        $this->assertSame(TestEnum::testCase(), TestEnum::from('test_id'));
        $this->assertSame(TestEnum::testCaseTwo(), TestEnum::from('test_id_2'));
    }

    public function testThrowExceptionOnTryingGetNonExistingEnum(): void
    {
        $this->expectException(EnumNotFoundException::class);
        $this->expectExceptionMessage('Unable to find enumerable with test_enum of type ' . TestEnum::class);

        TestEnum::from('test_enum');
    }

    public function testOptionsReturnOnlyFinalPublicStaticMethods(): void
    {
        $this->assertEquals(
            [
                'test_id' => 'test_name',
                'test_id_2' => 'test_name_2',
                'test_id_d' => 'Description Name',
            ],
            TestEnum::options()
        );
    }

    public function testJsonReturnOnlyPublicStaticMethods(): void
    {
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'test_id' => 'test_name',
                'test_id_2' => 'test_name_2',
                'test_id_d' => 'Description Name',
            ]),
            TestEnum::json()
        );
    }

    public function testEnumIdsReturnOnlyFinalMethodsIdsAsArray(): void
    {
        $this->assertEquals(
            [
                'test_id',
                'test_id_2',
                'test_id_d',
            ],
            TestEnum::enumIds()
        );
    }
}

class TestEnum extends Enumerable
{
    final public static function testCase(): TestEnum
    {
        return self::make('test_id', 'test_name');
    }

    final public static function testCaseTwo(): TestEnum
    {
        return self::make('test_id_2', 'test_name_2');
    }

    final public static function testCaseWithDescription(): TestEnum
    {
        return self::make('test_id_d', 'Description Name', 'Test Case Description');
    }

    public static function randomMethod(): TestEnum
    {
        return self::make('random_id', 'random_name');
    }
}
