<?php

declare(strict_types=1);

namespace PHPoker\Poker\Math;

class Combinations
{
    /**
     * @param  array<int, mixed>  $elements
     */
    public function __construct(protected array $elements = [])
    {
        $this->elements = array_values($elements);
    }

    /**
     * @return array<int, mixed>
     */
    public function getCombinations(int $length, bool $allowRepetition = false): array
    {
        return iterator_to_array($this->calculateCombinations($length, $allowRepetition));
    }

    /**
     * @return array<int, mixed>
     */
    public function getPermutations(int $length, bool $allowRepetition = false): array
    {
        return iterator_to_array($this->calculatePermutations($length, $allowRepetition));
    }

    /**
     * @param  array<int, mixed>  $elements
     */
    protected function calculateCombinations(int $length, bool $allowRepetition = false, int $position = 0, array $elements = []): \Generator
    {
        $elementCount = count($this->elements);

        for ($i = $position; $i < $elementCount; $i++) {
            $elements[] = $this->elements[$i];

            if (count($elements) === $length) {
                yield $elements;
            } else {
                foreach ($this->calculateCombinations($length, $allowRepetition, ($allowRepetition === true ? $i : $i + 1), $elements) as $value) {
                    yield $value;
                }
            }

            array_pop($elements);
        }
    }

    /**
     * @param  array<int, mixed>  $elements
     * @param  array<int, mixed>  $keys
     */
    protected function calculatePermutations(int $length, bool $allowRepetition = false, array $elements = [], array $keys = []): \Generator
    {
        foreach ($this->elements as $key => $value) {
            if (($allowRepetition === false) && in_array($key, $keys, true)) {
                continue;
            }

            $keys[] = $key;
            $elements[] = $value;

            if (count($elements) === $length) {
                yield $elements;
            } else {
                foreach ($this->calculatePermutations($length, $allowRepetition, $elements, $keys) as $value2) {
                    yield $value2;
                }
            }

            array_pop($keys);
            array_pop($elements);
        }
    }
}
