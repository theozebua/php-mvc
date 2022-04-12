<?php

namespace App\Core\Interfaces;

interface Migration
{
    /**
     * This is a function to create a table that
     * every migration class must implements
     */
    public function up(): bool;

    /**
     * This is a function to drop a table that
     * every migration class must implements
     */
    public function down(): bool;
}
