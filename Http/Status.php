<?php

declare(strict_types=1);

namespace Simples\Http;

/**
 * Class Status
 *
 * @package App\Http
 */
class Status
{
    /**
     * Continue
     *
     * @var integer
     */
    const CODE_100 = 100;

    /**
     * Switching Protocols
     *
     * @var integer
     */
    const CODE_101 = 101;

    /**
     * Processing
     *
     * @var integer
     */
    const CODE_102 = 102;

    /**
     * Early Hints
     *
     * @var integer
     */
    const CODE_103 = 103;

    /**
     * OK
     *
     * @var integer
     */
    const CODE_200 = 200;

    /**
     * Created
     *
     * @var integer
     */
    const CODE_201 = 201;

    /**
     * Accepted
     *
     * @var integer
     */
    const CODE_202 = 202;

    /**
     * Non-Authoritative Information
     *
     * @var integer
     */
    const CODE_203 = 203;

    /**
     * No Content
     *
     * @var integer
     */
    const CODE_204 = 204;

    /**
     * Reset Content
     *
     * @var integer
     */
    const CODE_205 = 205;

    /**
     * Partial Content
     *
     * @var integer
     */
    const CODE_206 = 206;

    /**
     * Multi-Status
     * @var integer
     */
    const CODE_207 = 207;

    /**
     * Already Reported
     *
     * @var integer
     */
    const CODE_208 = 208;

    /**
     * IM Used
     *
     * @var integer
     */
    const CODE_226 = 226;

    /**
     * Multiple Choices
     *
     * @var integer
     */
    const CODE_300 = 300;

    /**
     * Moved Permanently
     *
     * @var integer
     */
    const CODE_301 = 301;

    /**
     * Found
     *
     * @var integer
     */
    const CODE_302 = 302;

    /**
     * See Other
     *
     * @var integer
     */
    const CODE_303 = 303;

    /**
     * Not Modified
     *
     * @var integer
     */
    const CODE_304 = 304;

    /**
     * Use Proxy
     *
     * @var integer
     */
    const CODE_305 = 305;

    /**
     * Temporary Redirect
     *
     * @var integer
     */
    const CODE_307 = 307;

    /**
     * Permanent Redirect
     *
     * @var integer
     */
    const CODE_308 = 308;

    /**
     * Bad Request
     *
     * @var integer
     */
    const CODE_400 = 400;

    /**
     * Unauthorized
     *
     * @var integer
     */
    const CODE_401 = 401;

    /**
     * Payment Required
     *
     * @var integer
     */
    const CODE_402 = 402;

    /**
     * Forbidden
     *
     * @var integer
     */
    const CODE_403 = 403;

    /**
     * Not Found
     *
     * @var integer
     */
    const CODE_404 = 404;

    /**
     * Method Not Allowed
     *
     * @var integer
     */
    const CODE_405 = 405;

    /**
     * Not Acceptable
     *
     * @var integer
     */
    const CODE_406 = 406;

    /**
     * Proxy Authentication Required
     *
     * @var integer
     */
    const CODE_407 = 407;

    /**
     * Request Timeout
     *
     * @var integer
     */
    const CODE_408 = 408;

    /**
     * Conflict
     *
     * @var integer
     */
    const CODE_409 = 409;

    /**
     * Gone
     *
     * @var integer
     */
    const CODE_410 = 410;

    /**
     * Length Required
     *
     * @var integer
     */
    const CODE_411 = 411;

    /**
     * Precondition Failed
     *
     * @var integer
     */
    const CODE_412 = 412;

    /**
     * Payload Too Large
     *
     * @var integer
     */
    const CODE_413 = 413;

    /**
     * URI Too Long
     *
     * @var integer
     */
    const CODE_414 = 414;

    /**
     * Unsupported Media Type
     *
     * @var integer
     */
    const CODE_415 = 415;

    /**
     * Range Not Satisfiable
     *
     * @var integer
     */
    const CODE_416 = 416;

    /**
     * Expectation Failed
     *
     * @var integer
     */
    const CODE_417 = 417;

    /**
     * I\'m a teapot
     *
     * @var integer
     */
    const CODE_418 = 418;

    /**
     * Misdirected Request
     *
     * @var integer
     */
    const CODE_421 = 421;

    /**
     * Unprocessable Entity
     *
     * @var integer
     */
    const CODE_422 = 422;

    /**
     * Locked
     *
     * @var integer
     */
    const CODE_423 = 423;

    /**
     * Failed Dependency
     *
     * @var integer
     */
    const CODE_424 = 424;

    /**
     * Too Early
     *
     * @var integer
     */
    const CODE_425 = 425;

    /**
     * Upgrade Required
     *
     * @var integer
     */
    const CODE_426 = 426;

    /**
     * Precondition Required
     *
     * @var integer
     */
    const CODE_428 = 428;

    /**
     * Too Many Requests
     *
     * @var integer
     */
    const CODE_429 = 429;

    /**
     * Request Header Fields Too Large
     *
     * @var integer
     */
    const CODE_431 = 431;

    /**
     * Unavailable For Legal Reasons
     *
     * @var integer
     */
    const CODE_451 = 451;

    /**
     * Internal Server Error
     *
     * @var integer
     */
    const CODE_500 = 500;

    /**
     * Not Implemented
     *
     * @var integer
     */
    const CODE_501 = 501;

    /**
     * Bad Gateway
     *
     * @var integer
     */
    const CODE_502 = 502;

    /**
     * Service Unavailable
     *
     * @var integer
     */
    const CODE_503 = 503;

    /**
     * Gateway Timeout
     *
     * @var integer
     */
    const CODE_504 = 504;

    /**
     * HTTP Version Not Supported
     *
     * @var integer
     */
    const CODE_505 = 505;

    /**
     * Variant Also Negotiates
     *
     * @var integer
     */
    const CODE_506 = 506;

    /**
     * Insufficient Storage
     *
     * @var integer
     */
    const CODE_507 = 507;

    /**
     * Loop Detected
     *
     * @var integer
     */
    const CODE_508 = 508;

    /**
     * Not Extended
     *
     * @var integer
     */
    const CODE_510 = 510;

    /**
     * Network Authentication Required
     *
     * @var integer
     */
    const CODE_511 = 511;
}
