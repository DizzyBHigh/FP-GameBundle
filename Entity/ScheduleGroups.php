<?php
/**
 * ScheduleGroups.php 
 * Created by: Dizzy B High 
 * Email: dizzy@base5designs.co.uk.
 * User: Dizzy
 * NFLtest - 09, 2015
 */

namespace FantasyPro\GameBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ScheduleGroups
 *
 * @ORM\Table(name="fp_scheduleGroups")
 * @ORM\Entity(repositoryClass="FantasyPro\GameBundle\Entity\ScheduleGroupsRepository")
 */
class ScheduleGroups {

    public function __construct()
    {
        $this->schedules = new ArrayCollection();
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="scheduleGroupID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="FantasyPro\DataBundle\Entity\Schedule", mappedBy="ScheduleGroups")
     * @ORM\Column(type="string")
     */
    protected $schedules;

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

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

}