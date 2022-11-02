<?php

namespace App\Helpers;

use App\Exceptions\GoogleDriveException;
use Exception;
use Google_Service_Drive_Permission;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Config;
use League\Flysystem\FileNotFoundException;

class GoogleDriveHelpers
{
    const DISK = 'google';
    const GET_CHILD = true;
    const NO_GET_CHILD = false;

    /**
     * @param $path
     * @return string
     * @throws GoogleDriveException
     */
    public static function getUrl($path): string
    {
        try {
            list ($directory, $basename) = self::getBasename($path);
            return Storage::disk(self::DISK)->url($basename);
        } catch (Exception $exception) {
            $message = throwExceptionCustom($exception, "[GoogleDriveHelpers][getUrl]");
            throw new GoogleDriveException($message, $exception->getCode());
        }
    }

    /**
     * @param $path
     * @return string
     */
    public static function getImage($path): string
    {
        list ($directory, $basename) = self::getBasename($path);

        return config('settings.google_drive.url') . $basename;
    }

    /**
     * Get file by path
     * @param string $path
     * @return array
     * @throws GoogleDriveException|FileNotFoundException
     */
    public static function getFile(string $path): array
    {
        return Storage::disk(self::DISK)->getMetadata($path);
    }

    /**
     * Get contents data file in directory
     * @param string $directory
     * @param bool $recursive
     * @return Collection
     */
    public static function listFiles(string $directory, bool $recursive = self::NO_GET_CHILD): Collection
    {
        return collect(Storage::disk(self::DISK)->listContents($directory, $recursive));
    }

    /**
     * @param $path
     * @return false|string
     * @throws GoogleDriveException
     */
    public static function read($path)
    {
        try {
            $response = Storage::disk(self::DISK)->read($path);
            if (empty($response)) {
                return null;
            }
            return $response;
        } catch (Exception $exception) {
            $message = throwExceptionCustom($exception, "[GoogleDriveHelpers][read]");
            throw new GoogleDriveException($message, $exception->getCode());
        }
    }

    /**
     * @param $path
     * @param $contents
     * @param array $config
     * @return bool
     * @throws GoogleDriveException
     */
    public static function upload($path, $contents, array $config = array()): bool
    {
        try {
            return Storage::disk(self::DISK)->put($path, $contents, $config);
        } catch (Exception $exception) {
            $message = throwExceptionCustom($exception, "[GoogleDriveHelpers][upload]");
            throw new GoogleDriveException($message, $exception->getCode());
        }
    }

    /**
     * @param $path
     * @param $contents
     * @param Config $config
     * @return bool
     * @throws GoogleDriveException
     */
    public static function update($path, $contents, Config $config): bool
    {
        try {
            return Storage::disk(self::DISK)->update($path, $contents, $config);
        } catch (Exception $exception) {
            $message = throwExceptionCustom($exception, "[GoogleDriveHelpers][update]");
            throw new GoogleDriveException($message, $exception->getCode());
        }
    }

    /**
     * @param $path
     * @param $new_path
     * @return bool
     * @throws GoogleDriveException
     */
    public static function move($path, $new_path): bool
    {
        try {
            return Storage::disk(self::DISK)->rename($path, $new_path);
        } catch (Exception $exception) {
            $message = throwExceptionCustom($exception, "[GoogleDriveHelpers][move]");
            throw new GoogleDriveException($message, $exception->getCode());
        }
    }

    /**
     * @param $path
     * @param $new_path
     * @return bool
     * @throws GoogleDriveException
     */
    public static function copy($path, $new_path): bool
    {
        try {
            return Storage::disk(self::DISK)->copy($path, $new_path);
        } catch (Exception $exception) {
            $message = throwExceptionCustom($exception, "[GoogleDriveHelpers][copy]");
            throw new GoogleDriveException($message, $exception->getCode());
        }
    }

    /**
     * @param $path
     * @return bool
     * @throws GoogleDriveException
     */
    public static function delete($path): bool
    {
        try {
            return Storage::disk(self::DISK)->delete($path);
        } catch (Exception $exception) {
            $message = throwExceptionCustom($exception, "[GoogleDriveHelpers][delete]");
            throw new GoogleDriveException($message, $exception->getCode());
        }
    }

