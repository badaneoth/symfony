<?php

namespace Pfi\CateBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * Film
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Film
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=45)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="info", type="date", length=245)
     */
    private $info;
    /**
     * @var string
     *
     * @ORM\Column(name="resume", type="string", length=445)
     */
    private $resume;


    /**
     *
     *
     *
     * @ORM\ManyToMany(targetEntity="image")
     * @ORM\JoinTable(name="Film_image",
     *      joinColumns={@ORM\JoinColumn(name="Film_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="image_id", referencedColumnName="id")}
     *      )
     **/
    private $image;


    private $commentaire;

    public function __construct(){
        $this->images = new ArrayCollection();
    }





    /**
     * @ORM\ManyToMany(targetEntity="Categorie")
     *
     * @ORM\JoinTable(name="Film_Categorie",
     *      joinColumns={@ORM\JoinColumn(name="Film_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="categorie_id", referencedColumnName="id")}
     *      )
     **/
    public  $categorie;

    /**
     * @ORM\ManyToMany(targetEntity="Acteur")
     */
    private $acteurs;

    public function __construct1()
    {
        $this->acteurs = new \Doctrine\Common\Collections\ArrayCollection();
    }
    /**
     * @ORM\ManyToMany(targetEntity="Realisateur")
     */
    private $realisateurs;

    public function __construct2()
    {
        $this->realisateurs = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nom
     *
     * @param string $nom
     * @return Film
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }
    /**
     * Set info
     *
     * @param string $info
     * @return Film
     */
    public function setInfo($info)
    {
        $this->info = $info;

    }

    /**
     * Get info
     *
     * @return string
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Set resume
     *
     * @param string $resume
     * @return Film
     */
    public function setResume($resume)
    {
        $this->resume = $resume;

        return $this;
    }

    /**
     * Get resume
     *
     * @return string
     */
    public function getResume()
    {
        return $this->resume;
    }
    /**
     * Set image
     *
     * @param array $image
     * @return Film
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return array
     *
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set categorie
     *
     * @param Pfi\CateBundle\Entity\Categorie $categorie
     */
    public function setCategorie(\Pfi\CateBundle\Entity\Categorie $categorie)
    {
        $this->categorie = $categorie;
    }

    /**
     * Get categorie
     *
     * @return Pfi\CateBundle\Entity\Categorie $categorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Add acteurs
     *
     * @param Pfi\CateBundle\Entity\Acteur $acteurs
     */
    public function addActeurs(\MyApp\FilmothequeBundle\Entity\Acteur $acteurs)
    {
        $this->acteurs[] = $acteurs;
    }

    /**
     * Get acteurs
     *
     * @return Doctrine\Common\Collections\Collection $acteurs
     */
    public function getActeurs()
    {
        return $this->acteurs;
    }

    /**
     * Add realisateurs
     *
     * @param Pfi\CateBundle\Entity\Realisateur $realisateurs
     */
    public function addRealisateurs(\MyApp\FilmothequeBundle\Entity\Realisateur $realisateurs)
    {
        $this->realisateurs[] = $realisateurs;
    }

    /**
     * Get realisateurs
     *
     * @return Doctrine\Common\Collections\Collection $realisateurs
     */
    public function getRealisateurs()
    {
        return $this->realisateurs;
    }




}
