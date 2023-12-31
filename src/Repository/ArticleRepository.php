<?php

namespace App\Repository;

use App\Entity\Article;
use App\Model\SearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function save(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findBySearch(SearchData $searchData)
    {
        $term = $searchData->q;

        if(!empty($term)) {
            $articles = $this->createQueryBuilder('a')
                ->where('a.title LIKE :term')
                ->orWhere('a.content LIKE :term')
                ->addOrderBy('a.id', 'DESC')
                ->setParameter('term', '%'.$term.'%')
                ->getQuery()
                ->getResult();
        }

        return $articles;
    }

    public function findByDate()
    {
        $articles = $this->createQueryBuilder('a')
            ->select('a')
            ->addOrderBy('a.date', 'DESC')
            ->getQuery()
            ->getResult();
        
        return $articles;
    }

    public function findByUser($id)
    {
        $articles = $this->createQueryBuilder('a')
            ->select('a')
            ->where('a.user_id LIKE :id')
            ->addOrderBy('a.date', 'DESC')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
        
        return $articles;
    }

//    /**
//     * @return Article[] Returns an array of Article objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Article
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
