<?php

namespace App\Model;

class WelcomeModel
{
    CONST SITE_TITLE_LABEL = 'Titre du blog';

    CONST SITE_TITLE_NAME = 'blog_title';

    CONST SITE_INSTALLED_LABEL = 'Site installé';

    CONST SITE_INSTALLED_NAME = 'blog_installed';

    private ?string $siteTitle;

    private ?string $username;

    private ?string $password;

    /**
     * @return string|null
     */
    public function getSiteTitle(): ?string
    {
        return $this->siteTitle;
    }

    /**
     * @param string|null $siteTtile
     */
    public function setSiteTitle(?string $siteTtile): void
    {
        $this->siteTitle = $siteTtile;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     */
    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }


}