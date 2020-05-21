<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Persistence\RepositoryInterface;

/**
 * Class AbstractPersistenceController
 *
 * @package App\Http
 */
class AbstractPersistenceController extends AbstractController
{
    /**
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * AbstractPersistenceController constructor.
     *
     * @param RepositoryInterface $repository
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return RepositoryInterface
     */
    final protected function repository(): RepositoryInterface
    {
        return $this->repository;
    }
}