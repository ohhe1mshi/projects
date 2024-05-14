<?php

namespace App\Controller;

use App\Entity\Worker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;

class WorkerController extends AbstractController
{
    #[Route('/worker', name: 'workers')]
    public function workersTable(
        EntityManagerInterface $em, Request $request): Response
    {
        $workers = $em -> getRepository(Worker::class) -> findAll();

        return $this->render('worker/index.html.twig', [
            'workers' => $workers, 
        ]); 
    }

    #[Route('/worker/sort/{id}', name: 'workersSorted')]
    public function workersTableSorted(
        EntityManagerInterface $em, Request $request, $id): Response
    {
        $session = $request -> getSession();

        $sortNum = $session -> get('sortNum');
        $sortName = $session -> get('sortName');
        $sortLastname = $session -> get('sortLastname');
        $sortJob = $session -> get('sortJob');

        if ($id == 'num') {
            if ($sortNum == 0) {
                $workers = $em -> getRepository(Worker::class) -> findBy([], ['Number' => 'ASC']);
                $session -> set('sortNum', true);
            } else {
                $workers = $em -> getRepository(Worker::class) -> findBy([], ['Number' => 'DESC']);
                $session -> set('sortNum', false);
            } 
        } else if ($id == 'name') {
            if ($sortName == 0) {
                $workers = $em -> getRepository(Worker::class) -> findBy([], ['name' => 'ASC']);
                $session -> set('sortName', true);
            } else {
                $workers = $em -> getRepository(Worker::class) -> findBy([], ['name' => 'DESC']);
                $session -> set('sortName', false);
            }
        } else if ($id == 'lastname') {
            if ($sortLastname == 0) {
                $workers = $em -> getRepository(Worker::class) -> findBy([], ['lastname' => 'ASC']);
                $session -> set('sortLastname', true);
            } else {
                $workers = $em -> getRepository(Worker::class) -> findBy([], ['lastname' => 'DESC']);
                $session -> set('sortLastname', false);      
            }
        } else {
            if ($sortJob == 0) {
                $workers = $em -> getRepository(Worker::class) -> findBy([], ['job' => 'ASC']);
                $session -> set('sortJob', true);
            } else {
                $workers = $em -> getRepository(Worker::class) -> findBy([], ['job' => 'DESC']);
                $session -> set('sortJob', false);      
            }
        }
              
        return $this->render('worker/index.html.twig', [
            'workers' => $workers, 
        ]);
         
    }
    
    // #[Route('/worker/real-time', name: 'workersNew')]
    // public function RealTimeAction(EntityManagerInterface $em) {
    //     $workers = $em -> getRepository(Worker::class) -> findAll();
    //     return new JsonResponse($workers);
    // }

    #[Route('/worker/new', name: 'createWorker')]
    public function createAction(ManagerRegistry $doctrine, EntityManagerInterface $em, Request $request): Response
    {
        $entityManager = $doctrine -> getManager();
        $numWorker = $em -> getRepository(Worker::class) -> findOneBy([], ['Number' => 'DESC']);

        $name = $request -> request -> get('name');
        $lastname = $request -> request->get('lastname');
        $job = $request -> request->get('job');
        
        $num = $numWorker -> getNumber();

        $worker = new Worker();
        $worker -> setName($name);
        $worker -> setLastname($lastname);
        $worker -> setJob($job);
        $worker -> setNumber($num + 1);

        $entityManager -> persist($worker);
        $entityManager -> flush();
        

        return $this -> redirectToRoute('workers');
    }

    #[Route('/worker/delete/{id}', name: 'deleteWorker')]
    public function deleteAction(Worker $worker, EntityManagerInterface $em, ManagerRegistry $doctrine) 
    {
        $em = $doctrine -> getManager();

        $em -> remove($worker);
        $em -> flush();
       
        return $this -> redirectToRoute('workers');
    }

    #[Route('/worker/update/{id}', name: 'updateWorker')]
    public function updateAction(ManagerRegistry $doctrine, EntityManagerInterface $em, Worker $worker, Request $request): Response
    {
        $entityManager = $doctrine -> getManager();

        $name = $request -> request -> get('name');
        $lastname = $request -> request->get('lastname');
        $job = $request -> request->get('job');

        $worker -> setName($name);
        $worker -> setLastname($lastname);
        $worker -> setJob($job);

        $entityManager -> persist($worker);
        $entityManager -> flush();
        

        return $this -> redirectToRoute('workers');
    }

    // #[Route('/worker/sortNumberUp', name: 'sortNumberUp')]
    // public function sortNumUpAction(EntityManagerInterface $em): Response
    // {   
    //     $workers = $em -> getRepository(Worker::class) -> findBy([], ['Number' => 'DESC']);

    //     return $this->render('worker/index.html.twig', [
    //         'workers' => $workers, 
    //     ]); 
    // }

    // #[Route('/worker/sortNumberDown', name: 'sortNumberDown')]
    // public function sortNumDownAction(EntityManagerInterface $em): Response
    // {   
    //     $workers = $em -> getRepository(Worker::class) -> findBy([], ['Number' => 'ASC']);

    //     return $this->render('worker/index.html.twig', [
    //         'workers' => $workers, 
    //     ]); 
    // }
}
