<?php

use PHPoker\Poker\Enum\TournamentProperties;

test('TournamentProperties has correct string values', function () {
    expect(TournamentProperties::SNG->value)->toBe('SNG')
        ->and(TournamentProperties::DON->value)->toBe('DON')
        ->and(TournamentProperties::BOUNTY->value)->toBe('Bounty')
        ->and(TournamentProperties::SHOOTOUT->value)->toBe('Shootout')
        ->and(TournamentProperties::REBUY->value)->toBe('Rebuy')
        ->and(TournamentProperties::MATRIX->value)->toBe('Matrix')
        ->and(TournamentProperties::PUSH_OR_FOLD->value)->toBe('Push_Or_Fold')
        ->and(TournamentProperties::SATELLITE->value)->toBe('Satellite')
        ->and(TournamentProperties::STEPS->value)->toBe('Steps')
        ->and(TournamentProperties::DEEP->value)->toBe('Deep')
        ->and(TournamentProperties::MULTI_ENTRY->value)->toBe('Multi-Entry')
        ->and(TournamentProperties::FIFTY50->value)->toBe('Fifty50')
        ->and(TournamentProperties::FLIPOUT->value)->toBe('Flipout')
        ->and(TournamentProperties::TRIPLEUP->value)->toBe('TripleUp')
        ->and(TournamentProperties::LOTTERY->value)->toBe('Lottery')
        ->and(TournamentProperties::RE_ENTRY->value)->toBe('Re-Entry')
        ->and(TournamentProperties::POWER_UP->value)->toBe('Power_Up')
        ->and(TournamentProperties::PROGRESSIVE_BOUNTY->value)->toBe('Progressive-Bounty');
});

test('TournamentProperties enum cases can be accessed', function () {
    expect(TournamentProperties::cases())->toHaveCount(18)
        ->and(TournamentProperties::cases())->toContain(
            TournamentProperties::SNG,
            TournamentProperties::DON,
            TournamentProperties::BOUNTY,
            TournamentProperties::SHOOTOUT,
            TournamentProperties::REBUY,
            TournamentProperties::MATRIX,
            TournamentProperties::PUSH_OR_FOLD,
            TournamentProperties::SATELLITE,
            TournamentProperties::STEPS,
            TournamentProperties::DEEP,
            TournamentProperties::MULTI_ENTRY,
            TournamentProperties::FIFTY50,
            TournamentProperties::FLIPOUT,
            TournamentProperties::TRIPLEUP,
            TournamentProperties::LOTTERY,
            TournamentProperties::RE_ENTRY,
            TournamentProperties::POWER_UP,
            TournamentProperties::PROGRESSIVE_BOUNTY
        );
});

test('TournamentProperties enum values can be accessed through invoke syntax', function () {
    expect(TournamentProperties::SNG())->toBe('SNG')
        ->and(TournamentProperties::DON())->toBe('DON')
        ->and(TournamentProperties::BOUNTY())->toBe('Bounty')
        ->and(TournamentProperties::SHOOTOUT())->toBe('Shootout')
        ->and(TournamentProperties::REBUY())->toBe('Rebuy')
        ->and(TournamentProperties::MATRIX())->toBe('Matrix')
        ->and(TournamentProperties::PUSH_OR_FOLD())->toBe('Push_Or_Fold')
        ->and(TournamentProperties::SATELLITE())->toBe('Satellite')
        ->and(TournamentProperties::STEPS())->toBe('Steps')
        ->and(TournamentProperties::DEEP())->toBe('Deep')
        ->and(TournamentProperties::MULTI_ENTRY())->toBe('Multi-Entry')
        ->and(TournamentProperties::FIFTY50())->toBe('Fifty50')
        ->and(TournamentProperties::FLIPOUT())->toBe('Flipout')
        ->and(TournamentProperties::TRIPLEUP())->toBe('TripleUp')
        ->and(TournamentProperties::LOTTERY())->toBe('Lottery')
        ->and(TournamentProperties::RE_ENTRY())->toBe('Re-Entry')
        ->and(TournamentProperties::POWER_UP())->toBe('Power_Up')
        ->and(TournamentProperties::PROGRESSIVE_BOUNTY())->toBe('Progressive-Bounty');
});

test('TournamentProperties returns enum names correctly', function () {
    expect(TournamentProperties::names())->toContain(
        'SNG',
        'DON',
        'BOUNTY',
        'SHOOTOUT',
        'REBUY',
        'MATRIX',
        'PUSH_OR_FOLD',
        'SATELLITE',
        'STEPS',
        'DEEP',
        'MULTI_ENTRY',
        'FIFTY50',
        'FLIPOUT',
        'TRIPLEUP',
        'LOTTERY',
        'RE_ENTRY',
        'POWER_UP',
        'PROGRESSIVE_BOUNTY'
    );
});

test('TournamentProperties returns enum values correctly', function () {
    expect(TournamentProperties::values())->toContain(
        'SNG',
        'DON',
        'Bounty',
        'Shootout',
        'Rebuy',
        'Matrix',
        'Push_Or_Fold',
        'Satellite',
        'Steps',
        'Deep',
        'Multi-Entry',
        'Fifty50',
        'Flipout',
        'TripleUp',
        'Lottery',
        'Re-Entry',
        'Power_Up',
        'Progressive-Bounty'
    );
});

test('TournamentProperties returns enum name/value pairs correctly', function () {
    $options = TournamentProperties::options();
    expect($options)->toBeArray()
        ->and($options)->toHaveCount(18)
        ->and($options['SNG'])->toBe('SNG')
        ->and($options['DON'])->toBe('DON')
        ->and($options['BOUNTY'])->toBe('Bounty')
        ->and($options['SHOOTOUT'])->toBe('Shootout')
        ->and($options['REBUY'])->toBe('Rebuy')
        ->and($options['MATRIX'])->toBe('Matrix')
        ->and($options['PUSH_OR_FOLD'])->toBe('Push_Or_Fold')
        ->and($options['SATELLITE'])->toBe('Satellite')
        ->and($options['STEPS'])->toBe('Steps')
        ->and($options['DEEP'])->toBe('Deep')
        ->and($options['MULTI_ENTRY'])->toBe('Multi-Entry')
        ->and($options['FIFTY50'])->toBe('Fifty50')
        ->and($options['FLIPOUT'])->toBe('Flipout')
        ->and($options['TRIPLEUP'])->toBe('TripleUp')
        ->and($options['LOTTERY'])->toBe('Lottery')
        ->and($options['RE_ENTRY'])->toBe('Re-Entry')
        ->and($options['POWER_UP'])->toBe('Power_Up')
        ->and($options['PROGRESSIVE_BOUNTY'])->toBe('Progressive-Bounty');
});
