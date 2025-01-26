<?php

namespace App\Observers;

use App\Models\Setting\Menus;
use Illuminate\Support\Facades\Cache;

class MenuObserver
{
    /**
     * Handle the Menus "created" event.
     */
    public function created(Menus $menu)
    {
        $this->clearBreadcrumbCache($menu);
    }

    /**
     * Handle the Menus "updated" event.
     */
    public function updated(Menus $menu)
    {
        $this->clearBreadcrumbCache($menu);
    }

    /**
     * Handle the Menus "deleted" event.
     */
    public function deleted(Menus $menu)
    {
        $this->clearBreadcrumbCache($menu);
    }

    /**
     * Clear breadcrumb cache for the given menu.
     */
    protected function clearBreadcrumbCache(Menus $menu)
    {
        $urls = [$menu->url];
        $parent = $menu->parent;

        while ($parent) {
            $urls[] = $parent->url;
            $parent = $parent->parent;
        }

        foreach ($urls as $url) {
            $cacheKey = 'breadcrumbs_' . md5($url);
            Cache::forget($cacheKey);
        }
    }
}