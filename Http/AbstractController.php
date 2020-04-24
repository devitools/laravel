<?php

declare(strict_types=1);

namespace Simples\Http;

use App\Http\Controllers\Controller;
use Simples\Response\Answer\AnswerTrait;

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
