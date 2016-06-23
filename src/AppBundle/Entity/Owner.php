<?php
/**
 * Created by PhpStorm.
 * User: tw
 * Date: 18.10.15
 * Time: 21:07
 */

// src/AppBundle/Entity/Owner.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="owners")
 */
class Owner
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
    protected $firstName;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $lastName;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $address;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $city;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $telephone;

    /**
     * @ORM\OneToMany(targetEntity="Pet", mappedBy="owner")
     **/
    protected $pets;

    public function __construct()
    {
        $this->pets = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return strval($this->getFirstName()." ".$this->getLastName());
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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Owner
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Owner
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Owner
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Owner
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return Owner
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Add pet
     *
     * @param \AppBundle\Entity\Pet $pet
     *
     * @return Owner
     */
    public function addPet(\AppBundle\Entity\Pet $pet)
    {
        $this->pets[] = $pet;

        return $this;
    }

    /**
     * Remove pet
     *
     * @param \AppBundle\Entity\Pet $pet
     */
    public function removePet(\AppBundle\Entity\Pet $pet)
    {
        $this->pets->removeElement($pet);
    }

    /**
     * Get pets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPets()
    {
        return $this->pets;
    }
}
