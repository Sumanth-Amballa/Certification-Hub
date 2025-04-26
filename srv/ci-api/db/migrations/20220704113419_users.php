<?php


use Phinx\Migration\AbstractMigration;

class Users extends AbstractMigration
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
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other distructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table=$this->table('users');
        $table
            ->addColumn('email','varbinary','NOT NULL')
            ->addColumn('password','string','NOT NULL')
            ->addColumn('role_id', 'string',['default'=>'3'])
            ->addColumn('manager_id','integer','NOT NULL')
            ->addColumn('dept_id','integer','NOT NULL')
            ->addColumn('created_time', 'datetime')
            ->addColumn('modify_time', 'datetime')
            ->addColumn('active_status', 'integer',['default'=>1])
            ->addForeignKey('dept_id','department','d_id',['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->create();
    
    }
}
