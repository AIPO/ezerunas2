<?php

namespace Tests\Feature;

use App\Reply;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class Favoritestest extends TestCase
{
    use DatabaseMigrations;
    public function testGuestCantFavoriteAnything()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->post('replies/1/favorites')->assertRedirect('/login');
    }
    public function testAuthenticatedUserCanFavoriteAnyReply()
    {
        //Add post to favorite
        $this->signIn();
        //post by url /replies/id/favorites
        $reply = create(Reply::class);
        $this->post('replies/' . $reply->id . '/favorites');
        $this->assertCount(1, $reply->favorites);
    }
    public function testAuthenticatedUserCanUnFavoriteaReply()
    {
        //Add post to favorite
        $this->signIn();
        //post by url /replies/id/favorites
        $reply = create(Reply::class);
        $reply->favorite();
        $this->delete('replies/' . $reply->id . '/favorites');
        $this->assertCount(0, $reply->fresh()->favorites);
    }
    public function testAuthenticatedUserMayOnlyFavoriteReplyOnce()
    {
        $this->signIn();
        //post by url /replies/id/favorites
        $reply = create(Reply::class);
        try {
            $this->post('replies/' . $reply->id . '/favorites');
            $this->post('replies/' . $reply->id . '/favorites');
        } catch (\Exception $e) {
            $this->fail('Did not expect insert the same record more than once');
        }

        $this->assertCount(1, $reply->favorites);
    }
}
