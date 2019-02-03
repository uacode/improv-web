<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\UpdateOrganizationRequest;
use App\Http\Resources\V1\OrganizationResource;
use App\Http\Services\OrganizationStorageService;
use App\Orm\Filters\FilterTranslatedName;
use App\Orm\Organization;
use App\Orm\OrganizationUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Organizations
 *
 * An Organization is a group of Users with a common identity. Simply put, an
 * Organization can equal an improv group.
 *
 * An Organization is identified by its `slug` attribute.
 */
class OrganizationController extends Controller
{

    /**
     * @var OrganizationStorageService
     */
    private $organizationStorageService;

    public function __construct(OrganizationStorageService $organizationStorageService)
    {
        $this->authorizeResource(Organization::class, 'organization');
        $this->organizationStorageService = $organizationStorageService;
    }

    /**
     * Show Organization details
     *
     * @param Organization $organization
     * @return OrganizationResource
     */
    public function show(Organization $organization)
    {
        return new OrganizationResource($organization);
    }

    /**
     * List all Organizations
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $organizations = QueryBuilder::for(Organization::class)
            ->allowedFilters(Filter::custom('name', FilterTranslatedName::class))
            ->orderBy('id', 'asc')
            ->onlyMine($request->input('onlyMine', false))
            ->paginate(30);
        return OrganizationResource::collection($organizations);
    }

    /**
     * Create a new Organization
     *
     * @param Request $request
     * @return OrganizationResource
     * @authenticated
     * @bodyParam name string required Name of the organization. Example: Loose Moose
     * @responseFile 200 api-doc/v1/responses/organizations/store.200.json
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|filled|unique:organization_translations|max:255|min:2',
        ]);

        $organization = $this->organizationStorageService->save(new Organization, $request);
        $this->organizationStorageService->addCreatorAsMember($organization, $request->user());

        return new OrganizationResource($organization);
    }

    /**
     * Update an Organization
     *
     * @param Organization $organization
     * @param UpdateOrganizationRequest $request
     * @return OrganizationResource
     * @bodyParam name string required Name of the organization. Example: Loose Moose
     * @bodyParam description string
     * @bodyParam is_public boolean
     * @authenticated
     */
    public function update(Organization $organization, UpdateOrganizationRequest $request)
    {
        $organization = $this->organizationStorageService->save($organization, $request);
        return new OrganizationResource($organization);
    }

    /**
     * Delete an Organization
     *
     * @param Organization $organization
     * @throws \Exception
     * @authenticated
     */
    public function destroy(Organization $organization)
    {

        $organization->delete();
    }
}
