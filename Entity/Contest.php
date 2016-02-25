<?php

namespace FantasyPro\GameBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FantasyPro\UserBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Contest
 *
 * @ORM\Table(name="fp_contest")
 * @ORM\Entity(repositoryClass="FantasyPro\GameBundle\Entity\ContestRepository")
 */
class Contest
{
    public function __construct()
    {
        $this->scheduleGroup   = new ArrayCollection();
        $this->contestStyle    = new ArrayCollection();
        $this->entryFee        = new ArrayCollection();
        $this->payoutStructure = new ArrayCollection();
        $this->contestEntries  = new ArrayCollection();
    }

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", name="id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="FantasyPro\GameBundle\Entity\ScheduleGroup", inversedBy="contests")
     * @ORM\JoinColumn(name="scheduleGroup_id", referencedColumnName="id")
     * @Assert\Valid()
     */
    private $scheduleGroup;

    /**
     * @ORM\ManyToOne(targetEntity="FantasyPro\GameBundle\Entity\ContestStyle", inversedBy="contests")
     * @ORM\JoinColumn(name="contestStyle_id", referencedColumnName="id")
     * @Assert\Valid()
     *
     */
    private $contestStyle;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false, name="playerCount")
     * @Assert\NotBlank()
     */
    private $playerCount;

    /**
     * @ORM\ManyToOne(targetEntity="FantasyPro\GameBundle\Entity\EntryFee", inversedBy="contests")
     * @ORM\JoinColumn(name="entryFee_id", referencedColumnName="id")
     * @Assert\Valid()
     */
    private $entryFee;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="FantasyPro\GameBundle\Entity\PayoutStructure", inversedBy="contests")
     * @ORM\JoinColumn(name="payoutStructure_id", referencedColumnName="id")
     */
    private $payoutStructure;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true, name="name")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true, name="playerScope")
     *
     */
    private $playerScope;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true, name="created")
     *
     */
    private $initialised;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\OneToMany(targetEntity="FantasyPro\GameBundle\Entity\ContestEntry", mappedBy="contest")
     */
    private $contestEntries;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\ManyToMany(targetEntity="FantasyPro\UserBundle\Entity\User", mappedBy="contests")
     **/
    private $users;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function getScheduleGroup()
    {
        return $this->scheduleGroup;
    }

    /**
     * @param ScheduleGroup $scheduleGroup
     */
    public function setScheduleGroup( ScheduleGroup $scheduleGroup = null )
    {
        $this->scheduleGroup = $scheduleGroup;
    }

    public function getContestStyle()
    {
        return $this->contestStyle;
    }

    /**
     * @param ContestStyle $contestStyle
     */
    public function setContestStyle( ContestStyle $contestStyle = null )
    {
        $this->contestStyle = $contestStyle;
    }

    /**
     * @return int
     */
    public function getPlayerCount()
    {
        return $this->playerCount;
    }

    /**
     * @param int $playerCount
     */
    public function setPlayerCount( $playerCount )
    {
        $this->playerCount = $playerCount;
    }

    public function getEntryFee()
    {
        return $this->entryFee;
    }

    public function setEntryFee( EntryFee $entryFee = null )
    {
        $this->entryFee = $entryFee;
    }

    /**
     * @return string
     */
    public function getPayoutStructure()
    {
        return $this->payoutStructure;
    }

    /**
     * @param string $payoutStructure
     */
    public function setPayoutStructure( $payoutStructure )
    {
        $this->payoutStructure = $payoutStructure;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName( $name )
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPlayerScope()
    {
        return $this->playerScope;
    }

    /**
     * @param string $playerScope
     */
    public function setPlayerScope( $playerScope )
    {
        $this->playerScope = $playerScope;
    }

    /**
     * @return boolean
     */
    public function isInitialised()
    {
        return $this->initialised;
    }

    /**
     * @param boolean $initialised
     */
    public function setInitialised( $initialised )
    {
        $this->initialised = $initialised;
    }

    public function getContestEntries()
    {
        return $this->contestEntries;
    }

    public function  addContestEntry( $contestEntry = null )
    {
        $this->contestEntries[] = $contestEntry;

        return $this;
    }

    /**
     * @return User
     */
    public function getUsers()
    {
        return $this->users;
    }

    public function  addUser( $user )
    {
        $this->users[] = $user;

        return $this;
    }

}

