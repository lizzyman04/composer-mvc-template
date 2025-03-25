<?php

namespace Core;

class Uploader
{
    /**
     * Uploads an image to the specified target directory.
     *
     * @param mixed $file The uploaded file (either an instance of UploadedFile or a regular file array).
     * @param string $targetDir The directory where the file will be uploaded.
     * @param string|null $currentImage The current image, used when updating the image (optional).
     * @return string The path to the uploaded file.
     * @throws \Exception If there is an error in uploading.
     */
    public static function uploadImage($file, $targetDir, $currentImage = null)
    {
        if ($file instanceof \Illuminate\Http\UploadedFile && $file->isValid()) {
            $fileName = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9\._-]/', '', $file->getClientOriginalName());
            $targetPath = $targetDir . '/' . $fileName;

            if (!is_dir($targetDir) && !mkdir($targetDir, 0755, true) && !is_dir($targetDir)) {
                throw new \Exception("Error creating the directory: $targetDir");
            }

            if (!$file->move($targetDir, $fileName)) {
                throw new \Exception("Error moving the file.");
            }

            return $targetPath;
        }

        if (isset($file) && is_array($file) && $file['error'] === UPLOAD_ERR_OK) {
            $fileName = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9\._-]/', '', $file['name']);
            $targetPath = $targetDir . '/' . $fileName;

            if (!is_dir($targetDir) && !mkdir($targetDir, 0755, true) && !is_dir($targetDir)) {
                throw new \Exception("Error creating the directory: $targetDir");
            }

            if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
                throw new \Exception("Error moving the file.");
            }

            return $targetPath;
        }

        return $currentImage;
    }
}
