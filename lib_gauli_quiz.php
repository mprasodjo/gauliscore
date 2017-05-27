<?php


Class Gauli_Learndash_Get_Quiz {


function print_quiz_result($quizname,$userlist,$title) {
?>

<div class="entry-content">

<div style="margin-bottom: 30px; margin-top: 10px;" class="wpProQuiz_toplist" data-quiz_id="13">
	<h2> <?php print "$quizname"; ?>
	<table class="wpProQuiz_toplistTable">
	<!-- <caption>maximum of <span class="wpProQuiz_max_points">10</span> points</caption> -->
	<thead>
	    <tr>
		<th style="width: 40px;">Pos.</th>
		<th style="text-align: left ;">Name</th>
		<th style="width: 140px;">Entered on</th>
		<th style="width: 60px;">Points</th>
	    </tr>
	</thead>
	<tbody>
	    <tr style="display: none;">
		<td colspan="5">Table is loading</td>
	    </tr>
	    <tr style="display: none;">
		<td colspan="5">No data available</td>
	    </tr>
	    <tr style="display: none;">
		<td></td>
		<td style="text-align: left ;"></td>
		<td style=" color: rgb(124, 124, 124); font-size: x-small;"></td>
		<td></td>
	    </tr>


<?php 
$pos=1;
$strip=1;
foreach ($userlist as $key) { 

  if($strip=='1') {
?>

	<tr style="display: table-row;">
		<td><?php print $pos; ?></td>
		<td style="text-align: left ;"><?php print "$key->name"; ?></td>
		<td style=" color: rgb(124, 124, 124); font-size: x-small;"><?php $dt = new DateTime("@$key->date"); print $dt->format('Y-m-d H:i:s');?></td>
		<td><?php print $key->points; ?></td>
<?php 
    $strip=0;
  } else {
?>
	    </tr><tr style="display: table-row;">
		<td class="wpProQuiz_toplistTrOdd"><?php print $pos; ?></td>
		<td style="text-align: left ;" class="wpProQuiz_toplistTrOdd"><?php print $key->name; ?></td>
		<td style=" color: rgb(124, 124, 124); font-size: x-small;" class="wpProQuiz_toplistTrOdd"><?php $dt = new DateTime("@$key->date"); print $dt->format('Y-m-d H:i:s');?></td>
		<td class="wpProQuiz_toplistTrOdd"><?php print $key->points; ?></td>
	    </tr>
<?php 
    $strip=1;
  }
  $pos++;
} 
?>
</tbody>
    </table>
</div>
<?php
}

function gauli_shortcode($atts = [], $content = null, $tag = '')
{


    // normalize attribute keys, lowercase
    $atts = array_change_key_case((array)$atts, CASE_LOWER);
 
    // override default attributes with user attributes
    $gauli_atts = shortcode_atts([
                                     'id' => 'onta',
                                 ], $atts, $tag);
 

    $id=$gauli_atts['id'];
    //print "<br>kambing <br>";
    $coursename=get_course_name("$id");
    print $coursename;
    //print "<br>kambing <br>";

}

function get_quiz_name($id) {
  global $wpdb;
  $query = "SELECT name FROM wp_wp_pro_quiz_master WHERE id='$id' limit 1";
  return $wpdb->get_var($query);
}

function get_userlist($quizid) {
  global $wpdb;

  $query="select toplist_data from wp_wp_pro_quiz_master where id='$quizid' limit 1";
  $toplistDataShowLimit = $wpdb->get_results($query, OBJECT);

  foreach ($toplistDataShowLimit as $key) {
    $toplist_data=unserialize($key->toplist_data);
  }

  $toplistDataSort = $toplist_data['toplistDataSort'];
  $toplistDataShowIn = $toplist_data['toplistDataShowIn'];
  $toplistDataShowLimit= $toplist_data['toplistDataShowLimit'];

  if($toplistDataSort == '1') { // best user
    $sort_user = "ORDER by result ASC, date ASC";
  } elseif ($toplistDataSort == '2') { // newest entry
    $sort_user = "ORDER by date DESC";
  } elseif ($toplistDataSort == '3') {  // oldest entry
    $sort_user = "ORDER by date ASC";
  } else {
    $sort_user = "ORDER by result DESC";
  }

  if($toplistDataShowLimit > 0) {
    $limit_user = "LIMIT $toplistDataShowLimit";
  } else {
    $limit_user = "";
  }

  $query="SELECT post_id, meta_key, meta_value FROM wp_postmeta WHERE meta_key='quiz_pro_id' and meta_value='6' ORDER BY meta_id ASC";
  $postid=$wpdb->get_var($query);

  $query="SELECT meta_value FROM wp_postmeta WHERE post_id IN ($postid) AND meta_key='_sfwd-quiz' ORDER BY meta_id ASC;";
  $quiz_data_meta=$wpdb->get_var($query);

  $quiz_data=unserialize($quiz_data_meta);

  $min_result = $quiz_data['sfwd-quiz_passingpercentage'];

  $query="SELECT DISTINCT user_id,name,points,date FROM wp_wp_pro_quiz_toplist WHERE quiz_id='$quizid' AND result>=$min_result GROUP by name $sort_user $limit_user";
  //print $query;
  $userlist = $wpdb->get_results($query, OBJECT);

  return $userlist;
}

}

?>

