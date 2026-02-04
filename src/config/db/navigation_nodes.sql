INSERT INTO `SITE_DB`.`navigation_nodes` (node_name, node_link, navigation_id)
SELECT 'Services', '/janitor/service/list', (SELECT id FROM `SITE_DB`.`navigation` WHERE handle = 'main-janitor')
WHERE '/janitor/service/list' NOT IN (
	SELECT node_link FROM `SITE_DB`.`navigation_nodes`
);