<?php

use PHPoker\Poker\Enum\CardFace;

dataset('face_prime_numbers', [
    'Two Prime' => [CardFace::TWO, 2],
    'Three Prime' => [CardFace::THREE, 3],
    'Four Prime' => [CardFace::FOUR, 5],
    'Five Prime' => [CardFace::FIVE, 7],
    'Six Prime' => [CardFace::SIX, 11],
    'Seven Prime' => [CardFace::SEVEN, 13],
    'Eight Prime' => [CardFace::EIGHT, 17],
    'Nine Prime' => [CardFace::NINE, 19],
    'Ten Prime' => [CardFace::TEN, 23],
    'Jack Prime' => [CardFace::JACK, 29],
    'Queen Prime' => [CardFace::QUEEN, 31],
    'King Prime' => [CardFace::KING, 37],
    'Ace Prime' => [CardFace::ACE, 41],
]);

dataset('face_prime_bitmasks', [
    'Two Prime Bitmask' => [CardFace::TWO, '00000010'],
    'Three Prime Bitmask' => [CardFace::THREE, '00000011'],
    'Four Prime Bitmask' => [CardFace::FOUR, '00000101'],
    'Five Prime Bitmask' => [CardFace::FIVE, '00000111'],
    'Six Prime Bitmask' => [CardFace::SIX, '00001011'],
    'Seven Prime Bitmask' => [CardFace::SEVEN, '00001101'],
    'Eight Prime Bitmask' => [CardFace::EIGHT, '00010001'],
    'Nine Prime Bitmask' => [CardFace::NINE, '00010011'],
    'Ten Prime Bitmask' => [CardFace::TEN, '00010111'],
    'Jack Prime Bitmask' => [CardFace::JACK, '00011101'],
    'Queen Prime Bitmask' => [CardFace::QUEEN, '00011111'],
    'King Prime Bitmask' => [CardFace::KING, '00100101'],
    'Ace Prime Bitmask' => [CardFace::ACE, '00101001'],
]);

dataset('face_mask_values', [
    'Two Mask Value (2^0)' => [CardFace::TWO, 1],
    'Three Mask Value (2^1)' => [CardFace::THREE, 2],
    'Four Mask Value (2^2)' => [CardFace::FOUR, 4],
    'Five Mask Value (2^3)' => [CardFace::FIVE, 8],
    'Six Mask Value (2^4)' => [CardFace::SIX, 16],
    'Seven Mask Value (2^5)' => [CardFace::SEVEN, 32],
    'Eight Mask Value (2^6)' => [CardFace::EIGHT, 64],
    'Nine Mask Value (2^7)' => [CardFace::NINE, 128],
    'Ten Mask Value (2^8)' => [CardFace::TEN, 256],
    'Jack Mask Value (2^9)' => [CardFace::JACK, 512],
    'Queen Mask Value (2^10)' => [CardFace::QUEEN, 1024],
    'King Mask Value (2^11)' => [CardFace::KING, 2048],
    'Ace Mask Value (2^12)' => [CardFace::ACE, 4096],
]);

dataset('face_value_bitmasks', [
    'Two Value Bitmask' => [CardFace::TWO, '0000000000000001'],
    'Three Value Bitmask' => [CardFace::THREE, '0000000000000010'],
    'Four Value Bitmask' => [CardFace::FOUR, '0000000000000100'],
    'Five Value Bitmask' => [CardFace::FIVE, '0000000000001000'],
    'Six Value Bitmask' => [CardFace::SIX, '0000000000010000'],
    'Seven Value Bitmask' => [CardFace::SEVEN, '0000000000100000'],
    'Eight Value Bitmask' => [CardFace::EIGHT, '0000000001000000'],
    'Nine Value Bitmask' => [CardFace::NINE, '0000000010000000'],
    'Ten Value Bitmask' => [CardFace::TEN, '0000000100000000'],
    'Jack Value Bitmask' => [CardFace::JACK, '0000001000000000'],
    'Queen Value Bitmask' => [CardFace::QUEEN, '0000010000000000'],
    'King Value Bitmask' => [CardFace::KING, '0000100000000000'],
    'Ace Value Bitmask' => [CardFace::ACE, '0001000000000000'],
]);

