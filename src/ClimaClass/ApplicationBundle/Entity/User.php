<?php

namespace ClimaClass\ApplicationBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ClimaClass\ApplicationBundle\Entity\UserRepository")
 */
class User extends BaseUser {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="establishment", type="string", length=255, nullable=true)
     */
    private $establishment;

    /**
     * @var string
     *
     * @ORM\Column(name="class", type="string", length=255, nullable=true)
     */
    private $class;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float", scale=7, nullable=true)
     */
    private $latitude;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float", scale=7, nullable=true)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="picture", type="string", length=255)
     */
    private $picture = 'default.png';

    /**
     * @ORM\ManyToOne(targetEntity="Language")
     * @ORM\JoinColumn(name="main_language", referencedColumnName="id")
     * */
    private $main_language;

    /**
     * @ORM\ManyToMany(targetEntity="Language")
     * @ORM\JoinTable(name="user_language",
     *      joinColumns={@ORM\JoinColumn(name="id_user", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_language", referencedColumnName="id")}
     *      )
     * */
    private $languages;

    /**
     * @ORM\OneToMany(targetEntity="Report", mappedBy="user")
     * */
    private $reports;
    private $file;

    public function getFile() {

        return $this->file;
    }

    public function setFile(UploadedFile $file = null) {

        $this->file = $file;
    }

    public function upload() {
        // Si jamais il n'y a pas de fichier (champ facultatif), on ne fait rien
        if (null === $this->file) {
            return;
        }

        // On récupère le nom original du fichier de l'internaute
        $name = $this->file->getClientOriginalName();


        // On déplace le fichier envoyé dans le répertoire de notre choix
        $this->file->move($this->getUploadRootDir(), $name);

        // On sauvegarde le nom de fichier dans notre attribut $url
        $this->picture = $name;
    }

    public function getUploadDir() {
        // On retourne le chemin relatif vers l'image pour un navigateur (relatif au répertoire /web donc)
        return 'bundles/climatclassapplication/images/users';
    }

    protected function getUploadRootDir() {
        // On retourne le chemin relatif vers l'image pour notre code PHP
        return __DIR__ . '/../../../web/' . $this->getUploadDir();
    }

    public function __construct() {
        parent::__construct();
        $this->reports = new ArrayCollection();
        $this->languages = new ArrayCollection();
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
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname) {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname() {
        return $this->lastname;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname) {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname() {
        return $this->firstname;
    }

    /**
     * Set establishment
     *
     * @param string $establishment
     * @return User
     */
    public function setEstablishment($establishment) {
        $this->establishment = $establishment;

        return $this;
    }

    /**
     * Get establishment
     *
     * @return string 
     */
    public function getEstablishment() {
        return $this->establishment;
    }

    /**
     * Set class
     *
     * @param string $class
     * @return User
     */
    public function setClass($class) {
        $this->class = $class;

        return $this;
    }

    /**
     * Get class
     *
     * @return string 
     */
    public function getClass() {
        return $this->class;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     * @return User
     */
    public function setLatitude($latitude) {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float 
     */
    public function getLatitude() {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     * @return User
     */
    public function setLongitude($longitude) {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float 
     */
    public function getLongitude() {
        return $this->longitude;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return User
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set picture
     *
     * @param string $picture
     * @return User
     */
    public function setPicture($picture) {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string 
     */
    public function getPicture() {
        return $this->picture;
    }

    /**
     * Set main_language
     *
     * @param \ClimaClass\ApplicationBundle\Entity\Language $mainLanguage
     * @return User
     */
    public function setMainLanguage(\ClimaClass\ApplicationBundle\Entity\Language $mainLanguage = null) {
        $this->main_language = $mainLanguage;

        return $this;
    }

    /**
     * Get main_language
     *
     * @return \ClimaClass\ApplicationBundle\Entity\Language 
     */
    public function getMainLanguage() {
        return $this->main_language;
    }

    /**
     * Add languages
     *
     * @param \ClimaClass\ApplicationBundle\Entity\Language $languages
     * @return User
     */
    public function addLanguage(\ClimaClass\ApplicationBundle\Entity\Language $languages) {
        $this->languages[] = $languages;

        return $this;
    }

    /**
     * Remove languages
     *
     * @param \ClimaClass\ApplicationBundle\Entity\Language $languages
     */
    public function removeLanguage(\ClimaClass\ApplicationBundle\Entity\Language $languages) {
        $this->languages->removeElement($languages);
    }

    /**
     * Get languages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLanguages() {
        return $this->languages;
    }

    /**
     * Add reports
     *
     * @param \ClimaClass\ApplicationBundle\Entity\Report $reports
     * @return User
     */
    public function addReport(\ClimaClass\ApplicationBundle\Entity\Report $reports) {
        $this->reports[] = $reports;

        return $this;
    }

    /**
     * Remove reports
     *
     * @param \ClimaClass\ApplicationBundle\Entity\Report $reports
     */
    public function removeReport(\ClimaClass\ApplicationBundle\Entity\Report $reports) {
        $this->reports->removeElement($reports);
    }

    /**
     * Get reports
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReports() {
        return $this->reports;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return User
     */
    public function setAddress($address) {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress() {
        return $this->address;
    }

    public function getCompleteName() {
        return $this->getLastname() . ' ' . $this->getFirstname() ;
    }

}
