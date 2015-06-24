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
     * @Route("/conversation/list_conversation", name="list_conversation")
     * @Template()
     */
    public function listPrivateMessageAction(Request $request) {
        $conversations = $this->getDoctrine()->getRepository("ClimaClassApplicationBundle:Conversation")->findMyConversation($this->getUser());
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($conversations, $request->query->getInt('page', 1), 20);
        return array('pagination' => $pagination);
    }

    /**
     * @Route("/admin/conversation/list_conversation_admin", name="liste_conversation_admin")
     * @Template()
     */
    public function listPrivateMessageAdminAction(Request $request) {
        $conversations = $this->getDoctrine()->getRepository("ClimaClassApplicationBundle:Conversation")->findByAdmin(1);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($conversations, $request->query->getInt('page', 1), 20);
        return array('pagination' => $pagination);
    }

    /**
     * @Route("/conversation/{id}", name="display_conversation")
     * @Template()
     */
    public function displayConversationAction(Request $request, $id) {
        $conversation = $this->getDoctrine()->getRepository("ClimaClassApplicationBundle:Conversation")->find($id);
        $messages = $this->getDoctrine()->getRepository("ClimaClassApplicationBundle:Message")->findByConversation($conversation);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($messages, $request->query->getInt('page', 1), 20);
        $message = new Message();
        $form = $this->createForm(new MessageType(), $message);
        $form->add('Send', 'submit');
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $message->setConversation($conversation);
            $message->setUser($this->getUser());
            $message->setPostDate(new \DateTime(date('Y-m-d H:i:s')));
            $em->persist($message);
            $em->flush();
            return $this->redirect($this->generateUrl('display_conversation', array('id' => $id)));
        }
        return array('conversation' => $conversation, 'form' => $form->createView(),'pagination'=>$pagination);
    }

    /**
     * @Route("/conversation/new_conversation/{id_recipient}", name="new_conversation")
     * @Template()
     */
    public function newConversationAction(Request $request, $id_recipient) {
        $conversation = new Conversation();
        $message = new Message();
        $user_recipient = $this->getDoctrine()->getRepository("ClimaClassApplicationBundle:User")->find($id_recipient);
        $form = $this->createFormBuilder()
                ->add('subject', 'text', array('required' => true))
                ->add('body', 'textarea', array('required' => true))
                ->add('Send', 'submit');
        $form = $form->getForm();

        $form->handleRequest($request);
        $data = $form->getData();
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $conversation->setUserCreator($this->getUser());
            $conversation->setUserRecipient($user_recipient);
            $conversation->setSubject($data['subject']);
            $conversation->setAdmin(0);
            $em->persist($conversation);
            $message->setConversation($conversation);
            $message->setUser($this->getUser());
            $message->setPostDate(new \DateTime(date('Y-m-d H:i:s')));
            $message->setBody($data['body']);
            $em->persist($message);
            $em->flush();
            return $this->redirect($this->generateUrl('profile', array('id' => $id_recipient)));
        }
        return array('form' => $form->createView());
    }

    /**
     * @Route("/message/admin", name="message_admin")
     * @Template()
     */
    public function messageAdminAction(Request $request) {
        $conversation = new Conversation();
        $message = new Message();
        $form = $this->createFormBuilder()
                ->add('subject', 'text', array('required' => true))
                ->add('body', 'textarea', array('required' => true))
                ->add('mail', 'email', array('required' => false))
                ->add('Send', 'submit');
        $form = $form->getForm();

        $form->handleRequest($request);
        $data = $form->getData();
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $conversation->setUserCreator($this->getUser());
            $conversation->setSubject($data['subject']);
            $conversation->setMail($data['mail']);
            $conversation->setAdmin(1);
            $em->persist($conversation);
            $message->setConversation($conversation);
            $message->setUser($this->getUser());
            $message->setPostDate(new \DateTime(date('Y-m-d H:i:s')));
            $message->setBody($data['body']);
            $em->persist($message);
            $em->flush();
            return $this->redirect($this->generateUrl('index'));
        }
        return array('form' => $form->createView());
    }

}
