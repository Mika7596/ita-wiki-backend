<?php

declare (strict_types=1);

namespace App\Console\Commands;

use App\Models\RoleNode;
use Illuminate\Console\Command;

class CreateSuperAdminNode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:superadmin {node_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a Superadmin with node_id using env variable';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        
        $superadmin_node_id = $this->argument('node_id');

        if(!$superadmin_node_id){
            $superadmin_github_id = env('SUPERADMIN_NODE_ID');
        }

        if(!$superadmin_node_id){
            $this->error('The Node ID is not defined');
            return Command::FAILURE;
        }

        RoleNode::create([
            'node_id' => $superadmin_node_id,
            'role' => 'superadmin',
        ]);

        $this->info('Superadmin created successfully with node_id: ' . $superadmin_node_id);
        return Command::SUCCESS;
    }
}
