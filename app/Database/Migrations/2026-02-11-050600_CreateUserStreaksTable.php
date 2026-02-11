<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserStreaksTable extends Migration
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
            'current_streak' => [
                'type'    => 'INT',
                'default' => 0,
            ],
            'longest_streak' => [
                'type'    => 'INT',
                'default' => 0,
            ],
            'last_activity_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('user_id', 'unique_user_streak');
        $this->forge->createTable('user_streaks', true);

        $this->db->query('ALTER TABLE user_streaks ADD CONSTRAINT fk_us_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE user_streaks DROP FOREIGN KEY fk_us_user');
        $this->forge->dropTable('user_streaks', true);
    }
}
