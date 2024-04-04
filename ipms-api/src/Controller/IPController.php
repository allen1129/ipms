<?php

namespace App\Controller;

use App\Entity\IP;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;


/**
 * Class IPController
 * @package App\Controller
 * @Route('/api', name='api_ips')
 */

 #[Route('/api', name: 'api_ips')]
class IPController extends AbstractController
{

    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * List all IP entities.
     * @Route('/ips', name='ip_index', methods={'GET'})
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
    #[Route('/ips', name: 'ip_index', methods:['get'] )]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {
        $ips = $entityManager
            ->getRepository(IP::class)
            ->findAll();

        $data = [];

        foreach ($ips as $ip) {
            $data[] = $ip->toArray();
        }

        return $this->json($data);
    }

    /**
     * Show a single IP entity.
     * @Route('/ips/{id}', name='ip_show', methods={'GET'})
     * @param EntityManagerInterface $entityManager
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/ips/{id}', name: 'ip_show', methods:['get'] )]
    public function show(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $ip = $entityManager->getRepository(IP::class)->find($id);

        if (!$ip) {
            return $this->json('No IP found for id ' . $id, 404);
        }

        return $this->json($ip->toArray());
    }

     /**
     * Create a new IP entity.
     * @Route('/ips', name='ip_create', methods={'POST'})
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/ips', name: 'ip_create', methods:['post'] )]
    public function create(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $ip = new IP();
        $ip->setIp($data['ip']);
        $ip->setName($data['name']);
        $ip->setComment($data['comment']);
        $ip->setStatus($data['status']);
        $ip->setCreatedAt(new \DateTime());
        $ip->setUpdatedAt(new \DateTime());
        $ip->setCreatedBy($data['created_by']);

        $entityManager->persist($ip);
        $entityManager->flush();
        
        $this->logAuditTrail(array(), $ip->toArray(), 'Create IP ');
        return $this->json($ip->toArray());
    }

    /**
     * Update an existing IP entity.
     * @Route('/ips/{id}', name='ip_update', methods={'PUT', 'PATCH'})
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/ips/{id}', name: 'ip_update', methods:['put'] )]
    public function update(EntityManagerInterface $entityManager, Request $request, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $ip = $entityManager->getRepository(IP::class)->find($id);

        if (!$ip) {
            return $this->json('No IP found for id ' . $id, 404);
        }

        // Audit Trail: Log the updated data
        $oldData = $ip->toArray();

        $ip->setIp($data['ip']);
        $ip->setName($data['name']);
        $ip->setComment($data['comment']);
        $ip->setStatus($data['status']);
        $ip->setUpdatedAt(new \DateTime());
        $ip->setCreatedBy($data['created_by']);

        $entityManager->flush();

        // Audit Trail: Log the changes
        $newData = $ip->toArray();
        $this->logAuditTrail($oldData, $newData, 'Updated IP with id ' . $id);

        return $this->json($ip->toArray());
    }


    /**
     * Delete an existing IP entity.
     * @Route('/ips/{id}', name='ip_delete', methods={'DELETE'})
     * @param EntityManagerInterface $entityManager
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/projects/{id}', name: 'ip_delete', methods:['delete'] )]
    public function delete(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $ip = $entityManager->getRepository(IP::class)->find($id);

        if (!$ip) {
            return $this->json('No IP found for id ' . $id, 404);
        }

        // Audit Trail: Log the deleted data
        $deletedData = $ip->toArray();

        $entityManager->remove($ip);
        $entityManager->flush();

        // Audit Trail: Log the deletion
        $this->logAuditTrail($deletedData, [], 'Deleted IP with id ' . $id);

        return $this->json('Deleted an IP successfully with id ' . $id);
    }

    /**
     * Log the audit trail.
     * @param array $oldData
     * @param array $newData
     * @param string $action
     */
    private function logAuditTrail(array $oldData, array $newData, string $action): void
    {
        // Log the audit trail
        $this->logger->info('Action: ' . $action);
        
         // Log old data
        $this->logger->info('Old Data: ' . json_encode($oldData));
        
        // Log new data
        $this->logger->info('New Data: ' . json_encode($newData));
    }
}