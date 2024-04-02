<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IPRepository")
 * @ORM\Table(name="ips")
 */
class IP
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $ip;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="text")
     */
    private string $comment;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private string $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $updatedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $createdBy;

    // Getters and setters...

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'ip' => $this->getIp(),
            'name' => $this->getName(),
            'comment' => $this->getComment(),
            'status' => $this->getStatus(),
            'createdAt' => $this->getCreatedAt()->format('Y-m-d H:i:s'),
            'updatedAt' => $this->getUpdatedAt()->format('Y-m-d H:i:s'),
            'createdBy' => $this->getCreatedBy(),
        ];
    }

    // Other methods...
}