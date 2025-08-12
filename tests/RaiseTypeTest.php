<?php

use PHPoker\Poker\Enum\RaiseType;

test('RaiseType has correct string values', function () {
    expect(RaiseType::RFI->value)->toBe('Raise First In')
        ->and(RaiseType::ISO->value)->toBe('Isolation Raise')
        ->and(RaiseType::C_BET->value)->toBe('Continuation Bet')
        ->and(RaiseType::THREE_BET->value)->toBe('3-Bet')
        ->and(RaiseType::FOUR_BET->value)->toBe('4-Bet')
        ->and(RaiseType::FIVE_BET->value)->toBe('5-Bet')
        ->and(RaiseType::SIX_BET->value)->toBe('6-Bet')
        ->and(RaiseType::SEVEN_BET->value)->toBe('7-Bet')
        ->and(RaiseType::SHOVE->value)->toBe('All-In')
        ->and(RaiseType::CHECK_RAISE->value)->toBe('Check-Raise');
});

test('RaiseType fromText parses inputs correctly', function (string $input, RaiseType $expected) {
    expect(RaiseType::fromText($input))->toBe($expected);
})->with([
    'RFI uppercase' => ['RFI', RaiseType::RFI],
    'rfi lowercase' => ['rfi', RaiseType::RFI],

    'ISO uppercase' => ['ISO', RaiseType::ISO],
    'iso lowercase' => ['iso', RaiseType::ISO],

    'cbet variants' => ['CBET', RaiseType::C_BET],
    'c-bet with dash' => ['C-BET', RaiseType::C_BET],
    'c_bet with underscore' => ['C_BET', RaiseType::C_BET],
    'continuation bet' => ['CONTINUATION BET', RaiseType::C_BET],
    'continuationbet' => ['CONTINUATIONBET', RaiseType::C_BET],

    'three bet variants' => ['THREEBET', RaiseType::THREE_BET],
    '3bet' => ['3BET', RaiseType::THREE_BET],
    '3 bet with space' => ['3 BET', RaiseType::THREE_BET],
    'three bet with space' => ['THREE BET', RaiseType::THREE_BET],
    '3-bet with dash' => ['3-BET', RaiseType::THREE_BET],
    '3_bet with underscore' => ['3_BET', RaiseType::THREE_BET],

    'four bet variants' => ['FOURBET', RaiseType::FOUR_BET],
    '4bet' => ['4BET', RaiseType::FOUR_BET],
    '4 bet with space' => ['4 BET', RaiseType::FOUR_BET],
    'four bet with space' => ['FOUR BET', RaiseType::FOUR_BET],
    '4-bet with dash' => ['4-BET', RaiseType::FOUR_BET],
    '4_bet with underscore' => ['4_BET', RaiseType::FOUR_BET],

    'five bet variants' => ['FIVEBET', RaiseType::FIVE_BET],
    '5bet' => ['5BET', RaiseType::FIVE_BET],
    '5 bet with space' => ['5 BET', RaiseType::FIVE_BET],
    'five bet with space' => ['FIVE BET', RaiseType::FIVE_BET],
    '5-bet with dash' => ['5-BET', RaiseType::FIVE_BET],
    '5_bet with underscore' => ['5_BET', RaiseType::FIVE_BET],

    'six bet variants' => ['SIXBET', RaiseType::SIX_BET],
    '6bet' => ['6BET', RaiseType::SIX_BET],
    '6 bet with space' => ['6 BET', RaiseType::SIX_BET],
    'six bet with space' => ['SIX BET', RaiseType::SIX_BET],
    '6-bet with dash' => ['6-BET', RaiseType::SIX_BET],
    '6_bet with underscore' => ['6_BET', RaiseType::SIX_BET],

    'seven bet variants' => ['SEVENBET', RaiseType::SEVEN_BET],
    '7bet' => ['7BET', RaiseType::SEVEN_BET],
    '7 bet with space' => ['7 BET', RaiseType::SEVEN_BET],
    'seven bet with space' => ['SEVEN BET', RaiseType::SEVEN_BET],
    '7-bet with dash' => ['7-BET', RaiseType::SEVEN_BET],
    '7_bet with underscore' => ['7_BET', RaiseType::SEVEN_BET],

    'shove variants' => ['SHOVE', RaiseType::SHOVE],
    'allin' => ['ALLIN', RaiseType::SHOVE],
    'jam' => ['JAM', RaiseType::SHOVE],
    'all-in with dash' => ['ALL-IN', RaiseType::SHOVE],
    'all_in with underscore' => ['ALL_IN', RaiseType::SHOVE],

    'check raise variants' => ['CHECKRAISE', RaiseType::CHECK_RAISE],
    'check-raise with dash' => ['CHECK-RAISE', RaiseType::CHECK_RAISE],
    'check_raise with underscore' => ['CHECK_RAISE', RaiseType::CHECK_RAISE],
]);

