<?php

use PHPoker\Poker\Enum\HandProperties;

test('HandProperties has correct string values', function () {
    expect(HandProperties::RUN_IT_TWICE->value)->toBe('Run_It_Twice')
        ->and(HandProperties::ANONYMOUS->value)->toBe('Anonymous')
        ->and(HandProperties::OBSERVED->value)->toBe('Observed')
        ->and(HandProperties::FAST->value)->toBe('Fast')
        ->and(HandProperties::CAP->value)->toBe('Cap');
});

test('HandProperties enum cases can be accessed', function () {
    expect(HandProperties::cases())->toHaveCount(5)
        ->and(HandProperties::cases())->toContain(
            HandProperties::RUN_IT_TWICE,
            HandProperties::ANONYMOUS,
            HandProperties::OBSERVED,
            HandProperties::FAST,
            HandProperties::CAP
        );
});

test('HandProperties enum values can be accessed through invoke syntax', function () {
    expect(HandProperties::RUN_IT_TWICE())->toBe('Run_It_Twice')
        ->and(HandProperties::ANONYMOUS())->toBe('Anonymous')
        ->and(HandProperties::OBSERVED())->toBe('Observed')
        ->and(HandProperties::FAST())->toBe('Fast')
        ->and(HandProperties::CAP())->toBe('Cap');
});

test('HandProperties returns enum names correctly', function () {
    expect(HandProperties::names())->toContain(
        'RUN_IT_TWICE',
        'ANONYMOUS',
        'OBSERVED',
        'FAST',
        'CAP'
    );
});

test('HandProperties returns enum values correctly', function () {
    expect(HandProperties::values())->toContain(
        'Run_It_Twice',
        'Anonymous',
        'Observed',
        'Fast',
        'Cap'
    );
});

test('HandProperties returns enum name/value pairs correctly', function () {
    $options = HandProperties::options();
    expect($options)->toBeArray()
        ->and($options)->toHaveCount(5)
        ->and($options['RUN_IT_TWICE'])->toBe('Run_It_Twice')
        ->and($options['ANONYMOUS'])->toBe('Anonymous')
        ->and($options['OBSERVED'])->toBe('Observed')
        ->and($options['FAST'])->toBe('Fast')
        ->and($options['CAP'])->toBe('Cap');
});
