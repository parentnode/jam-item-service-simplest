<?php
global $module_group_id;
global $module_id;

$module = module()->getModule($module_group_id, $module_id);
?>
<div class="scene module i:module service i:service">
	<h1>Itemtype Service</h1>
	<h2>Configuration</h2>

	<?= HTML()->renderSnippet("snippets/modules/actions-back.php") ?>

	<h3>Module description</h3>
	<?= HTML()->renderSnippet("snippets/modules/panel-info.php", [
		"module" => $module,
	]) ?>


	<p>The simplest service item does not have any additional settings.</p>


	<?= HTML()->renderSnippet("snippets/modules/panel-version.php", [
		"module" => $module,
	]) ?>
	<?= HTML()->renderSnippet("snippets/modules/panel-upgrade.php", [
		"module" => $module,
	]) ?>
	<?= $HTML->renderSnippet("snippets/modules/panel-uninstall.php",  [
		"module" => $module,
	]) ?>

</div>