<?php

namespace App\Model;

class SearchData
{
    public string $search = "";


    /**
     * @return string
     */
    public function getSearch(): string
    {
        return $this->search;
    }

    /**
     * @param string $search
     */
    public function setSearch(string $search = ""): void
    {
        $this->search = $search;
    }
    public function __toString()
    {
        return $this->search;
    }
}