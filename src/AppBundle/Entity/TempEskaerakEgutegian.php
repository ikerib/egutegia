<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TempEskaerakEgutegian
 *
 * @ORM\Table(name="temp_eskaerak_egutegian")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TempEskaerakEgutegianRepository")
 */
class TempEskaerakEgutegian
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="eskaera", type="integer", unique=true)
     */
    private $eskaera;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set eskaera.
     *
     * @param int $eskaera
     *
     * @return TempEskaerakEgutegian
     */
    public function setEskaera($eskaera)
    {
        $this->eskaera = $eskaera;

        return $this;
    }

    /**
     * Get eskaera.
     *
     * @return int
     */
    public function getEskaera()
    {
        return $this->eskaera;
    }
}
