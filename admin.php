<?php

/**
 * All The adminstrative functions such as member count, member deletion and member data/authorization will be displayed here.
 *
 * @version    PHP 8.0.12 
 * @since      July 2022
 * @author     AtharvaShah
 */

error_reporting(E_ERROR | E_PARSE);
if (!isset($_GET['letmein'])) {
  echo ("<img src='images/website/imposter.jpg' style='width: 100%; height: 100%;'>");
  die();
}

require "connection.php";
require "functions.php";

// executes the query and returns the first row of the result set. 
function executeSQL($con, $sql)
{
  if ($query = mysqli_query($con, $sql)) {
    $row = mysqli_fetch_array($query);
    return $row[0];
  } else {
    echo mysqli_error($con);
  }
}

/*************
  TOTAL MEDIA COUNT (SUM OF ALL USERS)
 *************/
$sql = "SELECT sum(allcount) AS Total_Count FROM(
    (SELECT count(`videogame`) as allcount FROM `data` WHERE videogame!='')
    UNION ALL
    (SELECT count(album) AS allcount FROM `data` WHERE album!='')
    UNION ALL
    (SELECT count(book) AS allcount FROM `data` WHERE book!='')
    UNION ALL
    (SELECT count(movie) AS allcount FROM `data` WHERE movie!='')
    UNION ALL
    (SELECT count(tv) AS allcount FROM `data` WHERE tv!='')
)t";

$total_media_count = executeSQL($con, $sql);

/*************
  TOTAL CURRENT ACTIVE USERS ON SITE
 *************/
$sql = "SELECT count(`user_name`) FROM `users` where `active`=1";
$current_active_users = executeSQL($con, $sql);

/*************
  TOTAL USERS COUNT (TOTAL REGISTERED USERS)
 *************/

$sql = "SELECT count(`user_name`) FROM `users`";
$total_users_count = executeSQL($con, $sql);

/*************
  TOTAL BOOKS COUNT (SUM OF ALL USERS)
 *************/
$sql = "SELECT count(`book`) FROM `data` where `book`!=''";
$total_book_count = executeSQL($con, $sql);

/*************
  TOTAL MOVIE COUNT (SUM OF ALL USERS)
 *************/
$sql = "SELECT count(`movie`) FROM `data` where `movie`!=''";
$total_movie_count = executeSQL($con, $sql);

/*************
  TOTAL TV COUNT (SUM OF ALL USERS)
 *************/
$sql = "SELECT count(`tv`) FROM `data` where `tv`!=''";
$total_tv_count = executeSQL($con, $sql);

/*************
  TOTAL VIDEOGAME COUNT (SUM OF ALL USERS)
 *************/
$sql = "SELECT count(`videogame`) FROM `data` where `videogame`!=''";
$total_videogame_count = executeSQL($con, $sql);

/*************
  TOTAL ALBUM COUNT (SUM OF ALL USERS)
 *************/
$sql = "SELECT count(`album`) FROM `data` where `album`!=''";
$total_album_count = executeSQL($con, $sql);


/*************
  TOP 50 MOST LOGGED BOOKS -> ACROSS ALL USERS
 *************/
$sql = "SELECT book, count(book) FROM `data` where book!='' GROUP BY book HAVING count(book)>1 ORDER BY count(book) DESC LIMIT 50";

$top_50_books = executeSQL($con, $sql);


/*************
  TOP 50 MOST LOGGED ALBUMS -> ACROSS ALL USERS
 *************/
$sql = "SELECT album, count(album) FROM `data` where album!='' GROUP BY album HAVING count(album)>1 ORDER BY count(album) DESC LIMIT 50";

$top_50_albums = executeSQL($con, $sql);


/*************
  TOP 50 MOST LOGGED TV SHOWS -> ACROSS ALL USERS
 *************/
$sql = "SELECT tv, count(tv) FROM `data` where tv!='' GROUP BY tv HAVING count(tv)>1 ORDER BY count(tv) DESC LIMIT 50";

$top_50_tvs = executeSQL($con, $sql);


/*************
  TOP 50 MOST LOGGED VIDEOGAMES -> ACROSS ALL USERS
 *************/
$sql = "SELECT videogame, count(videogame) FROM `data` where videogame!='' GROUP BY videogame HAVING count(videogame)>1 ORDER BY count(videogame) DESC LIMIT 50";

$top_50_videogames = executeSQL($con, $sql);

/*************
  TOP 50 MOST LOGGED MOVIES -> ACROSS ALL USERS
 *************/
$sql = "SELECT movie, count(movie) FROM `data` where movie!='' GROUP BY movie HAVING count(movie)>1 ORDER BY count(movie) DESC LIMIT 50";

$top_50_movies = executeSQL($con, $sql);


/*************
  GET TOP 50 MOST POPULAR USERS (USERS WITH MOST FOLLOWERS)
 *************/

$sql = "SELECT followed_username as popular_users, COUNT(*) AS follower_count 
FROM social
GROUP BY followed_username ORDER BY follower_count desc limit 50";
$popular_users = executeSQL($con, $sql);


