<?php

namespace App\Controller;

use App\Repository\CheckupRepository;
use App\Repository\ServiceRepository;
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
        $mockCurrentYearData = [
            'labels' => ['Январь', 'Февраль', 'Март', 'Апрель', 'Май'],
            'data' => [32141, 33123, 54232, 43534, 23534]
        ];
        $mockYearsData = [
            'labels' => ['2019', '2020', '2021', '2022'],
            'data' => [5634646, 6245346, 6345634, 4523425]
        ];

        return $this->json(['current_year' => $mockCurrentYearData, 'years' => $mockYearsData]);
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
            $doctorResponse['id'] = $doctor->getId();
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
     * @Route("/doctors/{id<\d+>}", name="doctor_statistic_by_id", methods={"GET"})
     */
    public function getDoctorStatisticById(Request $request, int $id): Response
    {
        $mockCurrentYearData = [
            'labels' => ['Январь', 'Февраль', 'Март', 'Апрель', 'Май'],
            'data' => [2141, 3123, 4232, 3534, 3534]
        ];
        $mockYearsData = [
            'labels' => ['2019', '2020', '2021', '2022'],
            'data' => [634646, 245346, 345634, 523425]
        ];

        return $this->json(['current_year' => $mockCurrentYearData, 'years' => $mockYearsData]);
    }

    /**
     * @Route("/popular", name="popular_services_statistic", methods={"GET"})
     */
    public function getPopularServicesStatistic(Request $request, ServiceRepository $serviceRepository): Response
    {
        $services = $serviceRepository->findAll();
        $servicesNames = [];
        foreach ($services as $service) {
            $servicesNames[] = $service->getName();
        }

        $mockCurrentYearData = [
            'labels' => $servicesNames,
            'data' => [3783, 4794, 3940, 1130, 1179, 1379, 2257, 2253, 3327, 3770, 2530, 2844, 2879, 4531, 3733, 3517, 4742, 2966, 4103, 4956, 1295, 1727, 3337, 2752, 4355, 3743, 3119, 3639, 2484, 3396, 1852]
        ];
        $mockYearsData = [
            'labels' => ["2019 (Купирование ушных раковин у собак)", "2020 (Рентген)", "2021 (Вакцинация животного с проведением клинического осмотра)", "2022 (Взятие соскобов, мазков)"],
            'data' => [48558, 40572, 96317, 12815]
        ];

        return $this->json(['current_year' => $mockCurrentYearData, 'years' => $mockYearsData]);
    }

    /**
     * @Route("/returns", name="client_returns", methods={"GET"})
     */
    public function getClientReturns(Request $request): Response
    {
        $mockData = [
            'labels' => ['Доктор 1', 'Доктор 2', 'Доктор 3', 'Доктор 4', 'Доктор 5'],
            'data' => [10, 6, 58, 33, 52]
        ];

        return $this->json(['returns' => $mockData]);
    }
}
