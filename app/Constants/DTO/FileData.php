<?php

namespace App\Constants\DTO;

use DateTime;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\UploadedFile;

class FileData
{
    /** @var UploadedFile */
    private $file;

    /** @var string|null */
    private $mimeType;

    /** @var string|null */
    private $filename;

    /** @var string|null */
    private $category;

    /** @var string|null */
    private $alt;

    public function __construct($file, string $category)
    {
        $this->file = $file;

        $this->mimeType = $this->file->getClientMimeType();

        $uuid = Uuid::fromDateTime(new DateTime());

        $extension = $this->file->getClientOriginalExtension();
        $this->filename = $uuid . '.' . $extension;

        $this->category = $category;

        $this->alt = json_encode([strtolower(app()->getLocale()) => $this->filename]);
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }
}
