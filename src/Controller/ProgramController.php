<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Program;
use App\Repository\EpisodeRepository;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use phpDocumentor\Reflection\DocBlock\Tags\See;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
        return $this->render('program/index.html.twig', [
            'programs' => $programs
        ]);
    }

    #[Route('/{id<^[0-9]+$>}', name: 'show')]
    public function show(int $id, Program $progra, ProgramRepository $programRepository, SeasonRepository $seasonRepository): Response
    {
        $program = $programRepository->findOneBy(['id' => $id]);
        $seasons = $seasonRepository->findAll();

        $seasons = $progra->getSeasons();

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : ' . $id . ' found in program\'s table.'
            );
        }
        return $this->render('program/show.html.twig', [
            'program' => $program, 'seasons' => $seasons
        ]);
    }

    #[Route('/{programId}/season/{seasonId}', methods: ['GET'], name: 'season_show')]
    public function showSeason(int $programId, int $seasonId, ProgramRepository $programRepository, SeasonRepository $seasonRepository, EpisodeRepository $episodeRepository)
    {
        $program = $programRepository->findOneById(['programId' => $programId]);
        $seasons = $seasonRepository->findOneById(['seasonId' => $seasonId]);
        $episodes = $episodeRepository->findBy(['season' => $seasons], ['number' => 'ASC']);

        return $this->render('program/season_show.html.twig', ['program' => $program, 'season' => $seasons, 'episodes' => $episodes]);
    }
}
