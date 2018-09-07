<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=75)
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Civility", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $civility;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserMailingList", mappedBy="user")
     */
    private $userMailingLists;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $phone;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Site", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $site;

    public function __construct()
    {
        $this->userMailingLists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCivility(): ?Civility
    {
        return $this->civility;
    }

    public function setCivility(?Civility $civility): self
    {
        $this->civility = $civility;

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
            $userMailingList->setUser($this);
        }

        return $this;
    }

    public function removeUserMailingList(UserMailingList $userMailingList): self
    {
        if ($this->userMailingLists->contains($userMailingList)) {
            $this->userMailingLists->removeElement($userMailingList);
            // set the owning side to null (unless already changed)
            if ($userMailingList->getUser() === $this) {
                $userMailingList->setUser(null);
            }
        }

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getSite(): ?Site
    {
        return $this->site;
    }

    public function setSite(?Site $site): self
    {
        $this->site = $site;

        return $this;
    }
}
