<?php

namespace FantasyPro\GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PayoutStructure
 *
 * @ORM\Table(name="fp_payoutStructure")
 * @ORM\Entity(repositoryClass="FantasyPro\GameBundle\Entity\PayoutStructureRepository")
 */
class PayoutStructure
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
     * @ORM\OneToMany(targetEntity="FantasyPro\GameBundle\Entity\Contest", mappedBy="payoutStructure")
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
     * @return PayoutStructure
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

