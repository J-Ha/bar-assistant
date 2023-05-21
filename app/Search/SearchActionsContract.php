<?php

declare(strict_types=1);

namespace Kami\Cocktail\Search;

interface SearchActionsContract
{
    public function getPublicApiKey(bool $isDemo = false): ?string;

    public function isAvailable(): bool;

    public function getVersion(): ?string;

    public function updateIndexSettings(): void;
}
