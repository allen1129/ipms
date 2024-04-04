<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Ip; 
use App\Entity\User; 

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $sampleData = [
            [
                'ip' => '192.168.1.1',
                'name' => 'Sample IP 1',
                'comment' => 'This is a sample IP 1',
                'status' => 'active',
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
                'created_by' => 'admin',
            ],
            [
                'ip' => '192.168.1.2',
                'name' => 'Sample IP 2',
                'comment' => 'This is a sample IP 2',
                'status' => 'active',
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
                'created_by' => 'admin',
            ],
            [
                'ip' => '192.168.1.3',
                'name' => 'Sample IP 3',
                'comment' => 'This is a sample IP 3',
                'status' => 'active',
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
                'created_by' => 'admin',
            ],
        ];

        // Create Ip entities with sample data
        foreach ($sampleData as $data) {
            $ip = new Ip();
            $ip->setIp($data['ip']);
            $ip->setName($data['name']);
            $ip->setComment($data['comment']);
            $ip->setStatus($data['status']);
            $ip->setCreatedAt($data['created_at']);
            $ip->setUpdatedAt($data['updated_at']);
            $ip->setCreatedBy($data['created_by']);
            $manager->persist($ip);
        }

        $user = new User();
        $user->setEmail('test@example.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword('$2a$12$2YilJl0GYu30SoMhL8nu6uvzFqYZaDXmEACG6V1xN3ZdstJJGaBKi'); // Hashed password
        $manager->persist($user);


        $manager->flush();

    }
}
