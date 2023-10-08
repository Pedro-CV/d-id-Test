<?php

namespace App\Interfaces\DidInterfaces;

interface ImageInterface {
    public function uploadImage(String $path);
    public function deleteImage(String $id);
}

