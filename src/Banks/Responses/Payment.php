<?php


namespace App\Banks\Responses;


class Payment
{
    public const STATUS_FAILED = 1;
    public const STATUS_COMPLETED = 2;

    private $status;
    private bool $needNotify;

    public function __construct($status, $needNotify = false)
    {
        $this->status = $status;
        $this->needNotify = $needNotify;
    }

    public function isFailed(): bool
    {
        return $this->status == self::STATUS_FAILED;
    }

    public function isCompleted(): bool
    {
        return $this->status == self::STATUS_COMPLETED;
    }

    public function isNeedNotify():bool
    {
        return $this->needNotify;
    }


}