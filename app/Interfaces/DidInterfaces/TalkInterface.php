<?php

namespace App\Interfaces\DidInterfaces;

interface TalkInterface {

    public function createTalk(String $title, String $content, String $imageUrl, array $emotions);
    public function getTalks();
    public function getTalk(String $id);
    public function deleteTalk(String $id);
    public function getVoices();

}