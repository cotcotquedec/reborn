<?php namespace Models;


class Acl extends \FrenchFrogs\Acl\Acl
{

    // PERMISSION


    // ADMIN
    const PERMISSION_GROUP_ADMIN = 'admin';
    const PERMISSION_ADMIN = 'admin';
    const PERMISSION_USER = 'admin.user';
    const PERMISSION_SCHEDULE = 'admin.schedule';
    const PERMISSION_REFERENCE = 'admin.reference';


    // FILE
    const PERMISSION_GROUP_FILE = 'file';
    const PERMISSION_FILE = 'file';
    const PERMISSION_FILE_UPLOAD = 'file.upload';
    const PERMISSION_FILE_SORT = 'file.sort';
}