    /**
     * @param $basename
     * @param $directory
     * @return bool
     * @throws GoogleDriveException
     */
    public static function deleteBasename($basename, $directory): bool
    {
        try {
            $contents = self::listFiles($directory);
            $file = $contents->where('type', '=', 'file')
                ->where('basename', '=', $basename)
                ->first();

            Storage::disk(self::DISK)->delete($file['path']);
            return true;
        } catch (Exception $exception) {
            $message = throwExceptionCustom($exception, "[GoogleDriveHelpers][deleteBasename]");
            throw new GoogleDriveException($message, $exception->getCode());
        }
    }

    /**
     * Delete directory.
     * @param $path
     * @return bool
     * @throws GoogleDriveException
     */
    public static function deleteDirectory($path): bool
    {
        try {
            return Storage::disk(self::DISK)->deleteDirectory($path);
        } catch (Exception $exception) {
            $message = throwExceptionCustom($exception, "[GoogleDriveHelpers][deleteDirectory]");
            throw new GoogleDriveException($message, $exception->getCode());
        }
    }

    /**
     * Make directory.
     * @param $new_path
     * @param Config $config
     * @return bool
     * @throws GoogleDriveException
     */
    public static function makeDirectory($new_path, Config $config): bool
    {
        try {
            return Storage::disk(self::DISK)->createDir($new_path, $config);
        } catch (Exception $exception) {
            $message = throwExceptionCustom($exception, "[GoogleDriveHelpers][makeDirectory]");
            throw new GoogleDriveException($message, $exception->getCode());
        }
    }

    /**
     * Allow anyone to read this file
     * @param string $basename // ID file or path file (basename)
     */
    public static function publicFile(string $basename)
    {
        $service = Storage::disk(self::DISK)->getAdapter()->getService();
        $permission = new Google_Service_Drive_Permission();
        $permission->setRole('reader'); // organizer | owner | writer | commenter | reader
        $permission->setType('anyone'); // user | group | domain | anyone
        $permission->setAllowFileDiscovery(false); // don't access to drive storage
        $service->permissions->create($basename, $permission);
    }

    /**
     * @return string
     */
    protected static function filenameGenerator(): string
    {
        $now = date('YmdHis');
        $random = rand(10, 99);
        return adminInfo(ADM_TEAM_ID) . "_{$now}_$random";
    }

    /**
     * @param string $path
     * @param bool $getParentId
     * @return array
     */
    protected static function getBasename(string $path, bool $getParentId = true): array
    {
        if ($path === '' || $path === '/') {
            $fileName = 'root';
            $dirName = '';
        } else {

            $paths = explode('/', $path);
            $fileName = array_pop($paths);
            if ($getParentId) {
                $dirName = $paths ? array_pop($paths) : '';
            } else {
                $dirName = join('/', $paths);
            }
            if ($dirName === '') {
                $dirName = 'root';
            }
        }
        return [
            $dirName,
            $fileName
        ];
    }

    /**
     * @param $file
     * @param bool $get_request
     * @return array|null
     * @throws GoogleDriveException
     */
    public static function uploadAvatar($file, bool $get_request = true): ?array
    {
        $content = null;
        $extension = null;
        if ($get_request) {
            if (request()->hasFile($file)) {
                $file = request()->file($file);
                $content = $file->getContent();
                $extension = $file->getExtension();
            }
        } else {
            $content = $file;
            $extension = 'png';
        }

        if ($content && $extension) {
            $filename = self::filenameGenerator();
            $dir = config('settings.google_drive.storage.avatar');
            $path = "$dir/$filename.$extension";
            self::upload($path, $content);
            $files = self::listFiles($dir);
            $file = $files->where('type', '=', 'file')
                ->where('filename', '=', $filename)
                ->where('extension', '=', $extension)
                ->first();
            self::publicFile($file['basename']);
            return $file;
        }
        return null;
    }
}
