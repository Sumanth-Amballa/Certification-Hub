<?php


use Phinx\Migration\AbstractMigration;

class UserProfile extends AbstractMigration
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
        $table=$this->table('user_profile');
        $table
            ->addColumn('user_id','integer','NOT NULL')
            ->addColumn('username','string','NULL')
            ->addColumn('phonenumber','string','NULL')
            ->addColumn('dob','date',)
            ->addColumn('image','string','NULL')
            ->addColumn('created_time', 'datetime')
            ->addColumn('modify_time', 'datetime')
            ->addColumn('active_status', 'integer',['default'=>1])
            ->addForeignKey('user_id','users','id',['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->create();
    }
}
