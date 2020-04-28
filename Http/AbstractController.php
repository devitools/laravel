<?php

declare(strict_types=1);

namespace DeviTools\Http;

use App\Http\Controllers\Controller;
use DeviTools\Http\Response\AnswerTrait;

/**
 * Class AbstractController
 *
 * @package DeviTools\Http
 */
abstract class AbstractController extends Controller
{
    /**
     * @see AnswerTrait
     */
    use AnswerTrait;
}
