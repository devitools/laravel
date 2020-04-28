<?php

declare(strict_types=1);

namespace DeviTools\Http;

use DeviTools\Exceptions\ErrorExternalIntegration;
use DeviTools\Persistence\AbstractRepository;
use DeviTools\Persistence\RepositoryInterface;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class AbstractPersistenceController
 *
 * @package DeviTools\Http
 */
class AbstractPersistenceController extends AbstractController
{
    /**
     * @var AbstractRepository
     */
    protected $repository;

    /**
     * AbstractRestController constructor.
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

    /**
     * @param string $id
     * @param array $data
     *
     * @return array
     * @throws ErrorExternalIntegration
     */
    public function prepareRecord(string $id, array $data): array
    {
        foreach ($data as $field => &$value) {
            if ($value instanceof UploadedFile) {
                $value = $this->parseFile($id, $field, $value);
            }
        }
        return $data;
    }

    /**
     * @param string $id
     * @param string $field
     * @param UploadedFile $file
     *
     * @return string
     * @throws ErrorExternalIntegration
     */
    protected function parseFile(string $id, string $field, UploadedFile $file): string
    {
        $domain = $this->repository()->prefix();
        $extension = $file->getClientOriginalExtension();
        $path = "{$domain}/$id/{$field}";
        if (!Storage::disk('minio')->put($path, File::get($file->getRealPath()))) {
            throw new ErrorExternalIntegration('Cloud storage not available');
        }
        return "{$domain}/$id/{$field}.{$extension}";
    }

}