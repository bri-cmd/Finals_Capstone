<?php

namespace App\Services;

use Google_Client;
use Google\Service\Drive as Google_Service_Drive;
use Google\Service\Drive\DriveFile as Google_Service_Drive_DriveFile;
use Google\Service\Drive\Permission as Google_Service_Drive_Permission;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class GoogleDriveUploader
{
    protected Google_Service_Drive $drive;

    public function __construct()
    {
        $client = new Google_Client();
        $client->setClientId(config('filesystems.disks.google.clientId'));
        $client->setClientSecret(config('filesystems.disks.google.clientSecret'));
        $client->refreshToken(config('filesystems.disks.google.refreshToken'));

        $this->drive = new Google_Service_Drive($client);
    }

    public function upload(UploadedFile $file, string $folderId): string
    {
        $filename = time() . '_' . pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.' . $file->getClientOriginalExtension();

        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name' => $filename,
            'parents' => [$folderId],
        ]);

        $uploaded = $this->drive->files->create($fileMetadata, [
            'data' => file_get_contents($file->getRealPath()),
            'uploadType' => 'multipart',
            'fields' => 'id',
        ]);

        $permission = new Google_Service_Drive_Permission([
            'type' => 'anyone',
            'role' => 'reader',
        ]);

        $this->drive->permissions->create($uploaded->id, $permission);

        return $uploaded->id;
    }

    public function delete(string $fileId): void
    {
        $client = new \Google_Client();
        $client->setClientId(config('filesystems.disks.google.clientId'));
        $client->setClientSecret(config('filesystems.disks.google.clientSecret'));
        $client->refreshToken(config('filesystems.disks.google.refreshToken'));

        $drive = new Google_Service_Drive($client);

        try {
            $drive->files->delete($fileId);
        } catch (\Exception $e) {
            // Optional: log error or ignore if file already deleted
            Log::warning("Failed to delete Google Drive file: {$fileId}. Error: " . $e->getMessage());
        }
    }

}