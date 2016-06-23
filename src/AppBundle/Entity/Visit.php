<?php
/**
 * Created by PhpStorm.
 * User: tw
 * Date: 18.10.15
 * Time: 21:24
 */

// src/AppBundle/Entity/Visit.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="visit")
 */
class Visit
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="date")
     */
    protected $date;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $description;

    /**
     * @ORM\ManyToOne(targetEntity="Pet", inversedBy="visits")
     * @ORM\JoinColumn(name="pet_id", referencedColumnName="id")
     **/
    protected $pet;

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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Visit
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Visit
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set pet
     *
     * @param \AppBundle\Entity\Pet $pet
     *
     * @return Visit
     */
    public function setPet(\AppBundle\Entity\Pet $pet = null)
    {
        $this->pet = $pet;

        return $this;
    }

    /**
     * Get pet
     *
     * @return \AppBundle\Entity\Pet
     */
    public function getPet()
    {
        return $this->pet;
    }
}
