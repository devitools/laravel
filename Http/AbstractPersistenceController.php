<?php

declare(strict_types=1);

namespace Simples\Http;

use Illuminate\Http\Request;
use Simples\Persistence\AbstractRepository;
use Simples\Persistence\RepositoryInterface;

/**
 * Class AbstractPersistenceController
 *
 * @package App\Http\Controllers\Api
 */
class AbstractPersistenceController extends AbstractController
{
    /**
     * @var AbstractRepository
     */
    protected $repository;

    /**
     * @var Request
     */
    protected $request;

    /**
     * AbstractRestController constructor.
     *
     * @param RepositoryInterface $repository
     * @param Request $request [null]
     */
    public function __construct(RepositoryInterface $repository, Request $request = null)
    {
        $this->repository = $repository;
        $this->request = $request;
    }

    /**
     * @return RepositoryInterface
     */
    final protected function repository(): RepositoryInterface
    {
        return $this->repository;
    }
}