<?php

declare(strict_types=1);

namespace DeviTools\Http;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * Class State
 *
 * @package DeviTools\Http
 */
class State extends AbstractController
{
    /**
     * The __invoke method is called when a script tries to call an object as a function.
     *
     * @param Request $request
     * @param string $token
     *
     * @return JsonResponse
     * @link http://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.invoke
     */
    public function __invoke(Request $request, string $token)
    {
        if (!Cache::has($token)) {
            return $this->answerFail(['state' => 'undefined']);
        }
        $state = Cache::get($token);

        return $this->answerSuccess($state);
    }
}
