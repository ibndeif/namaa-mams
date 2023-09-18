<?php

namespace Tests\Feature\Articles;

use App\Enum\ArticleStatus;
use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ArticlesTest extends TestCase
{
    use DatabaseMigrations;

    private User $user;
    private Collection $articles;

    protected function setUp(): void
    {
        parent::setUp();
        // create user to be used for login
        $this->user = User::factory()->create();

        $this->articles = Article::factory()->count(3)->sequence(
            [
                'title' => 'Dwelling and speedily ignorant any steepest.',
                'status' => ArticleStatus::Pending->value,
                'body' => 'Admiration instrument affronting invitation reasonably up do of prosperous in. Shy saw declared age debating ecstatic man. Call in so want pure rank am dear were. Remarkably to continuing in surrounded diminution on. In unfeeling existence objection immediate repulsive on he in. Imprudence comparison uncommonly me he difficulty diminution resolution. Likewise proposal differed scarcely dwelling as on raillery. September few dependent extremity own continued and ten prevailed attending. Early to weeks we could.'
            ],
            [
                'title' => 'Sing long her way size.',
                'status' => ArticleStatus::Published->value,
                'body' => 'Waited end mutual missed myself the little sister one. So in pointed or chicken cheered neither spirits invited. Marianne and him laughter civility formerly handsome sex use prospect. Hence we doors is given rapid scale above am. Difficult ye mr delivered behaviour by an. If their woman could do wound on. You folly taste hoped their above are and but.'
            ],
            [
                'title' => 'Are sentiments apartments decisively the especially alteration.',
                'status' => ArticleStatus::Unpublished->value,
                'body' => 'Thrown shy denote ten ladies though ask saw. Or by to he going think order event music. Incommode so intention defective at convinced. Led income months itself and houses you. After nor you leave might share court balls.'
            ]
        )->create();
    }


    public function test_articles_page_is_displayed(): void
    {

        $response = $this->actingAs($this->user)->get('/articles');

        $response->assertOk();
    }

    public function test_articles_index_show_correct_data_without_filtering()
    {
        $response = $this->actingAs($this->user)->get('/articles');

        $response->assertOk();
        $response->assertViewHas('articles', function ($collection) {
            return $collection->count() === $this->articles->count();
        });
    }

    public function test_articles_index_show_correct_data_when_filtering_by_term()
    {
        $term = 'speedily';
        $response = $this->actingAs($this->user)->get('/articles?term=' . $term);

        $response->assertOk();
        $response->assertViewHas('articles', function ($collection) {
            return
                $collection->count() === 1 &&
                $collection->first()->is($this->articles->first());
        });
    }

    public function test_articles_index_no_data_returned_when_filtering_by_term_with_no_matching_data()
    {
        $term = 'termnodata';
        $response = $this->actingAs($this->user)->get('/articles?term=' . $term);

        $response->assertOk();
        $response->assertViewHas('articles', function ($collection) {
            return
                $collection->count() === 0;
        });
    }

    public function test_articles_index_show_correct_data_when_filter_by_status()
    {
        $status = ArticleStatus::Pending->value;
        $response = $this->actingAs($this->user)->get('/articles?status=' . $status);

        $response->assertOk();
        $response->assertViewHas('articles', function ($collection) {
            return
                $collection->count() === 1 &&
                $collection->first()->is($this->articles->first());
        });
    }

    public function test_articles_index_show_correct_data_when_filter_by_status_and_term()
    {
        $term = 'speedily';
        $status = ArticleStatus::Pending->value;
        $response = $this->actingAs($this->user)->get("/articles?status=$status&term=$term");

        $response->assertOk();
        $response->assertViewHas('articles', function ($collection) {
            return
                $collection->count() === 1 &&
                $collection->first()->is($this->articles->first());
        });
    }
}
