<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Response\AnswerTrait;

/**
 * Class AbstractController
 *
 * @package App\Http
 */
abstract class AbstractController extends Controller
{
    /**
     * @see AnswerTrait
     */
    use AnswerTrait;
}
