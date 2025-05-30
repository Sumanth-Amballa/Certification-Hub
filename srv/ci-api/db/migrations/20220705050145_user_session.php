<?php


use Phinx\Migration\AbstractMigration;

class UserSession extends AbstractMigration
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
        $table=$this->table('user_session');
        $table
            ->addColumn('user_id','integer','NOT NULL')
            ->addColumn('token','varbinary','NOT NULL')
            ->addColumn('login_time', 'datetime')
            ->addColumn('logout_time', 'datetime')
            ->addForeignKey('user_id','users','id',['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->create();
    }
}
