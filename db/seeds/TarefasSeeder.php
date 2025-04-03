<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class TarefasSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $data = [
            [
                'title' => 'Estudar React',
                'description' => 'Motivo: criar um projeto SPA',
            ],
            [
                'title' => 'Estudar Tailwindcss',
                'description' => 'Motivo: criar o frontend mais rápido',
            ],
            [
                'title' => 'Criar um projeto com tudo que aprendi',
                'description' => 'Criar para ter mais experiência'
            ]
        ];

        $this->table('tarefas')->insert($data)->save();
    }
}
