<?php

namespace ClimaClass\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use ClimaClass\ApplicationBundle\Form\MessageType;
use ClimaClass\ApplicationBundle\Form\ConversationType;
use ClimaClass\ApplicationBundle\Entity\Message;
use ClimaClass\ApplicationBundle\Entity\Conversation;

class MessageController extends Controller {

    /**
     * @Route("/list_conversation", name="liste_conversation")
     * @Template()
     */
    public function listPrivateMessageAction(Request $request) {
        $conversations = $this->getDoctrine()->getRepository("ClimaClassApplicationBundle:Conversation")->findMyConversation($this->getUser());
        return array('conversations' => $conversations);
    }

    /**
     * @Route("/conversation/{id}", name="display_conversation")
     * @Template()
     */
    public function displayConversationAction(Request $request, $id) {
        $conversation = $this->getDoctrine()->getRepository("ClimaClassApplicationBundle:Conversation")->find($id);
        $message = new Message();
        $form = $this->createForm(new MessageType(), $message);
        $form->get('message')->set($message);
        $form->add('Send', 'submit');
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $message->setConversation($conversation);
            $message->setUser($this->getUser());
            $message->setPostDate(new \DateTime(date('Y-m-d H:i:s')));
            $em->persist($message);
            $em->flush();
            return $this->redirect($this->generateUrl('display_conversation',array('id'=>$id)));
        }
        return array('conversation' => $conversation, 'form' => $form->createView());
    }
    
     /**
     * @Route("/new_conversation/{id_recipient}", name="new_conversation")
     * @Template()
     */
    public function newConversationAction(Request $request, $id_recipient) {
        $conversation = new Conversation();
        $user_recipient=$this->getDoctrine()->getRepository("ClimaClassApplicationBundle:User")->find($id_recipient);
        $form = $this->createForm(new ConversationType(), $conversation);
        $form->add('Send', 'submit');
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $conversation->setUserCreator($this->getUser());
            $conversation->setUserRecipient($user_recipient);
            $conversation->getMessages()->setUser($this->getUser());
            $conversation->getMessages()->setPostDate(new \DateTime(date('Y-m-d H:i:s')));
            $em->persist($conversation);
            $em->flush();
            return $this->redirect($this->generateUrl('profile',array('id'=>$id_recipient)));
        }
        return array('form' => $form->createView());
    }
    

}
