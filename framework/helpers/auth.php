<?php
/**
 * All helpers regarding auth
 */

/**
 * Returns true if user is logged, false otherwise
 */
function auth_check()
{
    return isset($_SESSION['user_id']);
}

/**
 * Returns active user
 *
 * @return UserModel
 */
function auth_user()
{
    if (!auth_check()) return null;

    return UserModel::instantiate()->find($_SESSION['user_id']);
}
