<?php
declare(strict_types = 1);
/**
 * /src/Rest/Traits/Actions/Root/FindAction.php
 */

namespace App\Rest\Traits\Actions\Root;

use App\Rest\Traits\Methods\FindMethod;
use OpenApi\Annotations as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

/**
 * Trait FindAction
 *
 * Trait to add 'findAction' for REST controllers for 'ROLE_ROOT' users.
 *
 * @see \App\Rest\Traits\Methods\FindMethod for detailed documents.
 *
 * @package App\Rest\Traits\Actions\Root
 */
trait FindAction
{
    // Traits
    use FindMethod;

    /**
     * Get list of entities, accessible only for 'ROLE_ROOT' users.
     *
     * @Route(
     *      path="",
     *      methods={"GET"},
     *  )
     *
     * @Security("is_granted('ROLE_ROOT')")
     *
     * @OA\Response(
     *     response=200,
     *     description="success",
     *     @OA\Schema(
     *         type="array",
     *         @OA\Items(type="string"),
     *     ),
     * )
     * @OA\Response(
     *     response=403,
     *     description="Access denied",
     *     @OA\Schema(
     *         type="object",
     *         example={
     *             "Access denied": "{code: 403, message: 'Access denied'}",
     *         },
     *         @OA\Property(property="code", type="integer", description="Error code"),
     *         @OA\Property(property="message", type="string", description="Error description"),
     *     ),
     * )
     *
     * @throws Throwable
     */
    public function findAction(Request $request): Response
    {
        return $this->findMethod($request);
    }
}