dataset('face_rank_bitmasks', [
    'Two Rank Bitmask' => [CardFace::TWO, '0000'],
    'Three Rank Bitmask' => [CardFace::THREE, '0001'],
    'Four Rank Bitmask' => [CardFace::FOUR, '0010'],
    'Five Rank Bitmask' => [CardFace::FIVE, '0011'],
    'Six Rank Bitmask' => [CardFace::SIX, '0100'],
    'Seven Rank Bitmask' => [CardFace::SEVEN, '0101'],
    'Eight Rank Bitmask' => [CardFace::EIGHT, '0110'],
    'Nine Rank Bitmask' => [CardFace::NINE, '0111'],
    'Ten Rank Bitmask' => [CardFace::TEN, '1000'],
    'Jack Rank Bitmask' => [CardFace::JACK, '1001'],
    'Queen Rank Bitmask' => [CardFace::QUEEN, '1010'],
    'King Rank Bitmask' => [CardFace::KING, '1011'],
    'Ace Rank Bitmask' => [CardFace::ACE, '1100'],
]);

dataset('face_symbols', [
    'Two Symbol' => [CardFace::TWO, '2'],
    'Three Symbol' => [CardFace::THREE, '3'],
    'Four Symbol' => [CardFace::FOUR, '4'],
    'Five Symbol' => [CardFace::FIVE, '5'],
    'Six Symbol' => [CardFace::SIX, '6'],
    'Seven Symbol' => [CardFace::SEVEN, '7'],
    'Eight Symbol' => [CardFace::EIGHT, '8'],
    'Nine Symbol' => [CardFace::NINE, '9'],
    'Ten Symbol' => [CardFace::TEN, 'T'],
    'Jack Symbol' => [CardFace::JACK, 'J'],
    'Queen Symbol' => [CardFace::QUEEN, 'Q'],
    'King Symbol' => [CardFace::KING, 'K'],
    'Ace Symbol' => [CardFace::ACE, 'A'],
]);

dataset('face_values', [
    'Two Value' => [CardFace::TWO, 2],
    'Three Value' => [CardFace::THREE, 3],
    'Four Value' => [CardFace::FOUR, 4],
    'Five Value' => [CardFace::FIVE, 5],
    'Six Value' => [CardFace::SIX, 6],
    'Seven Value' => [CardFace::SEVEN, 7],
    'Eight Value' => [CardFace::EIGHT, 8],
    'Nine Value' => [CardFace::NINE, 9],
    'Ten Value' => [CardFace::TEN, 10],
    'Jack Value' => [CardFace::JACK, 11],
    'Queen Value' => [CardFace::QUEEN, 12],
    'King Value' => [CardFace::KING, 13],
    'Ace Value (High)' => [CardFace::ACE, 14],
]);

dataset('face_plus_increments', [
    'Two Plus One' => [CardFace::TWO, 1, CardFace::THREE],
    'Seven Plus Two' => [CardFace::SEVEN, 2, CardFace::NINE],
    'Jack Plus Three' => [CardFace::JACK, 3, CardFace::ACE],
    'King Plus One' => [CardFace::KING, 1, CardFace::ACE],
    'Ace Plus One' => [CardFace::ACE, 1, CardFace::TWO], // Wraps around
    'Ten Plus Four' => [CardFace::TEN, 4, CardFace::ACE],
    'Eight Plus Eight' => [CardFace::EIGHT, 8, CardFace::THREE], // Wraps around
    'Five Plus Ten' => [CardFace::FIVE, 10, CardFace::TWO], // Wraps around
    'Queen Plus Thirteen' => [CardFace::QUEEN, 13, CardFace::QUEEN], // Full wrap
]);

