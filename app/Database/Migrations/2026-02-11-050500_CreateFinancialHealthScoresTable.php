<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFinancialHealthScoresTable extends Migration
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
                'comment'    => 'Month (1-12)',
            ],
            'year' => [
                'type'       => 'INT',
                'constraint' => 4,
                'comment'    => 'Year (e.g., 2026)',
            ],
            'saving_ratio_score' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'default'    => 0,
            ],
            'debt_ratio_score' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'default'    => 0,
            ],
            'budget_compliance_score' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'default'    => 0,
            ],
            'emergency_fund_score' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'default'    => 0,
            ],
            'total_score' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'default'    => 0,
            ],
            'label' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['user_id', 'month', 'year'], 'unique_user_month_year');
        $this->forge->createTable('financial_health_scores', true);

        $this->db->query('ALTER TABLE financial_health_scores ADD CONSTRAINT fk_fhs_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE financial_health_scores DROP FOREIGN KEY fk_fhs_user');
        $this->forge->dropTable('financial_health_scores', true);
    }
}
