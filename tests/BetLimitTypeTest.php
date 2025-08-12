<?php

use PHPoker\Poker\Enum\BetLimitType;

test('BetLimitType has correct string values', function () {
    expect(BetLimitType::NO_LIMIT->value)->toBe('NL')
        ->and(BetLimitType::POT_LIMIT->value)->toBe('PL')
        ->and(BetLimitType::FIXED_LIMIT->value)->toBe('FL');
});

test('BetLimitType fromText parses valid inputs correctly', function (string $input, BetLimitType $expected) {
    expect(BetLimitType::fromText($input))->toBe($expected);
})->with([
    'no limit lowercase' => ['nolimit', BetLimitType::NO_LIMIT],
    'no limit uppercase' => ['NOLIMIT', BetLimitType::NO_LIMIT],
    'no limit with spaces' => ['no limit', BetLimitType::NO_LIMIT],
    'no limit with dashes' => ['no-limit', BetLimitType::NO_LIMIT],
    'no limit with underscores' => ['no_limit', BetLimitType::NO_LIMIT],
    'no limit with apostrophes' => ["no'limit", BetLimitType::NO_LIMIT],
    'nl abbreviation' => ['nl', BetLimitType::NO_LIMIT],
    'NL uppercase' => ['NL', BetLimitType::NO_LIMIT],

    'pot limit lowercase' => ['potlimit', BetLimitType::POT_LIMIT],
    'pot limit uppercase' => ['POTLIMIT', BetLimitType::POT_LIMIT],
    'pot limit with spaces' => ['pot limit', BetLimitType::POT_LIMIT],
    'pot limit with dashes' => ['pot-limit', BetLimitType::POT_LIMIT],
    'pot limit with underscores' => ['pot_limit', BetLimitType::POT_LIMIT],
    'pot only' => ['pot', BetLimitType::POT_LIMIT],
    'pl abbreviation' => ['pl', BetLimitType::POT_LIMIT],
    'PL uppercase' => ['PL', BetLimitType::POT_LIMIT],

    'fixed limit lowercase' => ['fixedlimit', BetLimitType::FIXED_LIMIT],
    'fixed limit uppercase' => ['FIXEDLIMIT', BetLimitType::FIXED_LIMIT],
    'fixed limit with spaces' => ['fixed limit', BetLimitType::FIXED_LIMIT],
    'fixed limit with dashes' => ['fixed-limit', BetLimitType::FIXED_LIMIT],
    'fixed limit with underscores' => ['fixed_limit', BetLimitType::FIXED_LIMIT],
    'fixed only' => ['fixed', BetLimitType::FIXED_LIMIT],
    'fl abbreviation' => ['fl', BetLimitType::FIXED_LIMIT],
    'FL uppercase' => ['FL', BetLimitType::FIXED_LIMIT],
]);

test('BetLimitType fromText returns null for null input', function () {
    expect(BetLimitType::fromText(null))->toBeNull();
});

test('BetLimitType fromText returns null for empty string', function () {
    expect(BetLimitType::fromText(''))->toBeNull();
});

test('BetLimitType fromText returns null for invalid input', function (string $input) {
    expect(BetLimitType::fromText($input))->toBeNull();
})->with([
    'random string' => ['random'],
    'number' => ['123'],
    'special chars' => ['!@#$'],
    'mixed invalid' => ['nolimitx'],
    'partial match' => ['no'],
    'misspelled' => ['nolimitt'],
]);

test('BetLimitType enum cases can be accessed', function () {
    expect(BetLimitType::cases())->toHaveCount(3)
        ->and(BetLimitType::cases())->toContain(
            BetLimitType::NO_LIMIT,
            BetLimitType::POT_LIMIT,
            BetLimitType::FIXED_LIMIT
        );
});
