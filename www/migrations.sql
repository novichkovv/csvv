CREATE DATABASE mysite;
USE mysite;
CREATE TABLE `users` (
   `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
   `user_group_id` bigint(20) unsigned NOT NULL,
   `email` varchar(255) NOT NULL,
   `user_name` VARCHAR(255) NULL,
   `user_surname` VARCHAR(255) NULL,
   `user_password` varchar(255) NOT NULL,
   `create_date` datetime NOT NULL,
   PRIMARY KEY (`id`),
   UNIQUE KEY `id` (`id`)
 ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

 CREATE TABLE `system_routes` (
   `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
   `route` varchar(255) NOT NULL,
   `title` varchar(255) NOT NULL,
   `position` int(11) NOT NULL,
   `hidden` tinyint(4) NOT NULL,
   `permitted` tinyint(4) NOT NULL,
   `extenal` tinyint(4) NOT NULL,
   `parent` bigint(20) unsigned NOT NULL,
   `icon` varchar(255) NOT NULL,
   PRIMARY KEY (`id`),
   UNIQUE KEY `id` (`id`)
 ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

 CREATE TABLE `system_routes_user_groups_relations` (
   `system_route_id` bigint(20) unsigned NOT NULL,
   `user_group_id` bigint(20) unsigned NOT NULL
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

 CREATE TABLE `user_groups` (
   `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
   `group_name` varchar(255) NOT NULL,
   `create_date` datetime NOT NULL,
   PRIMARY KEY (`id`),
   UNIQUE KEY `id` (`id`)
 ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

 INSERT INTO `users` (`user_group_id`, `email`, `user_password`, `create_date`) VALUES ('1', 'admin', 'c4ca4238a0b923820dcc509a6f75849b', '2016-06-22');
INSERT INTO `system_routes` (`route`, `title`, `position`, `icon`) VALUES ('', 'Users', '4', 'icon-users');
INSERT INTO `system_routes` (`route`, `title`, `position`, `hidden`, `permitted`, `extenal`, `parent`, `icon`) VALUES ('users', 'Users List', '5', '0', '0', '0', '1', 'icon-user');
INSERT INTO `system_routes` (`route`, `title`, `position`, `hidden`, `permitted`, `extenal`, `parent`, `icon`) VALUES ('users/add', 'Users Add', '6', '0', '0', '0', '1', 'icon-user-follow');
INSERT INTO `system_routes` (`route`, `title`, `position`, `hidden`, `permitted`, `extenal`, `parent`, `icon`) VALUES ('users/groups', 'User Groups', '7', '0', '0', '0', '1', 'icon-users');
INSERT INTO `system_routes` (`route`, `title`, `position`, `hidden`, `permitted`, `extenal`, `parent`, `icon`) VALUES ('users/add_group', 'Add Group', '8', '0', '0', '0', '1', 'icon-users');
INSERT INTO `system_routes` (`route`, `title`, `position`, `hidden`, `permitted`, `extenal`, `parent`, `icon`) VALUES ('users/permissions', 'Users Permissions', '9', '0', '0', '0', '1', ' icon-close');

INSERT INTO `user_groups` (`group_name`, `create_date`) VALUES ('admin', '2016-06-22');
INSERT INTO system_routes_user_groups_relations SET system_route_id = '1', user_group_id = '1';
INSERT INTO system_routes_user_groups_relations SET system_route_id = '2', user_group_id = '1';
INSERT INTO system_routes_user_groups_relations SET system_route_id = '3', user_group_id = '1';
INSERT INTO system_routes_user_groups_relations SET system_route_id = '4', user_group_id = '1';
INSERT INTO system_routes_user_groups_relations SET system_route_id = '5', user_group_id = '1';
INSERT INTO system_routes_user_groups_relations SET system_route_id = '6', user_group_id = '1';
INSERT INTO `system_routes` (`title`, `position`, `icon`) VALUES ('Dashboard', '1', 'icon-home');


