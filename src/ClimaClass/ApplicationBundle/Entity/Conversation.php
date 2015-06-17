<?php

namespace ClimaClass\ApplicationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Conversation
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ClimaClass\ApplicationBundle\Entity\ConversationRepository")
 */
class Conversation
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
     * @ORM\Column(name="subject", type="string", length=255)
     */
    private $subject;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="id_user_creator", referencedColumnName="id")
     **/
    private $userCreator;
    
    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="id_user_recipient", referencedColumnName="id")
     **/
    private $userRecipient;
     
    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="conversation", cascade={"persist"})
     **/
    private $messages;
    
    public function __construct() {
        $this->messages = new ArrayCollection();
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
     * Set subject
     *
     * @param string $subject
     * @return Conversation
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set user_creator
     *
     * @param \ClimaClass\ApplicationBundle\Entity\User $userCreator
     * @return Conversation
     */
    public function setUserCreator(\ClimaClass\ApplicationBundle\Entity\User $userCreator = null)
    {
        $this->userCreator = $userCreator;

        return $this;
    }

    /**
     * Get user_creator
     *
     * @return \ClimaClass\ApplicationBundle\Entity\User 
     */
    public function getUserCreator()
    {
        return $this->userCreator;
    }

    /**
     * Set user_recipient
     *
     * @param \ClimaClass\ApplicationBundle\Entity\User $userRecipient
     * @return Conversation
     */
    public function setUserRecipient(\ClimaClass\ApplicationBundle\Entity\User $userRecipient = null)
    {
        $this->userRecipient = $userRecipient;

        return $this;
    }

    /**
     * Get user_recipient
     *
     * @return \ClimaClass\ApplicationBundle\Entity\User 
     */
    public function getUserRecipient()
    {
        return $this->userRecipient;
    }

    /**
     * Add messages
     *
     * @param \ClimaClass\ApplicationBundle\Entity\Message $messages
     * @return Conversation
     */
    public function addMessage(\ClimaClass\ApplicationBundle\Entity\Message $messages)
    {
        $this->messages[] = $messages;

        return $this;
    }

    /**
     * Remove messages
     *
     * @param \ClimaClass\ApplicationBundle\Entity\Message $messages
     */
    public function removeMessage(\ClimaClass\ApplicationBundle\Entity\Message $messages)
    {
        $this->messages->removeElement($messages);
    }

    /**
     * Get messages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMessages()
    {
        return $this->messages;
    }
}
