<?php

declare(strict_types=1);

namespace Simples\Http;

use Simples\Http\Rest\Create;
use Simples\Http\Rest\Destroy;
use Simples\Http\Rest\Read;
use Simples\Http\Rest\Restore;
use Simples\Http\Rest\Search;
use Simples\Http\Rest\Update;

/**
 * Class AbstractRestController
 *
 * @package App\Http\Controllers\Api
 */
abstract class AbstractRestController extends AbstractPersistenceController implements RestControllerInterface
{
    /**
     * Basic operations
     */
    use Create;
    use Destroy;
    use Read;
    use Restore;
    use Search;
    use Update;
}
