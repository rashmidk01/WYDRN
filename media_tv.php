<?php


/**
 * SHOWS NON-DUPLICATE TV SHOWS LOGGED BY THE USER IN A GRID/GALLERY FORM. ON HOVERING ON AN ITEM THE DATE OF LOGGING IS DISPLAYED.  
 *
 * @version    PHP 8.0.12 
 * @since      July 2022
 * @author     AtharvaShah
 */

 

session_start();
if (empty($_SESSION)) {
    header("Location: login.php");
}
require "header.php";
require "connection.php";
require "functions.php";
$user_data = check_login($con);
$username = $user_data['user_name'];

flush(); 
ob_flush();

function getposterpath($name){
    $api_key="e446bc89015229cf337e16b0849d506c";
    $url = 'https://api.themoviedb.org/3/search/tv?api_key='.$api_key.'&query='.$name.'&include_adult=true';
   
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
      'Content-Type: application/json'
    ]);
    
    $response = curl_exec($curl);
    $response=json_decode($response,true);
    curl_close($curl);
    
    if (empty($response['results'][0]['poster_path'])) {
        $response = "images/API/WYDRNtv.png";
    }
    else {
        $response = "https://image.tmdb.org/t/p/w300".$response['results'][0]['poster_path'];
    }
    return $response;
    
}
?>


<html>
<head>
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>WYDRN - Your TV Shows</title>

    <!--Bootstrap Link-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    
    <!--Custom Link-->
    <link rel="stylesheet" href="CSS/media_tv.css">
</head>
<body class="css-selector">

<div class="heading">
  <h1>Your TV Shows<span>"There is ugliness in this world. Disarray. I choose to see the beauty." - Westworld</span></h1>
</div>

<?php
    $per_page_record = 15; // Number of entries to show in a page.
    // Look for a GET variable page if not found default is 1.
    if (isset($_GET["page"])) {
        $page = $_GET["page"];
    } else {
        $page = 1;
    }
    $start_from = ($page - 1) * $per_page_record;

$html_tv="<br><br><section class='cards-wrapper'>"; // $html_tv stores the html code for the movie cards
    
//only select unique shows logged by the user
$sql = "SELECT `tv`, `streaming`, `date` FROM `data` where tv != '' and username='$username' GROUP BY `tv` order by `date` DESC LIMIT $start_from, $per_page_record;";
if ($query = mysqli_query($con, $sql)) {
    $totaltvcount=mysqli_num_rows($query);
    if ($totaltvcount > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            $tvname=$row['tv'];
            $platform=$row['streaming'];
            $tv_logged=date("F jS, Y", strtotime($row['date']));

            $stripnametv=$stripped = str_replace(' ', '+', $tvname);

            /**if poster is not downloaded, download the poster in the directory and show the image*/
            //remove special characters since we are using it as a file name
            $filename= preg_replace('/[^A-Za-z0-9\-]/', '', $stripnametv);
            $pseudo_poster='images/API/tv-'.$filename.'.jpg';
            if (file_exists($pseudo_poster)) {
                $posterpath=$pseudo_poster;
            }
            else {
                $posterpath = getposterpath($stripnametv); // URL to download file from
                $img = 'images/API/tv-'.$filename.'.jpg'; // Image path to save downloaded image
                // Save image 
                file_put_contents($img, file_get_contents($posterpath));
                
            }
         
          
            

            // one single div tag for each movie
            $html_tv.="<div class='card-grid-space'>";
                // image tag for the movie
                $html_tv.="<div class='card' style='background-image:url(";
                $html_tv.=  $posterpath; // get the poster path from the api
                $html_tv.=")'";
                $html_tv.=">";
            
                $html_tv.="<div>"; 
                $html_tv.="<div class='logged-date'>". $tv_logged ."</div>"; 
                $html_tv.="</div>";  // end of div for the movie name


                $html_tv.="</div>"; // end of card

                $html_tv.="<h1 class='moviename'>". $tvname."</h1>";
                $html_tv.="<div class='tags'>"; // div for the tags
                $html_tv.="<div class='tag'>". $platform."</div>";
                $html_tv.="</div>"; // end of tags
                $html_tv.="</div>"; //end of card-grid-space

        }
    }else{
        $html_tv.="No TV shows Logged";
    }
}

$html_tv.="</section>";
echo $html_tv;
?>

<!--PAGINATION ROW -->
<center>
 <div class="pagination">
        <?php
        $query="SELECT DISTINCT count(DISTINCT `tv`) FROM `data` where tv != '' and username='$username'";
        $rs_result = mysqli_query($con, $query);
        $row = mysqli_fetch_row($rs_result);
        $total_records = $row[0];

        echo "</br>";
        // CALCULATING THE NUMBER OF PAGES
        $total_pages = ceil($total_records / $per_page_record);
        $pageLink = "";

        // SHOW PREVIOUS BUTTON IF NOT ON PAGE 1
        if ($page >= 2) {
            echo "<a href='media_tv.php?page=" . ($page - 1) . "'> <span class='neonText'> ??? </span> </a>";
        }

        // SHOW THE LINKS TO EACH PAGE IN THE PAGINATION GRID 
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {
                $pageLink .= "<a class = 'active' href='media_tv.php?page="
                    . $i . "'>" . $i . " </a>";
            } else {
                $pageLink .= "<a href='media_tv.php?page=" . $i . "'>" . $i . " </a>";
            }
        }
        echo $pageLink;

        // SHOW NEXT BUTTON IF NOT ON LAST PAGE
        if ($page < $total_pages) {
            echo "<a href='media_tv.php?page=" . ($page + 1) . "'> <span class='neonText'> ??? </span> </a>";
        }
        ?>
    </div><!--END OF PAGINATION ROW -->
</center>


<body>
</html>
<?php  mysqli_close($con);?>