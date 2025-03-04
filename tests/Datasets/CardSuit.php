<?php

use PHPoker\Poker\Enum\CardSuit;

dataset('suit_bitmasks', [
    'Club bitmask' => [CardSuit::CLUB, '1000'],
    'Diamond bitmask' => [CardSuit::DIAMOND, '0100'],
    'Heart bitmask' => [CardSuit::HEART, '0010'],
    'Spade bitmask' => [CardSuit::SPADE, '0001'],
]);

dataset('suit_symbols', [
    'Club symbol' => [CardSuit::CLUB, '♣'],
    'Diamond symbol' => [CardSuit::DIAMOND, '♦'],
    'Heart symbol' => [CardSuit::HEART, '♥'],
    'Spade symbol' => [CardSuit::SPADE, '♠'],
]);

dataset('suit_texts', [
    'Club text' => [CardSuit::CLUB, 'c'],
    'Diamond text' => [CardSuit::DIAMOND, 'd'],
    'Heart text' => [CardSuit::HEART, 'h'],
    'Spade text' => [CardSuit::SPADE, 's'],
]);

dataset('valid_suit_integers', [
    // Hexadecimal values
    'Club (hex)' => [0x8000, CardSuit::CLUB],
    'Diamond (hex)' => [0x4000, CardSuit::DIAMOND],
    'Heart (hex)' => [0x2000, CardSuit::HEART],
    'Spade (hex)' => [0x1000, CardSuit::SPADE],

    // Decimal values
    'Club (decimal)' => [32768, CardSuit::CLUB],     // 0x8000 in decimal
    'Diamond (decimal)' => [16384, CardSuit::DIAMOND],  // 0x4000 in decimal
    'Heart (decimal)' => [8192, CardSuit::HEART],     // 0x2000 in decimal
    'Spade (decimal)' => [4096, CardSuit::SPADE],     // 0x1000 in decimal
]);

dataset('invalid_suit_integers', [
    'Zero' => [0],
    'One' => [1],
    'Small number' => [100],
    'Too small for suit' => [0x800],   // Too small
    'Invalid combination' => [0xF000],  // Invalid combination
    'Too large' => [0x10000], // Too large
    'Negative one' => [-1],
    'Negative hex' => [-0x8000],
]);

dataset('valid_suit_strings', [
    // Club representations
    'Lowercase c' => ['c', CardSuit::CLUB],
    'Uppercase C' => ['C', CardSuit::CLUB],
    'Club symbol' => ['♣', CardSuit::CLUB],
    'Lowercase club' => ['club', CardSuit::CLUB],
    'Title Case Club' => ['Club', CardSuit::CLUB],
    'Uppercase CLUB' => ['CLUB', CardSuit::CLUB],
    'Lowercase clubs' => ['clubs', CardSuit::CLUB],
    'Title Case Clubs' => ['Clubs', CardSuit::CLUB],
    'Uppercase CLUBS' => ['CLUBS', CardSuit::CLUB],

    // Diamond representations
    'Lowercase d' => ['d', CardSuit::DIAMOND],
    'Uppercase D' => ['D', CardSuit::DIAMOND],
    'Diamond symbol' => ['♦', CardSuit::DIAMOND],
    'Lowercase diamond' => ['diamond', CardSuit::DIAMOND],
    'Title Case Diamond' => ['Diamond', CardSuit::DIAMOND],
    'Uppercase DIAMOND' => ['DIAMOND', CardSuit::DIAMOND],
    'Lowercase diamonds' => ['diamonds', CardSuit::DIAMOND],
    'Title Case Diamonds' => ['Diamonds', CardSuit::DIAMOND],
    'Uppercase DIAMONDS' => ['DIAMONDS', CardSuit::DIAMOND],

    // Heart representations
    'Lowercase h' => ['h', CardSuit::HEART],
    'Uppercase H' => ['H', CardSuit::HEART],
    'Heart symbol' => ['♥', CardSuit::HEART],
    'Lowercase heart' => ['heart', CardSuit::HEART],
    'Title Case Heart' => ['Heart', CardSuit::HEART],
    'Uppercase HEART' => ['HEART', CardSuit::HEART],
    'Lowercase hearts' => ['hearts', CardSuit::HEART],
    'Title Case Hearts' => ['Hearts', CardSuit::HEART],
    'Uppercase HEARTS' => ['HEARTS', CardSuit::HEART],

    // Spade representations
    'Lowercase s' => ['s', CardSuit::SPADE],
    'Uppercase S' => ['S', CardSuit::SPADE],
    'Spade symbol' => ['♠', CardSuit::SPADE],
    'Lowercase spade' => ['spade', CardSuit::SPADE],
    'Title Case Spade' => ['Spade', CardSuit::SPADE],
    'Uppercase SPADE' => ['SPADE', CardSuit::SPADE],
    'Lowercase spades' => ['spades', CardSuit::SPADE],
    'Title Case Spades' => ['Spades', CardSuit::SPADE],
    'Uppercase SPADES' => ['SPADES', CardSuit::SPADE],
]);

dataset('invalid_suit_strings', [
    'Lowercase x' => ['x', 'Cannot Determine Playing Card Suit From [x]'],
    'Uppercase X' => ['X', 'Cannot Determine Playing Card Suit From [X]'],
    'Numeric 1' => ['1', 'Cannot Determine Playing Card Suit From [1]'],
    'Word card' => ['card', 'Cannot Determine Playing Card Suit From [card]'],
    'Empty string' => ['', 'Cannot Determine Playing Card Suit From []'],
    'Numeric string' => ['123', 'Cannot Determine Playing Card Suit From [123]'],
    'Reversed suit sc' => ['sc', 'Cannot Determine Playing Card Suit From [sc]'],
    'Abbreviated Club' => ['clb', 'Cannot Determine Playing Card Suit From [clb]'],
    'Abbreviated Diamond' => ['dmnd', 'Cannot Determine Playing Card Suit From [dmnd]'],
    'Abbreviated Heart' => ['hrt', 'Cannot Determine Playing Card Suit From [hrt]'],
    'Abbreviated Spade' => ['spd', 'Cannot Determine Playing Card Suit From [spd]'],
]);
