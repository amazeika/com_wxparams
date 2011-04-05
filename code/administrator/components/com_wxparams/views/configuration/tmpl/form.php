<?
defined( 'KOOWA' ) or die( 'Restricted access' );
?>

<script src="media://lib_koowa/js/koowa.js" />
<script src="media://com_wextend/js/libraries/jquery/jquery.js" />
<script src="media://com_wextend/js/libraries/jquery/ui/jquery-ui.min.js" />

<style src="media://com_wextend/js/libraries/jquery/ui/css/smoothness/jquery-ui.css" />
<style src="media://com_default/css/form.css" />
<style src="media://com_wextend/css/admin.css" />
<style src="media://com_wxparams/css/admin.css" />

<script type="text/javascript">
wxjq(document).ready(function() {
	wxjq('#tabs').tabs();
});
</script>

<form method="post" action="<?=@route( 'id=' . $configuration->id )?>"
	class="adminform" name="adminForm">
<div id="mainform">
<label for="title" class="mainlabel"><?=@text('WXPARAMS_TITLE');?></label>
<input id="title" type="text" name="title" value="<?=@escape($configuration->title);?>" /><br />
<label for="description" class="mainlabel"><?=@text('WXPARAMS_DESCRIPTION');?></label>
<textarea id="description" name="description"><?=@escape($configuration->description);?></textarea><br />
<?
// Render the XML form
echo $form->renderHtml();
?>
</div>
<input type="hidden" name="package" value="<?=$package;?>"/>
</form>