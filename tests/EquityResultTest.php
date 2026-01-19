<?php

use PHPoker\Poker\Collections\CardCollection;
use PHPoker\Poker\Equity\EquityCalculation;
use PHPoker\Poker\Equity\EquityResult;

test('EquityCalculation exposes array and JSON data', function () {
    $calculation = new EquityCalculation('Ah Ad', 12.5, 25, 3, 100);

    expect($calculation->toArray())->toBe([
        'hand' => 'Ah Ad',
        'equity' => 12.5,
        'wins' => 25,
        'ties' => 3,
        'iterations' => 100,
    ]);

    expect($calculation->jsonSerialize())->toBe([
        'hand' => 'Ah Ad',
        'equity' => 12.5,
        'wins' => 25,
        'ties' => 3,
        'iterations' => 100,
    ]);
});

test('EquityResult exposes equity calculations and player count', function () {
    $equities = [
        new EquityCalculation('Ah Ad', 62.5, 50, 0, 100),
        new EquityCalculation('Kh Kd', 37.5, 30, 10, 100),
    ];

    $board = CardCollection::fromText('As Kc Qh');
    $dead = CardCollection::fromText('2d 3d');
    $result = new EquityResult($equities, 100, $board, $dead);

    expect($result->playerCount())->toBe(2)
        ->and($result->equities)->toBe($equities)
        ->and($result->iterations)->toBe(100)
        ->and($result->board)->toBe($board)
        ->and($result->deadCards)->toBe($dead);
});
