<?php declare(strict_types=1);

final class Evaluator
{
    public static function evaluate(string $expr) {
        if ($expr == '') {
                return '0';
        }

        $total = 0;
        $terms = Evaluator::tokenize($expr);
        $op = '+'; // Default to '+' for single term expressions.
        $sp = 0; // treat $terms as a stack, where $terms[0] is the top of the stack.
        while ($sp < count($terms)) {
            if (!is_numeric($terms[$sp])) {
                throw new InvalidArgumentException("'$expr' is not valid");
            }
            $left = (int) $terms[$sp++];
            switch ($op) {
                case '+':
                    $total += $left; break;
                case '-':
                    $total -= $left; break;
                case '*':
                    $total *= $left; break;
            }

            if ($sp == count($terms)) {
                break;
            }

            if (is_numeric($terms[$sp])) {
                throw new InvalidArgumentException("'$expr' is not valid");
            }

            $op = $terms[$sp++];
        }
        return $total;
    }

    public static function tokenize(string $expr) {
        if ($expr == '') {
            return [];
        }
        $tokens = preg_split('/([*\/+-])\s*|([\d]+)\s*/',
            $expr, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        return $tokens;
    }
}

?>