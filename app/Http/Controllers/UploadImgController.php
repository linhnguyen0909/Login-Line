<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

/**
 * Class UploadImgController
 * @package App\Http\Controllers
 */
class UploadImgController extends Controller
{
    /**
     * @var
     */
    private $name;
    /**
     * @var
     */
    private $extension;

    /**
     * @param  Request  $request
     */
    public function uploadImage(Request $request)
    {
        $file = $request->file('image');
        $fileInfo = pathinfo($file->getClientOriginalName());
        $path = Carbon::now()->format('Y/m/d');
        $this->setFileName($path, $fileInfo);
        $request->file('image')->storeAs($path.'/', $this->name);
        $this->imageThumbnail($file, $path);
    }

    /**
     * @param $file
     * @param $path
     */
    public function imageThumbnail($file, $path)
    {
        $thumbnail = Image::make($file)
            ->fit(200, 300)->encode($this->extension);
        Storage::put($path.'/'.'thumbnail/thumbnail_'.$this->name, $thumbnail->__tostring());
    }

    /**
     * @param $path
     * @param $fileInfo
     */
    public function setFileName($path, $fileInfo)
    {
        $i = 0;
        do {
            $fileName = $fileInfo['filename'].($i ? "_($i)" : "").".".$fileInfo['extension'];
            $i++;
            $pathInfo = storage_path('app/'.$path.'/'.$fileName);
        } while (file_exists($pathInfo));
        $this->name = $fileName;
    }
    //    public function setFileName($path, $fileInfo)
//    {
//        $this->name = $fileInfo['filename'];
//        $this->extension = $fileInfo['extension'];
//        if (Storage::disk('local')->exists($path)) {
//            //lấy tất cả file
//            $pathFiles = storage_path('app/'.$path);
//            $arrFileName = scandir($pathFiles,1);
//            //xét rule cho file name
//            $ruleRegex = '/('.$this->name.'[0-9]{0,})(\.)('.$this->extension.'$)/';
//            //lộc file name theo rule
//            $arrFileName = array_filter($arrFileName, function ($file) use ($ruleRegex) {
//                if (preg_match($ruleRegex, $file)) {
//                    return $file;
//                }
//            });
//            // trả về mảng đã đươc lộc
//            if ($arrFileName) {
//                // tìm max trong file name
//                $lastFileName = max($arrFileName);
//
//                $stt = str_replace('image', '', $lastFileName);
//                $this->name .= (intval($stt) + 1).'.'.$this->extension;
//            } else {
//                $this->name .= '.'.$this->extension;
//            }
//        } else {
//            $this->name .= '.'.$this->extension;
//        }
//    }
}
