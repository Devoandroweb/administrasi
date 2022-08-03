<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait Uploader
{
    public function uploadImage($dir, $file)
    {
        $result = null;
        $namaFile = time() . "_" . $file->getClientOriginalName();
        $ext = $file->getClientOriginalExtension();
        $filename = $file->move($dir, $namaFile . '.' . $ext);
        $result = $filename->getFileName();
        return $result;
    }
}