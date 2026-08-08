<?php
declare(strict_types=1);
namespace App\Controllers\Admin;
use App\Core\Response;
use App\Repositories\DashboardRepository;
final class DashboardController{public function __construct(private DashboardRepository $dashboard){} public function index():Response{return Response::view('admin/dashboard',['stats'=>$this->dashboard->stats(),'activity'=>$this->dashboard->recentActivity()]);}}