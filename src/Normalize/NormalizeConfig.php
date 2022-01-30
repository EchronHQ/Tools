<?php
declare(strict_types=1);

namespace Echron\Tools\Normalize;

class NormalizeConfig
{
    private bool $allowSlash = false;
    private bool $allowDash = false;
    private bool $allowDot = false;
    private bool $allowPlus = false;
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

    public function setAllowExtended(bool $allowExtended)
    {
        $this->allowExtended = $allowExtended;
    }

    public function isAllowPlus(): bool
    {
        return $this->allowPlus;
    }

    public function setAllowPlus(bool $allowPlus)
    {
        $this->allowPlus = $allowPlus;
    }

    public function getMaxLength(): int
    {
        return $this->maxLength;
    }

    public function setMaxLength(int $maxLength)
    {
        $this->maxLength = $maxLength;
    }

    public function isAllowSlash(): bool
    {
        return $this->allowSlash;
    }

    public function setAllowSlash(bool $allowSlash)
    {
        $this->allowSlash = $allowSlash;
    }

    public function isAllowDash(): bool
    {
        return $this->allowDash;
    }

    public function setAllowDash(bool $allowDash)
    {
        $this->allowDash = $allowDash;
    }

    public function isAllowDot(): bool
    {
        return $this->allowDot;
    }

    public function setAllowDot(bool $allowDot)
    {
        $this->allowDot = $allowDot;
    }

    public function isCasesAllowed(): bool
    {
        return $this->allowCases;
    }

    public function setIsCasesAllowed(bool $allowCases)
    {
        $this->allowCases = $allowCases;
    }
}

