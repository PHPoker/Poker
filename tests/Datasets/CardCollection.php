<?php

use Illuminate\Support\Collection;
use PHPoker\Poker\Card;
use PHPoker\Poker\Collections\CardCollection;
use PHPoker\Poker\Enum\CardFace;
use PHPoker\Poker\Enum\CardSuit;

/**
 * Dataset for CardCollection tests
 */
dataset('card_collection_strings', [
    'Single card' => ['Ac', CardCollection::make([Card::make(CardFace::ACE, CardSuit::CLUB)])],
    'Multiple cards' => ['Ac 2d', CardCollection::make([
        Card::make(CardFace::ACE, CardSuit::CLUB),
        Card::make(CardFace::TWO, CardSuit::DIAMOND),
    ])],
    'Cards with symbols' => ['A♣ 2♦', CardCollection::make([
        Card::make(CardFace::ACE, CardSuit::CLUB),
        Card::make(CardFace::TWO, CardSuit::DIAMOND),
    ])],
    'Mixed format' => ['A♣ 2d 3♥ 4s', CardCollection::make([
        Card::make(CardFace::ACE, CardSuit::CLUB),
        Card::make(CardFace::TWO, CardSuit::DIAMOND),
        Card::make(CardFace::THREE, CardSuit::HEART),
        Card::make(CardFace::FOUR, CardSuit::SPADE),
    ])],
    'Comma separated' => ['Ac,2d,3h,4s', CardCollection::make([
        Card::make(CardFace::ACE, CardSuit::CLUB),
        Card::make(CardFace::TWO, CardSuit::DIAMOND),
        Card::make(CardFace::THREE, CardSuit::HEART),
        Card::make(CardFace::FOUR, CardSuit::SPADE),
    ])],
    'Mix of spaces and commas' => ['Ac, 2d, 3h 4s', CardCollection::make([
        Card::make(CardFace::ACE, CardSuit::CLUB),
        Card::make(CardFace::TWO, CardSuit::DIAMOND),
        Card::make(CardFace::THREE, CardSuit::HEART),
        Card::make(CardFace::FOUR, CardSuit::SPADE),
    ])],
    'Poker hand' => ['Ah Kh Qh Jh Th', CardCollection::make([
        Card::make(CardFace::ACE, CardSuit::HEART),
        Card::make(CardFace::KING, CardSuit::HEART),
        Card::make(CardFace::QUEEN, CardSuit::HEART),
        Card::make(CardFace::JACK, CardSuit::HEART),
        Card::make(CardFace::TEN, CardSuit::HEART),
    ])],
]);

