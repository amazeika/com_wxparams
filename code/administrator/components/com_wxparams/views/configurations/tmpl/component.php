<?php

defined( 'KOOWA' ) or die( 'Restricted access' );

?>

<style src="base://templates/khepri/css/icon.css" />
<style src="base://templates/khepri/css/rounded.css" />
<script src="media://com_wextend/js/libraries/jquery/jquery.js" />

<div id="toolbar-box">
<div class="t">
<div class="t">
<div class="t"></div>
</div>
</div>
<div class="m">
<?
// Display the toolbar
echo $toolbar->render();
echo $toolbar->renderTitle();
?>
				<div class="clr"></div>
</div>
<div class="b">
<div class="b">
<div class="b"></div>
</div>
</div>
</div>

<?

// Render the default template
echo @template( 'default' );

?>

<script type="text/javascript">
wxjq(document).ready(function() {
	var form = wxjq('form[name="adminForm"]');
	// Make sure that tmpl is always component when displaying this template
	form.append('<input type="hidden" name="tmpl" value="component" />');
});
</script>