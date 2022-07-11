<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $menuOrder;

    #[ORM\ManyToMany(targetEntity: self::class, inversedBy: 'subMenus')]
    private $subMenu;

    #[ORM\ManyToMany(targetEntity: self::class, mappedBy: 'subMenu')]
    private $subMenus;

    #[ORM\Column(type: 'boolean')]
    private $isVisible;

    #[ORM\ManyToOne(targetEntity: Article::class)]
    private $article;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    private $category;

    #[ORM\ManyToOne(targetEntity: Page::class)]
    private $page;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $link;

    public function __construct()
    {
        $this->subMenu = new ArrayCollection();
        $this->subMenus = new ArrayCollection();
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

    public function getMenuOrder(): ?int
    {
        return $this->menuOrder;
    }

    public function setMenuOrder(?int $menuOrder): self
    {
        $this->menuOrder = $menuOrder;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getSubMenu(): Collection
    {
        return $this->subMenu;
    }

    public function addSubMenu(self $subMenu): self
    {
        if (!$this->subMenu->contains($subMenu)) {
            $this->subMenu[] = $subMenu;
        }

        return $this;
    }

    public function removeSubMenu(self $subMenu): self
    {
        $this->subMenu->removeElement($subMenu);

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getSubMenus(): Collection
    {
        return $this->subMenus;
    }

    public function isIsVisible(): ?bool
    {
        return $this->isVisible;
    }

    public function setIsVisible(bool $isVisible): self
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

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

    public function getPage(): ?Page
    {
        return $this->page;
    }

    public function setPage(?Page $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }
}
