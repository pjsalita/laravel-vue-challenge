<?php

return [
    /**
     * Determines how the coffee machine's state is persisted.
     * Supported: 'database', 'file', 'cache', 'redis'
     */
    'storage' => env('MACHINE_STATE_STORAGE', 'database'),

    'default_containers' => [
        [
            'type' => 'water',
            'name' => 'Water',
            'current' => 0,
            'capacity' => 2,
            'unit' => 'L',
        ],
        [
            'type' => 'coffee',
            'name' => 'Coffee',
            'current' => 0,
            'capacity' => 500,
            'unit' => 'g',
        ],
    ],

    'default_drinks' => [
        [
            'slug' => 'espresso',
            'name' => 'Espresso',
            'water' => 24,
            'water_unit' => 'mL',
            'coffee' => 8,
            'coffee_unit' => 'g',
            'active' => true,
            'icon' => '<svg class="size-10" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.5" xmlns="http://www.w3.org/2000/svg"><rect x="10" y="10" width="12" height="8" rx="2" /><path d="M22 12h2a2 2 0 0 1 0 4h-2" /><line x1="8" y1="20" x2="24" y2="20" /><circle cx="16" cy="14" r="1.5" fill="currentColor" /></svg>',
        ],
        [
            'slug' => 'double_espresso',
            'name' => 'Double Espresso',
            'water' => 48,
            'water_unit' => 'mL',
            'coffee' => 16,
            'coffee_unit' => 'g',
            'active' => true,
            'icon' => '<svg class="size-10" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.5" xmlns="http://www.w3.org/2000/svg"><rect x="10" y="10" width="12" height="8" rx="2" /><path d="M22 12h2a2 2 0 0 1 0 4h-2" /><line x1="8" y1="20" x2="24" y2="20" /><circle cx="14" cy="14" r="1.5" fill="currentColor" /><circle cx="18" cy="14" r="1.5" fill="currentColor" /></svg>',
        ],
        [
            'slug' => 'ristretto',
            'name' => 'Ristretto',
            'water' => 16,
            'water_unit' => 'mL',
            'coffee' => 8,
            'coffee_unit' => 'g',
            'active' => false,
            'icon' => '<svg width="32" height="32" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.5" xmlns="http://www.w3.org/2000/svg"><rect x="12" y="10" width="8" height="8" rx="2"/><path d="M20 12h2a2 2 0 0 1 0 4h-2"/><line x1="10" y1="20" x2="22" y2="20"/><rect x="14" y="12" width="4" height="4" fill="currentColor"/></svg>',
        ],
        [
            'slug' => 'americano',
            'name' => 'Americano',
            'water' => 148,
            'water_unit' => 'mL',
            'coffee' => 16,
            'coffee_unit' => 'g',
            'active' => true,
            'icon' => '<svg class="size-10" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.5" xmlns="http://www.w3.org/2000/svg"><rect x="12" y="8" width="8" height="12" rx="2" /><path d="M20 10h2a2 2 0 0 1 0 4h-2" /><line x1="10" y1="22" x2="22" y2="22" /><line x1="14" y1="12" x2="18" y2="12" /><line x1="14" y1="16" x2="18" y2="16" /></svg>',
        ],
    ],
];