dataset('valid_face_strings', [
    'Numeric 2' => ['2', CardFace::TWO],
    'Word two' => ['two', CardFace::TWO],
    'Word Two' => ['Two', CardFace::TWO],
    'Word TWO' => ['TWO', CardFace::TWO],

    'Numeric 3' => ['3', CardFace::THREE],
    'Word three' => ['three', CardFace::THREE],
    'Word Three' => ['Three', CardFace::THREE],
    'Word THREE' => ['THREE', CardFace::THREE],

    'Numeric 4' => ['4', CardFace::FOUR],
    'Word four' => ['four', CardFace::FOUR],
    'Word Four' => ['Four', CardFace::FOUR],
    'Word FOUR' => ['FOUR', CardFace::FOUR],

    'Numeric 5' => ['5', CardFace::FIVE],
    'Word five' => ['five', CardFace::FIVE],
    'Word Five' => ['Five', CardFace::FIVE],
    'Word FIVE' => ['FIVE', CardFace::FIVE],

    'Numeric 6' => ['6', CardFace::SIX],
    'Word six' => ['six', CardFace::SIX],
    'Word Six' => ['Six', CardFace::SIX],
    'Word SIX' => ['SIX', CardFace::SIX],

    'Numeric 7' => ['7', CardFace::SEVEN],
    'Word seven' => ['seven', CardFace::SEVEN],
    'Word Seven' => ['Seven', CardFace::SEVEN],
    'Word SEVEN' => ['SEVEN', CardFace::SEVEN],

    'Numeric 8' => ['8', CardFace::EIGHT],
    'Word eight' => ['eight', CardFace::EIGHT],
    'Word Eight' => ['Eight', CardFace::EIGHT],
    'Word EIGHT' => ['EIGHT', CardFace::EIGHT],

    'Numeric 9' => ['9', CardFace::NINE],
    'Word nine' => ['nine', CardFace::NINE],
    'Word Nine' => ['Nine', CardFace::NINE],
    'Word NINE' => ['NINE', CardFace::NINE],

    'Numeric 10' => ['10', CardFace::TEN],
    'Letter t' => ['t', CardFace::TEN],
    'Letter T' => ['T', CardFace::TEN],
    'Word ten' => ['ten', CardFace::TEN],
    'Word Ten' => ['Ten', CardFace::TEN],
    'Word TEN' => ['TEN', CardFace::TEN],

    'Letter j' => ['j', CardFace::JACK],
    'Letter J' => ['J', CardFace::JACK],
    'Word jack' => ['jack', CardFace::JACK],
    'Word Jack' => ['Jack', CardFace::JACK],
    'Word JACK' => ['JACK', CardFace::JACK],

    'Letter q' => ['q', CardFace::QUEEN],
    'Letter Q' => ['Q', CardFace::QUEEN],
    'Word queen' => ['queen', CardFace::QUEEN],
    'Word Queen' => ['Queen', CardFace::QUEEN],
    'Word QUEEN' => ['QUEEN', CardFace::QUEEN],

    'Letter k' => ['k', CardFace::KING],
    'Letter K' => ['K', CardFace::KING],
    'Word king' => ['king', CardFace::KING],
    'Word King' => ['King', CardFace::KING],
    'Word KING' => ['KING', CardFace::KING],

    'Letter a' => ['a', CardFace::ACE],
    'Letter A' => ['A', CardFace::ACE],
    'Word ace' => ['ace', CardFace::ACE],
    'Word Ace' => ['Ace', CardFace::ACE],
    'Word ACE' => ['ACE', CardFace::ACE],
]);

dataset('valid_face_integers', [
    'Two (0)' => [0, CardFace::TWO],
    'Three (1)' => [1, CardFace::THREE],
    'Four (2)' => [2, CardFace::FOUR],
    'Five (3)' => [3, CardFace::FIVE],
    'Six (4)' => [4, CardFace::SIX],
    'Seven (5)' => [5, CardFace::SEVEN],
    'Eight (6)' => [6, CardFace::EIGHT],
    'Nine (7)' => [7, CardFace::NINE],
    'Ten (8)' => [8, CardFace::TEN],
    'Jack (9)' => [9, CardFace::JACK],
    'Queen (10)' => [10, CardFace::QUEEN],
    'King (11)' => [11, CardFace::KING],
    'Ace (12)' => [12, CardFace::ACE],
]);

dataset('invalid_face_integers', [
    'Negative one' => [-1],
    'Negative large' => [-100],
    'Out of range (13)' => [13],
    'Out of range (14)' => [14],
    'Large number' => [100],
    'Very large number' => [10000],
]);
