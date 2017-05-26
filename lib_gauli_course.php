<?php

function get_course_name($courseid) {
  global $wpdb;
  $query_course = "SELECT post_title FROM wp_posts WHERE post_type = 'sfwd-courses' AND post_status NOT IN ( 'trash','auto-draft','inherit' ) AND ID='$courseid' LIMIT 1";
  return $wpdb->get_var($query_course);
}

function get_all_quiz($courseid,$limit) {
  global $wpdb;

  //find quiz list first step
  $query="SELECT post_id FROM wp_postmeta WHERE meta_key='course_id' AND meta_value='$courseid' ORDER BY meta_id ASC";
  $list_quiz=$wpdb->get_results($query, OBJECT);

  print "<br>";
  $quiz_pro_id="";
  $control=0;

  foreach($list_quiz as $key) {

    //find quiz list second step
    $query="SELECT post_id, meta_key, meta_value FROM wp_postmeta WHERE post_id IN ($key->post_id) AND meta_key='quiz_pro_id' ORDER BY meta_id ASC;";
    $list_quiz_id=$wpdb->get_results($query, OBJECT);

    foreach($list_quiz_id as $key_quiz) {
     if($key_quiz->meta_value) {

        if($control == '0') {
          $quiz_pro_id=$quiz_pro_id . "quiz_id='$key_quiz->meta_value'";
          $control=1;
        } else {
          $quiz_pro_id=$quiz_pro_id . " OR quiz_id='$key_quiz->meta_value'";
        }
      }
    }
  }


    if($limit=='0') {
      $query_limit = "";
    } else {
      $query_limit = "LIMIT $limit";
    }

    $query="select name, sum(totalpoints) as totalpoints from (SELECT a.name,points as totalpoints from gaulinet.wp_wp_pro_quiz_toplist as a  WHERE  result>='100' AND ($quiz_pro_id) group by quiz_id,name) as b group by name ORDER by totalpoints DESC $query_limit";
    //print $query;
    $total=$wpdb->get_results($query, OBJECT);

  return $total;

}


function print_course_result($coursename,$user_total,$title) {
?>

<div class="entry-content">

<div style="margin-bottom: 30px; margin-top: 10px;" class="wpProQuiz_toplist" data-quiz_id="13">
    <h2><?php print "Top Score of $coursename"; ?>
    <table class="wpProQuiz_toplistTable">
<!--    <caption>maximum of <span class="wpProQuiz_max_points"></span> points</caption> -->
    <thead>
        <tr>
	<th style="width: 40px;">Pos.</th>
	<th style="text-align: left ;">Name</th>
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
foreach ($user_total as $key) { 

  if($strip =='1') {
?>

    <tr style="display: table-row;">
	<td><?php print $pos; ?> </td>
	<td style="text-align: left ;"><?php print "<a href=/members/$key->name>$key->name</a>"; ?></td>
	<td><?php print $key->totalpoints; ?></td>
<?php 
    $strip=0;
  } else {
?>
        </tr><tr style="display: table-row;">
	<td class="wpProQuiz_toplistTrOdd"><?php print $pos;?></td>
	<td style="text-align: left ;" class="wpProQuiz_toplistTrOdd"><?php print $key->name; ?></td>
	<td class="wpProQuiz_toplistTrOdd"><?php print $key->totalpoints; ?></td>
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


?>

