<?php
/**
 * Block Name: Here's an idea
 *
 * This is the template that displays the testimonial block.
 */

// create id attribute for specific styling
$id = 'red_ppb_idea-' . $block['id'];
$idSelector = '#' . $id;

// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : '';

?>
<div id="<?php echo $id; ?>" class="red-ppb-idea <?php echo $align_class; ?>">
	<?php
	echo '<h2>' . $block['title'] . '</h2>';
	the_field('content'); ?>
</div>
<style type="text/css">
	<?php echo $idSelector; ?> {
        padding: 1em;
		color: #000000;
	}
    <?php echo $idSelector; ?> p {
        margin: 0;
    }
</style>