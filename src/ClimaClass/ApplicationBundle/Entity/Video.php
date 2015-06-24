<?php

namespace ClimaClass\ApplicationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Video
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ClimaClass\ApplicationBundle\Entity\VideoRepository")
 */
class Video {

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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Report", inversedBy="videos", cascade={"persist"})
     * @ORM\JoinColumn(name="id_report", referencedColumnName="id")
     * */
    private $report;
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
        $this->name = $name;

    }

    public function getUploadDir() {
        // On retourne le chemin relatif vers l'image pour un navigateur (relatif au répertoire /web donc)
        return 'bundles/climaclassapplication/videos';
    }

    protected function getUploadRootDir() {
        // On retourne le chemin relatif vers l'image pour notre code PHP
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
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
     * Set name
     *
     * @param string $name
     * @return Video
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set report
     *
     * @param \ClimaClass\ApplicationBundle\Entity\Report $report
     * @return Video
     */
    public function setReport(\ClimaClass\ApplicationBundle\Entity\Report $report = null) {
        $this->report = $report;

        return $this;
    }

    /**
     * Get report
     *
     * @return \ClimaClass\ApplicationBundle\Entity\Report 
     */
    public function getReport() {
        return $this->report;
    }

}
