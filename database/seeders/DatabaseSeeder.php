<?php

namespace Database\Seeders;

use App\Enums\PlanType;
use App\Enums\UserRole;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Criar uma Empresa de Teste
        $company = Company::factory()->create([
            'name' => 'Empresa Gamifica',
            'slug' => 'empresa-gamifica',
            'plan_type' => PlanType::Pro,
        ]);

        // 2. Criar um Administrador
        User::factory()->create([
            'company_id' => $company->id,
            'name' => 'Admin Teste',
            'username' => 'admin',
            'email' => 'admin@gamifica.com.br',
            'password' => Hash::make('password'), // Senha padrão: password
            'role' => UserRole::Admin,
        ]);

        // 3. Criar um Colaborador
        User::factory()->create([
            'company_id' => $company->id,
            'name' => 'João Colaborador',
            'username' => 'joao',
            'email' => 'joao@gamifica.com.br',
            'password' => Hash::make('password'), // Senha padrão: password
            'role' => UserRole::Employee,
            'points_balance' => 500,
        ]);

        // 4. Criar outra empresa para testar isolamento (opcional no seeder)
        Company::factory(2)->hasUsers(3)->create();
    }
}
