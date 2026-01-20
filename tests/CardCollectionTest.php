<?php

use Illuminate\Support\Collection;
use PHPoker\Poker\Card;
use PHPoker\Poker\Collections\CardCollection;
use PHPoker\Poker\Enum\CardFace;
use PHPoker\Poker\Enum\CardSuit;
use PHPoker\Poker\Enum\HandRank;

test('CardCollection can be created with make method', function () {
    $collection = CardCollection::make([
        Card::make(CardFace::ACE, CardSuit::CLUB),
        Card::make(CardFace::KING, CardSuit::DIAMOND),
    ]);

    expect($collection)->toBeInstanceOf(CardCollection::class)
        ->and($collection)->toHaveCount(2)
        ->and($collection[0]->face)->toBe(CardFace::ACE)
        ->and($collection[0]->suit)->toBe(CardSuit::CLUB)
        ->and($collection[1]->face)->toBe(CardFace::KING)
        ->and($collection[1]->suit)->toBe(CardSuit::DIAMOND);
});

test('CardCollection fromText can parse string representations', function (string $input, CardCollection $expected) {
    $collection = CardCollection::fromText($input);
    expect($collection)->toHaveCount($expected->count());

    foreach ($collection as $index => $card) {
        expect($card->isEqualTo($expected[$index]))->toBeTrue();
    }
})->with('card_collection_strings');

test('CardCollection fromText can parse array of strings', function () {
    $collection = CardCollection::fromText(['Ac', 'Kd', 'Qh']);

    expect($collection)->toHaveCount(3)
        ->and($collection[0]->face)->toBe(CardFace::ACE)
        ->and($collection[0]->suit)->toBe(CardSuit::CLUB)
        ->and($collection[1]->face)->toBe(CardFace::KING)
        ->and($collection[1]->suit)->toBe(CardSuit::DIAMOND)
        ->and($collection[2]->face)->toBe(CardFace::QUEEN)
        ->and($collection[2]->suit)->toBe(CardSuit::HEART);
});

test('CardCollection fromText can parse array of Card objects', function () {
    $cards = [
        Card::make(CardFace::ACE, CardSuit::CLUB),
        Card::make(CardFace::KING, CardSuit::DIAMOND),
    ];

    $collection = CardCollection::fromText($cards);

    expect($collection)->toHaveCount(2)
        ->and($collection[0]->isEqualTo($cards[0]))->toBeTrue()
        ->and($collection[1]->isEqualTo($cards[1]))->toBeTrue();
});

test('CardCollection fromText handles duplicate cards', function () {
    $collection = CardCollection::fromText('Ac Ac Kd Kd');

    expect($collection)->toHaveCount(2)
        ->and($collection[0]->face)->toBe(CardFace::ACE)
        ->and($collection[0]->suit)->toBe(CardSuit::CLUB)
        ->and($collection[1]->face)->toBe(CardFace::KING)
        ->and($collection[1]->suit)->toBe(CardSuit::DIAMOND);
});

test('CardCollection fromText ignores invalid card text', function () {
    $c = CardCollection::fromText('Ax Ky');
    $c2 = CardCollection::fromText('#$ [] 32');

    expect($c)->toBeEmpty();
    expect($c2)->toBeEmpty();
});

test('CardCollection returns full deck of 52 cards', function () {
    $deck = CardCollection::createDeck();

    expect($deck)->toBeInstanceOf(CardCollection::class)
        ->and($deck)->toHaveCount(52);

    // Check that every combination of suit and face is present
    foreach (CardSuit::cases() as $suit) {
        foreach (CardFace::cases() as $face) {
            $hasCard = $deck->contains(function (Card $card) use ($face, $suit) {
                return $card->face === $face && $card->suit === $suit;
            });

            expect($hasCard)->toBeTrue("Deck is missing card: {$face->symbol()}{$suit->text()}");
        }
    }
});

test('CardCollection sorts cards by face value ascending', function (
    CardCollection $collection,
    CardCollection $expectedAscending,
    CardCollection $expectedDescending
) {
    $sorted = $collection->sortByFaceValue();

    expect($sorted)->toHaveCount($expectedAscending->count());

    foreach ($sorted as $index => $card) {
        expect($card->isEqualTo($expectedAscending[$index]))->toBeTrue();
    }
})->with('card_collections_for_sort');