test('RaiseType fromText handles lowercase inputs', function (string $input, RaiseType $expected) {
    expect(RaiseType::fromText(strtolower($input)))->toBe($expected);
})->with([
    'rfi lowercase' => ['RFI', RaiseType::RFI],
    'iso lowercase' => ['ISO', RaiseType::ISO],
    'threebet lowercase' => ['THREEBET', RaiseType::THREE_BET],
    'shove lowercase' => ['SHOVE', RaiseType::SHOVE],
    'checkraise lowercase' => ['CHECKRAISE', RaiseType::CHECK_RAISE],
]);

test('RaiseType fromText handles plural inputs with Str::singular', function (string $input, RaiseType $expected) {
    expect(RaiseType::fromText($input))->toBe($expected);
})->with([
    'rfis plural' => ['RFIS', RaiseType::RFI],
    'isos plural' => ['ISOS', RaiseType::ISO],
    'threebets plural' => ['THREEBETS', RaiseType::THREE_BET],
    'shoves plural' => ['SHOVES', RaiseType::SHOVE],
]);

test('RaiseType enum cases can be accessed', function () {
    expect(RaiseType::cases())->toHaveCount(10)
        ->and(RaiseType::cases())->toContain(
            RaiseType::RFI,
            RaiseType::ISO,
            RaiseType::C_BET,
            RaiseType::THREE_BET,
            RaiseType::FOUR_BET,
            RaiseType::FIVE_BET,
            RaiseType::SIX_BET,
            RaiseType::SEVEN_BET,
            RaiseType::SHOVE,
            RaiseType::CHECK_RAISE
        );
});

test('RaiseType enum values can be accessed through invoke syntax', function () {
    expect(RaiseType::RFI())->toBe('Raise First In')
        ->and(RaiseType::ISO())->toBe('Isolation Raise')
        ->and(RaiseType::C_BET())->toBe('Continuation Bet')
        ->and(RaiseType::THREE_BET())->toBe('3-Bet')
        ->and(RaiseType::FOUR_BET())->toBe('4-Bet')
        ->and(RaiseType::FIVE_BET())->toBe('5-Bet')
        ->and(RaiseType::SIX_BET())->toBe('6-Bet')
        ->and(RaiseType::SEVEN_BET())->toBe('7-Bet')
        ->and(RaiseType::SHOVE())->toBe('All-In')
        ->and(RaiseType::CHECK_RAISE())->toBe('Check-Raise');
});

test('RaiseType returns enum names correctly', function () {
    expect(RaiseType::names())->toContain(
        'RFI',
        'ISO',
        'C_BET',
        'THREE_BET',
        'FOUR_BET',
        'FIVE_BET',
        'SIX_BET',
        'SEVEN_BET',
        'SHOVE',
        'CHECK_RAISE'
    );
});

test('RaiseType returns enum values correctly', function () {
    expect(RaiseType::values())->toContain(
        'Raise First In',
        'Isolation Raise',
        'Continuation Bet',
        '3-Bet',
        '4-Bet',
        '5-Bet',
        '6-Bet',
        '7-Bet',
        'All-In',
        'Check-Raise'
    );
});

test('RaiseType fromText returns null for invalid input', function (string $input) {
    expect(RaiseType::fromText($input))->toBeNull();
})->with([
    'random string' => ['random'],
    'number' => ['123'],
    'special chars' => ['!@#$'],
    'partial match' => ['3'],
    'misspelled' => ['3bett'],
    'invalid action' => ['call'],
    'invalid action fold' => ['fold'],
]);

test('RaiseType returns enum name/value pairs correctly', function () {
    $options = RaiseType::options();
    expect($options)->toBeArray()
        ->and($options)->toHaveCount(10)
        ->and($options['RFI'])->toBe('Raise First In')
        ->and($options['ISO'])->toBe('Isolation Raise')
        ->and($options['C_BET'])->toBe('Continuation Bet')
        ->and($options['THREE_BET'])->toBe('3-Bet')
        ->and($options['FOUR_BET'])->toBe('4-Bet')
        ->and($options['FIVE_BET'])->toBe('5-Bet')
        ->and($options['SIX_BET'])->toBe('6-Bet')
        ->and($options['SEVEN_BET'])->toBe('7-Bet')
        ->and($options['SHOVE'])->toBe('All-In')
        ->and($options['CHECK_RAISE'])->toBe('Check-Raise');
});
