<?php
namespace App\Http\Controllers;

use App\Services\Upload;
use Config;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function server(Request $request)
    {
        $config = Config::get('UEditorUpload.upload');
        $action = $request->get('action');

        switch ($action) {
            case 'image':
                echo 555;
                break;
            case 'video':
                $upConfig = array(
                    "pathFormat" => $config['videoPathFormat'],
                    "maxSize" => $config['videoMaxSize'],
                    "allowFiles" => $config['videoAllowFiles'],
                    'fieldName' => $config['videoFieldName'],
                );
                $result = with(new Upload($upConfig, $request))->upload();
                break;
            case 'file':
                $upConfig = array(
                    "pathFormat" => $config['filePathFormat'],
                    "maxSize" => $config['fileMaxSize'],
                    "allowFiles" => $config['fileAllowFiles'],
                    'fieldName' => $config['fileFieldName'],
                );
                $result = with(new Upload($upConfig, $request))->upload();
                break;
            default:
                $data = ['code' => -200, 'msg' => '上传失败'];
                return response()->json($data);
        }

        return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
    }
}
