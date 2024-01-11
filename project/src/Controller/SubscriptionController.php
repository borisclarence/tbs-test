<?php 

namespace App\Controller;

use App\Entity\contact;
use App\Entity\product;
use App\Entity\subscription;

use App\Repository\SubscriptionRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubscriptionController extends AbstractController
{
    private $subscriptionRepository;

    public function __construct(SubscriptionRepository $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }

    /**
     * @Route("/subscription/{id}", name="get_suscribe", methods={"GET"})
     */
    public function index(ManagerRegistry $doctrine, int $id): Response
    {
        // ...
        $subscriptions = $doctrine
            ->getRepository(Subscription::class)
            ->findBy(['contact' => $id]);
   
        foreach ($subscriptions as $subscriptionDetail) {
           $data[] = [
               'name_contact' => $subscriptionDetail->getContact()->getLastName(),
               'name_product' => $subscriptionDetail->getProduct()->getNameProduct(),
               'date_start' => $subscriptionDetail->getDateStart(),
               'date_end' => $subscriptionDetail->getDateEnd(),
           ];
        }
   
        return $this->json($data);
    }

    /**
     * @Route("/subscription", name="post_subscribe", methods={"POST"})
     */
    public function createSubscription(Request $request, ManagerRegistry $doctrine): Response
    {
        // Get request data
        $data = json_decode($request->getContent(), true);
        
        $entityManager = $doctrine->getManager();

        $email =  $data['email'];
        $name_product = $data['name_product'];
        $date_start = new \DateTimeImmutable($data['date_start']);
        $date_end = new \DateTimeImmutable($data['date_end']);

        if (empty($email) || empty($name_product) || empty($date_start) || empty($date_end)) {
            return new Response('Expecting mandatory parameters!', Response::HTTP_BAD_REQUEST);
        }

        // Get Contact id 
        $contact = $doctrine->getRepository(Contact::class)
            ->findOneBy(['email' => $email]);

        // Get product id
        $product = $doctrine->getRepository(Product::class)
            ->findOneBy(['name_product' => $name_product]);

        // Save data
        $subscription = new Subscription();
        $subscription->setContact($contact->getId());
        $subscription->setProduct($product->getId());
        $subscription->setDateStart($date_start);
        $subscription->setDateEnd($date_end);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($subscription);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        
        return new Response('Saved new subscription with id '.$subscription->getId(), Response::HTTP_OK);
    }

    /**
     * @Route("/subscription/{id}", name="put_subscribe", methods={"PUT"})
     */
    public function edit($id, Request $request, ManagerRegistry $doctrine): Response
    {
        // ...
        $updatedSubscription = $this->subscriptionRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);
        $entityManager = $doctrine->getManager();

        $email =  $data['email'];
        $name_product = $data['name_product'];
        $date_start = new \DateTimeImmutable($data['date_start']);
        $date_end = new \DateTimeImmutable($data['date_end']);

        // Get Contact id 
        $contact = $doctrine->getRepository(Contact::class)
            ->findOneBy(['email' => $email]);

        // Get product id
        $product = $doctrine->getRepository(Product::class)
            ->findOneBy(['name_product' => $name_product]);

        // Update data
        $updatedSubscription->setContact($contact->getId());
        $updatedSubscription->setProduct($product->getId());
        $updatedSubscription->setDateStart($date_start);
        $updatedSubscription->setDateEnd($date_end);

        $entityManager->persist($updatedSubscription);
        $entityManager->flush();

        return new Response('Data updated'. $updatedSubscription->getId(), Response::HTTP_OK);
    }

    /**
     * @Route("/subscription/{id}", name="delete_subscribe", methods={"DELETE"})
     */
    public function delete($id): Response
    {
        // ...
        $customer = $this->subscriptionRepository->findOneBy(['id' => $id]);

        $this->subscriptionRepository->removeCustomer($customer);

        return new Response('Customer deleted', Response::HTTP_NO_CONTENT);
    }
}