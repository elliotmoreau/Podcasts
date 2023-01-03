<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$sname = "";
$unmae = "";
$password = "";

$db_name = "";

// Create connection
$con = mysqli_connect($sname, $unmae, $password, $db_name);
// Check connection
if (mysqli_connect_errno($con)) {
    echo "Database connection failed!: " . mysqli_connect_error();
}

$sql = "SELECT * FROM podcast ORDER BY id DESC LIMIT 20";
$query = mysqli_query($con, $sql);

header("Content-type: text/xml");
echo '<?xml version="1.0" encoding="UTF-8" ?>';
echo '<rss version="2.0"
xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:wfw="http://wellformedweb.org/CommentAPI/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/" xmlns:slash="http://purl.org/rss/1.0/modules/slash/" xmlns:georss="http://www.georss.org/georss" xmlns:geo="http://www.w3.org/2003/01/geo/wgs84_pos#">';
echo "
 <channel>
 <title>La Gazette Tulliste | Podcast</title>
 <link>https://journal.elliotmoreau.fr/</link>
 <language>fr-fr</language>";

echo '<atom:link href="https://journal.elliotmoreau.fr/fr/feed/podcast/" rel="self" type="application/rss+xml" />';

if (!ini_get('date.timezone')) {
    date_default_timezone_set('Europe/Paris');
}

echo "<itunes:owner>
<itunes:email>contact@elliotmoreau.fr</itunes:email>
<itunes:name>Elliot Moreau</itunes:name>
</itunes:owner>";

echo '<itunes:category text="News">
    <itunes:category text="Daily News" />
</itunes:category>';

echo '<itunes:category text="Arts">
    <itunes:category text="Books" />
    <itunes:category text="Food" />
    <itunes:category text="Performing Arts" />
</itunes:category>';

echo '<itunes:category text="Sports">
    <itunes:category text="Football" />
    <itunes:category text="Basketball" />
    <itunes:category text="Rugby" />
</itunes:category>';

echo "<itunes:image href='https://journal.elliotmoreau.fr/fr/img/podcast.jpeg'/>";

echo "<description>Ce podcast est le podcast officiel de LaGazetteTulliste, suivez l'actu de Tulle et de la Corrèze à travers des podcasts courts et réguliers sur toutes les platformes.</description>";

echo "<itunes:summary>Ce podcast est le podcast officiel de LaGazetteTulliste, suivez l'actu de Tulle et de la Corrèze à travers des podcasts courts et réguliers sur toutes les platformes.</itunes:summary>";

echo "<itunes:author>Romain Gorse</itunes:author>";

echo "<itunes:explicit>no</itunes:explicit>";

echo "<copyright>LaGazetteTulliste</copyright>";

echo "<itunes:subtitle>Ce podcast est le podcast officiel de LaGazetteTulliste, suivez l'actu de Tulle et de la Corrèze à travers des podcasts courts et réguliers sur toutes les platformes.</itunes:subtitle>";


while ($row = mysqli_fetch_array($query)) {
    $title = $row["titre"];
    $id = $row["id"];
    $link = $row["id"];
    $link = "https://journal.elliotmoreau.fr/fr/podcast/#podcast$link";
    $date = $row["date"];
    $duration = $row["duration"];

    echo "<item>
    <itunes:title>$title</itunes:title>
   <title>$title</title>
   <enclosure url='https://journal.elliotmoreau.fr/fr/podcast/audios/$id.mp3'
   type='audio/mpeg' length='34216300'/>
   <link>$link</link>
   <guid>$link</guid>
   <pubDate>$date</pubDate>
   <itunes:author>Romain Gorse</itunes:author>
   <itunes:subtitle>$title</itunes:subtitle>
   <itunes:image href='https://journal.elliotmoreau.fr/fr/img/podcast.jpeg'/>
   <itunes:duration>$duration</itunes:duration>
   <itunes:summary>Podcast n°$id de LaGazetteTulliste.</itunes:summary>
   <description>Podcast n°$id : $title</description>
   </item>";
}

echo "</channel></rss>";
