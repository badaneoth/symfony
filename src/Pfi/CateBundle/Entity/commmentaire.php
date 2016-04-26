<?php


namespace Pfi\CateBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;






/**
 *   commmentaire
 *
 * @ORM\Table()
 * @ORM\Entity
  */
class commmentaire
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
     * @ORM\Column(name="comment", type="string", length=445)
     */
    private $comment;



    /**
     *
     *
     *
     * @ORM\ManyToMany(targetEntity="Film")
     * @ORM\JoinTable(name="commmentaire_film",
     *      joinColumns={@ORM\JoinColumn(name="commmentaire_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="Film_id", referencedColumnName="id")}
     *      )
     **/
    private $film;



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
     * Set
     *
     * @param string $nom
     * @return commentaire
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }




}