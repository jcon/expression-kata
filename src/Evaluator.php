<?php declare(strict_types=1);

final class Evaluator
{
    public static function evaluate(string $expr) {
        if ($expr == '') {
                return '0';
        }
        $total = 0;
        $terms = Evaluator::tokenize($expr);
        foreach ($terms as $term) {
                $total += (int) $term;
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