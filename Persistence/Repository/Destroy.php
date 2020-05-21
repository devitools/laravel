<?php

declare(strict_types=1);

namespace App\Persistence\Repository;

use Exception;
use App\Persistence\AbstractModel;

/**
 * Trait Destroy
 *
 * @package App\Persistence\Repository
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