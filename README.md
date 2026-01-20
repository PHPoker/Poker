<p align="center">
    <img src="https://raw.githubusercontent.com/PHPoker/Poker/refs/heads/main/docs/logo-with-text.png" height="300" alt="PHPoker">
    <p align="center">
        <a href="https://github.com/PHPoker/Poker/actions"><img alt="GitHub Workflow Status (master)" src="https://github.com/PHPoker/Poker/actions/workflows/tests.yml/badge.svg"></a>
        <a href="https://packagist.org/packages/PHPoker/poker"><img alt="Total Downloads" src="https://img.shields.io/packagist/dt/PHPoker/poker"></a>
        <a href="https://packagist.org/packages/PHPoker/poker"><img alt="Latest Version" src="https://img.shields.io/packagist/v/PHPoker/poker"></a>
        <a href="https://packagist.org/packages/PHPoker/poker"><img alt="License" src="https://img.shields.io/github/license/PHPoker/poker"></a>
    </p>
</p>

------
PHP's Premier Poker Solution

> **Requires [PHP 8.2+](https://php.net/releases/)**

### ⚡️ Installation using [Composer](https://getcomposer.org):

```bash
composer require phpoker/poker
```

### 🧩 Optional phpoker Extension

For fast native hand evaluation (5/7 cards) and equity calculations, install the `phpoker` PHP extension.
Installation steps vary by platform, so follow the instructions in the extension repository:

https://github.com/PHPoker/Extension

### ✨ Features

- Base classes for common card + poker related entities
    - Card
    - CardFace
    - CardSuit
    - CardCollection
- Enums for game metadata, actions, and tournament settings
    - HandRank
    - GameType
    - BetLimitType
    - RaiseType
    - TournamentType
    - TournamentSpeedType
    - TournamentProperties
    - HandProperties
- Evaluate
    - Highly optimized 5-card/6-card/7-card hand evaluators (port of Kevin "CactusKev" Suffecool's algorithm)
- Equity
    - Monte Carlo equity calculation via the phpoker extension

### Usage

PHPoker provides a comprehensive toolkit for working with cards, decks, and poker hand evaluation. Below are examples of the main features and how to use them.

### Working with Cards

#### Creating Cards

```php
use PHPoker\Poker\Card;
use PHPoker\Poker\Enum\CardFace;
use PHPoker\Poker\Enum\CardSuit;

// Create a card using enums
$aceOfSpades = Card::make(CardFace::ACE, CardSuit::SPADE);

// Create a card from text notation
$kingOfHearts = Card::fromText('Kh'); // K = King, h = hearts
$queenOfClubs = Card::fromText('Q♣'); // Works with Unicode symbols too

// Create a random card
$randomCard = Card::random();
```

#### Card Properties and Methods

```php
// Get card details
echo $aceOfSpades->face->name;  // "ACE"
echo $aceOfSpades->suit->name;  // "SPADE"

// Convert to string
echo $aceOfSpades->toString();       // "As" (default text format)
echo $aceOfSpades->toString(true);   // "A♠" (with Unicode suit symbol)

// Get HTML representation
echo $aceOfSpades->toHtml();         // "[ A<span class="text-white">s</span> ]"
echo $aceOfSpades->toHtml(true);     // "[ A<span class="text-white">♠</span> ]"

// Check card equality
$card1 = Card::fromText('Ah');
$card2 = Card::fromText('Ah');
$card3 = Card::fromText('As');

$card1->isEqualTo($card2); // true - same face and suit
$card1->isEqualTo($card3); // false - different suit
Card::areEqual($card1, $card2); // true - static method alternative
```

### Working with Card Enums

#### Card Faces

```php
use PHPoker\Poker\Enum\CardFace;

// Accessing face values
CardFace::ACE->value;    // 12
CardFace::KING->value;   // 11
CardFace::QUEEN->value;  // 10
CardFace::JACK->value;   // 9
CardFace::TEN->value;    // 8
CardFace::TWO->value;    // 0

// Get symbol representation
CardFace::ACE->symbol();   // "A"
CardFace::KING->symbol();  // "K"
CardFace::TEN->symbol();   // "T"

// Get face value (numeric values for comparing cards)
CardFace::ACE->faceValue();     // 14 (Ace high by default)
CardFace::ACE->faceValue(true); // 1 (Ace low)
CardFace::KING->faceValue();    // 13
CardFace::TWO->faceValue();     // 2

// Parse from text
$face = CardFace::fromText('Q');  // CardFace::QUEEN
$face = CardFace::fromText('10'); // CardFace::TEN
$face = CardFace::fromText('t');  // CardFace::TEN (case-insensitive)
$face = CardFace::fromText('ace'); // CardFace::ACE (full name works too)

// Get all symbols
$symbols = CardFace::symbols(); // ['2', '3', '4', '5', '6', '7', '8', '9', 'T', 'J', 'Q', 'K', 'A']

// Increment a face
$face = CardFace::NINE;
$face->plus(1);  // CardFace::TEN
$face->plus(2);  // CardFace::JACK
```

#### Card Suits

```php
use PHPoker\Poker\Enum\CardSuit;

// Accessing suits
CardSuit::CLUB;     // Club enum
CardSuit::DIAMOND;  // Diamond enum
CardSuit::HEART;    // Heart enum
CardSuit::SPADE;    // Spade enum

// Get symbol representation
CardSuit::CLUB->symbol();    // "♣"
CardSuit::DIAMOND->symbol(); // "♦"
CardSuit::HEART->symbol();   // "♥"
CardSuit::SPADE->symbol();   // "♠"

// Get text representation (for short form notation)
CardSuit::CLUB->text();    // "c"
CardSuit::DIAMOND->text(); // "d"
CardSuit::HEART->text();   // "h"
CardSuit::SPADE->text();   // "s"

// Parse from text
$suit = CardSuit::fromText('c');    // CardSuit::CLUB
$suit = CardSuit::fromText('♦');    // CardSuit::DIAMOND
$suit = CardSuit::fromText('heart'); // CardSuit::HEART
$suit = CardSuit::fromText('SPADE'); // CardSuit::SPADE (case-insensitive)

// Get a random suit
$randomSuit = CardSuit::random();
```

#### Hand Rank

```php
use PHPoker\Poker\Enum\HandRank;

HandRank::STRAIGHT_FLUSH->value; // 1
HandRank::STRAIGHT_FLUSH();      // 1 (invokable)

// Evaluate a rank value into its enum bucket
HandRank::evaluate(10);   // HandRank::FOUR_OF_A_KIND
HandRank::evaluate(322);  // HandRank::FLUSH

// Utility methods (ArchTech enums)
HandRank::names();   // ['STRAIGHT_FLUSH', 'FOUR_OF_A_KIND', ...]
HandRank::values();  // [1, 2, 3, 4, 5, 6, 7, 8, 9]
HandRank::options(); // ['STRAIGHT_FLUSH' => 1, ...]
```

#### Game Type

```php
use PHPoker\Poker\Enum\GameType;

GameType::HOLDEM->value; // "Holdem"
GameType::fromText('NLH'); // GameType::HOLDEM
GameType::fromText('OmahaHiLo'); // GameType::OMAHA_HILO
```

#### Bet Limit Type

```php
use PHPoker\Poker\Enum\BetLimitType;

BetLimitType::NO_LIMIT->value; // "NL"
BetLimitType::fromText('pot limit'); // BetLimitType::POT_LIMIT
```

#### Raise Type

```php
use PHPoker\Poker\Enum\RaiseType;

RaiseType::THREE_BET->value; // "3-Bet"
RaiseType::fromText('3bet'); // RaiseType::THREE_BET
RaiseType::fromText('c-bet'); // RaiseType::C_BET
```

#### Tournament Type

```php
use PHPoker\Poker\Enum\TournamentType;

TournamentType::MULTI_TABLE_TOURNAMENT->value; // "MTT"
TournamentType::SINGLE_TABLE_TOURNAMENT->value; // "STT"
```

#### Tournament Speed Type

```php
use PHPoker\Poker\Enum\TournamentSpeedType;

TournamentSpeedType::TURBO->value; // "Turbo"
TournamentSpeedType::HYPER_TURBO->value; // "Hyper-Turbo"
```

#### Tournament Properties

```php
use PHPoker\Poker\Enum\TournamentProperties;

TournamentProperties::BOUNTY->value; // "Bounty"
TournamentProperties::names(); // ['SNG', 'DON', 'BOUNTY', ...]
```

#### Hand Properties

```php
use PHPoker\Poker\Enum\HandProperties;

HandProperties::RUN_IT_TWICE->value; // "Run_It_Twice"
HandProperties::values(); // ['Run_It_Twice', 'Anonymous', ...]
```

### Working with Card Collections

Card collections allow you to work with groups of cards like hands and decks.

#### Creating Collections

```php
use PHPoker\Poker\Collections\CardCollection;
use PHPoker\Poker\Card;
use PHPoker\Poker\Enum\CardFace;
use PHPoker\Poker\Enum\CardSuit;

// Create a collection with individual cards
$hand = CardCollection::make([
    Card::make(CardFace::ACE, CardSuit::SPADE),
    Card::make(CardFace::ACE, CardSuit::HEART),
]);

// Create a collection from text notation
$hand = CardCollection::fromText('As Ah Kh Kd 2c');

// Create a collection from array of text
$hand = CardCollection::fromText(['As', 'Ah', 'Kh', 'Kd', '2c']);

// Create a collection from integer card values
$hand = CardCollection::fromIntegers([
    Card::fromText('As')->toInteger(),
    Card::fromText('Ah')->toInteger(),
]);

// Create a deck (all 52 cards, shuffled)
$deck = CardCollection::createDeck();
```

#### Manipulating Collections

```php
// Get unique cards (remove duplicates)
$uniqueCards = $hand->uniqueCards();

// Sort cards by face value
$sortedAscending = $hand->sortByFaceValue();
$sortedDescending = $hand->sortByFaceValueDesc();

// Get cards of a specific face
$aces = $hand->ofFace(CardFace::ACE);

// Get cards of a specific suit
$hearts = $hand->ofSuit(CardSuit::HEART);

// Discard specific cards
$remainingCards = $hand->discard('As Ah'); // By string notation
$remainingCards = $hand->discard(['As', 'Ah']); // By array
$remainingCards = $hand->discard($otherCollection); // By collection

// Check if a collection contains a card, face, or suit
$hasAce = $hand->holding(CardFace::ACE);          // Check for an ace
$hasHearts = $hand->holding(CardSuit::HEART);     // Check for hearts
$hasAceOfSpades = $hand->holding(Card::fromText('As')); // Check for specific card
```

### Collection Hand Evaluation

The library includes a powerful hand evaluation engine based on Kevin "CactusKev" Suffecool's algorithm with perfect-hash improvements by Paul Senzee. This provides fast and accurate 5-card, 6-card, and 7-card hand evaluation.

#### Evaluating a Hand

```php
use PHPoker\Poker\Collections\CardCollection;

// Create a hand from text notation
$royalFlush = CardCollection::fromText('Ah Kh Qh Jh Th');
$fourOfAKind = CardCollection::fromText('Ah Ad As Ac Kh');
$twoPair = CardCollection::fromText('Ah Ad Kh Ks Qc');
$highCard = CardCollection::fromText('Ah Kd Qs Jc 9h');

// Get the hand rank as an enum
$handRank = $royalFlush->evaluateHandRank();
echo $handRank->name; // "STRAIGHT_FLUSH" (Royal Flush is a type of Straight Flush)

$handRank = $fourOfAKind->evaluateHandRank();
echo $handRank->name; // "FOUR_OF_A_KIND"

$handRank = $twoPair->evaluateHandRank();
echo $handRank->name; // "TWO_PAIR"

$handRank = $highCard->evaluateHandRank();
echo $handRank->name; // "HIGH_CARD"
```

#### Comparing Hands
```php
// Create two hands to compare
$royalFlush = CardCollection::fromText('Ah Kh Qh Jh Th');
$fourOfAKind = CardCollection::fromText('Ah Ad As Ac Kh');

// Get categorical ranks for each hand
$royalFlushRank = $royalFlush->evaluateHandRank();
$fourOfAKindRank = $fourOfAKind->evaluateHandRank();

// Compare the ranks (lower is better)
if ($royalFlushRank->value < $fourOfAKindRank->value) {
    echo "Royal Flush wins!";
} else {
    echo "Four of a Kind wins!";
}
// Output: "Royal Flush wins!"

// Another comparison
$fullHouse = CardCollection::fromText('Ah As Ad Kh Ks');
$flush = CardCollection::fromText('Ah Jh 8h 6h 2h');

if ($fullHouse->evaluateHandRank()->value < $flush->evaluateHandRank()->value) {
    echo "Full House wins!";
} else {
    echo "Flush wins!";
}
// Output: "Full House wins!"
```

#### Collection Analysis
```php
// Get collection of unique faces
$uniqueFaces = $hand->faces();

// Get collection of unique suits
$uniqueSuits = $hand->suits();

// Count suits in the collection
$suitCounts = $hand->countSuits(); // Returns Collection with counts

// Count faces in the collection
$faceCounts = $hand->countFaces(); // Returns Collection with counts

// Find the difference between two collections
$remainingCards = $hand->diffCards($cardsToRemove);
```

### Evaluating Raw Hands

If you already have integer card values, you can use the evaluator directly.

```php
use PHPoker\Poker\Card;
use PHPoker\Poker\Evaluate\Evaluator;
use PHPoker\Poker\Enum\HandRank;

$hand = [
    Card::fromText('Ah')->toInteger(),
    Card::fromText('Kh')->toInteger(),
    Card::fromText('Qh')->toInteger(),
    Card::fromText('Jh')->toInteger(),
    Card::fromText('Th')->toInteger(),
];

Evaluator::evaluateHand($hand); // HandRank::STRAIGHT_FLUSH

$sixCardHand = [
    Card::fromText('9h')->toInteger(),
    Card::fromText('Ah')->toInteger(),
    Card::fromText('Kh')->toInteger(),
    Card::fromText('Qh')->toInteger(),
    Card::fromText('Jh')->toInteger(),
    Card::fromText('Th')->toInteger(),
];

Evaluator::evaluateHand($sixCardHand); // HandRank::STRAIGHT_FLUSH
```

### Equity Calculations (phpoker extension required)

Equity calculations use the `phpoker` extension for Monte Carlo simulation.

```php
use PHPoker\Poker\Equity\Equity;

// Preflop equity for AA vs KK
$result = Equity::calculate(
    hands: ['Ah Ad', 'Kh Kd'],
    board: [],
    iterations: 100000,
    dead: ['2c', '7d']
);

$result->playerCount(); // 2
$result->iterations; // 100000
$result->board->toString(); // ""
$result->deadCards->toString(); // "2c 7d"
```

#### Equity Result and Calculation Objects

```php
use PHPoker\Poker\Equity\Equity;

$result = Equity::calculate(
    hands: ['Ah Ad', 'Kh Kd'],
    board: ['2c', '7d', 'Ts']
);

// Each entry is an EquityCalculation
$calculation = $result->equities[0];
$calculation->hand; // "Ah Ad"
$calculation->equity; // float percentage
$calculation->wins; // int
$calculation->ties; // int
$calculation->iterations; // int

$calculation->toArray(); // ['hand' => 'Ah Ad', 'equity' => 81.2, ...]
$calculation->jsonSerialize(); // Same as toArray()
```

#### Collection Output

```php
// Convert to string (default space-separated)
echo $hand->toString();        // "As Ah Kh Kd 2c"

// Custom separator
echo $hand->toString(',');     // "As,Ah,Kh,Kd,2c"

// Convert to HTML
echo $hand->toHtml();          // HTML representation with colored suits

// Convert cards to their unique integer values
$cardIntegers = $hand->toIntegers();
```

### 🛠️ Development & Contributing

All contributions are welcomed -- bug fixes, features, ideas, criticisms, optimizations!

Take advantage of the included development tools:

🧹 Keep a modern codebase with **Laravel Pint**:
```bash
composer lint
```

✅ Run refactors using **Rector**
```bash
composer refacto
```

⚗️ Run static analysis using **PHPStan**:
```bash
composer test:types
```

✅ Run unit tests using **PEST**
```bash
composer test:unit
```

🚀 Run the entire test suite:
```bash
composer test
```

**PHPoker** was created by **[Nick Poulos](https://nickpoulos.info)** under the **[MIT license](https://opensource.org/licenses/MIT)**.
