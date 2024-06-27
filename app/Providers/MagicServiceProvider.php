<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;


use App\Repositories\LeadRepositoryInterface;
use App\Repositories\LeadRepository;
use App\Repositories\CompanyRepositoryInterface;
use App\Repositories\CompanyRepository;
use App\Repositories\DepartmentRepositoryInterface;
use App\Repositories\DepartmentRepository;
use App\Repositories\DepartmentStaffRepositoryInterface;
use App\Repositories\DepartmentStaffRepository;
use App\Repositories\PackageRepositoryInterface;
use App\Repositories\PackageRepository;
use App\Repositories\LeadSettingRepositoryInterface;
use App\Repositories\LeadSettingRepository;
use App\Repositories\StatusSettingRepositoryInterface;
use App\Repositories\StatusSettingRepository;
use App\Repositories\CustomerSettingRepositoryInterface;
use App\Repositories\CustomerSettingRepository;
use App\Repositories\FieldSettingRepositoryInterface;
use App\Repositories\FieldSettingRepository;
use App\Repositories\OrganizationRepositoryInterface;
use App\Repositories\OrganizationRepository;
use App\Repositories\CustomFieldTypeRepositoryInterface;
use App\Repositories\CustomFieldTypeRepository;
use App\Repositories\CustomFieldRepositoryInterface;
use App\Repositories\CustomFieldRepository;
use App\Repositories\ContactRepositoryInterface;
use App\Repositories\ContactRepository;
use App\Repositories\LeadActivityRepositoryInterface;
use App\Repositories\LeadActivityRepository;
use App\Repositories\LeadFileRepositoryInterface;
use App\Repositories\LeadFileRepository;
use App\Repositories\LeadFileTypeRepositoryInterface;
use App\Repositories\LeadFileTypeRepository;
use App\Repositories\StatusHistoryRepositoryInterface;
use App\Repositories\StatusHistoryRepository;
use App\Repositories\ActivityTypeRepositoryInterface;
use App\Repositories\ActivityTypeRepository;
use App\Repositories\NoteRepositoryInterface;
use App\Repositories\NoteRepository;
use App\Repositories\TaskRepositoryInterface;
use App\Repositories\TaskRepository;
// REPOS USE

class MagicServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        

        $this->app->bind(
            LeadRepositoryInterface::class,
            LeadRepository::class
        );

        $this->app->bind(
            CompanyRepositoryInterface::class,
            CompanyRepository::class
        );

        $this->app->bind(
            DepartmentRepositoryInterface::class,
            DepartmentRepository::class
        );

        $this->app->bind(
            DepartmentStaffRepositoryInterface::class,
            DepartmentStaffRepository::class
        );

        $this->app->bind(
            PackageRepositoryInterface::class,
            PackageRepository::class
        );

        $this->app->bind(
            LeadSettingRepositoryInterface::class,
            LeadSettingRepository::class
        );

        $this->app->bind(
            StatusSettingRepositoryInterface::class,
            StatusSettingRepository::class
        );

        $this->app->bind(
            CustomerSettingRepositoryInterface::class,
            CustomerSettingRepository::class
        );

        $this->app->bind(
            FieldSettingRepositoryInterface::class,
            FieldSettingRepository::class
        );

        $this->app->bind(
            OrganizationRepositoryInterface::class,
            OrganizationRepository::class
        );

        $this->app->bind(
            CustomFieldTypeRepositoryInterface::class,
            CustomFieldTypeRepository::class
        );

        $this->app->bind(
            CustomFieldRepositoryInterface::class,
            CustomFieldRepository::class
        );

        $this->app->bind(
            ContactRepositoryInterface::class,
            ContactRepository::class
        );

        $this->app->bind(
            LeadActivityRepositoryInterface::class,
            LeadActivityRepository::class
        );

        $this->app->bind(
            LeadFileRepositoryInterface::class,
            LeadFileRepository::class
        );

        $this->app->bind(
            LeadFileTypeRepositoryInterface::class,
            LeadFileTypeRepository::class
        );

        $this->app->bind(
            StatusHistoryRepositoryInterface::class,
            StatusHistoryRepository::class
        );

        $this->app->bind(
            ActivityTypeRepositoryInterface::class,
            ActivityTypeRepository::class
        );

        $this->app->bind(
            NoteRepositoryInterface::class,
            NoteRepository::class
        );

        $this->app->bind(
            TaskRepositoryInterface::class,
            TaskRepository::class
        );
// REPOS BIND END
    }
}
