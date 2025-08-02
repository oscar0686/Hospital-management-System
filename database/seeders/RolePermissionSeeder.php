<?php
// database/seeders/RolePermissionSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions (only if they don't exist)
        $permissions = [
            'manage-users',
            'view-patients', 'create-patients', 'edit-patients', 'delete-patients',
            'view-doctors', 'create-doctors', 'edit-doctors', 'delete-doctors',
            'view-appointments', 'create-appointments', 'edit-appointments', 'delete-appointments',
            'view-medical-records', 'create-medical-records', 'edit-medical-records', 'delete-medical-records',
            'view-prescriptions', 'create-prescriptions', 'edit-prescriptions', 'delete-prescriptions',
            'view-bills', 'create-bills', 'edit-bills', 'delete-bills',
            'view-reports', 'generate-reports',
            'manage-settings'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions (only if they don't exist)
        $admin = Role::firstOrCreate(['name' => 'admin']);
        if (!$admin->hasAnyPermission(Permission::all())) {
            $admin->givePermissionTo(Permission::all());
        }

        $doctor = Role::firstOrCreate(['name' => 'doctor']);
        $doctorPermissions = [
            'view-patients', 'edit-patients',
            'view-appointments', 'edit-appointments',
            'view-medical-records', 'create-medical-records', 'edit-medical-records',
            'view-prescriptions', 'create-prescriptions', 'edit-prescriptions',
            'view-bills'
        ];
        if (!$doctor->hasAnyPermission($doctorPermissions)) {
            $doctor->givePermissionTo($doctorPermissions);
        }

        $patient = Role::firstOrCreate(['name' => 'patient']);
        $patientPermissions = [
            'view-appointments', 'view-medical-records', 'view-prescriptions', 'view-bills'
        ];
        if (!$patient->hasAnyPermission($patientPermissions)) {
            $patient->givePermissionTo($patientPermissions);
        }

        $nurse = Role::firstOrCreate(['name' => 'nurse']);
        $nursePermissions = [
            'view-patients', 'edit-patients',
            'view-appointments', 'edit-appointments',
            'view-medical-records', 'create-medical-records',
            'view-prescriptions'
        ];
        if (!$nurse->hasAnyPermission($nursePermissions)) {
            $nurse->givePermissionTo($nursePermissions);
        }

        $receptionist = Role::firstOrCreate(['name' => 'receptionist']);
        $receptionistPermissions = [
            'view-patients', 'create-patients', 'edit-patients',
            'view-appointments', 'create-appointments', 'edit-appointments',
            'view-bills', 'create-bills', 'edit-bills'
        ];
        if (!$receptionist->hasAnyPermission($receptionistPermissions)) {
            $receptionist->givePermissionTo($receptionistPermissions);
        }

        // Create users using your exact table structure (NO 'name' column)

        // Admin user
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@hospital.com'],
            [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'email' => 'admin@hospital.com',
                'password' => Hash::make('password'),
                'phone' => '+1234567890',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Doctor user
        $doctorUser = User::firstOrCreate(
            ['email' => 'doctor@hospital.com'],
            [
                'first_name' => 'Dr. John',
                'last_name' => 'Smith',
                'email' => 'doctor@hospital.com',
                'password' => Hash::make('password'),
                'phone' => '+1234567891',
                'gender' => 'male',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Patient user
        $patientUser = User::firstOrCreate(
            ['email' => 'patient@hospital.com'],
            [
                'first_name' => 'Jane',
                'last_name' => 'Doe',
                'email' => 'patient@hospital.com',
                'password' => Hash::make('password'),
                'phone' => '+1234567892',
                'gender' => 'female',
                'date_of_birth' => '1990-01-01',
                'address' => '123 Main St, City, Country',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Nurse user
        $nurseUser = User::firstOrCreate(
            ['email' => 'nurse@hospital.com'],
            [
                'first_name' => 'Sarah',
                'last_name' => 'Johnson',
                'email' => 'nurse@hospital.com',
                'password' => Hash::make('password'),
                'phone' => '+1234567893',
                'gender' => 'female',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Receptionist user
        $receptionistUser = User::firstOrCreate(
            ['email' => 'receptionist@hospital.com'],
            [
                'first_name' => 'Mike',
                'last_name' => 'Wilson',
                'email' => 'receptionist@hospital.com',
                'password' => Hash::make('password'),
                'phone' => '+1234567894',
                'gender' => 'male',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Assign roles (only if not already assigned)
        if (!$adminUser->hasRole('admin')) {
            $adminUser->assignRole('admin');
        }
        if (!$doctorUser->hasRole('doctor')) {
            $doctorUser->assignRole('doctor');
        }
        if (!$patientUser->hasRole('patient')) {
            $patientUser->assignRole('patient');
        }
        if (!$nurseUser->hasRole('nurse')) {
            $nurseUser->assignRole('nurse');
        }
        if (!$receptionistUser->hasRole('receptionist')) {
            $receptionistUser->assignRole('receptionist');
        }

        $this->command->info('Roles and permissions seeded successfully!');
        $this->command->info('Default users created:');
        $this->command->info('Admin: admin@hospital.com / password');
        $this->command->info('Doctor: doctor@hospital.com / password');
        $this->command->info('Patient: patient@hospital.com / password');
        $this->command->info('Nurse: nurse@hospital.com / password');
        $this->command->info('Receptionist: receptionist@hospital.com / password');
    }
}