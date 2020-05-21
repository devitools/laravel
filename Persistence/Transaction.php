<?php

declare(strict_types=1);

namespace App\Persistence;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

use function PhpBrasil\Collection\Helper\prop;

/**
 * Class Transaction
 *
 * @package App\Persistence
 */
abstract class Transaction
{
    /**
     * @var bool
     */
    private static bool $force = false;

    /**
     * @return void
     */
    public static function force(): void
    {
        static::$force = true;
    }

    /**
     * @return void
     */
    public static function start(): void
    {
        DB::beginTransaction();
    }

    /**
     * @return void
     */
    public static function commit(): void
    {
        if (!DB::transactionLevel()) {
            return;
        }
        DB::commit();
        DB::beginTransaction();
    }

    /**
     * @param int|Response $context
     */
    public static function finish($context): void
    {
        if (!DB::transactionLevel()) {
            return;
        }

        if (static::isForce($context)) {
            DB::commit();
            return;
        }

        if (static::isError($context)) {
            DB::rollBack();
            return;
        }
        DB::commit();
    }

    /**
     * @param int|Response $context
     *
     * @return bool
     */
    private static function isForce($context): bool
    {
        if (static::$force) {
            return true;
        }
        if ($context instanceof JsonResponse) {
            return (bool)prop($context->getData(), 'commit');
        }
        return false;
    }

    /**
     * @param int|Response $context
     *
     * @return bool
     */
    private static function isError($context): bool
    {
        if ($context instanceof JsonResponse) {
            return ($context->isClientError() || $context->isServerError());
        }
        return $context === 1;
    }
}