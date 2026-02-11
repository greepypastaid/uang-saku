<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMonthlyReportsTable extends Migration
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
            'month' => [
                'type'       => 'INT',
                'constraint' => 2,
            ],
            'year' => [
                'type'       => 'INT',
                'constraint' => 4,
            ],
            'total_income' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'default'    => 0,
            ],
            'total_expense' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'default'    => 0,
            ],
            'total_saving' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'default'    => 0,
            ],
            'net_cashflow' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'default'    => 0,
            ],
            'health_score_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['user_id', 'month', 'year'], 'unique_user_report');
        $this->forge->createTable('monthly_reports', true);

        $this->db->query('ALTER TABLE monthly_reports ADD CONSTRAINT fk_mr_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
        $this->db->query('ALTER TABLE monthly_reports ADD CONSTRAINT fk_mr_health FOREIGN KEY (health_score_id) REFERENCES financial_health_scores(id) ON DELETE SET NULL');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE monthly_reports DROP FOREIGN KEY fk_mr_user');
        $this->db->query('ALTER TABLE monthly_reports DROP FOREIGN KEY fk_mr_health');
        $this->forge->dropTable('monthly_reports', true);
    }
}