dataset('card_collections_for_sort', [
    'Mixed suits and faces' => [
        CardCollection::make([
            Card::make(CardFace::ACE, CardSuit::CLUB),
            Card::make(CardFace::TWO, CardSuit::DIAMOND),
            Card::make(CardFace::KING, CardSuit::HEART),
            Card::make(CardFace::FIVE, CardSuit::SPADE),
        ]),
        // Expected ascending order
        CardCollection::make([
            Card::make(CardFace::TWO, CardSuit::DIAMOND),
            Card::make(CardFace::FIVE, CardSuit::SPADE),
            Card::make(CardFace::KING, CardSuit::HEART),
            Card::make(CardFace::ACE, CardSuit::CLUB),
        ]),
        // Expected descending order
        CardCollection::make([
            Card::make(CardFace::ACE, CardSuit::CLUB),
            Card::make(CardFace::KING, CardSuit::HEART),
            Card::make(CardFace::FIVE, CardSuit::SPADE),
            Card::make(CardFace::TWO, CardSuit::DIAMOND),
        ]),
    ],
    'Same faces different suits' => [
        CardCollection::make([
            Card::make(CardFace::ACE, CardSuit::DIAMOND),
            Card::make(CardFace::ACE, CardSuit::HEART),
            Card::make(CardFace::ACE, CardSuit::CLUB),
            Card::make(CardFace::ACE, CardSuit::SPADE),
        ]),
        // Expected ascending order (unchanged as faces are the same)
        CardCollection::make([
            Card::make(CardFace::ACE, CardSuit::DIAMOND),
            Card::make(CardFace::ACE, CardSuit::HEART),
            Card::make(CardFace::ACE, CardSuit::CLUB),
            Card::make(CardFace::ACE, CardSuit::SPADE),
        ]),
        // Expected descending order (unchanged as faces are the same)
        CardCollection::make([
            Card::make(CardFace::ACE, CardSuit::DIAMOND),
            Card::make(CardFace::ACE, CardSuit::HEART),
            Card::make(CardFace::ACE, CardSuit::CLUB),
            Card::make(CardFace::ACE, CardSuit::SPADE),
        ]),
    ],
    'Reverse order' => [
        CardCollection::make([
            Card::make(CardFace::ACE, CardSuit::CLUB),
            Card::make(CardFace::KING, CardSuit::CLUB),
            Card::make(CardFace::QUEEN, CardSuit::CLUB),
            Card::make(CardFace::JACK, CardSuit::CLUB),
            Card::make(CardFace::TEN, CardSuit::CLUB),
        ]),
        // Expected ascending order
        CardCollection::make([
            Card::make(CardFace::TEN, CardSuit::CLUB),
            Card::make(CardFace::JACK, CardSuit::CLUB),
            Card::make(CardFace::QUEEN, CardSuit::CLUB),
            Card::make(CardFace::KING, CardSuit::CLUB),
            Card::make(CardFace::ACE, CardSuit::CLUB),
        ]),
        // Expected descending order
        CardCollection::make([
            Card::make(CardFace::ACE, CardSuit::CLUB),
            Card::make(CardFace::KING, CardSuit::CLUB),
            Card::make(CardFace::QUEEN, CardSuit::CLUB),
            Card::make(CardFace::JACK, CardSuit::CLUB),
            Card::make(CardFace::TEN, CardSuit::CLUB),
        ]),
    ],
]);

dataset('card_collections_unique_faces', [
    'Duplicate faces' => [
        // Input
        CardCollection::make([
            Card::make(CardFace::ACE, CardSuit::CLUB),
            Card::make(CardFace::ACE, CardSuit::DIAMOND),
            Card::make(CardFace::KING, CardSuit::HEART),
            Card::make(CardFace::KING, CardSuit::SPADE),
        ]),
        // Expected unique faces
        Collection::make([
            CardFace::ACE,
            CardFace::KING,
        ]),
    ],
]);

dataset('card_collections_unique_suits', [
    'Duplicate suits' => [
        // Input
        CardCollection::make([
            Card::make(CardFace::ACE, CardSuit::CLUB),
            Card::make(CardFace::KING, CardSuit::CLUB),
            Card::make(CardFace::QUEEN, CardSuit::HEART),
            Card::make(CardFace::JACK, CardSuit::HEART),
        ]),
        // Expected unique suits
        Collection::make([
            CardSuit::CLUB,
            CardSuit::HEART,
        ]),
    ],
]);

dataset('card_collections_unique_cards', [
    'Duplicate cards' => [
        // Input with duplicates
        CardCollection::fromText('Ac Ac Kh Kh'),
        // Expected unique cards
        CardCollection::fromText('Ac Kh'),
    ],
    'No duplicates' => [
        // Input with no duplicates
        CardCollection::fromText('Ac Kd Qh Js'),
        // Expected (unchanged as no duplicates)
        CardCollection::fromText('Ac Kd Qh Js'),
    ],
    'Mixed duplicate/unique cards' => [
        // Input with some duplicates
        CardCollection::fromText('Ac Ac Kd Qh Qh Js Tc Tc'),
        // Expected unique cards
        CardCollection::fromText('Ac Kd Qh Js Tc'),
    ],
    'All same card' => [
        // Input with all same card
        CardCollection::fromText('Ac Ac Ac Ac'),
        // Expected unique cards (just one card)
        CardCollection::fromText('Ac'),
    ],
    'Empty collection' => [
        // Empty input collection
        CardCollection::fromText(''),
        // Expected empty result
        CardCollection::fromText(''),
    ],
]);

