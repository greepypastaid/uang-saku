<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWishlistItemsTable extends Migration
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
            'goal_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'price' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'category' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'item_type' => [
                'type' => "ENUM('need','want')",
            ],
            'urgency_level' => [
                'type'    => "ENUM('urgent','high','medium','low')",
                'default' => 'medium',
            ],
            'priority_score' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'default'    => 0,
            ],
            'work_hours_cost' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
            ],
            'status' => [
                'type'    => "ENUM('pending','saving','ready_to_buy','purchased','cancelled')",
                'default' => 'pending',
            ],
            'image_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
            ],
            'note' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'purchased_at' => [
                'type' => 'DATETIME',
                'null' => true,
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
        $this->forge->addKey('user_id');
        $this->forge->createTable('wishlist_items', true);

        $this->db->query('ALTER TABLE wishlist_items ADD CONSTRAINT fk_wi_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
        $this->db->query('ALTER TABLE wishlist_items ADD CONSTRAINT fk_wi_goal FOREIGN KEY (goal_id) REFERENCES saving_goals(id) ON DELETE SET NULL');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE wishlist_items DROP FOREIGN KEY fk_wi_user');
        $this->db->query('ALTER TABLE wishlist_items DROP FOREIGN KEY fk_wi_goal');
        $this->forge->dropTable('wishlist_items', true);
    }
}
