<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ikastaroa
 *
 * @ORM\Table(name="ikastaroa")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\IkastaroaRepository")
 */
class Ikastaroa
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hasi", type="date")
     */
    private $hasi;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="amaitu", type="date")
     */
    private $amaitu;

    /**
     * @var string
     *
     * @ORM\Column(name="deskribapena", type="text")
     */
    private $deskribapena;

    /**
     * @var bool
     *
     * @ORM\Column(name="ordaindubeharda", type="boolean")
     */
    private $ordaindubeharda;

    /**
     * @var bool
     *
     * @ORM\Column(name="ordainduta", type="boolean")
     */
    private $ordainduta;

    /**
     * @var string
     *
     * @ORM\Column(name="asistentzia", type="string", length=255)
     */
    private $asistentzia;


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
     * Set name.
     *
     * @param string $name
     *
     * @return Ikastaroa
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set hasi.
     *
     * @param \DateTime $hasi
     *
     * @return Ikastaroa
     */
    public function setHasi($hasi)
    {
        $this->hasi = $hasi;

        return $this;
    }

    /**
     * Get hasi.
     *
     * @return \DateTime
     */
    public function getHasi()
    {
        return $this->hasi;
    }

    /**
     * Set amaitu.
     *
     * @param \DateTime $amaitu
     *
     * @return Ikastaroa
     */
    public function setAmaitu($amaitu)
    {
        $this->amaitu = $amaitu;

        return $this;
    }

    /**
     * Get amaitu.
     *
     * @return \DateTime
     */
    public function getAmaitu()
    {
        return $this->amaitu;
    }

    /**
     * Set deskribapena.
     *
     * @param string $deskribapena
     *
     * @return Ikastaroa
     */
    public function setDeskribapena($deskribapena)
    {
        $this->deskribapena = $deskribapena;

        return $this;
    }

    /**
     * Get deskribapena.
     *
     * @return string
     */
    public function getDeskribapena()
    {
        return $this->deskribapena;
    }

    /**
     * Set ordaindubeharda.
     *
     * @param bool $ordaindubeharda
     *
     * @return Ikastaroa
     */
    public function setOrdaindubeharda($ordaindubeharda)
    {
        $this->ordaindubeharda = $ordaindubeharda;

        return $this;
    }

    /**
     * Get ordaindubeharda.
     *
     * @return bool
     */
    public function getOrdaindubeharda()
    {
        return $this->ordaindubeharda;
    }

    /**
     * Set ordainduta.
     *
     * @param bool $ordainduta
     *
     * @return Ikastaroa
     */
    public function setOrdainduta($ordainduta)
    {
        $this->ordainduta = $ordainduta;

        return $this;
    }

    /**
     * Get ordainduta.
     *
     * @return bool
     */
    public function getOrdainduta()
    {
        return $this->ordainduta;
    }

    /**
     * Set asistentzia.
     *
     * @param string $asistentzia
     *
     * @return Ikastaroa
     */
    public function setAsistentzia($asistentzia)
    {
        $this->asistentzia = $asistentzia;

        return $this;
    }

    /**
     * Get asistentzia.
     *
     * @return string
     */
    public function getAsistentzia()
    {
        return $this->asistentzia;
    }
}