dataset('card_collections_for_counting', [
    'Equal distribution' => [
        // Input
        CardCollection::make([
            Card::make(CardFace::ACE, CardSuit::CLUB),
            Card::make(CardFace::KING, CardSuit::DIAMOND),
            Card::make(CardFace::QUEEN, CardSuit::HEART),
            Card::make(CardFace::JACK, CardSuit::SPADE),
        ]),
        // Expected suit counts
        CardCollection::make(['club' => 1, 'diamond' => 1, 'heart' => 1, 'spade' => 1]),
        // Expected face counts
        CardCollection::make(['ace' => 1, 'king' => 1, 'queen' => 1, 'jack' => 1]),
    ],
    'Uneven distribution' => [
        // Input
        CardCollection::make([
            Card::make(CardFace::ACE, CardSuit::CLUB),
            Card::make(CardFace::ACE, CardSuit::DIAMOND),
            Card::make(CardFace::ACE, CardSuit::HEART),
            Card::make(CardFace::KING, CardSuit::CLUB),
            Card::make(CardFace::KING, CardSuit::DIAMOND),
            Card::make(CardFace::QUEEN, CardSuit::CLUB),
        ]),
        // Expected suit counts
        CardCollection::make(['club' => 3, 'diamond' => 2, 'heart' => 1]),
        // Expected face counts
        CardCollection::make(['ace' => 3, 'king' => 2, 'queen' => 1]),
    ],
]);

dataset('card_collections_for_holding', [
    'Has face and suit' => [
        // Input
        CardCollection::make([
            Card::make(CardFace::ACE, CardSuit::CLUB),
            Card::make(CardFace::KING, CardSuit::DIAMOND),
            Card::make(CardFace::QUEEN, CardSuit::HEART),
            Card::make(CardFace::JACK, CardSuit::SPADE),
        ]),
        // Face to search for
        CardFace::ACE,
        // Suit to search for
        CardSuit::CLUB,
        // Has specific card
        Card::make(CardFace::ACE, CardSuit::CLUB),
        // Expected holding face result
        true,
        // Expected holding suit result
        true,
        // Expected holding card result
        true,
    ],
    'Missing face' => [
        // Input
        CardCollection::make([
            Card::make(CardFace::KING, CardSuit::CLUB),
            Card::make(CardFace::QUEEN, CardSuit::DIAMOND),
            Card::make(CardFace::JACK, CardSuit::HEART),
            Card::make(CardFace::TEN, CardSuit::SPADE),
        ]),
        // Face to search for
        CardFace::ACE,
        // Suit to search for
        CardSuit::CLUB,
        // Specific card
        Card::make(CardFace::ACE, CardSuit::CLUB),
        // Expected holding face result
        false,
        // Expected holding suit result
        true,
        // Expected holding card result
        false,
    ],
    'Missing suit' => [
        // Input
        CardCollection::make([
            Card::make(CardFace::ACE, CardSuit::DIAMOND),
            Card::make(CardFace::KING, CardSuit::DIAMOND),
            Card::make(CardFace::QUEEN, CardSuit::HEART),
            Card::make(CardFace::JACK, CardSuit::SPADE),
        ]),
        // Face to search for
        CardFace::ACE,
        // Suit to search for
        CardSuit::CLUB,
        // Specific card
        Card::make(CardFace::ACE, CardSuit::CLUB),
        // Expected holding face result
        true,
        // Expected holding suit result
        false,
        // Expected holding card result
        false,
    ],
]);

