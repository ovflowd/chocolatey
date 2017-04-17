<?php

namespace App\Models;

/**
 * Class NuxValidation.
 */
class NuxValidation
{
    /**
     * Result Code.
     *
     * @var string
     */
    public $code;

    /**
     * Specification of what Happened.
     *
     * @var array|null
     */
    public $validationResult = null;

    /**
     * Username Suggestions.
     *
     * @TODO: Code Suggestions
     *
     * @var array|null
     */
    public $suggestions = [];

    /**
     * Create a NUX Validation.
     *
     * @param string $code
     * @param array  $validationResult
     * @param array  $suggestions
     */
    public function __construct(string $code = 'OK', array $validationResult = [], array $suggestions = [])
    {
        $this->code = $code;

        if (!empty($validationResult)) {
            $this->validationResult = $validationResult;
        }

        if (!empty($suggestions)) {
            $this->suggestions = $suggestions;
        }
    }
}
