<div class="text-ban">

<?php
	if(count($bans['text_ad']) > 0) {
		$current_tad = array_shift($bans['text_ad']);
?>
		<a class="block-text" onclick="ClickCount(<?php echo $current_tad['ID'];?>, 'text')" href="<?php echo json_decode($current_tad['url']); ?>" target="_blank">
			<span class="name-text-ban"> <?php echo $current_tad['head'];?> </span>
			<?php echo $current_tad['body'];?>
		</a>
<?php
	}
?>

<div class="vertical-line block-360"></div>

<?php
	if(count($bans['text_ad']) > 0) {
		$current_tad = array_shift($bans['text_ad']);
?>
		<a class="block-text block-360" onclick="ClickCount(<?php echo $current_tad['ID'];?>, 'text')" href="<?php echo json_decode($current_tad['url']); ?>" target="_blank">
			<span class="name-text-ban"> <?php echo $current_tad['head'];?> </span>
			<?php echo $current_tad['body'];?>
		</a>
<?php
	}
?>

<div class="vertical-line block-768"></div>

<?php
	if(count($bans['text_ad']) > 0) {
		$current_tad = array_shift($bans['text_ad']);
?>
		<a class="block-text block-768" onclick="ClickCount(<?php echo $current_tad['ID'];?>, 'text')" href="<?php echo json_decode($current_tad['url']); ?>" target="_blank">
			<span class="name-text-ban"> <?php echo $current_tad['head'];?> </span>
			<?php echo $current_tad['body'];?>
		</a>
<?php
	}
?>

<div class="vertical-line block-992"></div>

<?php
	if(count($bans['text_ad']) > 0) {
		$current_tad = array_shift($bans['text_ad']);
?>
		<a class="block-text block-992" onclick="ClickCount(<?php echo $current_tad['ID'];?>, 'text')" href="<?php echo json_decode($current_tad['url']); ?>" target="_blank">
			<span class="name-text-ban"> <?php echo $current_tad['head'];?> </span>
			<?php echo $current_tad['body'];?>
		</a>
<?php
	}
?>

</div>