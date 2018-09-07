<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MailingListRepository")
 */
class MailingList
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserMailingList", mappedBy="mailingList")
     */
    private $userMailingLists;

    public function __construct()
    {
        $this->userMailingLists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|UserMailingList[]
     */
    public function getUserMailingLists(): Collection
    {
        return $this->userMailingLists;
    }

    public function addUserMailingList(UserMailingList $userMailingList): self
    {
        if (!$this->userMailingLists->contains($userMailingList)) {
            $this->userMailingLists[] = $userMailingList;
            $userMailingList->setMailingList($this);
        }

        return $this;
    }

    public function removeUserMailingList(UserMailingList $userMailingList): self
    {
        if ($this->userMailingLists->contains($userMailingList)) {
            $this->userMailingLists->removeElement($userMailingList);
            // set the owning side to null (unless already changed)
            if ($userMailingList->getMailingList() === $this) {
                $userMailingList->setMailingList(null);
            }
        }

        return $this;
    }
}