test('CardCollection sorts cards by face value descending', function (
    CardCollection $collection,
    CardCollection $expectedAscending,
    CardCollection $expectedDescending
) {
    $sorted = $collection->sortByFaceValueDesc();

    expect($sorted)->toHaveCount($expectedDescending->count());

    foreach ($sorted as $index => $card) {
        expect($card->isEqualTo($expectedDescending[$index]))->toBeTrue();
    }
})->with('card_collections_for_sort');

test('CardCollection returns collection with unique face values', function (
    CardCollection $collection,
    Collection $expectedUnique
) {
    $unique = $collection->faces();
    expect($unique)->toHaveCount($expectedUnique->count());

    expect($unique)->toEqual($expectedUnique);

})->with('card_collections_unique_faces');

test('CardCollection returns collection with unique suit values', function (
    CardCollection $collection,
    Collection $expectedUnique
) {
    $unique = $collection->suits();
    expect($unique)->toHaveCount($expectedUnique->count());

    expect($unique)->toEqual($expectedUnique);

})->with('card_collections_unique_suits');

test('CardCollection counts suits correctly', function (
    CardCollection $collection,
    Collection $expectedCounts
) {
    $counts = $collection->countSuits();
    expect($counts)->toEqual($expectedCounts);
})->with('card_collection_suit_counts');

test('CardCollection counts faces correctly', function (
    CardCollection $collection,
    Collection $expectedCounts
) {
    $counts = $collection->countFaces();
    expect($counts)->toEqual($expectedCounts);
})->with('card_collection_face_counts');

// Test ofSuit() method
test('CardCollection ofSuit returns cards of specified suit', function (
    CardCollection $collection,
    CardCollection $expectedClubs,
    CardCollection $expectedSpades,
    CardCollection $expectedAces,
    CardCollection $expectedFives
) {
    $clubCards = $collection->ofSuit(CardSuit::CLUB);
    $spadeCards = $collection->ofSuit(CardSuit::SPADE);

    // Test count
    expect($clubCards)->toHaveCount($expectedClubs->count());
    expect($spadeCards)->toHaveCount($expectedSpades->count());

    // Test each card
    foreach ($clubCards as $index => $card) {
        if ($index < $expectedClubs->count()) {
            expect($card->isEqualTo($expectedClubs[$index]))->toBeTrue();
        }
    }

    foreach ($spadeCards as $index => $card) {
        if ($index < $expectedSpades->count()) {
            expect($card->isEqualTo($expectedSpades[$index]))->toBeTrue();
        }
    }
})->with('card_collections_for_of_methods');

// Test ofFace() method
test('CardCollection ofFace returns cards of specified face', function (
    CardCollection $collection,
    CardCollection $expectedClubs,
    CardCollection $expectedSpades,
    CardCollection $expectedAces,
    CardCollection $expectedTwos
) {
    $aceCards = $collection->ofFace(CardFace::ACE);
    $twoCards = $collection->ofFace(CardFace::TWO);

    // Test count
    expect($aceCards)->toHaveCount($expectedAces->count());
    expect($twoCards)->toHaveCount($expectedTwos->count());

    // Test each card
    foreach ($aceCards as $index => $card) {
        if ($index < $expectedAces->count()) {
            expect($card->isEqualTo($expectedAces[$index]))->toBeTrue();
        }
    }

    foreach ($twoCards as $index => $card) {
        if ($index < $expectedTwos->count()) {
            expect($card->isEqualTo($expectedTwos[$index]))->toBeTrue();
        }
    }
})->with('card_collections_for_of_methods');

// Test diffCards() method
test('CardCollection diffCards returns correct difference', function (
    CardCollection $collection,
    CardCollection $madeHand,
    CardCollection $expected
) {
    $diff = $collection->diffCards($madeHand);

    expect($diff)->toHaveCount($expected->count());

    foreach ($diff as $index => $card) {
        expect($card->isEqualTo($expected[$index]))->toBeTrue();
    }
})->with('card_collections_for_diff_cards');

