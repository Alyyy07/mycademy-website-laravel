@props([
    'menuData' => []
])

@php
    $isActiveParent = $menuData->childrens->contains(function ($child) {
        return request()->is(trim($child->url, '/'));
    });
@endphp

@if ($menuData->childrens->count() > 0)
@can($menuData->module)
<div data-kt-menu-trigger="click" class="menu-item @if ($isActiveParent) show @endif menu-accordion">
    <span class="menu-link">
        <span class="menu-icon">
            <i class="{{ $menuData->icon }}"></i>
        </span>
        <span class="menu-title">{{ $menuData->name }}</span>
        <span class="menu-arrow"></span>
    </span>
    <div class="menu-sub menu-sub-accordion">
        @foreach ($menuData->childrens as $menu)
        @can($menu->module)
        <x-atoms.sidebar-menu-item :menuData="$menu" />
        @endcan
        @endforeach
    </div>
</div>
@endcan
@else
@can($menuData->module)
<div class="menu-item">
    <a class="menu-link @if (request()->is(trim($menuData->url, '/'))) active @endif" href="{{ $menuData->url }}">
        <span class="menu-icon">
            <i class="{{ $menuData->icon }}"></i>
        </span>
        <span class="menu-title">{{ $menuData->name }}</span>
    </a>
</div>
@endcan
@endif
