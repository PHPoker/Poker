<?php

use PHPoker\Poker\Enum\TournamentType;

test('TournamentType has correct string values', function () {
    expect(TournamentType::MULTI_TABLE_TOURNAMENT->value)->toBe('MTT')
        ->and(TournamentType::SINGLE_TABLE_TOURNAMENT->value)->toBe('STT');
});

test('TournamentType enum cases can be accessed', function () {
    expect(TournamentType::cases())->toHaveCount(2)
        ->and(TournamentType::cases())->toContain(
            TournamentType::MULTI_TABLE_TOURNAMENT,
            TournamentType::SINGLE_TABLE_TOURNAMENT
        );
});

test('TournamentType enum values can be accessed through invoke syntax', function () {
    expect(TournamentType::MULTI_TABLE_TOURNAMENT())->toBe('MTT')
        ->and(TournamentType::SINGLE_TABLE_TOURNAMENT())->toBe('STT');
});

test('TournamentType returns enum names correctly', function () {
    expect(TournamentType::names())->toContain(
        'MULTI_TABLE_TOURNAMENT',
        'SINGLE_TABLE_TOURNAMENT'
    );
});

test('TournamentType returns enum values correctly', function () {
    expect(TournamentType::values())->toContain(
        'MTT',
        'STT'
    );
});

test('TournamentType returns enum name/value pairs correctly', function () {
    $options = TournamentType::options();
    expect($options)->toBeArray()
        ->and($options)->toHaveCount(2)
        ->and($options['MULTI_TABLE_TOURNAMENT'])->toBe('MTT')
        ->and($options['SINGLE_TABLE_TOURNAMENT'])->toBe('STT');
});
