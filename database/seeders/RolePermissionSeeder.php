<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User Management
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',

            // Product Management
            'view-products',
            'create-products',
            'edit-products',
            'delete-products',
            'manage-product-variants',
            'manage-product-images',
            'manage-product-attributes',

            // Category Management
            'view-categories',
            'create-categories',
            'edit-categories',
            'delete-categories',

            // Brand Management
            'view-brands',
            'create-brands',
            'edit-brands',
            'delete-brands',

            // Order Management
            'view-orders',
            'create-orders',
            'edit-orders',
            'delete-orders',
            'process-orders',
            'view-order-details',
            'manage-order-status',
            'manage-refunds',

            // Inventory Management
            'view-inventory',
            'manage-inventory',
            'view-stock-alerts',
            'manage-stock-adjustments',
            'view-warehouses',
            'manage-warehouses',

            // Customer Management
            'view-customers',
            'edit-customers',
            'delete-customers',
            'view-customer-orders',
            'view-customer-reviews',

            // Coupon Management
            'view-coupons',
            'create-coupons',
            'edit-coupons',
            'delete-coupons',

            // Payment Management
            'view-payments',
            'process-payments',
            'manage-payment-methods',
            'view-transactions',

            // Shipping Management
            'view-shipping-methods',
            'manage-shipping-methods',
            'view-shipping-zones',
            'manage-shipping-zones',
            'view-shipments',
            'manage-shipments',
            'track-shipments',

            // Tax Management
            'view-tax-settings',
            'manage-tax-classes',
            'manage-tax-rates',
            'manage-tax-rules',

            // Content Management
            'view-pages',
            'create-pages',
            'edit-pages',
            'delete-pages',
            'view-blogs',
            'create-blogs',
            'edit-blogs',
            'delete-blogs',
            'manage-banners',
            'manage-menus',

            // Review Management
            'view-reviews',
            'moderate-reviews',
            'delete-reviews',

            // Newsletter Management
            'view-newsletters',
            'manage-newsletters',
            'view-email-campaigns',
            'manage-email-campaigns',

            // Support Management
            'view-support-tickets',
            'create-support-tickets',
            'edit-support-tickets',
            'close-support-tickets',
            'view-ticket-messages',
            'create-ticket-messages',

            // Vendor Management (if marketplace)
            'view-vendors',
            'approve-vendors',
            'manage-vendor-applications',
            'view-vendor-commissions',
            'manage-vendor-payouts',

            // Settings Management
            'view-settings',
            'manage-settings',
            'manage-currencies',
            'manage-countries',

            // Analytics & Reports
            'view-analytics',
            'view-reports',
            'export-data',

            // System Administration
            'access-admin-panel',
            'manage-roles',
            'manage-permissions',
            'view-system-logs',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $this->createSuperAdminRole();
        $this->createAdminRole();
        $this->createManagerRole();
        $this->createVendorRole();
        $this->createCustomerSupportRole();
        $this->createCustomerRole();
    }

    private function createSuperAdminRole()
    {
        $role = Role::create(['name' => 'super-admin']);
        // Super admin gets all permissions
        $role->givePermissionTo(Permission::all());
    }

    private function createAdminRole()
    {
        $role = Role::create(['name' => 'admin']);

        $permissions = [
            'access-admin-panel',
            'view-users', 'create-users', 'edit-users', 'delete-users',
            'view-products', 'create-products', 'edit-products', 'delete-products',
            'manage-product-variants', 'manage-product-images', 'manage-product-attributes',
            'view-categories', 'create-categories', 'edit-categories', 'delete-categories',
            'view-brands', 'create-brands', 'edit-brands', 'delete-brands',
            'view-orders', 'create-orders', 'edit-orders', 'process-orders',
            'view-order-details', 'manage-order-status', 'manage-refunds',
            'view-inventory', 'manage-inventory', 'view-stock-alerts', 'manage-stock-adjustments',
            'view-warehouses', 'manage-warehouses',
            'view-customers', 'edit-customers', 'view-customer-orders', 'view-customer-reviews',
            'view-coupons', 'create-coupons', 'edit-coupons', 'delete-coupons',
            'view-payments', 'process-payments', 'manage-payment-methods', 'view-transactions',
            'view-shipping-methods', 'manage-shipping-methods', 'view-shipping-zones', 'manage-shipping-zones',
            'view-shipments', 'manage-shipments', 'track-shipments',
            'view-tax-settings', 'manage-tax-classes', 'manage-tax-rates', 'manage-tax-rules',
            'view-pages', 'create-pages', 'edit-pages', 'delete-pages',
            'view-blogs', 'create-blogs', 'edit-blogs', 'delete-blogs',
            'manage-banners', 'manage-menus',
            'view-reviews', 'moderate-reviews', 'delete-reviews',
            'view-newsletters', 'manage-newsletters', 'view-email-campaigns', 'manage-email-campaigns',
            'view-vendors', 'approve-vendors', 'manage-vendor-applications',
            'view-vendor-commissions', 'manage-vendor-payouts',
            'view-settings', 'manage-settings', 'manage-currencies', 'manage-countries',
            'view-analytics', 'view-reports', 'export-data',
        ];

        $role->givePermissionTo($permissions);
    }

    private function createManagerRole()
    {
        $role = Role::create(['name' => 'manager']);

        $permissions = [
            'access-admin-panel',
            'view-products', 'create-products', 'edit-products',
            'manage-product-variants', 'manage-product-images', 'manage-product-attributes',
            'view-categories', 'create-categories', 'edit-categories',
            'view-brands', 'view-brands', 'edit-brands',
            'view-orders', 'edit-orders', 'process-orders', 'view-order-details', 'manage-order-status',
            'view-inventory', 'manage-inventory', 'view-stock-alerts', 'manage-stock-adjustments',
            'view-customers', 'view-customer-orders', 'view-customer-reviews',
            'view-coupons', 'create-coupons', 'edit-coupons',
            'view-payments', 'view-transactions',
            'view-shipments', 'manage-shipments', 'track-shipments',
            'view-reviews', 'moderate-reviews',
            'view-support-tickets', 'edit-support-tickets', 'view-ticket-messages', 'create-ticket-messages',
            'view-analytics', 'view-reports',
        ];

        $role->givePermissionTo($permissions);
    }

    private function createVendorRole()
    {
        $role = Role::create(['name' => 'vendor']);

        $permissions = [
            'access-admin-panel',
            'view-products', 'create-products', 'edit-products',
            'manage-product-variants', 'manage-product-images', 'manage-product-attributes',
            'view-orders', 'view-order-details', 'manage-order-status',
            'view-inventory', 'manage-inventory', 'view-stock-alerts',
            'view-shipments', 'manage-shipments', 'track-shipments',
            'view-analytics', 'view-reports',
        ];

        $role->givePermissionTo($permissions);
    }

    private function createCustomerSupportRole()
    {
        $role = Role::create(['name' => 'customer-support']);

        $permissions = [
            'access-admin-panel',
            'view-customers', 'view-customer-orders', 'view-customer-reviews',
            'view-orders', 'view-order-details',
            'view-support-tickets', 'create-support-tickets', 'edit-support-tickets', 'close-support-tickets',
            'view-ticket-messages', 'create-ticket-messages',
            'view-reviews', 'moderate-reviews',
            'manage-refunds',
        ];

        $role->givePermissionTo($permissions);
    }

    private function createCustomerRole()
    {
        $role = Role::create(['name' => 'customer']);

        $permissions = [
            'view-products',
            'create-orders',
            'view-order-details',
            'create-support-tickets',
            'view-ticket-messages',
            'create-ticket-messages',
        ];

        $role->givePermissionTo($permissions);
    }
}
