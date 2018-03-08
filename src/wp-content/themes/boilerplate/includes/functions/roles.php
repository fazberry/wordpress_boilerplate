<?php
    // Admin role
    $role = get_role('administrator');
    $role->add_cap('sequel_super_admin');

    // Manager role
    $manager_caps = array();
    $manager_caps['read'] = true;

    $manager_caps['publish_posts'] = true;
    $manager_caps['edit_posts'] = true;
    $manager_caps['delete_posts'] = true;
    $manager_caps['edit_published_posts'] = true;
    $manager_caps['delete_published_posts'] = true;
    $manager_caps['edit_others_posts'] = true;
    $manager_caps['delete_others_posts'] = true;
    $manager_caps['manage_categories'] = true;

    $manager_caps['publish_pages'] = true;
    $manager_caps['edit_pages'] = true;
    $manager_caps['delete_pages'] = true;
    $manager_caps['edit_published_pages'] = true;
    $manager_caps['delete_published_pages'] = true;
    $manager_caps['edit_others_pages'] = true;
    $manager_caps['delete_others_pages'] = true;

    $manager_caps['edit_comment'] = true;
    $manager_caps['moderate_comments'] = true;

    $manager_caps['list_users'] = true;
    $manager_caps['create_users'] = true;
    $manager_caps['edit_users'] = true;
    $manager_caps['delete_users'] = true;
    $manager_caps['add_users'] = true;
    $manager_caps['remove_users'] = true;

    remove_role('manager');
    add_role(
        'manager',
        'Manager',
        $manager_caps
    );

    remove_role('contributor');