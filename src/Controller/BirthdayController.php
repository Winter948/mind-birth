<?php
namespace App\Controller;

use App\Entity\Birthday;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/birthdays')] // <-- route “de base” pour la classe
class BirthdayController extends AbstractController
{
    #[Route('', methods: ['GET'])] // GET /api/birthdays
    public function list(EntityManagerInterface $em): JsonResponse
    {
        $birthdays = $em->getRepository(Birthday::class)->findAll();
        $data = array_map(fn(Birthday $b) => [
            'id' => $b->getId(),
            'title' => $b->getTitle(),
            'date' => $b->getDate()?->format('Y-m-d')
        ], $birthdays);

        return $this->json($data);
    }

    #[Route('', methods: ['POST'])] // POST /api/birthdays
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $payload = json_decode($request->getContent(), true);

        $birthday = new Birthday();
        $birthday->setTitle($payload['title'] ?? '');
        $birthday->setDate(new \DateTime($payload['date'] ?? 'now'));

        $em->persist($birthday);
        $em->flush();

        return $this->json([
            'id' => $birthday->getId(),
            'title' => $birthday->getTitle(),
            'date' => $birthday->getDate()?->format('Y-m-d')
        ], 201);
    }
}
