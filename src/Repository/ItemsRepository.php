<?php

namespace App\Repository;

use App\Entity\Items;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;



/**
 * @extends ServiceEntityRepository<Items>
 *
 * @method Items|null find($id, $lockMode = null, $lockVersion = null)
 * @method Items|null findOneBy(array $criteria, array $orderBy = null)
 * @method Items[]    findAll()
 * @method Items[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemsRepository extends ServiceEntityRepository
{
    private $paginator;
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Items::class);
        $this->paginator = $paginator;
    }

    public function paginateItems(Request $request, int $itemsPerPage)
    {
        $queryBuilder = $this->createQueryBuilder('i');
        $query = $queryBuilder->getQuery();
        $pagination = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $itemsPerPage
        );

        return $pagination;
    }

    public function paginateItemsByCategory(string $category)
    {

        $conn = $this->getEntityManager()->getConnection();
        $sql =
            "SELECT *
             FROM items i
             JOIN categories c ON
             i.category_id = c.id
             WHERE c.category = :category";

        $params = [
            'category' => $category
        ];

        $resultSet = $conn->executeQuery($sql, $params);
        return $resultSet->fetchAllAssociative();
    }
}
