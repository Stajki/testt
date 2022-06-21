<?php

namespace App\Services;

use App\Constants\ImageMimeTypes;
use App\Models\File;
use Illuminate\Support\Str;
use App\Constants\DTO\FileData;
use App\Constants\FileMimeTypes;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UploadFileService
{
    private $fileData;

    public function uploadImage($file, string $category)
    {
        $this->fileData = new FileData($file, $category);

        $this->createTempFile();

        return File::create([
            'file_name' => $this->fileData->getFilename(),
            'original_name' => $this->fileData->getFile()->getClientOriginalName(),
            'fingerprint' => sha1(Str::random(10)),
            'category' => $this->fileData->getCategory(),
            'alt' => $this->fileData->getAlt(),
            'mime_type' => $this->fileData->getMimeType(),
        ]);
    }

    private function createTempFile(): void
    {
        if ($this->fileData->getMimeType() === 'application/octet_stream') {
            throw new BadRequestHttpException('File is too big.');
        }

        if (
            !in_array($this->fileData->getMimeType(), FileMimeTypes::SUPPORTED, true)
            && !in_array($this->fileData->getMimeType(), ImageMimeTypes::SUPPORTED, true)
        ) {
            throw new BadRequestHttpException('Unsupported file type.');
        }

        $tempFilename = storage_path('app/public') . '/' . $this->fileData->getFilename();
        file_put_contents($tempFilename, file_get_contents($this->fileData->getFile()));
        unlink($this->fileData->getFile());
    }
}
