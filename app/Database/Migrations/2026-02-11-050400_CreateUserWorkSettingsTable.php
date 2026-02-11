<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserWorkSettingsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'working_days_per_month' => [
                'type'       => 'TINYINT',
                'default'    => 22,
            ],
            'working_hours_per_day' => [
                'type'       => 'TINYINT',
                'default'    => 8,
            ],
            'custom_monthly_income' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('user_id', 'unique_user_work');
        $this->forge->createTable('user_work_settings', true);

        $this->db->query('ALTER TABLE user_work_settings ADD CONSTRAINT fk_uws_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE user_work_settings DROP FOREIGN KEY fk_uws_user');
        $this->forge->dropTable('user_work_settings', true);
    }
}
