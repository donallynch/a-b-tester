<?php

/**
 * 3 way A/B Test
 *  Determine which promotional design to display based on some pre-defined percentages
 *
 * @return int
 */
public function abtest()
{
    /* Generate random number to determine which design to display */
    $rand = mt_rand() / mt_getrandmax();

    /* Define default split_percentage total */
    $total = 0.0;

    /* Define default promo option */
    $option = 0;

    /**
     * Simulate pulling the designs for the promo from cache/database
     *  - Redis key "promoDesigns:promo_id:1" returns the set [4,5,6]
     *  - Redis keys "promoDesigns:4","promoDesigns:5","promoDesigns:6" returns each row (or pulls them from database)
     */
    $designsFromDb = [
        ['id' => 4, 'promo_id' => 1, 'split_percentage' => 50, 'option' => 1],
        ['id' => 5, 'promo_id' => 1, 'split_percentage' => 25, 'option' => 2],
        ['id' => 6, 'promo_id' => 1, 'split_percentage' => 25, 'option' => 3]
    ];

    /* Determine which promo option id to display */

    /* Loop over promoDesigns */
    foreach ($designsFromDb as $row) {
        /* Increment total split percentage */
        $total += ($row['split_percentage'] / 100);

        /* If rand is in range of current split percentage */
        if ($total - $rand >= 0) {
            /* Identify option to display */
            $option = $row['option'];
            break;
        }
    }

    return $option;
}


