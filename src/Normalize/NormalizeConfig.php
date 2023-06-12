<?php

declare(strict_types=1);

namespace Echron\Tools\Normalize;

class NormalizeConfig
{
    private bool $allowSlash = false;
    public int $allowConsecutiveSlashes = 0;

    private bool $allowDash = false;
    public int $allowConsecutiveDashes = 0;

    private bool $allowDot = false;
    public int $allowConsecutiveDots = 0;

    private bool $allowPlus = false;
    public int $allowConsecutivePluses = 0;

    private bool $allowCases = false;
    private bool $allowExtended = false;
    private int $maxLength = -1;

    public function __construct()
    {
    }

    public function isAllowExtended(): bool
    {
        return $this->allowExtended;
    }

    public function setAllowExtended(bool $allowExtended): void
    {
        $this->allowExtended = $allowExtended;
    }

    public function isAllowPlus(): bool
    {
        return $this->allowPlus;
    }

    public function setAllowPlus(bool $allowPlus, int $consecutive = 1): void
    {
        $this->allowPlus = $allowPlus;
        $this->allowConsecutivePluses = $consecutive;
    }

    public function getMaxLength(): int
    {
        return $this->maxLength;
    }

    public function setMaxLength(int $maxLength): void
    {
        $this->maxLength = $maxLength;
    }

    public function isAllowSlash(): bool
    {
        return $this->allowSlash;
    }


    public function setAllowSlash(bool $allowSlash, int $consecutive = 1): void
    {
        $this->allowSlash = $allowSlash;
        $this->allowConsecutiveSlashes = $consecutive;
    }

    public function isAllowDash(): bool
    {
        return $this->allowDash;
    }

    public function setAllowDash(bool $allowDash, int $consecutive = 1): void
    {
        $this->allowDash = $allowDash;
        $this->allowConsecutiveDashes = $consecutive;
    }

    public function isAllowDot(): bool
    {
        return $this->allowDot;
    }

    public function setAllowDot(bool $allowDot, int $consecutive = 1): void
    {
        $this->allowDot = $allowDot;
        $this->allowConsecutiveDots = $consecutive;
    }

    public function isCasesAllowed(): bool
    {
        return $this->allowCases;
    }

    public function setIsCasesAllowed(bool $allowCases): void
    {
        $this->allowCases = $allowCases;
    }
}
