<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Rest\Create;
use App\Http\Controllers\Rest\Destroy;
use App\Http\Controllers\Rest\Read;
use App\Http\Controllers\Rest\Restore;
use App\Http\Controllers\Rest\Search;
use App\Http\Controllers\Rest\Update;
use App\Http\Support\Permission;

/**
 * Class AbstractRestController
 *
 * @package App\Http
 */
abstract class AbstractRestController extends AbstractPersistenceController implements RestControllerInterface
{
    /**
     * Support
     */
    use Permission;

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
