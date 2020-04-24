<?php

declare(strict_types=1);

namespace DeviTools\Http;

use DeviTools\Http\Rest\Create;
use DeviTools\Http\Rest\Destroy;
use DeviTools\Http\Rest\Read;
use DeviTools\Http\Rest\Restore;
use DeviTools\Http\Rest\Search;
use DeviTools\Http\Rest\Update;

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
