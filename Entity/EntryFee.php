<?php

namespace FantasyPro\GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EntryFee
 *
 * @ORM\Table(name="fp_entryFee")
 * @ORM\Entity(repositoryClass="FantasyPro\GameBundle\Entity\EntryFeeRepository")
 */
class EntryFee
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", name="id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true, name="entryFee")
     */
    private $entryFee;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=true, name="entryFeeString")
     */
    private $entryFeeString;

    /**
     * @ORM\OneToMany(targetEntity="FantasyPro\GameBundle\Entity\Contest", mappedBy="entryFee")
     */
    private $contests;


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
     * Set entryFee
     *
     * @param integer $entryFee
     *
     * @return EntryFee
     */
    public function setEntryFee( $entryFee )
    {
        $this->entryFee = $entryFee;

        return $this;
    }

    /**
     * Get entryFee
     *
     * @return integer
     */
    public function getEntryFee()
    {
        return $this->entryFee;
    }

    /**
     * Set entryFeeString
     *
     * @param string $entryFeeString
     *
     * @return EntryFee
     */
    public function setEntryFeeString( $entryFeeString )
    {
        $this->entryFeeString = $entryFeeString;

        return $this;
    }

    /**
     * Get entryFeeString
     *
     * @return string
     */
    public function getEntryFeeString()
    {
        return $this->entryFeeString;
    }

}

