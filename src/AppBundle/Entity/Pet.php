<?php
/**
 * Created by PhpStorm.
 * User: tw
 * Date: 18.10.15
 * Time: 11:54
 */


// src/AppBundle/Entity/Pet.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="pets")
 */
class Pet
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;

    /**
     * @ORM\Column(type="date")
     */
    protected $birthdate;

    /**
     * @ORM\ManyToOne(targetEntity="PetType")
     * @ORM\JoinColumn(name="pettype_id", referencedColumnName="id")
     **/
    protected $petType;

    /**
     * @ORM\ManyToOne(targetEntity="Owner", inversedBy="pets")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     **/
    protected $owner;

    /**
     * @ORM\OneToMany(targetEntity="Visit", mappedBy="pet")
     **/
    protected $visits;

    public function __toString()
    {
        return strval($this->getName());
    }

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
     * @return Pet
     */
    public function setName($name)
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

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     *
     * @return Pet
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set petType
     *
     * @param \AppBundle\Entity\PetType $petType
     *
     * @return Pet
     */
    public function setPetType(\AppBundle\Entity\PetType $petType = null)
    {
        $this->petType = $petType;

        return $this;
    }

    /**
     * Get petType
     *
     * @return \AppBundle\Entity\PetType
     */
    public function getPetType()
    {
        return $this->petType;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->visits = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set owner
     *
     * @param \AppBundle\Entity\Owner $owner
     *
     * @return Pet
     */
    public function setOwner(\AppBundle\Entity\Owner $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \AppBundle\Entity\Owner
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Add visit
     *
     * @param \AppBundle\Entity\Visit $visit
     *
     * @return Pet
     */
    public function addVisit(\AppBundle\Entity\Visit $visit)
    {
        $this->visits[] = $visit;

        return $this;
    }

    /**
     * Remove visit
     *
     * @param \AppBundle\Entity\Visit $visit
     */
    public function removeVisit(\AppBundle\Entity\Visit $visit)
    {
        $this->visits->removeElement($visit);
    }

    /**
     * Get visits
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVisits()
    {
        return $this->visits;
    }
}
