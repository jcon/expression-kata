# TDD Kata - Evaluating Expression

## 🚧 Install Dependencies

```sh
./bootstrap.sh
```

## ✅  Run Tests 

```sh
sh> ./test.sh
```

## 👀 Run Tests (in watch mode)

```sh
sh> ./watch.sh
7993:tdd-kata-1 jconnell$ ./watch.sh 
PHPUnit 9.5.4 by Sebastian Bergmann and contributors.

.                                                                   1 / 1 (100%)

Time: 00:00.005, Memory: 4.00 MB
```

## 🥋 The Kata

You are going to write a simple expression evaluator using TDD. When we're done, it should support simple arithmetic (without operator prescedence).

When we're done, we should be able to support:
1+1 => 2
2*5 => 10
10 / 2 => 5
10-8 => 2
6+10/2 => 8 (note that precedence isn't observed here)
6+(10/2) => 11


For each part of the Kata, you should write a failing test first, then make the tests pass.

1. `evaluate` should return 0 for empty strings.
2. `evaluate` should return an integer, if that is all that is supplied.
3. `evaluate` should support addition (5 + 2 => 7) **See note about tokenizing if you get stuck**.
4. `evaluate` should support subtraction (15 - 2 => 13).
5. `evaluate` should throw an InvalidArgumentException for bad input (e.g. 5 ++ 10).
6. `evaluate` should support multiplication (15 * 3 => 45).
7. `evaluate` should support division (20 / 4 => 5).
8. `evaluate` HARDER: should support parenthetical evaluation (inner most parenthesis is evaluated first) (8+(15/3) => 13)


### Simple Tokenizing

In the previous stages, we didn't have to break the string into parts. In order to
do real evaluation though, we'll need to convert the string into a series of tokens 
and react to them.

<details>
    <summary>Expand to see a simple tokenizer for our expressions</summary>
    <pre><code>
    /**
     * Tokenize the following expression into an array of tokens. 
     * Valid tokens are positive integer, and '+', '-', '*', '/'
     */
    public static function tokenize(string $expr) {
        $tokens = preg_split('/([*\/+-])\s*|([\d]+)\s*/',
            $expr, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        return $tokens;
    }
    </code></pre>
</details>
