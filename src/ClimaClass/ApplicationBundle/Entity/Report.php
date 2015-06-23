<?php

namespace ClimaClass\ApplicationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Report
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ClimaClass\ApplicationBundle\Entity\ReportRepository")
 */
class Report
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="post_date", type="datetime")
     */
    private $postDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_modification_date", type="datetime")
     */
    private $lastModificationDate;
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="reports")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     **/
    private $user;
    
    /**
     * @ORM\OneToMany(targetEntity="Measure", mappedBy="report", cascade={"persist"})
     **/
    private $measures;
    
    /**
     * @ORM\OneToMany(targetEntity="Video", mappedBy="report", cascade={"persist"})
     **/
    private $videos;
    
    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="report", cascade={"persist"})
     **/
    private $comments;
    
    public function __construct() {
        $this->measures = new ArrayCollection();
        $this->videos = new ArrayCollection();
        $this->comment = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return Report
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Report
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set postDate
     *
     * @param \DateTime $postDate
     * @return Report
     */
    public function setPostDate($postDate)
    {
        $this->postDate = $postDate;

        return $this;
    }

    /**
     * Get postDate
     *
     * @return \DateTime 
     */
    public function getPostDate()
    {
        return $this->postDate;
    }

    /**
     * Set lastModificationDate
     *
     * @param \DateTime $lastModificationDate
     * @return Report
     */
    public function setLastModificationDate($lastModificationDate)
    {
        $this->lastModificationDate = $lastModificationDate;

        return $this;
    }

    /**
     * Get lastModificationDate
     *
     * @return \DateTime 
     */
    public function getLastModificationDate()
    {
        return $this->lastModificationDate;
    }

    /**
     * Set user
     *
     * @param \ClimaClass\ApplicationBundle\Entity\User $user
     * @return Report
     */
    public function setUser(\ClimaClass\ApplicationBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \ClimaClass\ApplicationBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add measures
     *
     * @param \ClimaClass\ApplicationBundle\Entity\Measure $measures
     * @return Report
     */
    public function addMeasure(\ClimaClass\ApplicationBundle\Entity\Measure $measures)
    {
        $this->measures->add($measures);
        $measures->setReport($this);
        return $this;
    }

    /**
     * Remove measures
     *
     * @param \ClimaClass\ApplicationBundle\Entity\Measure $measures
     */
    public function removeMeasure(\ClimaClass\ApplicationBundle\Entity\Measure $measures)
    {
        $this->measures->removeElement($measures);
        $measures->setReport(null);
    }

    /**
     * Get measures
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMeasures()
    {
        return $this->measures;
    }

    /**
     * Add videos
     *
     * @param \ClimaClass\ApplicationBundle\Entity\Video $videos
     * @return Report
     */
    public function addVideo(\ClimaClass\ApplicationBundle\Entity\Video $videos)
    {
        $this->videos[] = $videos;

        return $this;
    }

    /**
     * Remove videos
     *
     * @param \ClimaClass\ApplicationBundle\Entity\Video $videos
     */
    public function removeVideo(\ClimaClass\ApplicationBundle\Entity\Video $videos)
    {
        $this->videos->removeElement($videos);
    }

    /**
     * Get videos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * Add comments
     *
     * @param \ClimaClass\ApplicationBundle\Entity\Comment $comments
     * @return Report
     */
    public function addComment(\ClimaClass\ApplicationBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \ClimaClass\ApplicationBundle\Entity\Comment $comments
     */
    public function removeComment(\ClimaClass\ApplicationBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }
    public function countMeasures()
    {
        return count($this->measures);
    }
    public function lastMeasure() {
        if($this->countMeasures() > 1){
            
        }
        return $this->measures[$this->countMeasures()-1];
    }
}
