<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Services\DynamicScopesBuilder;
use Laravel\Passport\Passport;

class ScopeRepository extends \Laravel\Passport\Bridge\ScopeRepository
{
    private DynamicScopesBuilder $builder;

    /**
     * @param DynamicScopesBuilder $builder
     */
    public function __construct(DynamicScopesBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function getScopeEntityByIdentifier($identifier)
    {
        if (!Passport::hasScope($identifier)) {
            // Dynamically inject scopes into Passport
            $description = $this->builder->detect((string)$identifier);
            if (null !== $description) {
                Passport::$scopes[$identifier] = $description;
            }
        }

        return parent::getScopeEntityByIdentifier($identifier);
    }
}
