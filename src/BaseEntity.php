<?php

namespace Recruitment;

abstract class BaseEntity
{
    private $id;
    public function setId(int $id): BaseEntity
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): int
    {
        if (empty($this->id)) {
            return 0;
        }
        return $this->id;
    }
}
