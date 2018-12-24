<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompanyRepository")
 */
class Company
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", length=100)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $body;

    /**
     * @ORM\Column(type="float")
     */
    private $str;

    /**
     * @ORM\Column(type="float")
     */
    private $usd;

    /**
     * @ORM\Column(type="float")
     */
    private $euro;

    //Getters & Setters
    public function getId(){
        return $this->id;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getBody(){
        return $this->body;
    }

    public function getStr(){
        return $this->str;
    }

    public function getUsd(){
        return $this->usd;
    }

    public function getEuro(){
        return $this->euro;
    }

    public function setTitle($title){
        $this->title = $title;
    }

    public function setBody($body){
        $this->body = $body;
    }

    public function setStr($str){
        $this->str = $str;
    }

    public function setEuro($euro){
        $this->euro = $euro;
    }

    public function setUsd($usd){
        $this->usd = $usd;
    }
}
