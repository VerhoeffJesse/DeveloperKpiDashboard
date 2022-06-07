<?php

namespace Tests\Models;

use App\Models\WhereConditionModel;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Models\WhereConditionModel
 */
class WhereConditionModelTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::formatConditionAsString
     * @covers ::__toString
     * @dataProvider whereConditionDataProvider
     */
    public function testItCanBeConvertedToAValidWhereConditionString(
        string $fieldName,
        string $operator,
        mixed $clauseValue,
        string $expected
    ): void {
        $this->assertSame(
            $expected,
            (string) new WhereConditionModel($fieldName, $operator, $clauseValue)
        );
    }

    public function whereConditionDataProvider(): array
    {
        $companyName = 'Test company';
        $company = new Company($companyName);

        return [
            'string' => ['name', '=', 'Test', 'name=\'Test\''],
            'int' => ['age', '=', 1, 'age=1'],
            'float' => ['salary', '=', 100.5, 'salary=100.5'],
            'bool' => ['is_available', '=', true, 'is_available=true'],
            'object' => ['company_name', '=', $company, 'company_name=\''.$companyName.'\''],
        ];
    }

    /**
     * @covers ::__construct
     */
    public function testItThrowsAnExceptionWhenObjectIsNotStringable(): void
    {
        $object = new \stdClass();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Classes must be stringable when providing them as a where clause value');

        new WhereConditionModel('object', '=', $object);
    }
}

/**
 * Used to test the object to string functionality
 */
class Company
{
    public function __construct(
        protected string $companyName
    ) {
    }

    public function __toString(): string
    {
        return $this->companyName;
    }
}
