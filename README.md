<p align="center">
    <img src="https://raw.githubusercontent.com/PHPoker/Poker/refs/heads/main/docs/logo-with-text.png" height="300" alt="PHPoker">
    <p align="center">
        <a href="https://github.com/nunomaduro/skeleton-php/actions"><img alt="GitHub Workflow Status (master)" src="https://github.com/nunomaduro/skeleton-php/actions/workflows/tests.yml/badge.svg"></a>
        <a href="https://packagist.org/packages/nunomaduro/skeleton-php"><img alt="Total Downloads" src="https://img.shields.io/packagist/dt/nunomaduro/skeleton-php"></a>
        <a href="https://packagist.org/packages/nunomaduro/skeleton-php"><img alt="Latest Version" src="https://img.shields.io/packagist/v/nunomaduro/skeleton-php"></a>
        <a href="https://packagist.org/packages/nunomaduro/skeleton-php"><img alt="License" src="https://img.shields.io/packagist/l/nunomaduro/skeleton-php"></a>
    </p>
</p>

------
PHP's Premier Poker Solution

> **Requires [PHP 8.2+](https://php.net/releases/)**

### ⚡️ Installation using [Composer](https://getcomposer.org):

```bash
composer require phpoker/poker
```

### ✨ Features

- Base classes for common card + poker related entities
    - Card
    - CardFace
    - CardSuit
    - CardCollection
- Evaluate
    - Highly optimized 5-card/7-card hand evaluators (port of Kevin "CactusKev" Suffecool's algorithm)

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
