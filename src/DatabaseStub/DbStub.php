<?php


namespace App\DatabaseStub;


class DbStub {
    private array $rules;

    public function __construct()
    {
        $file = file_get_contents(__DIR__."/rules.json");
        $this->rules = json_decode($file, true);
    }

    public function getRules()
    {
        return $this->rules;
    }

    public function where(array $search)
    {
        $arr = [];
        foreach ($this->rules as $el){
            if ($this->isEqual($el, $search)) {
                $arr[] = $el;
            }
        }
        return $arr;
    }

    private function isEqual($el, $search){
        foreach ($search as $key => $val) {
            if (!array_key_exists($key, $el)) {
                return false;
            }
            if ($el[$key] !== $val) {
                return false;
            }
        }
        return true;
    }
}