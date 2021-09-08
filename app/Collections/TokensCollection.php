<?php

declare(strict_types=1);

namespace App\Collections;

use App\Models\Token;
use Illuminate\Database\Eloquent\Collection;
use function str_contains;
use function str_ends_with;

class TokensCollection extends Collection
{
    public function whereFirm(int $firmId): static
    {
        $matcher = "firm-${firmId}";

        return $this->filter(
            static function (Token $token) use ($matcher) {
                $found = false;

                foreach ((array)$token->scopes as $scope) {
                    $found = str_contains((string)$scope, "{$matcher}-")
                             || str_ends_with((string)$scope, $matcher);

                    if ($found) {
                        break;
                    }
                }

                return $found;
            }
        );
    }
}
