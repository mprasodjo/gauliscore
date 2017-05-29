/**
 * Plugin Name: GauliScore
 * Description: Custom Leaderboard for Learndash
 * Version: 1.0
 * Author: M. Prasodjo
 * Author URI: https://gauli.com/
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt

*/


Learndash custom Leaderboard

there is 2 shortcode

    [gauliscore id=postid limit=numberoflimit]

the id is a post id limit is number of record you want to show, not empty than all record this shortcode will make summary of total point user have in course (from all quiz)

    [gauliquiz id=postid] the id is same like learndash shortcode ld_quiz quiz_id this shortcode will make a summary of leaderboard and using your leaderboard quiz configuration (sort by, number to displayed), but will remove duplicate entry that show in learndash leaderboard.

how to use : just create a post and use a shortcode example [gauliquiz id=13] [gauliquiz id=1234]

note : 
- You need to have Learndash Plugin Installed and Activated
- it just very quick and very dirty solution, code is not optimizing yet

