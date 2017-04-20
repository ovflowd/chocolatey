<?php

namespace App\Models;

/**
 * Class Question.
 */
class Question
{
    /**
     * Question Identifier (One or Two).
     *
     * @var int
     */
    public $questionId = 1;

    /**
     * Question Key (Translate Text).
     *
     * @var string
     */
    public $questionKey = '';

    /**
     * Store a Question.
     *
     * @param int    $questionId
     * @param string $questionKey
     */
    public function __construct(int $questionId, string $questionKey)
    {
        $this->questionId = $questionId;
        $this->questionKey = $questionKey;
    }
}
