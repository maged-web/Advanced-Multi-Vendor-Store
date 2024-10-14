<?php
return[
    [
        'icon'=>'nav-icon fas fa-tachometer-alt',
        'route'=>'dashboard.dashboard',
        'title'=>'Dashboard',
        'active'=>'dashboard.dashboard'
        
    ],
    [
        'icon'=>'far fa-circle nav-icon',
        'route'=>'dashboard.categories.index',
        'title'=>'Category',
        'badge'=>'New',
        'active'=>'dashboard.categories.*'
    ],
    [
        'icon'=>'far fa-circle nav-icon',
        'route'=>'dashboard.products.index',
        'title'=>'Product',
        'badge'=>'New',
        'active'=>'dashboard.products.*'
    ]
    ];