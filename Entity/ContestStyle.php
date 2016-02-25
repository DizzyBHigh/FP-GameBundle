<?php

namespace FantasyPro\GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContestStyle
 *
 * @ORM\Table(name="fp_contestStyle")
 * @ORM\Entity(repositoryClass="FantasyPro\GameBundle\Entity\ContestStyleRepository")
 */
class ContestStyle
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
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true, name="name")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="FantasyPro\GameBundle\Entity\Contest", mappedBy="contestStyle")
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
     * Set name
     *
     * @param string $name
     *
     * @return ContestStyle
     */
    public function setName( $name )
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}

