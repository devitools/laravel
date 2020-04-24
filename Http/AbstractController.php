<?php

declare(strict_types=1);

namespace DeviTools\Http;

use App\Http\Controllers\Controller;
use DeviTools\Http\Response\AnswerTrait;

/**
 * Class Controller
 *
 * @package App\Http\Controllers
 */
abstract class AbstractController extends Controller
{
    /**
     * @see AnswerTrait
     */
    use AnswerTrait;
}
