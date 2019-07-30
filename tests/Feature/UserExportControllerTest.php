<?php

namespace Tests\Feature;

use App\Exports\UsersExportQuery;
use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExportCollection;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserExportControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        factory(User::class, 30)->create();
        Carbon::setTestNow(Carbon::create(2001, 5, 21, 12));
        Excel::fake();
    }

    /** @test */
    public function user_can_download_users_export_collection() : void
    {
        $users = User::take(10)->get();

        $this->actingAs($users->first())
            ->getJson('/users/export/collection');

        Excel::assertDownloaded($this->getFileName(), function(UsersExportCollection $export) use($users) {
            // Assert that the correct export is downloaded.
            return $export->collection()->contains($users->random());
        });
    }

    /** @test */
    public function user_can_download_users_export_query() : void
    {
        $users = User::take(10)->get();

        $this->actingAs($users->first())
            ->getJson('/users/export/query');

        Excel::assertDownloaded($this->getFileName(), function(UsersExportQuery $export) use($users) {
            // Assert that the correct export is downloaded.
            return $export->query()->get()->contains($users->random());
        });
    }

    public function getFileName(): string
    {
        return 'users-export-'. now()->timestamp . '.xlsx';
    }
}
