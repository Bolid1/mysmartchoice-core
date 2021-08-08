<?php

declare(strict_types=1);

namespace App\Enums;

use Generator;
use IteratorAggregate;
use League\ISO3166\ISO3166;

class Currencies implements IteratorAggregate
{
    private ISO3166 $countries;

    public function __construct(ISO3166 $countries)
    {
        $this->countries = $countries;
    }

    public function getIterator(): Generator
    {
        foreach ($this->countries as $country) {
            foreach (($country['currency'] ?? []) as $currency) {
                yield [
                    'country' => $country['name'],
                    'code' => $currency,
                ];
            }
        }
    }

    public function all(): array
    {
        $currencies = [];

        foreach ($this as $currency) {
            $currencies[] = $currency;
        }

        return $currencies;
    }
}
