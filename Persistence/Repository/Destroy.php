<?php

declare(strict_types=1);

namespace Devitools\Persistence\Repository;

use Devitools\Persistence\AbstractModel;
use Exception;

/**
 * Trait Destroy
 *
 * @package Devitools\Persistence\Repository
 */
trait Destroy
{
    /**
     * @param string $id
     * @param bool $erase
     *
     * @return string
     * @throws Exception
     */
    public function destroy(string $id, $erase = false): ?string
    {
        /** @var AbstractModel $instance */
        $instance = $this->pull($id, (bool)$erase);
        if ($instance === null) {
            return null;
        }
        if ($erase) {
            $instance->forceDelete();
            return $id;
        }
        $instance->delete();
        return $id;
    }
}