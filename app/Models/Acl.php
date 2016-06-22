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

    // JOBMAKER
    const PERMISSION_GROUP_JOBMAKER = 'jobmaker';
    const PERMISSION_JOBMAKER = 'jobmaker';
    const PERMISSION_JOBMAKER_USER = 'jobmaker.user';
}
