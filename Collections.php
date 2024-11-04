<?php

class Collections {
    
    private  Int $Idcollection;
    private String $Nomcollection;
    

    public function getIdcollection(): int
    {
        return $this->Idcollection;
    }

    public function setIdcollection(int $Idcollection): self
    {
        $this->Idcollection = $Idcollection;

        return $this;
    }

    public function getNomcollection(): string
    {
        return $this->Nomcollection;
    }

    public function setNomcollection(string $Nomcollection): self
    {
        $this->Nomcollection = $Nomcollection;

        return $this;
    }
}
?>
