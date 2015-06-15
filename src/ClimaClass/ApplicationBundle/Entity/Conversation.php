<?php

namespace ClimaClass\ApplicationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
    private $user_creator;
    
    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="id_user_recipient", referencedColumnName="id")
     **/
    private $user_recipient;
    
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
        $this->user_creator = $userCreator;

        return $this;
    }

    /**
     * Get user_creator
     *
     * @return \ClimaClass\ApplicationBundle\Entity\User 
     */
    public function getUserCreator()
    {
        return $this->user_creator;
    }

    /**
     * Set user_recipient
     *
     * @param \ClimaClass\ApplicationBundle\Entity\User $userRecipient
     * @return Conversation
     */
    public function setUserRecipient(\ClimaClass\ApplicationBundle\Entity\User $userRecipient = null)
    {
        $this->user_recipient = $userRecipient;

        return $this;
    }

    /**
     * Get user_recipient
     *
     * @return \ClimaClass\ApplicationBundle\Entity\User 
     */
    public function getUserRecipient()
    {
        return $this->user_recipient;
    }
}
