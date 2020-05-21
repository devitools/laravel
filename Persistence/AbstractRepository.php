<?php

declare(strict_types=1);

namespace App\Persistence;

use App\Units\Common\Instance;
use App\Persistence\Repository\Basic;
use App\Persistence\Repository\Count;
use App\Persistence\Repository\Create;
use App\Persistence\Repository\Destroy;
use App\Persistence\Repository\Helper;
use App\Persistence\Repository\Prepare;
use App\Persistence\Repository\Read;
use App\Persistence\Repository\Restore;
use App\Persistence\Repository\Search;
use App\Persistence\Repository\Update;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class AbstractRepository
 *
 * @package Simples
 */
abstract class AbstractRepository implements RepositoryInterface
{
    /**
     * Helpers
     */
    use Helper;
    use Instance;

    /**
     * Support
     */
    use Basic;
    use Prepare;
    use Count;

    /**
     * Basic operations
     */
    use Create;
    use Read;
    use Update;
    use Destroy;

    /**
     * Extra operations
     */
    use Restore;
    use Search;

    /**
     * @var ModelInterface
     */
    protected $model;

    /**
     * @var string
     */
    protected string $prototype;

    /**
     * PHP 5 allows developers to declare constructor methods for classes.
     * Classes which have a constructor method call this method on each newly-created object,
     * so it is suitable for any initialization that the object may need before it is used.
     * Note: Parent constructors are not called implicitly if the child class defines a constructor.
     * In order to run a parent constructor, a call to parent::__construct() within the child constructor is required.
     * param [ mixed $args [, $... ]]
     *
     * @link http://php.net/manual/en/language.oop5.decon.php
     *
     * @param ModelInterface $model
     */
    public function __construct(ModelInterface $model = null)
    {
        if (!$model) {
            /** @noinspection CallableParameterUseCaseInTypeContextInspection */
            $model = app($this->prototype);
        }
        $this->model = $model;
    }

    /**
     * @return array
     */
    public function getFilterable(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function getManyToOne(): array
    {
        return $this->model->manyToOne();
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return $this->model->newQuery();
    }

    /**
     * @return array|string[]
     */
    public function getDefaults(): array
    {
        return $this->model->getDefaults();
    }
}
