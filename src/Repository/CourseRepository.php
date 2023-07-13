<?php

namespace App\Repository;

use App\Entity\Course;
use App\Entity\CourseMetas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Course>
 *
 * @method Course|null find($id, $lockMode = null, $lockVersion = null)
 * @method Course|null findOneBy(array $criteria, array $orderBy = null)
 * @method Course[]    findAll()
 * @method Course[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Course::class);
    }

    public function save(Course $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Course $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByCourseMetaJoin(int $id)
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('App\Entity\CourseMetas', 'cm')
            ->where('c.id = :course_id')
            ->setParameter('course_id', $id)
            ->getQuery()
            ->getResult();
    }


}

//    public function findByCourseMetaJoin(int $id): array {
//
//        return $this->createQueryBuilder('course')
//            ->innerJoin('course', 'course_metas')
//            ->where('course.id = :courseId')
//            ->setParameter('courseId', $id)
//            ->getQuery()
//            ->getResult();
//    }


//    public function findByCourseMetaJoin($id)
//    {
//        $qb = $this->createQueryBuilder('c')
//            ->Join('c.id', 'cm')
//            //->addSelect('s')
////        ->Join('cm.course_id', 'ci')
////        ->where('s.categories IN (:categories)')
//            ->setParameter('categories', $id);
//        //dump($qb);
//        // try {
//        return $qb->getQuery()->getResult();
//
//    }
//}
//    /**
//     * @return Course[] Returns an array of Course objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Course
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

