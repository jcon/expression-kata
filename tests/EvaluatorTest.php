<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class EvaluatorTest extends TestCase
{   
    /**
     * @dataProvider validTokensProvider
     */
    public function testValidTokenizerInput($expr, $expected) {
        $this->assertEquals(
            $expected,
            Evaluator::tokenize($expr)
        );
    }

    public function validTokensProvider() {
        return [
            /** [input, expected] */
            ['', []],
            ['42', ['42']],
            ['8 + 2', ['8', '+', '2']]
        ];
    }

    /**
     * @dataProvider validExpressionProvider
     */
    public function testValidExpressions($expr, $expected) {
        $this->assertEquals(
            $expected,
            Evaluator::evaluate($expr)
        );
    }

    public function validExpressionProvider() {
        return [
            /** [input, expected] */
            ['', '0'],
            ['42', '42'],
            ['8 + 2', '10'],
            ['8 - 2', '6'],
            ['8 - 2 + 5', '11'],
            ['15 * 3', '45'],
            ['15 * 3 * 3', '135'],
            ['100 / 3', '33']
        ];
    }

    /**
     * @dataProvider invalidExpressionProvider
     */
    public function testInvalidExpressions($expr, $expected) {
        $this->expectException($expected);
        Evaluator::evaluate($expr);
    }

    public function invalidExpressionProvider() {
        return [
            /** [input, expected] */
            ['+ 8 - 2', InvalidArgumentException::class],
            ['8 -- 2', InvalidArgumentException::class],
            ['8 8 - 2', InvalidArgumentException::class],
        ];
    }
}

?>
