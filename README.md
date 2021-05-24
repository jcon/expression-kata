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
6+(10/2) => 11 (NOTE: this is a much bigger change)


For each part of the Kata, you should write a failing test first, then make the tests pass.

1. `evaluate` should return 0 for empty strings.
2. `evaluate` should return an integer, if that is all that is supplied.
3. `evaluate` should support addition (5 + 2 => 7) **See note about tokenizing if you get stuck**.
4. `evaluate` should support subtraction (15 - 2 => 13).
5. `evaluate` should throw an InvalidArgumentException for bad input (e.g. 5 ++ 10).
6. `evaluate` should support multiplication (15 * 3 => 45).
7. `evaluate` should support division (20 / 4 => 5).
8. `evaluate` HARDER: should support parenthetical evaluation (inner most parenthesis is evaluated first) (8+(15/3) => 13) **See note below about evaluating this expression.**


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

## Parenthetical Evaluation

So far we've been focused on simple expressions. If we implemented our evaluator in the simplest possible form, we are likely missing support for operator prescedence and parenthetical evaluation. Of the two features we might implement, operator prescedence is a bit trickier to implement in a short period of time. Parenthetical evaluation is a little simpler to implement and makes for a good stretch goal for implementing an evaluator.

Before we discuss one approach, let's reframe what our evaluator is actually doing. Right now, it's parsing programs that fit the following grammar:

```
expression := term (op term)*
op := '+' | '-' | '*' | '/'
term := integerConstant
```

If we add parenthesis, our grammar would be modified slightly:

```
expression := term (op term)*
op := '+' | '-' | '*' | '/'
term := integerConstant | '(' expression ')'
```

There are a few ways to handle this. One way is using [Dijkstra's Two Stack Algorithm](http://www.wisenheimerbrainstorm.com/archive/algorithms/dijkstra-s-two-stack-algorithm). Another way our evaluator can support this grammar would be to convert the input into an evaluation tree that maps to expression form. We could then "evaluate" the tree, but evaluating each branch. We're finished once we have nothing else to evaluate. For instance, to evaluate `8 + (16 / (3 - 1))`:


<pre>
// First we, convert it to a tree form:
8+(16/(3-1)) =>          +
                      8    /
                        16    -  
                            3    1

// Then we recursively evaluate the left and right branches of the operation. Here's step 1:
8+(16/(3-1)) =>          +
                      8    /
                        16    2  


// Step 2:
8+(16/(3-1)) =>          +
                      8     8

// Step 3:
8+(16/(3-1)) =>          16
</pre>

Here's a sample data structure we could build to support this:
```php

class Term {
    private $num;
    private $expr;
    private $is_integer;


    private function __construct(/* int|null */ $num, /* Expression|null */ $expr) {
        $this->num = $num;
        $this->expr = $expr;
        $this->is_integer = $num != null;
    }

    public static function fromInt(int $num) {
        return new self($num, null);
    }

    public static function fromExpression(Expression $expr) {
        return new self(null, $expr);
    }

    public function evaluate() {
        // implement
    }
}

class Expression {
    private $left;
    private $op; // We could alternately use an enum here
    private $right;

    public function __construct(/* Term */ $left, /* string|null */ $op = null, /* Term|null */ $right) {
        $this->left = $left;
        $this->op = $op;
        $this->right = $right;
    }

    public function evaluate() {
        // implement
    }
}
```

The previous example of `8+(16/(3-1))` would generate the following Expression:

```php
        $e = new Expression(Term::fromInt(8), '+', 
                Term::fromExpression(new Expression(Term::fromInt(16), '/',
                    Term::fromExpression(new Expression(Term::fromInt(3), '-', Term::fromInt(1))))));
        $e->evaluate() // 16
```
               