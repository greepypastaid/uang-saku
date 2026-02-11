<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReportInsightsTable extends Migration
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
            'report_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'insight_type' => [
                'type' => "ENUM('overspending','saving_achievement','goal_acceleration','spending_trend','debt_warning','streak_praise','budget_compliance','emergency_fund')",
            ],
            'category' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'message' => [
                'type' => 'TEXT',
            ],
            'severity' => [
                'type'    => "ENUM('info','success','warning','danger')",
                'default' => 'info',
            ],
            'metadata' => [
                'type' => 'JSON',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('report_id');
        $this->forge->createTable('report_insights', true);

        $this->db->query('ALTER TABLE report_insights ADD CONSTRAINT fk_ri_report FOREIGN KEY (report_id) REFERENCES monthly_reports(id) ON DELETE CASCADE');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE report_insights DROP FOREIGN KEY fk_ri_report');
        $this->forge->dropTable('report_insights', true);
    }
}
