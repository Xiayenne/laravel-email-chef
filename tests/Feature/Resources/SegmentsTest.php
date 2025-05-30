<?php

namespace OfflineAgency\LaravelEmailChef\Tests\Feature\Resources;

use Illuminate\Support\Collection;
use OfflineAgency\LaravelEmailChef\Api\Resources\SegmentsApi;
use OfflineAgency\LaravelEmailChef\Entities\Segments\GetCollection;
use OfflineAgency\LaravelEmailChef\Entities\Segments\GetInstance;
use OfflineAgency\LaravelEmailChef\Entities\Segments\CountSegments;
use OfflineAgency\LaravelEmailChef\Entities\Segments\ContactsCount;
use OfflineAgency\LaravelEmailChef\Entities\Segments\CreatedSegmentEntity;
use OfflineAgency\LaravelEmailChef\Entities\Segments\UpdatedSegmentEntity;
use OfflineAgency\LaravelEmailChef\Entities\Segments\DeleteSegments;
use OfflineAgency\LaravelEmailChef\Tests\TestCase;
use Carbon\Carbon;

class SegmentsTest extends TestCase
{
    public function test_get_collection()
    {
        $segment = new SegmentsApi();

        $response = $segment->getCollection(
            config('email-chef.list_id'),
            config('email-chef.limit', 10),
            config('email-chef.offset', 0),
        );

        $this->assertInstanceOf(Collection::class, $response);

        $segments = $response->first();

        $this->assertInstanceOf(GetCollection::class, $segments);
        $this->assertIsString($segments->id);
        $this->assertIsString($segments->name);
        $this->assertIsString($segments->description);
        $this->assertIsInt($segments->match_count);
        $this->assertIsInt($segments->total_count);
        $this->assertInstanceOf(Carbon::class, $segments->last_refresh_time);
    }

    public function test_get_instance()
    {
        $segment = new SegmentsApi();

        $response = $segment->getInstance(
            config('email-chef.segment_id'),
        );

        $this->assertInstanceOf(GetInstance::class, $response);
        $this->assertIsInt($response->id);
        $this->assertIsInt($response->list_id);
        $this->assertIsString($response->name);
        $this->assertIsString($response->description);
        $this->assertNull($response->logic);
        $this->assertNull($response->condition_group);
    }

    public function test_get_count()
    {
        $segments = new SegmentsApi();

        $response = $segments->getCount(config('email-chef.list_id'));

        $this->assertInstanceOf(CountSegments::class, $response);
        $this->assertIsInt($response->totalcount);
    }

    public function test_get_contacts_count()
    {
        $segments = new SegmentsApi();
        $response = $segments->getContactsCount(
            config('email-chef.segment_id'),
        );

        $this->assertInstanceOf(ContactsCount::class, $response);
        $this->assertIsInt($response->match_count);
        $this->assertIsInt($response->total_count);
    }

    public function test_create()
    {
        $segment = new SegmentsApi();

        $response = $segment->create([
            'list_id' => config('email-chef.list_id'),
            'logic' => 'AND',
            'condition_groups' => [
                [
                    'logic' => 'OR',
                    'conditions' => [
                        [
                            'field_id' => '-1',
                            'name' => 'email',
                            'comparable_id' => null,
                            'comparator_id' => '3',
                            'value' => 'black',
                        ],
                    ],
                ],
            ],
            'name' => 'My Segment' . uniqid(),
            'description' => 'The first segment to play with',
        ]);

        $this->assertInstanceOf(CreatedSegmentEntity::class, $response);
        $this->assertIsInt($response->id);
        $this->assertIsString($response->status);
    }
    public function test_update()
    {
        $segment = new SegmentsApi;

        $response = $segment->update(config('email-chef.segment_id'), [
            'list_id' => config('email-chef.list_id'),
            'logic' => 'AND',
            'condition_groups' => [
                [
                    'logic' => 'OR',
                    'conditions' => [
                        [
                            'field_id' => '-1',
                            'name' => 'email',
                            'comparable_id' => null,
                            'comparator_id' => '3',
                            'value' => 'black',
                        ],
                    ],
                ],
            ],
            'name' => 'My Segment' . uniqid(),
            'description' => 'The first super segment to play with',
        ]);

        $this->assertInstanceOf(UpdatedSegmentEntity::class, $response);
    }

    public function test_delete()
    {
        $segment = new SegmentsApi();

        $response = $segment->delete(config('email-chef.segment_id'));

        $this->assertInstanceOf(DeleteSegments::class, $response);
        $this->assertIsInt($response->id);
        $this->assertIsString($response->status);
    }
}
