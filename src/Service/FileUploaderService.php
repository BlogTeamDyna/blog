<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploaderService
{
    public function __construct(public string $uploadsDirectory,private SluggerInterface $slugger)
    {}
    public function upload (UploadedFile $file): string
    {
        $fileSystem = new Filesystem();
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
        $fileSystem->mkdir($this->uploadsDirectory);
        try {
            $file->move(
                $this->uploadsDirectory,
                $newFilename
            );

        } catch (FileException $e) {
            return $e->getMessage();
        }

        return $newFilename;

    }
}
