<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
* @ORM\Entity()
* @ORM\Table(name="articles")
*/
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message = "Titre non vide")
     */
    private $title;
    
    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message = "Contenu non vide")
     */
    private $content;
    
    /**
     * @ORM\Column(type="text")
     */
    private $cover;
    
    /**
    * @ORM\Column(type="datetime")
    */
    private $date;

    public function __construct(){
        $this->date = new DateTime();
    }

    public function getId(){
        return $this->id;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getContent(){
        return $this->content;
    }

    public function getCover(){
        return $this->cover;
    }

    public function getDate(){
        return $this->date;
    }

    public function setId($id){
        $this->id = $id;
    }
    
    public function setTitle($title){
        $this->title = $title;
    }

    public function setContent($content){
        $this->content = $content;
    }

    public function setCover($cover){
        $this->cover = $cover;
    }

    public function setDate($date){
        $this->date = $date;
    }
}
