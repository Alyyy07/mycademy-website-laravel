<?php

if (!function_exists('generateBreadCrumbs')) {
    function generateBreadCrumbs($menuItems, $currentUrl, $isRoot = true)
    {
        $breadcrumbs = [];

        // Tambahkan "Dashboard" di awal jika ini adalah level pertama dan bukan halaman dashboard
        if ($isRoot && $currentUrl !== route('dashboard', [], false)) {
            $breadcrumbs[] = [
                'name' => 'Dashboard',
                'url' => route('dashboard'),
            ];
        }

        $found = false;
        foreach ($menuItems as $menuItem) {
            if ($menuItem['url'] === $currentUrl) {
                $breadcrumbs[] = [
                    'name' => $menuItem['name'],
                    'url' => count($menuItem['childrens']) == 0 ? $menuItem['url'] : null,
                ];
                $found = true;
                break;
            }

            if (count($menuItem['childrens']) > 0) {
                $breadcrumbs[] = [
                    'name' => $menuItem['name'],
                    'url' => null,
                ];

                $subBreadcrumbs = generateBreadCrumbs($menuItem['childrens'], $currentUrl, false);
                if (!empty($subBreadcrumbs)) {
                    $breadcrumbs = array_merge($breadcrumbs, $subBreadcrumbs);
                    $found = true;
                    break;
                }
            }
        }

        return $found ? $breadcrumbs : [];
    }
}
