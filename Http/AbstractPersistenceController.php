<?php

declare(strict_types=1);

namespace DeviTools\Http;

use DeviTools\Http\Support\Prepare;
use DeviTools\Persistence\RepositoryInterface;

/**
 * Class AbstractPersistenceController
 *
 * @package DeviTools\Http
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