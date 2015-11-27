<?php

namespace Ais\MatakuliahBundle\Model;

Interface MatakuliahInterface
{
	    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set kode
     *
     * @param string $kode
     *
     * @return Matakuliah
     */
    public function setKode($kode);

    /**
     * Get kode
     *
     * @return string
     */
    public function getKode();

    /**
     * Set nama
     *
     * @param string $nama
     *
     * @return Matakuliah
     */
    public function setNama($nama);

    /**
     * Get nama
     *
     * @return string
     */
    public function getNama();

    /**
     * Set namaSingkat
     *
     * @param string $namaSingkat
     *
     * @return Matakuliah
     */
    public function setNamaSingkat($namaSingkat);

    /**
     * Get namaSingkat
     *
     * @return string
     */
    public function getNamaSingkat();

    /**
     * Set prodiId
     *
     * @param integer $prodiId
     *
     * @return Matakuliah
     */
    public function setProdiId($prodiId);

    /**
     * Get prodiId
     *
     * @return integer
     */
    public function getProdiId();

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Matakuliah
     */
    public function setIsActive($isActive);

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive();

    /**
     * Set isDelete
     *
     * @param boolean $isDelete
     *
     * @return Matakuliah
     */
    public function setIsDelete($isDelete);

    /**
     * Get isDelete
     *
     * @return boolean
     */
    public function getIsDelete();
}
