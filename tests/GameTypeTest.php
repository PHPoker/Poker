<?php

use PHPoker\Poker\Enum\GameType;

test('GameType has correct string values', function () {
    expect(GameType::HOLDEM->value)->toBe('Holdem')
        ->and(GameType::OMAHA->value)->toBe('Omaha')
        ->and(GameType::OMAHA_HILO->value)->toBe('OmahaHiLo')
        ->and(GameType::STUD->value)->toBe('Stud')
        ->and(GameType::STUD_HILO->value)->toBe('StudHiLo')
        ->and(GameType::DRAW->value)->toBe('Draw');
});

test('GameType fromText parses holdem variants correctly', function (string $input, GameType $expected) {
    expect(GameType::fromText($input))->toBe($expected);
})->with([
    'holdem lowercase' => ['holdem', GameType::HOLDEM],
    'holdem uppercase' => ['HOLDEM', GameType::HOLDEM],
    'texas holdem' => ['texas holdem', GameType::HOLDEM],
    'texasholdem' => ['texasholdem', GameType::HOLDEM],
    'nlh abbreviation' => ['nlh', GameType::HOLDEM],
    'nlhe abbreviation' => ['nlhe', GameType::HOLDEM],
    'holdem with spaces' => ['hold em', GameType::HOLDEM],
    'holdem with dashes' => ['hold-em', GameType::HOLDEM],
    'holdem with apostrophes' => ["hold'em", GameType::HOLDEM],
]);

test('GameType fromText parses omaha variants correctly', function (string $input, GameType $expected) {
    expect(GameType::fromText($input))->toBe($expected);
})->with([
    'omaha lowercase' => ['omaha', GameType::OMAHA],
    'omaha uppercase' => ['OMAHA', GameType::OMAHA],
    'plo abbreviation' => ['plo', GameType::OMAHA],
    'PLO uppercase' => ['PLO', GameType::OMAHA],

    'omaha hilo' => ['omaha hilo', GameType::OMAHA_HILO],
    'omahahilo' => ['omahahilo', GameType::OMAHA_HILO],
    'omaha high low' => ['omaha high low', GameType::OMAHA_HILO],
    'omahahighlow' => ['omahahighlow', GameType::OMAHA_HILO],
    'omaha with dashes' => ['omaha-hilo', GameType::OMAHA_HILO],
]);

test('GameType fromText parses stud variants correctly', function (string $input, GameType $expected) {
    expect(GameType::fromText($input))->toBe($expected);
})->with([
    'stud lowercase' => ['stud', GameType::STUD],
    'stud uppercase' => ['STUD', GameType::STUD],
    '5 card stud' => ['5 card stud', GameType::STUD],
    '5cardstud' => ['5cardstud', GameType::STUD],
    'five card stud' => ['five card stud', GameType::STUD],
    'fivecardstud' => ['fivecardstud', GameType::STUD],
    '7 card stud' => ['7 card stud', GameType::STUD],
    '7cardstud' => ['7cardstud', GameType::STUD],
    'seven card stud' => ['seven card stud', GameType::STUD],
    'sevencardstud' => ['sevencardstud', GameType::STUD],

    'stud hilo' => ['stud hilo', GameType::STUD_HILO],
    'studhilo' => ['studhilo', GameType::STUD_HILO],
    'stud high low' => ['stud high low', GameType::STUD_HILO],
    'studhighlow' => ['studhighlow', GameType::STUD_HILO],
    'stud high lo' => ['stud high lo', GameType::STUD_HILO],
    'studhighlo' => ['studhighlo', GameType::STUD_HILO],
    'stud hi low' => ['stud hi low', GameType::STUD_HILO],
    'studhilow' => ['studhilow', GameType::STUD_HILO],
    '5 card stud hilo' => ['5 card stud hilo', GameType::STUD_HILO],
    '5cardstudhilo' => ['5cardstudhilo', GameType::STUD_HILO],
    '7 card stud hilo' => ['7 card stud hilo', GameType::STUD_HILO],
    '7cardstudhilo' => ['7cardstudhilo', GameType::STUD_HILO],
    'five card stud hilo' => ['five card stud hilo', GameType::STUD_HILO],
    'fivecardstudhilo' => ['fivecardstudhilo', GameType::STUD_HILO],
    'seven card stud high low' => ['seven card stud high low', GameType::STUD_HILO],
    'sevencardstudhighlow' => ['sevencardstudhighlow', GameType::STUD_HILO],
]);

test('GameType fromText parses draw variants correctly', function (string $input, GameType $expected) {
    expect(GameType::fromText($input))->toBe($expected);
})->with([
    'draw lowercase' => ['draw', GameType::DRAW],
    'draw uppercase' => ['DRAW', GameType::DRAW],
    '5 card draw' => ['5 card draw', GameType::DRAW],
    '5carddraw' => ['5carddraw', GameType::DRAW],
    'five card draw' => ['five card draw', GameType::DRAW],
    'fivecarddraw' => ['fivecarddraw', GameType::DRAW],
    '7 card draw' => ['7 card draw', GameType::DRAW],
    '7carddraw' => ['7carddraw', GameType::DRAW],
    'seven card draw' => ['seven card draw', GameType::DRAW],
    'sevencarddraw' => ['sevencarddraw', GameType::DRAW],
    '2-7 triple draw' => ['2-7 triple draw', GameType::DRAW],
    '27tripledraw' => ['27tripledraw', GameType::DRAW],
    '2-7 triple' => ['2-7 triple', GameType::DRAW],
    '27triple' => ['27triple', GameType::DRAW],
    'two seven triple' => ['two seven triple', GameType::DRAW],
    'twoseventriple' => ['twoseventriple', GameType::DRAW],
]);

test('GameType fromText returns null for null input', function () {
    expect(GameType::fromText(null))->toBeNull();
});

test('GameType fromText returns null for invalid input', function (string $input) {
    expect(GameType::fromText($input))->toBeNull();
})->with([
    'random string' => ['random'],
    'number' => ['123'],
    'special chars' => ['!@#$'],
    'poker only' => ['poker'],
    'blackjack' => ['blackjack'],
    'partial match' => ['hold'],
    'misspelled' => ['holdeem'],
]);

test('GameType enum cases can be accessed', function () {
    expect(GameType::cases())->toHaveCount(6)
        ->and(GameType::cases())->toContain(
            GameType::HOLDEM,
            GameType::OMAHA,
            GameType::OMAHA_HILO,
            GameType::STUD,
            GameType::STUD_HILO,
            GameType::DRAW
        );
});
