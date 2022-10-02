<?php

declare(strict_types=1);

namespace App\Tests\Functional\User\Transport\Controller\Api\v1\Profile;

use App\General\Domain\Utils\JSON;
use App\General\Transport\Utils\Tests\WebTestCase;
use App\Role\Domain\Entity\Role;
use App\User\Infrastructure\DataFixtures\ORM\LoadUserGroupData;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * Class GroupsControllerTest
 *
 * @package App\Tests
 */
class GroupsControllerTest extends WebTestCase
{
    private string $baseUrl = self::API_URL_PREFIX . '/v1/profile';

    /**
     * @testdox Test that `GET /api/v1/profile/groups` for the `john-logged` user returns success response.
     *
     * @throws Throwable
     */
    public function testThatGetGroupsActionForUserReturnsSuccessResponse(): void
    {
        $client = $this->getTestClient('john-logged', 'password-logged');

        $client->request(method: 'GET', uri: $this->baseUrl . '/groups');
        $response = $client->getResponse();
        $content = $response->getContent();
        self::assertNotFalse($content);
        self::assertSame(Response::HTTP_OK, $response->getStatusCode(), "Response:\n" . $response);
        $responseData = JSON::decode($content, true);
        self::assertIsArray($responseData);
        self::assertCount(1, $responseData);
        self::assertArrayHasKey('id', $responseData[0]);
        self::assertArrayHasKey('role', $responseData[0]);
        self::assertArrayHasKey('name', $responseData[0]);
        self::assertEquals($responseData[0]['id'], LoadUserGroupData::$uuids['Role-logged']);
        self::assertIsArray($responseData[0]['role']);
        self::assertArrayHasKey('id', $responseData[0]['role']);
        self::assertEquals(Role::ROLE_LOGGED, $responseData[0]['role']['id']);
        self::assertIsString($responseData[0]['name']);
    }

    /**
     * @testdox Test that `GET /api/v1/profile/groups` for non-logged user returns error response.
     *
     * @throws Throwable
     */
    public function testThatGetGroupsActionForNonLoggedUserReturnsErrorResponse(): void
    {
        $client = $this->getTestClient();

        $client->request(method: 'GET', uri: $this->baseUrl . '/groups');
        $response = $client->getResponse();
        $content = $response->getContent();
        self::assertNotFalse($content);
        self::assertSame(Response::HTTP_UNAUTHORIZED, $response->getStatusCode(), "Response:\n" . $response);
    }
}