// Tests for holding() method
test('CardCollection holding returns correct boolean for face check', function () {
    $collection = CardCollection::fromText('Ac Kd Qh');

    expect($collection->holding(CardFace::ACE))->toBeTrue();
    expect($collection->holding(CardFace::KING))->toBeTrue();
    expect($collection->holding(CardFace::QUEEN))->toBeTrue();
    expect($collection->holding(CardFace::JACK))->toBeFalse();
    expect($collection->holding(CardFace::TEN))->toBeFalse();
});

test('CardCollection holding returns correct boolean for suit check', function () {
    $collection = CardCollection::fromText('Ac Kd Qh');

    expect($collection->holding(CardSuit::CLUB))->toBeTrue();
    expect($collection->holding(CardSuit::DIAMOND))->toBeTrue();
    expect($collection->holding(CardSuit::HEART))->toBeTrue();
    expect($collection->holding(CardSuit::SPADE))->toBeFalse();
});

test('CardCollection holding returns correct boolean for specific card check', function () {
    $collection = CardCollection::fromText('Ac Kd Qh');

    $aceOfClubs = Card::make(CardFace::ACE, CardSuit::CLUB);
    $kingOfDiamonds = Card::make(CardFace::KING, CardSuit::DIAMOND);
    $aceOfSpades = Card::make(CardFace::ACE, CardSuit::SPADE);

    expect($collection->holding($aceOfClubs))->toBeTrue();
    expect($collection->holding($kingOfDiamonds))->toBeTrue();
    expect($collection->holding($aceOfSpades))->toBeFalse();
});

test('CardCollection holding returns false for any check on empty collection', function () {
    $emptyCollection = CardCollection::fromText('');

    expect($emptyCollection->holding(CardFace::ACE))->toBeFalse();
    expect($emptyCollection->holding(CardSuit::CLUB))->toBeFalse();
    expect($emptyCollection->holding(Card::make(CardFace::ACE, CardSuit::CLUB)))->toBeFalse();
});

test('CardCollection discard correctly removes specified cards', function (
    CardCollection $collection,
    $cardsToDiscard,
    CardCollection $expected
) {
    $result = $collection->discard($cardsToDiscard);

    // Test count
    expect($result)->toHaveCount($expected->count());

    // If empty result, just verify it's empty
    if ($expected->isEmpty()) {
        expect($result)->toBeEmpty();

        return;
    }

    // Test each card in the result
    foreach ($result as $index => $card) {
        expect($card->isEqualTo($expected[$index]))->toBeTrue(
            "Card at index {$index} doesn't match expected card: got {$card->toString()} expected {$expected[$index]->toString()}"
        );
    }

    // Verify that no discarded cards remain
    if ($cardsToDiscard instanceof CardCollection) {
        foreach ($cardsToDiscard as $discardedCard) {
            $containsDiscarded = $result->contains(function (Card $card) use ($discardedCard) {
                return $card->isEqualTo($discardedCard);
            });
            expect($containsDiscarded)->toBeFalse(
                "Result should not contain discarded card: {$discardedCard->toString()}"
            );
        }
    }
})->with('card_collections_for_discard');

test('CardCollection uniqueCards correctly removes duplicate cards', function (
    CardCollection $collection,
    CardCollection $expected
) {
    $uniqueCards = $collection->uniqueCards();

    // Test count
    expect($uniqueCards)->toHaveCount($expected->count());

    // If empty result, just verify it's empty
    if ($expected->isEmpty()) {
        expect($uniqueCards)->toBeEmpty();

        return;
    }

    // Verify each card in the result
    foreach ($uniqueCards as $index => $card) {
        expect($card->isEqualTo($expected[$index]))->toBeTrue(
            "Card at index {$index} doesn't match expected card: got {$card->toString()} expected {$expected[$index]->toString()}"
        );
    }

    // Verify that no duplicates exist in the result
    $cardStrings = [];
    foreach ($uniqueCards as $card) {
        $cardString = $card->toString();
        expect(in_array($cardString, $cardStrings))->toBeFalse(
            "Duplicate card found in unique collection: {$cardString}"
        );
        $cardStrings[] = $cardString;
    }
})->with('card_collections_unique_cards');

test('CardCollection toString returns correct string representation with default separator', function (
    CardCollection $collection,
    string $expectedDefaultString,
    string $expectedCustomString,
    string $expectedHtml
) {
    $output = $collection->toString();
    dump($output);
    expect($output)->toBe($expectedDefaultString);
})->with('card_collections_for_string_output');

