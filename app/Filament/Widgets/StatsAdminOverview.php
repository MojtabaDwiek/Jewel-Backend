<?php

namespace App\Filament\Widgets;

use App\Models\Retailer;
use App\Models\Customers;
use App\Models\Products;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsAdminOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Retailers', Retailer::query()->count())
                ->description('Number of Retailers')
                ->chart([20, 40, 15, 3, 70, 60, 50])
                ->color('success'),
            Stat::make('Customers', Customers::query()->count())
                ->description('Number of Customers')
                ->chart([7, 8, 10, 3, 25, 4, 29])
                ->color('danger'),
            Stat::make('Products', Products::query()->count())
                ->description('Number of Products')
                ->chart([7, 18, 10, 7, 15, 23, 30])
                ->color('info'),
        ];
    }
}