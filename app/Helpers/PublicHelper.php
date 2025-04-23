<?php

use App\Models\Setting\Menus;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

if (!function_exists('generateBreadCrumbs')) {
    function generateBreadCrumbs($currentUrl, $isRoot = true)
    {
        $cacheKey = 'breadcrumbs_' . md5($currentUrl);

        return Cache::remember($cacheKey, 60 * 60 * 24 * 7, function () use ($currentUrl, $isRoot) {
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
        });
    }
}

if (!function_exists('simplifyPermissions')) {
    function simplifyPermissions($data)
    {
        $result = [];

        // Iterasi data role
        foreach ($data as $roleData) {
            $groupedPermissions = [];

            // Group permissions berdasarkan menu dan submenu
            foreach ($roleData['permissions'] as $permission) {
                $parts = explode('.', $permission);
                $lastPart = end($parts);
                $menu = in_array($lastPart, ['create', 'read', 'update', 'delete']) ? implode('.', array_slice($parts, 0, -1)) : $permission;
                $action = in_array($lastPart, ['create', 'read', 'update', 'delete']) ? $lastPart : null;

                // Kelompokkan aksi berdasarkan menu
                $groupedPermissions[$menu][] = $action;
            }

            // Generate simplified permissions
            $simplifiedPermissions = [];
            foreach ($groupedPermissions as $menu => $actions) {
                $uniqueActions = array_unique(array_filter($actions));  // Menghapus null dan aksi duplikat
                $uniqueActions = mapActionsToNames($uniqueActions); // Memetakan nama aksi
                sort($uniqueActions); // Urutkan untuk konsistensi

                // Menentukan output berdasarkan jumlah aksi
                $simplifiedPermissions[] = formatPermissionsName($uniqueActions, capitalize($menu));
            }

            $result[] = [
                'id' => $roleData['id'],
                'role' => $roleData['role'],
                'permissions' => $simplifiedPermissions,
                'users' => $roleData['users'],
            ];
        }

        return $result;
    }
}

if (!function_exists('mapActionsToNames')) {
    function mapActionsToNames($actions)
    {
        // Memetakan aksi ke nama yang lebih mudah dibaca
        $map = [
            'create' => 'store',
            'read' => 'view',
            'update' => 'edit',
            'delete' => 'remove'
        ];

        return array_map(function ($action) use ($map) {
            return isset($map[$action]) ? $map[$action] : $action;
        }, $actions);
    }
}

if (!function_exists('formatPermissionsName')) {
    function formatPermissionsName($actions, $menu)
    {
        $actionCount = count($actions);

        // Jika ada 4 aksi (Full Control)
        if ($actionCount === 4) {
            return "$menu Full Controls";
        }

        // Jika hanya ada 1 aksi
        if ($actionCount === 1) {
            return ucfirst($actions[0]) . " $menu";
        }

        // Jika ada lebih dari 1 aksi
        $lastAction = array_pop($actions);
        $actionsString = $actions ? implode(', ', array_map('ucfirst', $actions)) . " and " . ucfirst($lastAction) : ucfirst($lastAction);
        return "$actionsString $menu";
    }
}

if (!function_exists('capitalize')) {
    function capitalize($string)
    {
        // Menggunakan ucwords dan mengganti simbol yang diinginkan
        $string = str_replace(['_', '.'], [' ', ' - '], $string);
        return ucwords($string);
    }
}

if (!function_exists('canManageModul')) {
    function canManageModul($tanggalPertemuan,$tanggalRealisasi)
    {
        if (!$tanggalRealisasi) {
            return true;
        }
        $today = now()->startOfDay();
        $tanggal = Carbon::parse($tanggalPertemuan)->startOfDay();
        return $today->lessThanOrEqualTo($tanggal);
    }
}