dataset('card_collections_for_fetching', [
    'Fetch by face' => [
        // Input
        CardCollection::make([
            Card::make(CardFace::ACE, CardSuit::CLUB),
            Card::make(CardFace::ACE, CardSuit::DIAMOND),
            Card::make(CardFace::KING, CardSuit::HEART),
            Card::make(CardFace::KING, CardSuit::SPADE),
        ]),
        // Face to fetch
        CardFace::ACE,
        // Expected face fetch result
        CardCollection::make([
            Card::make(CardFace::ACE, CardSuit::CLUB),
            Card::make(CardFace::ACE, CardSuit::DIAMOND),
        ]),
    ],
    'Fetch by suit' => [
        // Input
        CardCollection::make([
            Card::make(CardFace::ACE, CardSuit::CLUB),
            Card::make(CardFace::KING, CardSuit::CLUB),
            Card::make(CardFace::QUEEN, CardSuit::HEART),
            Card::make(CardFace::JACK, CardSuit::SPADE),
        ]),
        // Suit to fetch
        CardSuit::CLUB,
        // Expected suit fetch result
        CardCollection::make([
            Card::make(CardFace::ACE, CardSuit::CLUB),
            Card::make(CardFace::KING, CardSuit::CLUB),
        ]),
    ],
    'Face not found' => [
        // Input
        CardCollection::make([
            Card::make(CardFace::KING, CardSuit::CLUB),
            Card::make(CardFace::QUEEN, CardSuit::DIAMOND),
            Card::make(CardFace::JACK, CardSuit::HEART),
        ]),
        // Face to fetch
        CardFace::ACE,
        // Expected face fetch result (empty)
        CardCollection::make([]),
    ],
    'Suit not found' => [
        // Input
        CardCollection::make([
            Card::make(CardFace::ACE, CardSuit::CLUB),
            Card::make(CardFace::KING, CardSuit::DIAMOND),
            Card::make(CardFace::QUEEN, CardSuit::HEART),
        ]),
        // Suit to fetch
        CardSuit::SPADE,
        // Expected suit fetch result (empty)
        CardCollection::make([]),
    ],
]);

dataset('card_collections_for_string_output', [
    'Single card' => [
        // Input
        CardCollection::fromText('Ac'),
        // Expected toString output (default separator)
        'Ac',
        // Expected toString output (custom separator)
        'Ac',
        // Expected toHtml output (default separator)
        '[ A<span class="text-green-500">c</span> ]',
    ],
    'Multiple cards' => [
        // Input
        CardCollection::fromText('Ac Kd Qh'),
        // Expected toString output (default separator)
        'Ac Kd Qh',
        // Expected toString output (custom separator)
        'Ac,Kd,Qh',
        // Expected toHtml output (default separator)
        '[ A<span class="text-green-500">c</span> ] [ K<span class="text-blue-500">d</span> ] [ Q<span class="text-red-500">h</span> ]',
    ],
    'Royal flush' => [
        // Input
        CardCollection::fromText('Ah Kh Qh Jh Th'),
        // Expected toString output (default separator)
        'Ah Kh Qh Jh Th',
        // Expected toString output (custom separator)
        'Ah,Kh,Qh,Jh,Th',
        // Expected toHtml output (default separator)
        '[ A<span class="text-red-500">h</span> ] [ K<span class="text-red-500">h</span> ] [ Q<span class="text-red-500">h</span> ] [ J<span class="text-red-500">h</span> ] [ T<span class="text-red-500">h</span> ]',
    ],
    'Empty collection' => [
        // Input (empty)
        CardCollection::fromText(''),
        // Expected toString output (default separator)
        '',
        // Expected toString output (custom separator)
        '',
        // Expected toHtml output (default separator)
        '',
    ],
    'Mixed suits' => [
        // Input (all suits)
        CardCollection::fromText('As Kh Qd Jc'),
        // Expected toString output (default separator)
        'As Kh Qd Jc',
        // Expected toString output (custom separator)
        'As,Kh,Qd,Jc',
        // Expected toHtml output (default separator)
        '[ A<span class="text-white">s</span> ] [ K<span class="text-red-500">h</span> ] [ Q<span class="text-blue-500">d</span> ] [ J<span class="text-green-500">c</span> ]',
    ],
]);