/*************
 GET USERS WHO ARE NOT VERIFIED (CHECK `USERS` TABLE)
 *************/

$sql = "SELECT COUNT(`user_name`) FROM users where verified =0";
$not_verified = executeSQL($con, $sql);


/*************
  GET USERS WHO HAVE NOT LOGGED ANY MEDIA IN THE LAST 6 MONTHS
 *************/



/*************
  GET USERS WHO HAVE LOGGED MORE THAN 1000 MEDIA ITEMS (THIS CAN BE EXTENDED LATER TO CHECK FOR SPAMMING)
 *************/



/*************
  TOTAL MEDIA ADDED LAST 3 MONTHS (ACROSS ALL USERS)
 *************/



/*************
  TOTAL MEDIA ADDED LAST 6 MONTHS
 *************/



/*************
  TOTAL MEDIA ADDED LAST YEAR
 *************/



/*************
  AVERAGE MEDIA ADDED PER DAY (ACROSS ALL USERS) -> USEFUL TO DETERMINE RATE AT WHICH DB SIZE IS INCREASING
 *************/


?>

<!-- *******************
       HTML STUFF
******************* -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title>WYDRN - Admin Dashboard</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <link rel="stylesheet" href="CSS/admin.css">
</head>

<body>

  <div class="table-wrapper">
    <table class="fl-table">
      <thead>
        <tr>
          <th colspan="2" class="heading2">Admin</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>TOTAL MEDIA ADDED BY ALL USERS</td>
          <td><?php echo ($total_media_count) ?></td>
        </tr>
        
        <tr>
          <td> CURRENT ACTIVE USERS ON SITE </td>
          <td> <?php echo ($current_active_users) ?> </td>
        </tr>   

        <tr>
          <td> TOTAL USERS COUNT </td>
          <td> <?php echo "$total_users_count" ?> </td>
        </tr>

        <tr>
          <td> TOTAL BOOKS ADDED BY ALL USERS </td>
          <td> <?php echo "$total_book_count" ?> </td>
        </tr>

        <tr>
          <td> TOTAL MOVIES ADDED BY ALL USERS </td>
          <td> <?php echo "$total_movie_count" ?> </td>
        </tr>

        <tr>
          <td> TOTAL TVS ADDED BY ALL USERS </td>
          <td> <?php echo "$total_tv_count" ?> </td>
        </tr>

        <tr>
          <td> TOTAL VIDEOGAMES ADDED BY ALL USERS </td>
          <td> <?php echo "$total_videogame_count" ?> </td>
        </tr>

        <tr>
          <td> TOTAL ALBUMS ADDED BY ALL USERS </td>
          <td> <?php echo "$total_album_count" ?> </td>
        </tr>

        <tr>
          <td> TOP 50 MOST LOGGED BOOKS </td>
          <td> <?php echo "$top_50_books" ?> </td>
        </tr>

        <tr>
          <td> TOP 50 MOST LOGGED ALBUMS </td>
          <td> <?php echo "$top_50_albums"; ?> </td>
        </tr>

        <tr>
          <td> TOP 50 MOST LOGGED TV SHOWS </td>
          <td> <?php echo "$top_50_tvs"; ?> </td>
        </tr>

        <tr>
          <td> TOP 50 MOST LOGGED VIDEOGAMES </td>
          <td> <?php echo "$top_50_videogames"; ?> </td>
        </tr>

        <tr>
          <td> TOP 50 MOST LOGGED MOVIES </td>
          <td>  <?php echo "$top_50_movies"; ?> </td>
        </tr>

        <tr>
          <td> TOP 50 MOST POPULAR USERS (USERS WITH MOST FOLLOWERS) </td>
          <td> <?php echo "$popular_users"; ?> </td>
        </tr>

        <tr>
          <td> COUNT OF USERS WHO ARE NOT VERIFIED </td>
          <td> <?php echo $not_verified; ?> </td>
        </tr>

        <tr>
          <td> USERS WHO HAVE NOT LOGGED ANY MEDIA IN THE LAST 6 MONTHS </td>
          <td> <?php ?> </td>
        </tr>

        <tr>
          <td> USERS WHO HAVE LOGGED MORE THAN 1000 MEDIA ITEMS </td>
          <td> <?php ?> </td>
        </tr>
        
        <tr>
          <td> TOTAL MEDIA ADDED LAST 3 MONTHS </td>
          <td> <?php ?> </td>
        </tr>
        
        <tr>
          <td> TOTAL MEDIA ADDED LAST 6 MONTHS </td>
          <td> <?php ?> </td>
        </tr>
        
        <tr>
          <td> TOTAL MEDIA ADDED LAST YEAR </td>
          <td> <?php ?> </td>
        </tr>
        
        <tr>
          <td> AVERAGE MEDIA ADDED PER DAY (ACROSS ALL USERS) </td>
          <td> <?php ?> </td>
        </tr>
        
      </tbody>
    </table>
  </div>

</body>

</html>