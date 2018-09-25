<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CampaignRepository")
 * @UniqueEntity(
 *     fields = "name",
 *     message="Une campagne portant ce nom existe déjà."
 * )
 * @Vich\Uploadable
 */
class Campaign
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $sendDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="campaigns")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MailingList", inversedBy="campaigns")
     */
    private $mailingList;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="campaigns")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Template", inversedBy="campaigns")
     */
    private $template;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $file;

    /**
     * @Vich\UploadableField(
     *     mapping="campaign_file",
     *     fileNameProperty="file")
     * @var File
     * @Assert\File(
     *     maxSize = "50M",
     *     mimeTypes = "application/pdf",
     *     mimeTypesMessage = "Format de fichiers autorisé : .pdf"
     * )
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $updatedAt;


    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->updatedAt= null;
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

    public function getSendDate(): ?\DateTimeInterface
    {
        return $this->sendDate;
    }

    public function setSendDate(\DateTimeInterface $sendDate): self
    {
        $this->sendDate = $sendDate;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getMailingList(): ?MailingList
    {
        return $this->mailingList;
    }

    public function setMailingList(?MailingList $mailingList): self
    {
        $this->mailingList = $mailingList;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
        }

        return $this;
    }

    public function getTemplate(): ?Template
    {
        return $this->template;
    }

    public function setTemplate(?Template $template): self
    {
        $this->template = $template;

        return $this;
    }

    public function setImageFile(File $file = null)
    {
        $this->imageFile = $file;

        if ($file) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setFile($file)
    {
        $this->file = $file;
    }

    public function getFile()
    {
        return $this->file;
    }
}