dataset('card_collection_suit_counts', [
    'Single Suit' => [CardCollection::fromText('Ac 2c 3c 4c 5c'), collect(['CLUB' => 5])],
    'Multiple Suits' => [CardCollection::fromText('Ac 2c 3h 4d 5s'), collect(['CLUB' => 2, 'HEART' => 1, 'DIAMOND' => 1, 'SPADE' => 1])],
]);

dataset('card_collection_face_counts', [
    'Single Face' => [CardCollection::fromText('Ac Ad Ah As'), collect(['ACE' => 4])],
    'Multiple Faces' => [CardCollection::fromText('Ac Kc Kh Jd As'), collect(['ACE' => 2, 'JACK' => 1, 'KING' => 2])],
]);

// For ofSuit() and ofFace() tests
dataset('card_collections_for_of_methods', [
    'Mixed collection' => [
        // Input collection
        CardCollection::fromText('Ac 2c 3h 4d 5s Ks'),
        // Expected ofSuit(CLUB) result
        CardCollection::fromText('Ac 2c'),
        // Expected ofSuit(SPADE) result
        CardCollection::fromText('5s Ks'),
        // Expected ofFace(ACE) result
        CardCollection::fromText('Ac'),
        // Expected ofFace(FIVE) result
        CardCollection::fromText('5s'),
    ],
    'All same suit' => [
        // Input collection (all clubs)
        CardCollection::fromText('Ac 2c 3c 4c 5c'),
        // Expected ofSuit(CLUB) result (all cards)
        CardCollection::fromText('Ac 2c 3c 4c 5c'),
        // Expected ofSuit(SPADE) result (no cards)
        CardCollection::fromText(''),
        // Expected ofFace(ACE) result
        CardCollection::fromText('Ac'),
        // Expected ofFace(FIVE) result
        CardCollection::fromText('5c'),
    ],
    'Multiple of same face' => [
        // Input collection with multiple Aces
        CardCollection::fromText('Ac Ad Ah As 2c 3h'),
        // Expected ofSuit(CLUB) result
        CardCollection::fromText('Ac 2c'),
        // Expected ofSuit(SPADE) result
        CardCollection::fromText('As'),
        // Expected ofFace(ACE) result (all aces)
        CardCollection::fromText('Ac Ad Ah As'),
        // Expected ofFace(TWO) result
        CardCollection::fromText('2c'),
    ],
    'Empty collection' => [
        // Input empty collection
        CardCollection::fromText(''),
        // Expected ofSuit(CLUB) result (empty)
        CardCollection::fromText(''),
        // Expected ofSuit(SPADE) result (empty)
        CardCollection::fromText(''),
        // Expected ofFace(ACE) result (empty)
        CardCollection::fromText(''),
        // Expected ofFace(FIVE) result (empty)
        CardCollection::fromText(''),
    ],
]);

// For diffCards() tests
dataset('card_collections_for_diff_cards', [
    'Simple diff' => [
        // Original collection
        CardCollection::fromText('Ac Kd Qh Js Tc'),
        // Made hand to check against
        CardCollection::fromText('Ac Kd'),
        // Expected diff (cards not in made hand, sorted by face value desc)
        CardCollection::fromText('Qh Js Tc'),
    ],
    'No diff' => [
        // Original collection
        CardCollection::fromText('Ac Kd Qh'),
        // Made hand that includes all cards
        CardCollection::fromText('Ac Kd Qh'),
        // Expected diff (empty as all cards are in made hand)
        CardCollection::make(),
    ],
    'Complete diff' => [
        // Original collection
        CardCollection::fromText('Ac Kd Qh'),
        // Made hand with entirely different cards
        CardCollection::fromText('Js Tc 9h'),
        // Expected diff (all original cards, sorted by face value desc)
        CardCollection::fromText('Ac Kd Qh'),
    ],
]);

