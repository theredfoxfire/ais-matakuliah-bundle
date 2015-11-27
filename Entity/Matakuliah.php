<?php

namespace Ais\MatakuliahBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ais\MatakuliahBundle\Model\MatakuliahInterface;
/**
 * Matakuliah
 */
class Matakuliah implements MatakuliahInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $kode;

    /**
     * @var string
     */
    private $nama;

    /**
     * @var string
     */
    private $nama_singkat;

    /**
     * @var integer
     */
    private $prodi_id;

    /**
     * @var boolean
     */
    private $is_active;

    /**
     * @var boolean
     */
    private $is_delete;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set kode
     *
     * @param string $kode
     *
     * @return Matakuliah
     */
    public function setKode($kode)
    {
        $this->kode = $kode;

        return $this;
    }

    /**
     * Get kode
     *
     * @return string
     */
    public function getKode()
    {
        return $this->kode;
    }

    /**
     * Set nama
     *
     * @param string $nama
     *
     * @return Matakuliah
     */
    public function setNama($nama)
    {
        $this->nama = $nama;

        return $this;
    }

    /**
     * Get nama
     *
     * @return string
     */
    public function getNama()
    {
        return $this->nama;
    }

    /**
     * Set namaSingkat
     *
     * @param string $namaSingkat
     *
     * @return Matakuliah
     */
    public function setNamaSingkat($namaSingkat)
    {
        $this->nama_singkat = $namaSingkat;

        return $this;
    }

    /**
     * Get namaSingkat
     *
     * @return string
     */
    public function getNamaSingkat()
    {
        return $this->nama_singkat;
    }

    /**
     * Set prodiId
     *
     * @param integer $prodiId
     *
     * @return Matakuliah
     */
    public function setProdiId($prodiId)
    {
        $this->prodi_id = $prodiId;

        return $this;
    }

    /**
     * Get prodiId
     *
     * @return integer
     */
    public function getProdiId()
    {
        return $this->prodi_id;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Matakuliah
     */
    public function setIsActive($isActive)
    {
        $this->is_active = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * Set isDelete
     *
     * @param boolean $isDelete
     *
     * @return Matakuliah
     */
    public function setIsDelete($isDelete)
    {
        $this->is_delete = $isDelete;

        return $this;
    }

    /**
     * Get isDelete
     *
     * @return boolean
     */
    public function getIsDelete()
    {
        return $this->is_delete;
    }
}

