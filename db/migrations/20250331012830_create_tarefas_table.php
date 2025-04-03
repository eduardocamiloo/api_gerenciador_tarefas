<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTarefasTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('tarefas');
        $table
            ->addColumn('title', 'string', ['null' => false])
            ->addColumn('description', 'string', ['null' => false])
            ->addColumn('isCompleted', 'boolean', ['null' => false, "default" => false])
            ->addColumn("created_at", "timestamp", ["null" => false, "default" => "CURRENT_TIMESTAMP"])
            ->addColumn("updated_at", "timestamp", ["null" => false, "default" => "CURRENT_TIMESTAMP"])
        ->create();
    }
}
