<?php

namespace App\Traits;
use DateTime;

trait Timestampable
{
    private ?DateTime $createdAt = null;
    private ?DateTime $updatedAt = null;

    public function initTimestamps(): void 
    {
        $now = new DateTime();
        $this->createdAt = $this->createdAt ?? $now;
        $this->updatedAt = $now;
    }

    public function touch(): void
    {
        $this->updatedAt = new DateTime();
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setCreatedAt(string|DateTime $date): void
    {
        $this->createdAt = is_string($date) ? new DateTime($date) : $date;
    }
    
    public function setUpdatedAt(string|DateTime $date): void
    {
        $this->updatedAt = is_string($date) ? new DateTime($date) : $date;
    }
}