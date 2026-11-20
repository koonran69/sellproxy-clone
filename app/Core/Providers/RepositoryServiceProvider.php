<?php

namespace App\Core\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $repositories = [
        'App\Core\Repositories\Admin\AdminRepositoryInterface' => 'App\Core\Repositories\Admin\AdminRepository',
        'App\Core\Repositories\Permission\PermissionRepositoryInterface' => 'App\Core\Repositories\Permission\PermissionRepository',
        'App\Core\Repositories\Role\RoleRepositoryInterface' => 'App\Core\Repositories\Role\RoleRepository',
        'App\Core\Repositories\User\UserRepositoryInterface' => 'App\Core\Repositories\User\UserRepository',
        'App\Core\Repositories\Deposit\DepositRepositoryInterface' => 'App\Core\Repositories\Deposit\DepositRepository',
        'App\Core\Repositories\Transaction\TransactionRepositoryInterface' => 'App\Core\Repositories\Transaction\TransactionRepository',
        'App\Core\Repositories\Proxy\ProxyRepositoryInterface' => 'App\Core\Repositories\Proxy\ProxyRepository',
        'App\Core\Repositories\Order\OrderRepositoryInterface' => 'App\Core\Repositories\Order\OrderRepository',
        'App\Core\Repositories\Voucher\VoucherRepositoryInterface' => 'App\Core\Repositories\Voucher\VoucherRepository',
        'App\Core\Repositories\QA\QARepositoryInterface' => 'App\Core\Repositories\QA\QARepository',
        'App\Core\Repositories\Contact\ContactRepositoryInterface' => 'App\Core\Repositories\Contact\ContactRepository',
        'App\Core\Repositories\Coin\CoinRepositoryInterface' => 'App\Core\Repositories\Coin\CoinRepository',
        'App\Core\Repositories\CdKey\CdKeyRepositoryInterface' => 'App\Core\Repositories\CdKey\CdKeyRepository',
        'App\Core\Repositories\Page\PageRepositoryInterface' => 'App\Core\Repositories\Page\PageRepository',
        'App\Core\Repositories\WithDrawals\WithDrawalsRepositoryInterface' => 'App\Core\Repositories\WithDrawals\WithDrawalsRepository',
        'App\Core\Repositories\ProxyPackage\ProxyPackageRepositoryInterface' => 'App\Core\Repositories\ProxyPackage\ProxyPackageRepository',
        'App\Core\Repositories\ProxyCountryAvailable\ProxyCountryAvailableRepositoryInterface' => 'App\Core\Repositories\ProxyCountryAvailable\ProxyCountryAvailableRepository',
    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        //
        foreach ($this->repositories as $interface => $implement) {
            $this->app->singleton($interface, $implement);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
