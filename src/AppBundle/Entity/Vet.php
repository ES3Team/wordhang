<?php
/**
 * Created by PhpStorm.
 * User: tw
 * Date: 18.10.15
 * Time: 11:24
 */

// src/AppBundle/Entity/Vet.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="vets")
 */
class Vet
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
     * @ORM\ManyToMany(targetEntity="Specialty")
     * @ORM\JoinTable(name="vet_specialty",
     *      joinColumns={@ORM\JoinColumn(name="specialty_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="vet_id", referencedColumnName="id")}
     *      )
     **/
    protected $specialties;

    public function __construct() {
        $this->specialties = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Vet
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
     * @return Vet
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
     * Add specialty
     *
     * @param \AppBundle\Entity\Specialty $specialty
     *
     * @return Vet
     */
    public function addSpecialty(\AppBundle\Entity\Specialty $specialty)
    {
        $this->specialties[] = $specialty;

        return $this;
    }

    /**
     * Remove specialty
     *
     * @param \AppBundle\Entity\Specialty $specialty
     */
    public function removeSpecialty(\AppBundle\Entity\Specialty $specialty)
    {
        $this->specialties->removeElement($specialty);
    }

    /**
     * Get specialties
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSpecialties()
    {
        return $this->specialties;
    }
}
