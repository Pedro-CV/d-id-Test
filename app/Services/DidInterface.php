<?php

namespace App\Services;

interface DidInterface {

    public function createTalk(String $title, String $content, array $emotions);
    public function getTalks();
    public function getTalk(String $id);
    public function deleteTalk(String $id);

    public function uploadImage(String $path);
    public function deleteImage(String $id);

}