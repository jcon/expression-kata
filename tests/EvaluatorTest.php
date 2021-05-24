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
}

?>
