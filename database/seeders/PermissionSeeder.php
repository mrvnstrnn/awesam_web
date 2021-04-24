<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 'mode', 'menu', 'slug', 'title', 'sub title', 'levle_one', 'level_two', 'level_three'
        $data = [
            ['STS Endorsements', 'sts-endorsements', 'STS Endorsements', 'New sites from STS', 'profile_menu', 'tasks', ''],
            ['Document Approval', 'document-approval', 'Document Approval', 'Document management and validation', 'profile_menu', 'tasks', ''],
            ['Issue Approval', 'issue-approval', 'Issue Approval', 'Issue management and validation', 'profile_menu', 'tasks', ''],
            ['Calendar', 'calendar', 'My Calendar', 'Activities tracker', 'profile_menu', 'schedule', ''],
            ['Tasks', 'tasks', 'My Tasks', 'Tasks tracker', 'profile_menu', 'schedule', ''],
            ['Requests', 'requests', 'My Requests', 'Request tracker', 'profile_menu', 'schedule', ''],
            ['Calendar', 'calendar', 'Team Calendar', 'Activities tracker', 'profile_menu', 'schedule', ''],
            ['Team Tasks', 'tasks', 'Team Tasks', 'Team task management', 'profile_menu', 'tasks', ''],
            ['Requests', 'requests', 'Team Requests', 'Request tracker', 'profile_menu', 'schedule', ''],
            ['Agents', 'agents', 'My Team', 'Supervisor\'s team management', 'profile_menu', 'agents', ''],
            ['Dashboard', 'coloc', 'COLOC Dashboard', 'Colocation Service Management', 'program_menu', 'Colocation', ''],
            ['Universe', 'coloc/universe', 'COLOC Universe', 'Colocation Service Complete Sites', 'program_menu', 'Colocation', ''],
            ['Descoped', 'coloc/descoped', 'COLOC Descoped', 'Colocation Service Descoped Sites', 'program_menu', 'Colocation', ''],
            ['Dashboard', 'ibs', 'IBS Dashboard', 'In-Building Service Management', 'program_menu', 'In-Building', ''],
            ['Universe', 'ibs/universe', 'IBS Universe', 'In-Building Service Complete Sites', 'program_menu', 'In-Building', ''],
            ['Descoped', 'ibs/descoped', 'IBS Descoped', 'In-Building Service Descoped Sites', 'program_menu', 'In-Building', ''],
            ['Dashboard', 'wireless', 'Wireless Dashboard', 'Wireless Service Management', 'program_menu', 'Wireless', ''],
            ['Universe', 'wireless/universe', 'Wireless Universe', 'Wireless Service Complete Sites', 'program_menu', 'Wireless', ''],
            ['Descoped', 'wireless/descoped', 'Wireless Descoped', 'Wireless Service Descoped Sites', 'program_menu', 'Wireless', ''],
        ];

        for ($i=0; $i < count($data); $i++) { 
            Permission::create([
                'title' => $data[$i][2],
                'title_subheading' => $data[$i][3],
                'menu' => $data[$i][0],
                'slug' => $data[$i][1],
                'level_one' => $data[$i][4],
                'level_two' => $data[$i][5],
                'level_three' => $data[$i][6],
            ]);
        }
    }
}
