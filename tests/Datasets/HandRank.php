<?php

use PHPoker\Poker\Enum\HandRank;

// Dataset for HandRank enum values
dataset('hand_rank_values', [
    'STRAIGHT_FLUSH' => [HandRank::STRAIGHT_FLUSH, 1],
    'FOUR_OF_A_KIND' => [HandRank::FOUR_OF_A_KIND, 2],
    'FULL_HOUSE' => [HandRank::FULL_HOUSE, 3],
    'FLUSH' => [HandRank::FLUSH, 4],
    'STRAIGHT' => [HandRank::STRAIGHT, 5],
    'THREE_OF_A_KIND' => [HandRank::THREE_OF_A_KIND, 6],
    'TWO_PAIR' => [HandRank::TWO_PAIR, 7],
    'ONE_PAIR' => [HandRank::ONE_PAIR, 8],
    'HIGH_CARD' => [HandRank::HIGH_CARD, 9],
]);

// Dataset for HandRank::evaluate method
dataset('hand_rank_evaluations', [
    // Straight flush range
    'Straight Flush (lowest value)' => [1, HandRank::STRAIGHT_FLUSH],
    'Straight Flush (middle value)' => [5, HandRank::STRAIGHT_FLUSH],
    'Straight Flush (max value)' => [10, HandRank::STRAIGHT_FLUSH],

    // Four of a kind range (11-166)
    'Four of a Kind (lowest value)' => [11, HandRank::FOUR_OF_A_KIND],
    'Four of a Kind (middle value)' => [88, HandRank::FOUR_OF_A_KIND],
    'Four of a Kind (max value)' => [166, HandRank::FOUR_OF_A_KIND],

    // Full house range (167-322)
    'Full House (lowest value)' => [167, HandRank::FULL_HOUSE],
    'Full House (middle value)' => [244, HandRank::FULL_HOUSE],
    'Full House (max value)' => [322, HandRank::FULL_HOUSE],

    // Flush range (323-1599)
    'Flush (lowest value)' => [323, HandRank::FLUSH],
    'Flush (middle value)' => [960, HandRank::FLUSH],
    'Flush (max value)' => [1599, HandRank::FLUSH],

    // Straight range (1600-1609)
    'Straight (lowest value)' => [1600, HandRank::STRAIGHT],
    'Straight (middle value)' => [1605, HandRank::STRAIGHT],
    'Straight (max value)' => [1609, HandRank::STRAIGHT],

    // Three of a kind range (1610-2467)
    'Three of a Kind (lowest value)' => [1610, HandRank::THREE_OF_A_KIND],
    'Three of a Kind (middle value)' => [2038, HandRank::THREE_OF_A_KIND],
    'Three of a Kind (max value)' => [2467, HandRank::THREE_OF_A_KIND],

    // Two pair range (2468-3325)
    'Two Pair (lowest value)' => [2468, HandRank::TWO_PAIR],
    'Two Pair (middle value)' => [2896, HandRank::TWO_PAIR],
    'Two Pair (max value)' => [3325, HandRank::TWO_PAIR],

    // One pair range (3326-6185)
    'One Pair (lowest value)' => [3326, HandRank::ONE_PAIR],
    'One Pair (middle value)' => [4755, HandRank::ONE_PAIR],
    'One Pair (max value)' => [6185, HandRank::ONE_PAIR],

    // High card range (6186+)
    'High Card (lowest value)' => [6186, HandRank::HIGH_CARD],
    'High Card (middle value)' => [6800, HandRank::HIGH_CARD],
    'High Card (high value)' => [7462, HandRank::HIGH_CARD],
]);
