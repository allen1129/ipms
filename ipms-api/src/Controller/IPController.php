<?php

namespace App\Controller;

use App\Entity\IP;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Illuminate\Support\Facades\Log;

/**
 * Class IPController
 * @package App\Controller
 * @Route('/api', name='api_')
 */

 #[Route('/api', name: 'api_')]
class IPController extends AbstractController
{
    /**
     * List all IP entities.
     * @Route('/ips', name='ip_index', methods={'GET'})
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
    #[Route('/ips', name: 'ips_index', methods:['get'] )]
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
     * Log the audit trail.
     * @param array $oldData
     * @param array $newData
     * @param string $action
     */
    private function logAuditTrail(array $oldData, array $newData, string $action): void
    {
         // Log the audit trail
        Log::info('Action: ' . $action);
        
        // Log old data
        Log::info('Old Data:', $oldData);
        
        // Log new data
        Log::info('New Data:', $newData);
    }
}