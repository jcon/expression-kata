<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class EvaluatorTest extends TestCase
{   
    public function testEmptyStringReturnsZero(): void
    {           
        $this->assertEquals(
            "0", 
            Evaluator::evaluate('')
        );
    }           
        
    public function testPlainIntReturnsThatInt(): void
    {
        $this->assertEquals(
            "42",
            Evaluator::evaluate('42')
        );
    }

    public function testSimpleAdditionReturnsResult(): void
    {
        $this->assertEquals(
            "10",
            Evaluator::evaluate('8 + 2')
        );
    }

    public function testTokenizeEmptyStringReturnsEmptyArray(): void
    {           
        $this->assertEquals(
            [], 
            Evaluator::tokenize('')
        );
    }   

    public function testTokenizeSingleIntReturnsInt(): void
    {           
        $this->assertEquals(
            ['18'], 
            Evaluator::tokenize('18')
        );
    }

    public function testTokenizeExpressionReturnsExpressionTokens(): void
    {           
        $this->assertEquals(
            ['18', '+', '5'], 
            Evaluator::tokenize('18+5')
        );
    }   

}

?>
