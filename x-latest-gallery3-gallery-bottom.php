<?
	widget_css();
$_bo_table = $widget_config['forum1'];
$_no_of_posts = $widget_config['default_no_of_posts'];
if ( empty($_bo_table) ) $_bo_table = $widget_config['default_forum_id'];

$list = g::posts( array(
			"bo_table" 	=>	$_bo_table,
			"select"	=>	"idx,domain,bo_table,wr_id,wr_parent,wr_is_comment,wr_comment,ca_name,wr_datetime,wr_hit,wr_good,wr_nogood,wr_name,mb_id,wr_subject,wr_content"
				)
		);	
?>

<div class='latest-bottom-gallery'>
	
	<?		
	if ( $list ) {
		$gallery_info = array( array('bottom-left','bottom-middle','bottom-right'),array(318, 211, 318), array(213, 167, 213));
	for ($i = 0; $i<=2; $i++ ) {
		$_wr_id = $list[$i]['wr_id'];
		$imgsrc = x::post_thumbnail($_bo_table, $_wr_id, $gallery_info[1][$i], $gallery_info[2][$i]);
		$img = $imgsrc['src'];
		if ( empty($img) ) {
			$_wr_content = db::result("SELECT wr_content FROM $g5[write_prefix]$_bo_table WHERE wr_id='$_wr_id'");
			$image_from_tag = g::thumbnail_from_image_tag( $_wr_content, $_bo_table, $gallery_info[1][$i], $gallery_info[2][$i] );
			if ( empty($image_from_tag) ) $img = g::thumbnail_from_image_tag("<img src='".x::url()."/widget/$widget_config[name]/img/no-image.png'/>", $_bo_table, $gallery_info[1][$i], $gallery_info[2][$i]);
			else $img = $image_from_tag;
		}
		echo latest_bottom_gallery($gallery_info[0][$i],$img,$list,$i);
	} 
		echo "<div style='clear: left'></div>";
	} else {
		echo "
				<div>
					<img src='".x::url()."/widget/$widget_config[name]/img/no_image_banner.png' />
				</div>
			";
	}	
	?>
	
	
<? function latest_bottom_gallery( $name, $img, $list, $i ) { ?>
	<div class='<?=$name?>'>
				<? if ( $list ) {
						$url = $list[$i]['url'];
						$subject = cut_str($list[$i]['wr_subject'],10);
						$content = cut_str($list[$i]['wr_content'], 20);
				}
				else {
					$url = "javascript:void(0);";
					$subject = "회원님께서는 현재";
					$content = "필고 갤러리 테마 No.3를 선택 하셨습니다.";
				}
				?>
		<div class='inner'>
			<a href="<?=$url?>" ><img src="<?=$img?>"/></a>
			<div class='<?=$name?>-container'>
				<div class='<?=$name?>-subject'><a href="<?=$url?>" ><?=$subject?></a></div>
				<div class='<?=$name?>-content'><a href="<?=$url?>" ><?=$content?></a></div>
			</div>
		</div>
		<a href='<?=$url?>' class='read_more'></a>
	</div>
<?}?>
</div>
<?if ( preg_match('/msie 7/i', $_SERVER['HTTP_USER_AGENT'] ) ) {?>
<style>
	.bottom-left img, .bottom-middle img, .bottom-right img {
		width:auto;
	}
</style>
<?}?>
