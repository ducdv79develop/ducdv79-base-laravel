<?php

namespace App\Http\Controllers\Api;

use App\Helpers\GoogleDriveHelpers;
use App\Http\Controllers\Controller;
use App\Config\AppConstants;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoogleDriverController extends Controller
{
    private $bindingDir;
    private $bindingType;

    /**
     * GoogleDriverController constructor.
     */
    public function __construct()
    {
        $this->setBindingDir();
        $this->setBindingType();
    }

    public function getImage()
    {

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadImage(Request $request): JsonResponse
    {
        try {
            if (!$request->has('file')) {
                return $this->jsonResponse(false, 'file upload not found');
            }
            if (!$request->has('type') || !key_exists($request->get('type'), $this->bindingDir)) {
                return $this->jsonResponse(false, 'type upload not found');
            }
            $file = $request->file('file');
            $dir = $this->bindingDir[$request->get('type')];
            $hashName = explode('.', $file->hashName());
            $filename = $hashName[0];
            $extension = $hashName[1];

            GoogleDriveHelpers::upload("$dir/$filename.$extension", $file->getContent());
            $files = GoogleDriveHelpers::listFiles($dir);
            $fileUp = $files->where('type', '=', 'file')
                ->where('filename', '=', $filename)
                ->where('extension', '=', $extension)
                ->first();
            GoogleDriveHelpers::publicFile($fileUp['basename']);
            $ids = DB::table('images')->insertGetId([
                'type' => $this->bindingType[$request->get('type')],
                'path' => $fileUp['basename'],
                'name' => $file->getClientOriginalName(),
                'created_at' => date('Y-m-d H:i:s')
            ]);
            return $this->jsonResponse(true, 'upload success', ['image_id' => $ids]);
        } catch (Exception $exception) {
            $this->writeLogError($exception, 'uploadImage');
            return $this->jsonResponse(false, 'upload file error');
        }
    }

    public function deleteImage()
    {

    }

    private function setBindingDir()
    {
        $this->bindingDir = [
            'avatar' => config('settings.google_drive.storage.avatar'),
            'banner' => config('settings.google_drive.storage.banner'),
            'category' => config('settings.google_drive.storage.category'),
            'event' => config('settings.google_drive.storage.event'),
            'export' => config('settings.google_drive.storage.export'),
            'product' => config('settings.google_drive.storage.product'),
            'upload' => config('settings.google_drive.storage.upload'),
        ];
    }

    private function setBindingType()
    {
        $this->bindingType = [
            'avatar' => AppConstants::IMG_TYPE_NONE,
            'banner' => AppConstants::IMG_TYPE_BANNER,
            'category' => AppConstants::IMG_TYPE_CATEGORY,
            'event' => AppConstants::IMG_TYPE_EVENT,
            'export' => AppConstants::IMG_TYPE_NONE,
            'product' => AppConstants::IMG_TYPE_PRODUCT,
            'upload' => AppConstants::IMG_TYPE_NONE,
        ];
    }
}
