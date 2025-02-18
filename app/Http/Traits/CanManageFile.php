<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait CanManageFile
{
    protected ?string $resourceName = null;

    protected array $fileFieldNames;

    protected array $fileFolderPaths;

    /**
     * Store multiple files.
     */
    protected function storeFiles(Request $request, Model $model, string $disk = 'public'): void {
        foreach ($this->fileFieldNames as $i => $fieldName) {
            if ($request->hasFile($fieldName)) {
                $folderPath = $this->buildFolderPath($this->fileFolderPaths[$i] ?? $fieldName);
                $model->{$fieldName} = $this->storeFile($request->file($fieldName), $folderPath, $disk);
            }
        }
    }

    /**
     * Build the folder path, optionally prepending the resource name if it is set.
     */
    protected function buildFolderPath(string $folderPath): string {
        return $this->resourceName ? $this->resourceName.'/'.$folderPath : $folderPath;
    }

    /**
     * Store a single file.
     */
    public function storeFile($file, string $folderPath, string $disk = 'public'): string {
        // generate a unique name for the file.
        $fileName = time().$file->hashName();

        // store the file in the desired folder on the specified disk.
        $file->storeAs($folderPath, $fileName, $disk);

        return $fileName;
    }

    /**
     * Update multiple files.
     */
    protected function updateFiles(Request $request, Model $model, string $disk = 'public'): void {
        foreach ($this->fileFieldNames as $i => $fieldName) {
            if ($request->hasFile($fieldName)) {
                // delete old file if exists
                $folderPath = $this->buildFolderPath($this->fileFolderPaths[$i] ?? $fieldName);
                $this->deleteFile($model[$fieldName], $folderPath, $disk);
                // upload new file
                $model->{$fieldName} = $this->storeFile($request->file($fieldName), $folderPath, $disk);
            }
        }
    }

    /**
     * Delete a single file.
     */
    public function deleteFile(?string $fileName, string $folderPath, string $disk = 'public'): void {
        if ($fileName) {
            $filePath = $folderPath.'/'.$fileName;
            // delete the file if it exists on the disk.
            if (Storage::disk($disk)->exists($filePath)) {
                Storage::disk($disk)->delete($filePath);
            }
        }
    }

    /**
     * Delete multiple files.
     */
    protected function deleteFiles(Model $model, string $disk = 'public'): void {
        foreach ($this->fileFieldNames as $i => $fieldName) {
            $folderPath = $this->buildFolderPath($this->fileFolderPaths[$i] ?? $fieldName);
            $this->deleteFile($model[$fieldName], $folderPath, $disk);
        }
    }
}
