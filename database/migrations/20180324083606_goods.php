<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Goods extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('goods', array('engine' => 'InnoDB'));
        $table
            ->addColumn('name', 'string', array('limit' => '255', 'default' => ''))
            ->addColumn('thumb', 'string', array('limit' => '255', 'default' => ''))
            ->addColumn('price', 'decimal', array('limit' => 10, 'default' => '0.00'))
            ->addColumn('counts', 'integer', array('limit' => 10, 'default' => 0))
            ->addColumn('redis_counts', 'integer', array('limit' => 10, 'default' => 0))
            ->addColumn('create_at', 'datetime', array('default' => 0))
            ->create();
    }
}
