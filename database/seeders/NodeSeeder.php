<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Node;

class NodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        // Nodos 1
        Node::create(['title' => 'test','parent' => null]);
        Node::create(['parent' => 1]);
        Node::create(['parent' => 1]);
        Node::create(['parent' => 1]);
        Node::create(['parent' => 2]);
        Node::create(['parent' => 3]);
        Node::create(['parent' => 4]);
        Node::create(['parent' => 4]);

        // Nodos 2
        Node::create(['parent' => null]);
        Node::create(['parent' => 9]);
        Node::create(['parent' => 9]);
        Node::create(['parent' => 9]);
        Node::create(['parent' => 10]);
        Node::create(['parent' => 10]);
        Node::create(['parent' => 11]);
        Node::create(['parent' => 12]);

        // Nodos 3
        Node::create(['parent' => null]);
        Node::create(['parent' => 17]);

        // Nodos 4
        Node::create(['parent' => null]);
    }
}
