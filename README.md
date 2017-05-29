Learndash custom Leaderboard

A default leaderboard from learndash show all entry made by user. But since i need uniq user show in my leaderboard i write this plugin to for my needed.

Prerequisite : Learndash Plugin.

There is 2 shortcode

    gauliscore shortcode

    [gauliscore id=postid limit=numberoflimit title=titleyouwant]

    id is a post id of course you want to show
    limit is number of record you want to show. if not set then all record will show (from all quiz from course)
    title is something you want to show at top of table

example :

[gauliscore id=12 limit=10 title=’Top 10 Score’]

    gauliquiz shortcode

This shortcode is just like a leaderboard from learndash, but it will remove duplicate entry to show
It will use your leaderboard quiz configuration (sort by, number to displayed).

example :

[gauliquiz id=234 title="Top 10 of Quiz"] 

    id is same like learndash shortcode ld_quiz quiz_id
    title is something you want to show at top of table

How to use : just create a post and use a shortcode

note :
– You need to have Learndash Plugin Installed and Activated
– it just very quick and very dirty solution, code is not optimizing yet
