<?php

use App\Models\Setting\Menus;

if (!function_exists('generateBreadCrumbs')) {
    function generateBreadCrumbs($currentUrl, $isRoot = true)
    {
        $breadcrumbs = [];
        $dashboardUrl = route('dashboard', [], false);

        if ($isRoot && $currentUrl !== $dashboardUrl) {
            $breadcrumbs[] = [
                'name' => 'Dashboard',
                'url' => route('dashboard'),
            ];
        }

        // Cari item menu yang cocok dengan URL saat ini
        $menu = Menus::where('url', $currentUrl)->where('is_active', '1')->first();

        if ($menu) {
            $parents = [];
            $parentMenu = $menu->parent;

            while ($parentMenu) {
                $parents[] = [
                    'name' => $parentMenu->name,
                    'url' => $parentMenu->childrens->isEmpty() ? $parentMenu->url : null,
                ];
                $parentMenu = $parentMenu->parent;
            }
            $breadcrumbs = array_merge($breadcrumbs, array_reverse($parents));
            $breadcrumbs[] = [
                'name' => $menu->name,
                'url' => $menu->childrens->isEmpty() ? $menu->url : null,
            ];
        }

        return $breadcrumbs;
    }
}
