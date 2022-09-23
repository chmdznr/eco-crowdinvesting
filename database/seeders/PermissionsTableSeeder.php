<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'audit_log_show',
            ],
            [
                'id'    => 18,
                'title' => 'audit_log_access',
            ],
            [
                'id'    => 19,
                'title' => 'user_alert_create',
            ],
            [
                'id'    => 20,
                'title' => 'user_alert_show',
            ],
            [
                'id'    => 21,
                'title' => 'user_alert_delete',
            ],
            [
                'id'    => 22,
                'title' => 'user_alert_access',
            ],
            [
                'id'    => 23,
                'title' => 'faq_management_access',
            ],
            [
                'id'    => 24,
                'title' => 'faq_category_create',
            ],
            [
                'id'    => 25,
                'title' => 'faq_category_edit',
            ],
            [
                'id'    => 26,
                'title' => 'faq_category_show',
            ],
            [
                'id'    => 27,
                'title' => 'faq_category_delete',
            ],
            [
                'id'    => 28,
                'title' => 'faq_category_access',
            ],
            [
                'id'    => 29,
                'title' => 'faq_question_create',
            ],
            [
                'id'    => 30,
                'title' => 'faq_question_edit',
            ],
            [
                'id'    => 31,
                'title' => 'faq_question_show',
            ],
            [
                'id'    => 32,
                'title' => 'faq_question_delete',
            ],
            [
                'id'    => 33,
                'title' => 'faq_question_access',
            ],
            [
                'id'    => 34,
                'title' => 'content_management_access',
            ],
            [
                'id'    => 35,
                'title' => 'content_category_create',
            ],
            [
                'id'    => 36,
                'title' => 'content_category_edit',
            ],
            [
                'id'    => 37,
                'title' => 'content_category_show',
            ],
            [
                'id'    => 38,
                'title' => 'content_category_delete',
            ],
            [
                'id'    => 39,
                'title' => 'content_category_access',
            ],
            [
                'id'    => 40,
                'title' => 'content_tag_create',
            ],
            [
                'id'    => 41,
                'title' => 'content_tag_edit',
            ],
            [
                'id'    => 42,
                'title' => 'content_tag_show',
            ],
            [
                'id'    => 43,
                'title' => 'content_tag_delete',
            ],
            [
                'id'    => 44,
                'title' => 'content_tag_access',
            ],
            [
                'id'    => 45,
                'title' => 'content_page_create',
            ],
            [
                'id'    => 46,
                'title' => 'content_page_edit',
            ],
            [
                'id'    => 47,
                'title' => 'content_page_show',
            ],
            [
                'id'    => 48,
                'title' => 'content_page_delete',
            ],
            [
                'id'    => 49,
                'title' => 'content_page_access',
            ],
            [
                'id'    => 50,
                'title' => 'time_management_access',
            ],
            [
                'id'    => 51,
                'title' => 'time_work_type_create',
            ],
            [
                'id'    => 52,
                'title' => 'time_work_type_edit',
            ],
            [
                'id'    => 53,
                'title' => 'time_work_type_show',
            ],
            [
                'id'    => 54,
                'title' => 'time_work_type_delete',
            ],
            [
                'id'    => 55,
                'title' => 'time_work_type_access',
            ],
            [
                'id'    => 56,
                'title' => 'time_project_create',
            ],
            [
                'id'    => 57,
                'title' => 'time_project_edit',
            ],
            [
                'id'    => 58,
                'title' => 'time_project_show',
            ],
            [
                'id'    => 59,
                'title' => 'time_project_delete',
            ],
            [
                'id'    => 60,
                'title' => 'time_project_access',
            ],
            [
                'id'    => 61,
                'title' => 'time_entry_create',
            ],
            [
                'id'    => 62,
                'title' => 'time_entry_edit',
            ],
            [
                'id'    => 63,
                'title' => 'time_entry_show',
            ],
            [
                'id'    => 64,
                'title' => 'time_entry_delete',
            ],
            [
                'id'    => 65,
                'title' => 'time_entry_access',
            ],
            [
                'id'    => 66,
                'title' => 'time_report_create',
            ],
            [
                'id'    => 67,
                'title' => 'time_report_edit',
            ],
            [
                'id'    => 68,
                'title' => 'time_report_show',
            ],
            [
                'id'    => 69,
                'title' => 'time_report_delete',
            ],
            [
                'id'    => 70,
                'title' => 'time_report_access',
            ],
            [
                'id'    => 71,
                'title' => 'task_management_access',
            ],
            [
                'id'    => 72,
                'title' => 'task_status_create',
            ],
            [
                'id'    => 73,
                'title' => 'task_status_edit',
            ],
            [
                'id'    => 74,
                'title' => 'task_status_show',
            ],
            [
                'id'    => 75,
                'title' => 'task_status_delete',
            ],
            [
                'id'    => 76,
                'title' => 'task_status_access',
            ],
            [
                'id'    => 77,
                'title' => 'task_tag_create',
            ],
            [
                'id'    => 78,
                'title' => 'task_tag_edit',
            ],
            [
                'id'    => 79,
                'title' => 'task_tag_show',
            ],
            [
                'id'    => 80,
                'title' => 'task_tag_delete',
            ],
            [
                'id'    => 81,
                'title' => 'task_tag_access',
            ],
            [
                'id'    => 82,
                'title' => 'task_create',
            ],
            [
                'id'    => 83,
                'title' => 'task_edit',
            ],
            [
                'id'    => 84,
                'title' => 'task_show',
            ],
            [
                'id'    => 85,
                'title' => 'task_delete',
            ],
            [
                'id'    => 86,
                'title' => 'task_access',
            ],
            [
                'id'    => 87,
                'title' => 'tasks_calendar_access',
            ],
            [
                'id'    => 88,
                'title' => 'financial_access_type_create',
            ],
            [
                'id'    => 89,
                'title' => 'financial_access_type_edit',
            ],
            [
                'id'    => 90,
                'title' => 'financial_access_type_show',
            ],
            [
                'id'    => 91,
                'title' => 'financial_access_type_delete',
            ],
            [
                'id'    => 92,
                'title' => 'financial_access_type_access',
            ],
            [
                'id'    => 93,
                'title' => 'market_access_type_create',
            ],
            [
                'id'    => 94,
                'title' => 'market_access_type_edit',
            ],
            [
                'id'    => 95,
                'title' => 'market_access_type_show',
            ],
            [
                'id'    => 96,
                'title' => 'market_access_type_delete',
            ],
            [
                'id'    => 97,
                'title' => 'market_access_type_access',
            ],
            [
                'id'    => 98,
                'title' => 'project_status_create',
            ],
            [
                'id'    => 99,
                'title' => 'project_status_edit',
            ],
            [
                'id'    => 100,
                'title' => 'project_status_show',
            ],
            [
                'id'    => 101,
                'title' => 'project_status_delete',
            ],
            [
                'id'    => 102,
                'title' => 'project_status_access',
            ],
            [
                'id'    => 103,
                'title' => 'umkm_access',
            ],
            [
                'id'    => 104,
                'title' => 'type_of_business_create',
            ],
            [
                'id'    => 105,
                'title' => 'type_of_business_edit',
            ],
            [
                'id'    => 106,
                'title' => 'type_of_business_show',
            ],
            [
                'id'    => 107,
                'title' => 'type_of_business_delete',
            ],
            [
                'id'    => 108,
                'title' => 'type_of_business_access',
            ],
            [
                'id'    => 109,
                'title' => 'enterprise_create',
            ],
            [
                'id'    => 110,
                'title' => 'enterprise_edit',
            ],
            [
                'id'    => 111,
                'title' => 'enterprise_show',
            ],
            [
                'id'    => 112,
                'title' => 'enterprise_delete',
            ],
            [
                'id'    => 113,
                'title' => 'enterprise_access',
            ],
            [
                'id'    => 114,
                'title' => 'project_doc_create',
            ],
            [
                'id'    => 115,
                'title' => 'project_doc_edit',
            ],
            [
                'id'    => 116,
                'title' => 'project_doc_show',
            ],
            [
                'id'    => 117,
                'title' => 'project_doc_delete',
            ],
            [
                'id'    => 118,
                'title' => 'project_doc_access',
            ],
            [
                'id'    => 119,
                'title' => 'enterprise_doc_create',
            ],
            [
                'id'    => 120,
                'title' => 'enterprise_doc_edit',
            ],
            [
                'id'    => 121,
                'title' => 'enterprise_doc_show',
            ],
            [
                'id'    => 122,
                'title' => 'enterprise_doc_delete',
            ],
            [
                'id'    => 123,
                'title' => 'enterprise_doc_access',
            ],
            [
                'id'    => 124,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
