<?php
/**
 * @version 1.0 $Id$
 * @package com_wxparams
 * @copyright Copyright (C) 2011 Arunas Mazeika. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v3+ (GNU GPLv3) <http://www.gnu.org/licenses/gpl.html>
 * @link http://www.wextend.com
 */

defined('KOOWA') or die('Restricted access');
?>

<?=@helper('behavior.tooltip');?>
<?=@helper('behavior.modal');?>
<style src="media://lib_koowa/css/koowa.css" />
<style src="media://com_wxparams/css/wxparams.css" />
<style src="media://com_wextend/css/wextend.css" />


<script src="media://lib_koowa/js/koowa.js" />

<style src="base://templates/khepri/css/icon.css" />

<?=@helper('com://admin/default.template.helper.toolbar.render',array('toolbar'=>$this->getView()->getToolbar()));?>
<?=@helper('com://admin/default.template.helper.toolbar.title',array('toolbar'=>$this->getView()->getToolbar()));?>

<form action="<?=@route();?>" method="get" class="-koowa-grid">
<table class="adminlist" style="clear: both;">
	<thead>
		<tr>
			<td colspan="2">
		<?=@text('FILTERS');?>
		</td>
			<td colspan="3"></td>

			<td>
		</td>
		</tr>
		<tr>
			<th width="5"><?=@text('Num');?></th>
			<th width="20">
				<?=@helper('grid.checkall');?>
			</th>
			<th width="5">
				<?=@helper('grid.sort', array('column' => 'id', 'title' => @text('WXPARAMS_ID')));?>
			</th>
			<th>
				<?=@helper('grid.sort', array('column' => 'item_id', 'title' => @text('WXPARAMS_MENU_ITEM')));?>
			<th>
				<?=@helper('grid.sort', array('column' => 'title', 'title' => @text('WXPARAMS_TITLE')));?>
			</th>
			<th>
				<?=@text('WXPARAMS_DESCRIPTION');?>
			</th>
			<th>
				<?=@helper('grid.sort', array('column' => 'package', 'title' => @text('WXPARAMS_PACKAGE')));?>
			</th>
			<th width="5">
				<?=@text('WXPARAMS_ACTIONS');?>
			</th>
		</tr>
	</thead>
	<tbody>
	<?
	$i = 0;
	foreach($configurations as $configuration) {
		?>
		<tr>
			<td align="center">
				<?=$i + 1;?>
			</td>
			<td align="center">
				<?=@helper('grid.checkbox', array('row' => $configuration));?>
			</td>
			<td align="center">
				<?=@escape($configuration->id);?>
			</td>
			<td align="center">
				<?=@helper('com://admin/wxparams.template.helper.grid.itemid', array('row'=>$configuration));?>
			</td>
			<td align="center">
				<?=@escape($configuration->title);?>
			</td>
			<td align="center">
				<?=@escape($configuration->description);?>
			</td>
			<td align="center">
				<?=@escape($configuration->package);?>
			</td>
			<td align="center">
			<?=@helper('com://admin/wextend.template.helper.grid.actions', array('actions' => array('edit','defaultable'), 'row' => $configuration));?>
			</td>
		</tr>
	<?
		$i++;
	
	}
	
	if(!count($configurations)) {
		?>
		<tr>
			<td colspan="8" align="center">
				<?=@text('WXPARAMS_NO_ITEMS_FOUND');?>
			</td>
		</tr>
	<?
	}
	?>	
	</tbody>
	<tfoot>
		<tr>
			<td colspan="8">
			<?=@helper('paginator.pagination', array('total' => $total));?></td>
		</tr>
	</tfoot>
</table>
</form>