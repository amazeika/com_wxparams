<?php
defined( 'KOOWA' ) or die( 'Restricted access' );
?>

<?=@helper( 'behavior.tooltip' );?>
<?=@helper( 'behavior.modal' );?>
<style src="media://com_default/css/admin.css" />
<style src="media://com_wxparams/css/admin.css" />
<script src="media://lib_koowa/js/koowa.js" />

<table class="adminlist" style="clear: both;">
	<form action="<?=@route();?>" method="get" name="adminForm">
	<thead>
		<input type="hidden" name="boxchecked" value="0" />
		<tr>
			<td colspan="2">
		<?=@text( 'FILTERS' );?>
		</td>
			<td colspan="2"></td>
			<td>
		<?=@template( 'admin::com.default.view.list.search_form' );?>
		</td>
			<td>
		<?=@helper( 'admin::com.wxparams.template.helper.adapter.listbox.' . strtolower( WxFactory::getAdapter() ) . '.packages', array ('name'=>'package', 'attribs' => array ('onchange' => 'this.form.submit()' ) ) );?>
		</td>
		</tr>
		<tr>
			<th width="5"><?=@text( 'Num' );?></th>
			<th width="20"><input type="checkbox" name="toggle" value=""
				onclick="checkAll(<?=count( $configurations );?>);" /></th>
			<th width="5">
				<?=@helper( 'grid.sort', array ('column' => 'id', 'title' => @text( 'WXPARAMS_ID' ) ) );?>
			</th>
			<th width="5">
				<?=@helper( 'grid.sort', array ('column' => 'item_id', 'title' => @text( 'WXPARAMS_MENU_ITEM' ) ) );?>
			<th>
				<?=@helper( 'grid.sort', array ('column' => 'title', 'title' => @text( 'WXPARAMS_TITLE' ) ) );?>
			</th>
			<th>
				<?=@helper( 'grid.sort', array ('column' => 'package', 'title' => @text( 'WXPARAMS_PACKAGE' ) ) );?>
			</th>
			<th>
				<?=@helper( 'grid.sort', array ('column' => 'default', 'title' => @text( 'WXPARAMS_DEFAULT' ) ) );?>
			</th>
		</tr>
	</thead>
	<tbody>
	<?
	$i = 0;
	?>
	<?
	foreach ( $configurations as $configuration ) {
		?>
		<tr>
			<td align="center">
				<?=$i + 1;?>
			</td>
			<td align="center">
				<?=@helper( 'admin::com.wextend.template.helper.grid.checkbox', array ('row' => $configuration ) );?>
			</td>
			<td align="center">
				<?=$configuration->id;?>
			</td>
			<td align="center">
				<?=$configuration->item_id;?>
			</td>
			<td align="center">
				<?=$configuration->title;?>
			</td>
			<td align="center">
				<?=$configuration->package;?>
			</td>
			<td align="center">
				<?=@helper( 'admin::com.wextend.template.helper.grid.defaultable', array ('row' => $configuration ) );?>
			</td>
		</tr>
	<?
		$i ++;
	
	}
	
	if (! count( $configurations )) {
		?>
		<tr>
			<td colspan="7" align="center">
				<?=@text( 'WXPARAMS_NO_ITEMS_FOUND' );?>
			</td>
		</tr>
	<?
	}
	?>	
	</tbody>
	<tfoot>
		<tr>
			<td colspan="7">
			<?=@helper( 'paginator.pagination', array ('total' => $total ) );?></td>
		</tr>
	</tfoot>
	</form>
</table>