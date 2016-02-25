<?php

namespace FantasyPro\GameBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FantasyPro\DataBundle\Entity\Player;
use FantasyPro\DataBundle\Entity\Team;

/**
 * ContestEntry
 *
 * @ORM\Table(name="fp_contestEntry")
 * @ORM\Entity(repositoryClass="FantasyPro\GameBundle\Entity\ContestEntryRepository")
 */
class ContestEntry
{
    public function __construct()
    {
        $this->user    = new ArrayCollection();
        $this->contest = new ArrayCollection();
    }

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", name="id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="FantasyPro\UserBundle\Entity\User", inversedBy="contestEntries")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="FantasyPro\GameBundle\Entity\Contest", inversedBy="contestEntries")
     */
    private $contest;

    /**
     * @ORM\ManyToOne(targetEntity="FantasyPro\DataBundle\Entity\Player")
     * @ORM\JoinColumn(name="qb", referencedColumnName="id")
     */
    private $qb;

    /**
     * @ORM\ManyToOne(targetEntity="FantasyPro\DataBundle\Entity\Player")
     * @ORM\JoinColumn(name="wr1", referencedColumnName="id")
     */
    private $wr1;

    /**
     * @ORM\ManyToOne(targetEntity="FantasyPro\DataBundle\Entity\Player")
     * @ORM\JoinColumn(name="wr2", referencedColumnName="id")
     */
    private $wr2;

    /**
     * @ORM\ManyToOne(targetEntity="FantasyPro\DataBundle\Entity\Player")
     * @ORM\JoinColumn(name="rb1", referencedColumnName="id")
     */
    private $rb1;

    /**
     * @ORM\ManyToOne(targetEntity="FantasyPro\DataBundle\Entity\Player")
     * @ORM\JoinColumn(name="rb2", referencedColumnName="id")
     */
    private $rb2;

    /**
     * @ORM\ManyToOne(targetEntity="FantasyPro\DataBundle\Entity\Player")
     * @ORM\JoinColumn(name="te", referencedColumnName="id")
     */
    private $te;

    /**
     * @ORM\ManyToOne(targetEntity="FantasyPro\DataBundle\Entity\Player")
     * @ORM\JoinColumn(name="k", referencedColumnName="id")
     */
    private $k;

    /**
     * @ORM\ManyToOne(targetEntity="FantasyPro\DataBundle\Entity\Player")
     * @ORM\JoinColumn(name="flex", referencedColumnName="id")
     */
    private $flex;

    /**
     * @ORM\ManyToOne(targetEntity="FantasyPro\DataBundle\Entity\Team")
     * @ORM\JoinColumn(name="def", referencedColumnName="id")
     */
    private $def;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true, name="locked")
     */
    private $locked;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param int $user
     */
    public function setUser( $user = null )
    {
        $this->user = $user;
    }

    /**
     * @return Contest
     */
    public function getContest()
    {
        return $this->contest;
    }

    public function setContest( $contest = null )
    {
        $this->contest = $contest;
    }

    /**
     * @return int
     */
    public function getQb()
    {
        return $this->qb;
    }

    /**
     * @param int $qb
     *
     * @return $this
     */
    public function setQb( $qb = null )
    {
        $this->qb = $qb;

        return $this;
    }

    /**
     * @return int
     */
    public function getWr1()
    {
        return $this->wr1;
    }

    /**
     * @param int $wr1
     *
     * @return $this
     */
    public function setWr1( $wr1 = null )
    {
        $this->wr1 = $wr1;

        return $this;
    }

    /**
     * @return int
     */
    public function getWr2()
    {
        return $this->wr2;
    }

    /**
     * @param int $wr2
     *
     * @return $this
     */
    public function setWr2( $wr2 = null )
    {
        $this->wr2 = $wr2;

        return $this;
    }

    /**
     * @return int
     */
    public function getRb1()
    {
        return $this->rb1;
    }

    /**
     * @param int $rb1
     *
     * @return $this
     */
    public function setRb1( $rb1 = null )
    {
        $this->rb1 = $rb1;

        return $this;
    }

    /**
     * @return int
     */
    public function getRb2()
    {
        return $this->rb2;
    }

    /**
     * @param int $rb2
     *
     * @return $this
     */
    public function setRb2( $rb2 = null )
    {
        $this->rb2 = $rb2;

        return $this;
    }

    /**
     * @return int
     */
    public function getTe()
    {
        return $this->te;
    }

    /**
     * @param int $te
     *
     * @return $this
     */
    public function setTe( $te = null )
    {
        $this->te = $te;

        return $this;
    }

    /**
     * @return int
     */
    public function getFlex()
    {
        return $this->flex;
    }

    /**
     * @param int $flex
     *
     * @return $this
     */
    public function setFlex( $flex = null )
    {
        $this->flex = $flex;

        return $this;
    }

    /**
     * @return int
     */
    public function getK()
    {
        return $this->k;
    }

    /**
     * @param int $k
     *
     * @return $this
     */
    public function setK( $k = null )
    {
        $this->k = $k;

        return $this;
    }

    /**
     * @return int
     */
    public function getDef()
    {
        return $this->def;
    }

    /**
     * @param int $def
     *
     * @return $this
     */
    public function setDef( $def = null )
    {
        $this->def = $def;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isLocked()
    {
        return $this->locked;
    }

    /**
     * @param boolean $locked
     */
    public function setLocked( $locked )
    {
        $this->locked = $locked;
    }
}

