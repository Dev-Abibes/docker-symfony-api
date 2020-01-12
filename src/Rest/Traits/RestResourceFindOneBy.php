<?php
declare(strict_types = 1);
/**
 * /src/Rest/Traits/RestResourceFindOneBy.php
 */

namespace App\Rest\Traits;

use App\Entity\Interfaces\EntityInterface;

/**
 * Trait RestResourceFindOneBy
 *
 * @SuppressWarnings("unused")
 *
 * @package App\Rest\Traits
 */
trait RestResourceFindOneBy
{
    /**
     * Before lifecycle method for findOneBy method.
     *
     * @param array $criteria
     * @param array $orderBy
     */
    public function beforeFindOneBy(array &$criteria, array &$orderBy): void
    {
    }

    /**
     * After lifecycle method for findOneBy method.
     *
     * Notes:   If you make changes to entity in this lifecycle method by default it will be saved on end of current
     *          request. To prevent this you need to detach current entity from entity manager.
     *
     *          Also note that if you've made some changes to entity and you eg. throw an exception within this method
     *          your entity will be saved if it has eg Blameable / Timestampable traits attached.
     *
     * @param array                $criteria
     * @param array                $orderBy
     * @param EntityInterface|null $entity
     */
    public function afterFindOneBy(array &$criteria, array &$orderBy, ?EntityInterface $entity): void
    {
    }
}
