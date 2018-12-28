<?php

use components\Enum\Forum\ForumPermission;

return [
	"conf_access_deny"		=> "����������� �� �������",
	"topic_access_deny"		=> "���� �� �������",
	"topic_not_main"		=> "���� �� �������",
	"topic_deleted"		    => "���� ������� � ������, ���� � �� ����������",

    'permissions_forum' => [
        ForumPermission::FORUM_MODERATOR            => '���� �������������',
        ForumPermission::CAN_POST_DELETE            => '�������� �����',
        ForumPermission::CAN_POST_DELETE_HARD       => '�������� ����� �� ����',
        ForumPermission::CAN_POST_RESTORE           => '�������������� �����',
        ForumPermission::CAN_EDIT_POST              => '�������������� �����',
        ForumPermission::CAN_TOP_CLOSE              => '�������� ����',
        ForumPermission::CAN_TOP_OPEN               => '�������� ����',
        ForumPermission::CAN_TOP_DELETE             => '�������� ����',
        ForumPermission::CAN_TOP_DELETE_HARD        => '�������� ���� �� ���� ',
        ForumPermission::CAN_TOP_RESTORE            => '�������������� ����',
        ForumPermission::CAN_TOP_MOVE               => '������� ����',
        ForumPermission::CAN_TOP_DELETE_POSTS       => '�������� ���� ������ � ����',
        ForumPermission::CAN_COMMENT_WRITE          => '������ �����������',
        ForumPermission::CAN_COMMENT_DELETE         => '������� �����������',
        ForumPermission::CAN_TOP_FIX                => '����������� ���',
        ForumPermission::CAN_TOP_UNFIX              => '���������� ���',

        ForumPermission::CAN_SEE_DELETED_TOP        => '�������� ��������� �����',
        ForumPermission::CAN_SEE_DELETED_POST       => '�������� ��������� ������',
        ForumPermission::CAN_EDIT_POST              => '�������������� ������',
        ForumPermission::CAN_SEE_WHO_MODERATOR      => '�������� ���� ����������',
        ForumPermission::CAN_SEE_INVISIBLE_AUTHOR   => '�������� ������ ��� ����������',
        ForumPermission::CAN_BE_INVISIBLE           => '������ ������� �� ����� ���������',
        ForumPermission::CAN_MANAGE_APPEAL          => '������� �����',
        ForumPermission::CAN_MANAGE_CATEGORY        => '���������� ����������� ������',
    ],
];
