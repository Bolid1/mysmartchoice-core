<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class UserResourceTest extends TestCase
{
    use WithFaker;

    /**
     * @covers \App\Http\Resources\UserResource::toArray
     */
    public function testToArray(): void
    {
        /** @var User $user */
        $user    = User::factory()->makeOne();
        $request = $this->createMock(Request::class);

        $user->id         = 123;
        $user->created_at = $this->faker->dateTime;
        $user->updated_at = $this->faker->dateTime;

        self::assertEquals(
            [
                'id'                => $user->id,
                'name'              => $user->name,
                'email'             => $user->email,
                'email_verified_at' => $user->email_verified_at->toJSON(),
                'created_at'        => $user->created_at->toJSON(),
                'updated_at'        => $user->updated_at->toJSON(),
            ],
            (new UserResource($user))->toArray($request)
        );
    }
}
