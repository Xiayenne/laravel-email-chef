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
use Illuminate\Support\Facades\Http;

use function PHPUnit\Framework\assertIsArray;

class SegmentsTest extends TestCase
{
    public function test_get_collection()
    {
        $mockResponse = [
            [
                'id' => '12345',
                'name' => 'Test Segment',
                'description' => 'This is a test segment',
                'match_count' => '100',
                'total_count' => '200',
                'last_refresh_time' => now()->toDateTimeString(),
            ]
        ];

        Http::fake([
            'https://app.emailchef.com/apps/api/v1/lists/*/segments*' => Http::response($mockResponse, 200),
        ]);

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
        $this->assertIsString($segments->last_refresh_time);
    }

    public function test_get_instance()
    {
        $segment = new SegmentsApi();

        $response = $segment->getInstance(
            74016,
        );

        $this->assertInstanceOf(GetInstance::class, $response);
        $this->assertIsInt($response->id);
        $this->assertIsInt($response->list_id);
        $this->assertIsString($response->logic);
        $this->assertIsArray($response->condition_groups);
        $this->assertIsString($response->condition_groups[0]->logic);
        $this->assertIsArray($response->condition_groups[0]->conditions);
        $this->assertIsString($response->condition_groups[0]->conditions[0]->id);
        $this->assertIsString($response->condition_groups[0]->conditions[0]->field_id);
        $this->assertNull($response->condition_groups[0]->conditions[0]->comparable_id);
        $this->assertIsString($response->condition_groups[0]->conditions[0]->comparator_id);
        $this->assertIsString($response->condition_groups[0]->conditions[0]->value);
        $this->assertIsString($response->name);
        $this->assertIsString($response->description);
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
            74016,
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

        $response = $segment->update(74016, [
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

        $response = $segment->delete(74016);

        $this->assertInstanceOf(DeleteSegments::class, $response);
        $this->assertIsInt($response->id);
        $this->assertIsString($response->status);
    }
}
