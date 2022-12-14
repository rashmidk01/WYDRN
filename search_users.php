<?php

/**
 * USERS CAN SEARCH FOR OTHER USERS BY USERNAME AND VISIT THEIR PROFILE.
 *
 * @version    PHP 8.0.12 
 * @since      May 2022
 * @author     AtharvaShah
 */


session_start();
if (empty($_SESSION)) {
    header("Location: login.php");
}

require "header.php";

?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title> WYDRN - Search Users</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <link rel="stylesheet" href="CSS/search_users.css">

    <!--JQUERY-->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
</head>


<body>

<!--title-->
<div class="heading">
  <h1>Search Users<span>Find friendlies with the best tastes.</span></h1>
</div>

<!----------------------------
        FLEX COLUMNS
------------------------------->
<div class="columns">
    
    <!----------------------------
        Top 10 Most Followed users
    ------------------------------->
    <div class="column" id="most-followed-div">
        
        <div class='most-followed-header-div'>
            <h2> Top 10 <p>Most Followed Users</p></h2> 
        </div>
        
        <div class='most-followed-items'>  
            <?php
            // Get the top 10 most followed users.
            $sql="SELECT `followed_username` as `user_name`, COUNT(*) as `follower_count` from social GROUP BY `followed_username` ORDER BY `follower_count` desc  limit 8";
            $query = mysqli_query($con, $sql);
            if (mysqli_num_rows($query) > 0) {
                for ($i = 1; $i <9; $i++) {
                    $row[$i] = mysqli_fetch_array($query);
                    $username = $row[$i]['user_name'];
                    $follower_count = $row[$i]['follower_count'];
            ?>
                        <!-- HTML PART -->
                        <a href=<?php echo "profile.php?user_name=".$username; ?>> 
                            <div class='most-followed-person'>
                                <big class='most-followed-username'><?php echo $username?></big>
                                <br>
                                <small class='most-followed-follower-count'><?php echo $follower_count; ?> Followers</small>
                            </div>
                        </a>
                        
            <?php
                }
            }
            ?>
        </div>
    </div>
   


    <!----------------------------
       Search Box
    ------------------------------->


    <div class="column" id='search-div'>
            <center>
            <input type="text" id="search" placeholder="Search for users" autocomplete="off"/>
            <!-- Suggestions will be displayed in below div. -->
            <div id="display"></div>
            </center>
    </div>
 



    <!----------------------------
    Top 10 Users with most logged items 
    ------------------------------->
    <div class="column" id="most-active-div">
        <div class='most-active-header-div'>
            <h2> Top 10 <p>Most Active Users</p></h2> 
        </div>
        <div class='most-active-items'>  
            <?php
            // Get the top 10 most followed users.
            $sql="SELECT sum(allcount) as media_count, username  FROM(
                (SELECT username, count(`videogame`) as allcount FROM `data` WHERE videogame!=''  GROUP BY username)
                UNION ALL
                (SELECT username, count(album) AS allcount FROM `data` WHERE album!=''  GROUP BY username)
                UNION ALL
                (SELECT username, count(book) AS allcount FROM `data` WHERE book!=''  GROUP BY username)
                UNION ALL
                (SELECT username, count(movie) AS allcount FROM `data` WHERE movie!='' GROUP BY username)
                UNION ALL
                (SELECT username, count(tv) AS allcount FROM `data` WHERE tv!=''  GROUP BY username)
            )t group by username ORDER BY media_count DESC;";
            $query = mysqli_query($con, $sql);
            if (mysqli_num_rows($query) > 0) {
                for ($i = 1; $i <9; $i++) {
                    $row[$i] = mysqli_fetch_array($query);
                    
                    // $pfp=$row[$i]['profile_pic'];
                    $username = $row[$i]['username'];
                    $media_count = $row[$i]['media_count'];

            ?>
                        <a href=<?php echo "profile.php?user_name=".$username; ?>> 
                            <div class='most-active-person'>
                                <big class='most-active-username'><?php echo $username;?></big>
                                <br>
                                <small class='most-active-media-count'><?php echo $media_count;?> Medias</small>
                            </div>
                        </a>
            <?php
                }
            }
            ?>
        </div>
    </div>


<script>
    //function fill()
    function fill(Value) {
    $('#search').val(Value);
    $('#display').hide();
    }

    //Jquery for AJAX
    $(document).ready(function() {
    $("#search").keyup(function() {
        var name = $('#search').val();
        if (name == "") {
            $("#display").html("No Results Found");
        }

        else {

            $.ajax({
                type: "POST",
                url: "search_users_ajax.php",
                data: {
                    search: name
                },
                success: function(html) {
                    $("#display").html(html).show();
                }
            });
        }
    });
    });
</script>
</body>
</html>
