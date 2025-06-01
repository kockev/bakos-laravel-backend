<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\KitchenOrder;
use App\Models\Diet;
use App\Models\Institution;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Student;
use App\Models\User;
use App\Policies\ActivityLogPolicy;
use App\Policies\CompanyPolicy;
use App\Policies\KitchenOrderPolicy;
use App\Policies\DietPolicy;
use App\Policies\InstitutionPolicy;
use App\Policies\FoodPolicy;
use App\Policies\MenuPolicy;
use App\Policies\OrderPolicy;
use App\Policies\StudentPolicy;
use App\Policies\UserPolicy;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class         => UserPolicy::class,
        Company::class      => CompanyPolicy::class,
        Institution::class  => InstitutionPolicy::class,
        Student::class      => StudentPolicy::class,
        Food::class         => FoodPolicy::class,
        Diet::class         => DietPolicy::class,
        Menu::class         => MenuPolicy::class,
        Order::class        => OrderPolicy::class,
        KitchenOrder::class => KitchenOrderPolicy::class,
        Activity::class     => ActivityLogPolicy::class,
    ];
}
