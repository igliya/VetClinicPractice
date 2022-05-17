<?php

namespace App\Controller;

use App\Repository\CheckupRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1")
 */
class APIController extends AbstractController
{
    /**
     * @Route("/average", name="average_statistic", methods={"GET"})
     */
    public function getAverageStatistic(Request $request): Response
    {
        return $this->json(['method' => 'average']);
    }

    /**
     * @Route("/doctors", name="doctors_list", methods={"GET"})
     */
    public function getDoctorsList(Request $request, UserRepository $userRepository): Response
    {
        $doctors = $userRepository->getDoctors();
        $doctorsResponse = [];
        foreach ($doctors as $doctor) {
            $doctorResponse = [];
            $doctorResponse['username'] = $doctor->getLogin();
            $doctorResponse['last_name'] = $doctor->getLastName();
            $doctorResponse['first_name'] = $doctor->getFirstName();
            $doctorResponse['patronymic'] = $doctor->getPatronymic();
            $doctorResponse['phone'] = $doctor->getPhone();
            $doctorsResponse[] = $doctorResponse;
        }

        return $this->json($doctorsResponse, 200,
            [
                'Access-Control-Expose-Headers' => 'X-Total-Count',
                'X-Total-Count' => count($doctorsResponse)
            ]
        );
    }

    /**
     * @Route("/doctors/{id}", name="doctor_statistic_by_id", methods={"GET"})
     */
    public function getDoctorStatisticById(Request $request, int $id): Response
    {
        return $this->json(['method' => 'get doctor statistic by id' . $id]);
    }

    /**
     * @Route("/popular", name="popular_services_statistic", methods={"GET"})
     */
    public function getPopularServicesStatistic(Request $request): Response
    {
        return $this->json(['method' => 'get popular services statistic']);
    }

    /**
     * @Route("/returns", name="client_returns", methods={"GET"})
     */
    public function getClientReturns(Request $request): Response
    {
        return $this->json(['method' => 'get client returns statistic']);
    }
}
