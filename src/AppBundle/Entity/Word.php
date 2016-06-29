<?php

// src/AppBundle/Entity/Word.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="words")
 */
class Word {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $enWord;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $ptWord;

    /**
     * @ORM\Column(type="string", length=200)
     */
    protected $tip;

    public function __construct() {
        
    }

    public function __toString() {
        return strval($this->getEnWord() . " / " . $this->getPtWord());
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set enWord
     *
     * @param string $enWord
     *
     * @return Word
     */
    public function setEnWord($enWord) {
        $this->enWord = $enWord;

        return $this;
    }

    /**
     * Get enWord
     *
     * @return string
     */
    public function getEnWord() {
        return $this->enWord;
    }

    /**
     * Set ptWord
     *
     * @param string $ptWord
     *
     * @return Word
     */
    public function setPtWord($ptWord) {
        $this->ptWord = $ptWord;

        return $this;
    }

    /**
     * Get ptWord
     *
     * @return string
     */
    public function getPtWord() {
        return $this->ptWord;
    }

    /**
     * Set tip
     *
     * @param string $tip
     *
     * @return Word
     */
    public function setTip($tip) {
        $this->tip = $tip;

        return $this;
    }

    /**
     * Get tip
     *
     * @return string
     */
    public function getTip() {
        return $this->tip;
    }
}