// For discard() tests
dataset('card_collections_for_discard', [
    'Discard single card' => [
        // Input collection
        CardCollection::fromText('Ac Kd Qh Js Tc'),
        // Cards to discard
        CardCollection::fromText('Ac'),
        // Expected result after discard
        CardCollection::fromText('Kd Qh Js Tc'),
    ],
    'Discard multiple cards' => [
        // Input collection
        CardCollection::fromText('Ac Kd Qh Js Tc'),
        // Cards to discard
        CardCollection::fromText('Ac Qh Tc'),
        // Expected result after discard
        CardCollection::fromText('Kd Js'),
    ],
    'Discard cards as string' => [
        // Input collection
        CardCollection::fromText('Ac Kd Qh Js Tc'),
        // Cards to discard as string
        'Ac Qh',
        // Expected result after discard
        CardCollection::fromText('Kd Js Tc'),
    ],
    'Discard cards as array' => [
        // Input collection
        CardCollection::fromText('Ac Kd Qh Js Tc'),
        // Cards to discard as array
        ['Ac', 'Qh'],
        // Expected result after discard
        CardCollection::fromText('Kd Js Tc'),
    ],
    'Discard non-existent cards' => [
        // Input collection
        CardCollection::fromText('Ac Kd'),
        // Cards to discard (not in collection)
        CardCollection::fromText('Qh Js'),
        // Expected result (unchanged)
        CardCollection::fromText('Ac Kd'),
    ],
    'Discard from empty collection' => [
        // Empty input collection
        CardCollection::fromText(''),
        // Cards to discard
        CardCollection::fromText('Ac Kd'),
        // Expected result (still empty)
        CardCollection::fromText(''),
    ],
    'Discard all cards' => [
        // Input collection
        CardCollection::fromText('Ac Kd Qh'),
        // Discard all cards
        CardCollection::fromText('Ac Kd Qh'),
        // Expected result (empty)
        CardCollection::fromText(''),
    ],
    'Discard with mixed card formats' => [
        // Input collection
        CardCollection::fromText('Ac Kd Qh Js Tc'),
        // Discard with mix of symbol and text
        'A♣ Qh',
        // Expected result
        CardCollection::fromText('Kd Js Tc'),
    ],
]);

dataset('card_collections_for_integers', [
    'Single card' => [
        // Input collection
        CardCollection::fromText('Ac'),
        // Expected integers (each card's integer representation)
        [Card::fromText('Ac')->toInteger()],
    ],
    'Multiple cards' => [
        // Input collection
        CardCollection::fromText('Ac Kd Qh'),
        // Expected integers
        [
            Card::fromText('Ac')->toInteger(),
            Card::fromText('Kd')->toInteger(),
            Card::fromText('Qh')->toInteger(),
        ],
    ],
    'Royal flush' => [
        // Input collection
        CardCollection::fromText('Ah Kh Qh Jh Th'),
        // Expected integers
        [
            Card::fromText('Ah')->toInteger(),
            Card::fromText('Kh')->toInteger(),
            Card::fromText('Qh')->toInteger(),
            Card::fromText('Jh')->toInteger(),
            Card::fromText('Th')->toInteger(),
        ],
    ],
    'Empty collection' => [
        // Input collection (empty)
        CardCollection::fromText(''),
        // Expected integers (empty array)
        [],
    ],
    'Full deck' => [
        // Input collection (create a full deck, which is shuffled)
        CardCollection::createDeck(),
        // Expected: will check dynamically in the test due to shuffling
        null,
    ],
]);
