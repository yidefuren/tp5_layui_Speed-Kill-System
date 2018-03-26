<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Orders extends Migrator
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
        $table = $this->table('orders', ['engine' => 'InnoDB']);
        $table
            ->addColumn('order_id', 'string', array('limit' => '20', 'default' => ''))
            ->addColumn('gid', 'integer', array('limit'=>11, 'default'=> 0))
            ->addColumn('ip', 'string', array('limit' => 32, 'default'=>''))
            ->addColumn('temp', 'string', array('limit' => 50, 'default'=>''))
            ->addColumn('create_at', 'datetime', array('default' => 0))
            ->addIndex(array('gid'))
            ->create();

    }
}
