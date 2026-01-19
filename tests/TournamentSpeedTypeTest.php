<?php

use PHPoker\Poker\Enum\TournamentSpeedType;

test('TournamentSpeedType has correct string values', function () {
    expect(TournamentSpeedType::NORMAL->value)->toBe('Normal')
        ->and(TournamentSpeedType::SEMI_TURBO->value)->toBe('Semi-Turbo')
        ->and(TournamentSpeedType::TURBO->value)->toBe('Turbo')
        ->and(TournamentSpeedType::SUPER_TURBO->value)->toBe('Super-Turbo')
        ->and(TournamentSpeedType::HYPER_TURBO->value)->toBe('Hyper-Turbo')
        ->and(TournamentSpeedType::ULTRA_TURBO->value)->toBe('Ultra-Turbo');
});

test('TournamentSpeedType enum cases can be accessed', function () {
    expect(TournamentSpeedType::cases())->toHaveCount(6)
        ->and(TournamentSpeedType::cases())->toContain(
            TournamentSpeedType::NORMAL,
            TournamentSpeedType::SEMI_TURBO,
            TournamentSpeedType::TURBO,
            TournamentSpeedType::SUPER_TURBO,
            TournamentSpeedType::HYPER_TURBO,
            TournamentSpeedType::ULTRA_TURBO
        );
});

test('TournamentSpeedType enum values can be accessed through invoke syntax', function () {
    expect(TournamentSpeedType::NORMAL())->toBe('Normal')
        ->and(TournamentSpeedType::SEMI_TURBO())->toBe('Semi-Turbo')
        ->and(TournamentSpeedType::TURBO())->toBe('Turbo')
        ->and(TournamentSpeedType::SUPER_TURBO())->toBe('Super-Turbo')
        ->and(TournamentSpeedType::HYPER_TURBO())->toBe('Hyper-Turbo')
        ->and(TournamentSpeedType::ULTRA_TURBO())->toBe('Ultra-Turbo');
});

test('TournamentSpeedType returns enum names correctly', function () {
    expect(TournamentSpeedType::names())->toContain(
        'NORMAL',
        'SEMI_TURBO',
        'TURBO',
        'SUPER_TURBO',
        'HYPER_TURBO',
        'ULTRA_TURBO'
    );
});

test('TournamentSpeedType returns enum values correctly', function () {
    expect(TournamentSpeedType::values())->toContain(
        'Normal',
        'Semi-Turbo',
        'Turbo',
        'Super-Turbo',
        'Hyper-Turbo',
        'Ultra-Turbo'
    );
});

test('TournamentSpeedType returns enum name/value pairs correctly', function () {
    $options = TournamentSpeedType::options();
    expect($options)->toBeArray()
        ->and($options)->toHaveCount(6)
        ->and($options['NORMAL'])->toBe('Normal')
        ->and($options['SEMI_TURBO'])->toBe('Semi-Turbo')
        ->and($options['TURBO'])->toBe('Turbo')
        ->and($options['SUPER_TURBO'])->toBe('Super-Turbo')
        ->and($options['HYPER_TURBO'])->toBe('Hyper-Turbo')
        ->and($options['ULTRA_TURBO'])->toBe('Ultra-Turbo');
});