test('CardCollection toString returns correct string representation with custom separator', function (
    CardCollection $collection,
    string $expectedDefaultString,
    string $expectedCustomString,
    string $expectedHtml
) {
    $output = $collection->toString(',');
    expect($output)->toBe($expectedCustomString);
})->with('card_collections_for_string_output');

test('CardCollection toHtml returns correct HTML representation', function (
    CardCollection $collection,
    string $expectedDefaultString,
    string $expectedCustomString,
    string $expectedHtml
) {
    $output = $collection->toHtml();
    expect($output)->toBe($expectedHtml);
})->with('card_collections_for_string_output');

test('CardCollection toHtml with custom separator works correctly', function () {
    $collection = CardCollection::fromText('Ac Kd Qh');
    $output = $collection->toHtml(' | ');
    $expected = '[ A<span class="text-green-500">c</span> ] | [ K<span class="text-blue-500">d</span> ] | [ Q<span class="text-red-500">h</span> ]';
    expect($output)->toBe($expected);
});

test('CardCollection toIntegers converts cards to integer values correctly', function (
    CardCollection $collection,
    ?array $expectedIntegers
) {
    $result = $collection->toIntegers();

    expect($result)->toBeInstanceOf(Collection::class);

    if ($expectedIntegers === null) {
        // The collection should still have the same count
        expect($result)->toHaveCount($collection->count());

        // Each value should be an integer
        foreach ($result as $index => $value) {
            expect($value)->toBeInt();

            // Verify the integer value matches what would be generated from the original card
            $originalCard = $collection[$index];
            expect($value)->toBe($originalCard->toInteger());
        }

        return;
    }

    // For empty collection
    if (count($expectedIntegers) === 0) {
        expect($result)->toBeEmpty();

        return;
    }

    // For specific test cases with expected integers
    expect($result)->toHaveCount(count($expectedIntegers));

    foreach ($result as $index => $value) {
        expect($value)->toBeInt();
        expect($value)->toBe($expectedIntegers[$index]);
    }
})->with('card_collections_for_integers');

test('CardCollection toIntegers preserves original card order', function () {
    // Create a collection with specific order
    $collection = CardCollection::fromText('Ac Kd Qh Js 10c');

    // Get integer values
    $integers = $collection->toIntegers();

    // Convert back to cards for verification
    $reconstructed = CardCollection::make();
    foreach ($integers as $integer) {
        $reconstructed->push(Card::fromInteger($integer));
    }

    // Verify each card matches in order
    foreach ($collection as $index => $originalCard) {
        $reconstructedCard = $reconstructed[$index];
        expect($reconstructedCard->isEqualTo($originalCard))->toBeTrue(
            "Card at index {$index} doesn't match after integer conversion"
        );
    }
});

test('CardCollection toIntegers produces valid card integer values', function () {
    // Get a complete deck and convert to integers
    $deck = CardCollection::createDeck();
    $integers = $deck->toIntegers();

    // Each integer should be a valid card
    foreach ($integers as $integer) {
        // Attempting to convert back should not throw an exception
        $card = Card::fromInteger($integer);

        // Verify the card has a valid face and suit
        expect($card->face)->toBeInstanceOf(CardFace::class);
        expect($card->suit)->toBeInstanceOf(CardSuit::class);
    }
});

// Test for evaluateHandRank method
test('CardCollection evaluateHandRank returns correct hand rank', function (
    CardCollection $hand,
    HandRank $expectedRank
) {
    $handRank = $hand->evaluateHandRank();
    expect($handRank)->toBe($expectedRank);
})->with('hand_evaluations');

// Test for fromIntegers method
test('CardCollection fromIntegers correctly converts integer values to cards', function (
    array $integers,
    CardCollection $expected
) {
    $collection = CardCollection::fromIntegers($integers);

    expect($collection)->toHaveCount($expected->count());

    // If empty result, just verify it's empty
    if ($expected->isEmpty()) {
        expect($collection)->toBeEmpty();

        return;
    }

    // Test each card
    foreach ($collection as $index => $card) {
        expect($card->isEqualTo($expected[$index]))->toBeTrue(
            "Card at index {$index} doesn't match expected: got {$card->toString()}, expected {$expected[$index]->toString()}"
        );
    }
})->with('card_integers_for_collection');
