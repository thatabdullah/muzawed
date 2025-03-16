<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminDashboard extends BaseWidget
{
    protected function getStats(): array
    {
        return [
        Stat::make(__('dashboard.total_enterprise'), Account::where('type', 'enterprise')->count())
            ->description(__('dashboard.enterprise_description'))
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('success'),
        Stat::make(__('dashboard.total_saasprovider'), Account::where('type', 'saas')->count())
            ->description(__('dashboard.saasprovider_description'))
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('success'),    
        Stat::make(__('dashboard.total_user'), User::query()->count())
            ->description(__('dashboard.user_description'))
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('success'),
        Stat::make(__('dashboard.total_category'), Category::query()->count())
            ->description(__('dashboard.category_description'))
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('success'),
        Stat::make(__('dashboard.total_product'), Product::query()->count())
            ->description(__('dashboard.product_description'))
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('success'),
        ];
    }
}
