<?php
/**
 * Plugin Name: GauliScore
 * Plugin URI: https://gauli.com/
 * Description: Leaderboard for Learndash
 * Version: 1.0
 * Author: M. Prasodjo
 * Author URI: https://gauli.com/
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt

*/

  require_once dirname( __FILE__ ) . '/lib_gauli_quiz.php';
  require_once dirname( __FILE__ ) . '/lib_gauli_course.php';


//couse
//SELECT * FROM wp_posts WHERE post_type = 'sfwd-courses' AND post_status NOT IN ( 'trash','auto-draft','inherit' );

//leason
//SELECT * FROM wp_posts WHERE post_type = 'sfwd-lessons' AND post_status NOT IN ( 'trash','auto-draft','inherit' );

//quiz
//select * from wp_wp_pro_quiz_master;

//quiz data
//SELECT post_id, meta_key, meta_value FROM wp_postmeta WHERE post_id IN (52) ORDER BY meta_id ASC;



function gaulicourse_shortcode($atts = [], $content = null, $tag = '')
{
    // normalize attribute keys, lowercase
    $atts = array_change_key_case((array)$atts, CASE_LOWER);
 
    // override default attributes with user attributes
    $gauli_atts = shortcode_atts([
                                     'id' => '0',
                                     'limit' => '0',
                                 ], $atts, $tag);
 

    $id=$gauli_atts['id'];
    $limit=$gauli_atts['limit'];
    //print "<br>kambing <br>";
    $coursename=get_course_name("$id");
    print $coursename;
    //print "<br>kambing <br>";

    //print $limit;
    $totalquiz=get_all_quiz("$id","$limit");

    //var_dump($totalquiz);
    print_course_result($coursename,$totalquiz);
}


function gauliquiz_shortcode($atts = [], $content = null, $tag = '')
{
    // normalize attribute keys, lowercase
    $atts = array_change_key_case((array)$atts, CASE_LOWER);
 
    // override default attributes with user attributes
    $gauli_atts = shortcode_atts([
                                     'id' => '0',
                                 ], $atts, $tag);
 

    $id=$gauli_atts['id'];
    $quizname=get_quiz_name("$id");
    //print $quizname;

    $userlist=get_userlist("$id");

    //print_r($userlist);

   print_quiz_result($quizname,$userlist);


  global $wp_query; 
  $postid = $wp_query->post->ID; 
  $data=get_post_meta('52', '_sfwd-quiz', true);
  //var_dump($data);

  //print $data['sfwd-quiz_course'];
  //print $data['sfwd-quiz_passingpercentage'];

}

function gauli_shortcodes_init()
{
    add_shortcode('gauliscore', 'gaulicourse_shortcode');
    add_shortcode('gauliquiz', 'gauliquiz_shortcode');
}

add_action('init', 'gauli_shortcodes_init');
//add_action('init', 'gauliquiz_shortcodes_init');


?>

