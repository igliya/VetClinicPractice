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
            'data' => [1500, 1212, 3123, 2000, 962]
        ];
        $mockYearsData = [
            'labels' => ['2019', '2020', '2021', '2022'],
            'data' => [783, 913, 1300, 1243]
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
            'data' => [1141, 1232, 3123, 2232, 962]
        ];
        $mockYearsData = [
            'labels' => ['2019', '2020', '2021', '2022'],
            'data' => [646, 1534, 1324, 1255]
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
            'data' => [378, 479, 394, 113, 117, 137, 225, 225, 332, 377, 253, 284, 287, 453, 373, 351, 474, 296, 410, 495, 129, 172, 333, 275, 435, 374, 311, 363, 248, 339, 185]
        ];
        $mockYearsData = [
            'labels' => ["2019 (Купирование ушных раковин у собак)", "2020 (Рентген)", "2021 (Вакцинация животного с проведением клинического осмотра)", "2022 (Взятие соскобов, мазков)"],
            'data' => [485, 405, 631, 581]
        ];

        return $this->json(['current_year' => $mockCurrentYearData, 'years' => $mockYearsData]);
    }

    /**
     * @Route("/returns", name="client_returns", methods={"GET"})
     */
    public function getClientReturns(Request $request, UserRepository $userRepository): Response
    {
		$doctors = $userRepository->getDoctors();
        $doctorsResponse = [];
        foreach ($doctors as $doctor) {
			$doctorsResponse[] = $doctor->getFirstName() . ' ' . $doctor->getLastName();
        }
		
        $mockData = [
            'labels' => $doctorsResponse,
            'data' => [10, 6, 58, 33, 52]
        ];

        return $this->json(['returns' => $mockData]);
    }
}
