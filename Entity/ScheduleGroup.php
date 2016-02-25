<?php
/**
 * ScheduleGroup.php
 * Created by: Dizzy B High
 * Email: dizzy@base5designs.co.uk.
 * User: Dizzy
 * NFLtest - 09, 2015
 */

namespace FantasyPro\GameBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FantasyPro\DataBundle\Entity\Schedule;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ScheduleGroup
 *
 * @ORM\Table(name="fp_scheduleGroup")
 * @ORM\Entity(repositoryClass="FantasyPro\GameBundle\Entity\ScheduleGroupRepository")
 */
class ScheduleGroup
{

    public function __construct()
    {
        $this->schedules = new ArrayCollection();
        $this->contests  = new ArrayCollection();
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
     * @var string
     * @ORM\Column(type="string", length=50, nullable=false, name="name")
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @Assert\Valid()
     * @ORM\ManyToMany(targetEntity="FantasyPro\DataBundle\Entity\Schedule")
     * @ORM\JoinTable(name="schedulegroup_schedule",
     *      joinColumns={@ORM\JoinColumn(name="schedulegroup_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="schedule_id", referencedColumnName="id")}
     *      )
     */
    private $schedules;

    /**
     * @ORM\OneToMany(targetEntity="FantasyPro\GameBundle\Entity\Contest", mappedBy="scheduleGroup")
     */
    private $contests;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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

    public function getSchedules()
    {
        return $this->schedules;
    }

    public function setSchedules( Schedule $schedules = null )
    {
        $this->schedules = $schedules;
    }

    public function getContests()
    {
        return $this->contests;
    }

    public function setContests( Contest $contests = null )
    {
        $this->contests = $contests;
    }
}
