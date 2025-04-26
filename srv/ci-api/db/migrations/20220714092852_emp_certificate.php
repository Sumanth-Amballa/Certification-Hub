<?php


use Phinx\Migration\AbstractMigration;

class EmpCertificate extends AbstractMigration
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
        $table=$this->table('employee_certificate');
        $table
            ->addColumn('e_id','integer','NOT NULL')
            ->addColumn('c_id','integer','NOT NULL')
            ->addColumn('c_status','integer',['default'=>0])
            ->addColumn('attachment','string','NULL')
            ->addColumn('c_start', 'datetime')
            ->addColumn('c_end', 'datetime')
            ->addColumn('created_time', 'datetime')
            ->addColumn('modify_time', 'datetime')
            ->addColumn('active_status', 'integer',['default'=>1])
            ->addForeignKey('e_id','users','id',['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addForeignKey('c_id','certificates','cert_id',['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->create();
    }
}
