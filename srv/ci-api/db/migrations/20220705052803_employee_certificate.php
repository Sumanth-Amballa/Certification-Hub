<?php


use Phinx\Migration\AbstractMigration;

class EmployeeCertificate extends AbstractMigration
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
        $table=$this->table('certificates',['id'=>'cert_id']);
        $table
            ->addColumn('cert_name','string','NOT NULL')
            ->addColumn('levels','string','NOT NULL')
            ->addColumn('description','string','NOT NULL')
            ->addColumn('image','string','NULL')
            ->addColumn('references','string','NOT NULL')
            ->addColumn('authorization_status','string',['default'=>'1'])
            ->addColumn('created_time', 'datetime')
            ->addColumn('modify_time', 'datetime')
            ->addColumn('active_status', 'integer',['default'=>1])
            ->create();
    }
}
