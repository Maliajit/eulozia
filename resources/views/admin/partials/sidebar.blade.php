@php
    /**
     * Admin Sidebar Navigation
     * 
     * Purpose: Provides a collapsible vertical navigation menu for all admin modules.
     * 
     * Data Flow: 
     * - Defines a $navItems array which controls the menu structure and permissions (if implemented).
     * - Uses Route::currentRouteName() to determine active states.
     * - Injects Branding Name from app config.
     * 
     * Database: N/A (UI Component)
     * Dependencies: FontAwesome (for icons), Tailwind CSS, Custom Sidebar CSS classes.
     */


    // Navigation configuration
    $navItems = [
        'dashboard' => [
            'title' => 'Dashboard',
            'icon' => 'fas fa-home',
            'route' => 'admin.dashboard',
        ],

        'products' => [
            'title' => 'Products',
            'icon' => 'fas fa-cube',
            'route' => 'admin.products.index',
            'submenu' => [
                'all' => [
                    'title' => 'All Products',
                    'route' => 'admin.products.index',
                ],
                'create' => [
                    'title' => 'Add New',
                    'route' => 'admin.products.create',
                ],
                'attributes' => [
                    'title' => 'Attributes',
                    'route' => 'admin.products.attributes',
                    'params' => ['id' => 1],
                ],
                'specs' => [
                    'title' => 'Specifications',
                    'route' => 'admin.products.specifications',
                    'params' => ['id' => 1],
                ],
                'tags' => [
                    'title' => 'Tags',
                    'route' => 'admin.products.tags',
                ],
            ],
        ],

        'categories' => [
            'title' => 'Categories',
            'icon' => 'fas fa-tags',
            'route' => 'admin.categories.index',
            'submenu' => [
                'all' => [
                    'title' => 'All Categories',
                    'route' => 'admin.categories.index',
                ],
                'create' => [
                    'title' => 'Add New',
                    'route' => 'admin.categories.create',
                ],
            ],
        ],

        'brands' => [
            'title' => 'Brands',
            'icon' => 'fas fa-trademark',
            'route' => 'admin.brands.index',
        ],

        'taxes' => [
            'title' => 'Taxes',
            'icon' => 'fas fa-percent',
            'route' => 'admin.taxes.index',
        ],

        'orders' => [
            'title' => 'Orders',
            'icon' => 'fas fa-shopping-cart',
            'route' => 'admin.orders.index',
        ],

        'offers' => [
            'title' => 'Offers',
            'icon' => 'fas fa-percentage',
            'route' => 'admin.offers.index',
            'submenu' => [
                'all' => [
                    'title' => 'All Offers',
                    'route' => 'admin.offers.index',
                ],
                'create' => [
                    'title' => 'Add New',
                    'route' => 'admin.offers.create',
                ],
            ],
        ],

        'users' => [
            'title' => 'Customers',
            'icon' => 'fas fa-users',
            'route' => 'admin.users.index',
        ],

        'media' => [
            'title' => 'Media',
            'icon' => 'fas fa-images',
            'route' => 'admin.media.index',
        ],

        'crm' => [
            'title' => 'CRM',
            'icon' => 'fas fa-bullhorn',
            'route' => 'admin.crm.index',
            'submenu' => [
                'banners' => ['title' => 'Sliders', 'route' => 'admin.banners.index'],
                'home_sections' => ['title' => 'Home Page', 'route' => 'admin.home-sections.index'],
            ],
        ],


        'reviews' => [
            'title' => 'Reviews',
            'icon' => 'fas fa-star',
            'route' => 'admin.reviews.index',
        ],

        'testimonials' => [
            'title' => 'Testimonials',
            'icon' => 'fas fa-quote-right',
            'route' => 'admin.testimonials.index',
        ],

        'settings' => [
            'title' => 'Settings',
            'icon' => 'fas fa-cog',
            'route' => 'admin.settings.index',
        ],
    ];

    // Get current route
    $currentRoute = Route::currentRouteName();
    $isActive = function ($route, $params = []) use ($currentRoute) {
        return $currentRoute === $route;
    };
@endphp

<aside id="sidebar" class="fixed left-0 top-0 z-40 h-screen bg-white/80 backdrop-blur-lg
              border-r border-gray-200/50 shadow-lg group transition-all duration-300
              overflow-hidden sidebar-collapsed
              -translate-x-full md:translate-x-0">

    <div class="flex flex-col h-full">
        <!-- Logo -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200/50">
            <div class="flex items-center space-x-3">
                <div class="admin-logo-box">
                    <i class="fas fa-store"></i>
                </div>
                <span class="text-xl font-bold bg-gradient-to-r from-[var(--primary-brand-start)] to-[var(--primary-brand-end)]
                             bg-clip-text text-transparent transition-all duration-300
                             text-expandable whitespace-nowrap">
                    {{ config('app.name', 'Laravel Admin') }}
                </span>
            </div>
            <button id="sidebarClose" class="text-gray-500 hover:text-gray-700 md:hidden">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>


        <!-- Navigation -->
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            @foreach ($navItems as $key => $item)
                @php
                    $hasSubmenu = isset($item['submenu']);
                    $active = $isActive($item['route'] ?? '');
                    $submenuOpen = $active;
                @endphp

                <div class="relative {{ $submenuOpen ? 'submenu-open' : '' }}">
                    <!-- Parent Menu -->
                    <a href="{{ $hasSubmenu ? '#' : route($item['route']) }}"
                        class="parent-link flex items-center gap-3 px-4 py-3 rounded-xl
                                   text-gray-700 hover:bg-white/50 hover:shadow-sm
                                   transition-all duration-200 group-hover:pr-6
                                   {{ $active ? 'bg-indigo-50/50 border-r-2 border-[var(--primary-color)] text-[var(--primary-color)]' : '' }}">
                        <i class="{{ $item['icon'] }} text-xl min-w-6 text-center
                                      {{ $active ? 'text-indigo-500' : 'text-gray-400 group-hover:text-indigo-400' }}">
                        </i>
                        <span class="font-medium transition-all duration-300 text-expandable whitespace-nowrap">
                            {{ $item['title'] }}
                        </span>
                        @if ($hasSubmenu)
                            <i class="fas fa-chevron-down text-xs ml-auto transition-all duration-300
                                              {{ $submenuOpen ? 'transform rotate-180' : '' }}"></i>
                        @endif
                    </a>

                    <!-- Submenu -->
                    @if ($hasSubmenu)
                        <div class="submenu ml-8 mt-2 space-y-1 {{ $submenuOpen ? 'submenu-open' : '' }}">
                            @foreach ($item['submenu'] as $subKey => $subItem)
                                @php
                                    $subActive = $isActive($subItem['route']);
                                @endphp
                                <a href="{{ route($subItem['route'], $subItem['params'] ?? []) }}" class="submenu-link block px-4 py-2 text-sm rounded-lg
                                                      {{ $subActive ? 'bg-white/50 text-indigo-600' : 'text-gray-600 hover:bg-white/50 hover:text-indigo-600' }}
                                                      transition-all duration-200 text-expandable whitespace-nowrap">
                                    {{ $subItem['title'] }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </nav>

        <!-- Sidebar Footer -->
        <button id="sidebarToggleMode"
            class="w-full mt-4 bg-gray-200 text-gray-700 py-2 rounded-lg text-sm font-medium hover:bg-gray-300 transition">
            Expand
        </button>
    </div>
</aside>

<!-- Overlay for mobile -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-30 md:hidden hidden"></div>