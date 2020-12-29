<?php
namespace App;

class Helpers {

    /**
     * Method to check the language of uploaded content for any words that could be deemed offensive
     *
     * If so, the content will be flagged for approval of a site admin
     */
    public static function checkLanguage($inputString) {
        // Make the inputString all lowercase
        $inputString = strtolower($inputString);
        // Define the list of offensive/profane words
        $profanityList = ['fuck', 'shit', 'cunt', 'bitch', 'fag', 'dick', 'bellend', 'damn', 'kill you'];
        // Check the content for each trigger word
        $contentSafe = true;
        foreach($profanityList as $word) {
            if (strpos($inputString, $word)) {
                $contentSafe = false;
                break;
            }
        }
        // Return the result of the check
        return $contentSafe;
    }

}
