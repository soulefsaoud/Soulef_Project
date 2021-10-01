<?php 

namespace App\Search;

class SearchProduit
{
    protected $filtrerParNom;

    protected $filtrerParCategorie;

    public function getFiltrerParNom()
    {
        return $this->filtrerParNom;
    }

    public function getFiltrerParCategorie()
    {
        return $this->filtrerParCategorie;
    }

    public function setFiltrerParNom($filtrerParNom)
    {
        $this->filtrerParNom = $filtrerParNom;
        return $this;
    }

    public function setFiltrerParCategorie($filtrerParCategorie)
    {
        $this->filtrerParCategorie = $filtrerParCategorie;
        return $this;
    }
}